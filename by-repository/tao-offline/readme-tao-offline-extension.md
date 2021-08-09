# Readme: TAO Offline Extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-offline.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-offline.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-offline.svg)

> TAO Offline Capability offers schools the possibility to take assessments in environments with unstable internet connections. It uses Virtual Machines (VM) and a Central Server (CS). The assessment is performed on the VMs that contain a TAO installation as well as the tests. At the end the results of the test will be synchronized with the Central Server. 

## Installation instructions{#installation-instructions}

These instructions assume that you already have a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.


Add the extension to your TAO composer and to the autoloader:
```shell
composer require oat-sa/extension-tao-offline
```

Install the extension on the CLI from the project root:

**Linux:**
```shell
sudo php tao/scripts/installExtension oat-sa/extension-tao-offline
```

**Windows:**
```shell
php tao\scripts\installExtension oat-sa/extension-tao-offline
```

As a system administrator you can also install it through the TAO Extension Manager:
- Settings (the gears on the right-hand side of the menu) -> Extension manager
- Select _taoOffline_ on the right-hand side, check the box and hit _install_

## Synchronization and Encryption{#synchronization-and-encryption}

## Synchronization
The synchronization process is based upon two actors, the Client Server, which is installed on a Virtual Machine, and the Central Server.

#### Setting up the Client Server{#setting-up-the-client-server}

The following script needs to be run on a TAO instance in order to create a Client Server:

```shell
sudo -u www-data php index.php '\oat\taoOffline\scripts\tools\setup\SetupClientServer'
```

On systems where [extension-tao-encryption](https://github.com/oat-sa/extension-tao-encryption) is installed, the script will set it up with encryption.
    
Point the instance to a specific server by executing the following command:
 
 ```shell
sudo -u www-data php index.php '\oat\taoSync\scripts\tool\RegisterHandShakeRootURL' --rootUrl=http://tao-central.dev/
 ```

#### Setting up the Central Server{#setting-up-the-central-server}

Run the following to turn a TAO instance into a Central Server.

```shell
sudo -u www-data php index.php 'oat\taoOffline\scripts\tools\setup\SetupCentralServer'
```

Again, instances with `taoEncryption` will benefit from encryption.

#### Types of available synchronizations{#types-of-available-synchronizations}

* Central Server to VM
    * Test Centers
    * Users
    * Deliveries
    * Eligibilities
    * LTI Consumers
* VM to Central Server
    * Test Sessions
    * Results
    * Result Logs
    * LTI Users
    
#### Overview of the workflow{#overview-of-the-workflow}

![Overview workflow](docs/overview_sync.png)

##### Sequence Diagram{#sequence-diagram}

![Sequence Diagram](docs/sync_flow.png)

#### Synchronizing users with encryption{#synchronizing-users-with-encryption}

Every user has been assigned an application key that is used to decrypt the delivery content. Properties that are excluded from the synchronization process can be found under `excludedProperties` in the configuration file `config/taoSync/syncService.conf.php`.  Properties that are encrypted are defined inside `config/taoEncryption/encryptUserSyncFormatter.conf.php`.

![Synchronizing users](docs/sync_users.png)

#### Synchronizing deliveries with encryption{#synchronizing-deliveries-with-encryption}

During the synchronization of the deliveries, the test package is sent to the client. The client then imports the test and generates a delivery. 

_Note: If you are synchronizing a delivery that already exists on the VM a new import of the test will be created._

![Synchronizing Deliveries](docs/sync_delivery.png)

##### Synchronizing results with encryption{#synchronizing-results-with-encryption}

The `chunkSize` of a result is an essential configuration parameter that needs to be set in advance; the default is `10`. It can be set depending on the number of variables included in a result.

If you have, for example, a test with 100 items (which means about 400 variables), the total request will contain about 4000 variables. This scenario is likely to overload the server. In this case, reducing the `chunkSize` to a smaller value is advised.

The statuses of a result that needs to be sent can be configured under `statusExecutionsToSync` in `config/taoSync/resultService.conf.php`. Each request to the server will include the number of results. The process will stop after all results have been sent.

![Synchronizing Results](docs/sync_results.png)

#### Synchronizing results - Logs{#synchronizing-results-logs}

Each result log is synchronized with the Central Server to maintain a history of the test. The number of logs sent per request is defined in the configuration inside `config/taoSync/SyncDeliveryLogService.conf.php`.