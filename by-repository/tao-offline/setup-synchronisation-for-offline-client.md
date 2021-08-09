# Setup synchronisation for offline client

Tao offline is the ability to deliver a test without an active internet connection. 

In order to provide an offline delivery, a internet connection is required to synchronize data. It means:
* Data
  * Users (test-taker, proctor, test-center administrator)
  * Test centers (and assignments of test-taker/delivery)
* Content
  * Deliveries (compiled test and associated items)

The synchronisation is scoped to a test center "organisation id" to fetch only required data to make the process less resource intensive.
The synchronisation is a 2 step process: synchronisation of data/content, then synchronisation of results.
It is launched by the "offline device" to fetch data from "central server"
> All communications data are encrypted and protected by Oauth2 token

### 1°) Platform initialisation{#10-platform-initialisation}

We provide a tool to initialize TAO with preconfigured options from a JSON file.

```shell
sudo -u www-data php tao/scripts/taoSetup path/to/setup.json
```

Two setup.json are available to install an "offline device" and a "central server"
> Take care to update super-user.password, configuration.global.timezone, configuration.global.url, configuration.global.lang and database configuration under configuration.generis.persistences.default

#### 1A - Central server initialization (This is an informational step, the platform will be preconfigured with setup.json){#1a-central-server-initialization-this-is-an-informational-step-the-platform-will-be-preconfigured-with-setupjson}

To prepare for synchronisation the platform will:
- Generate keys pair for asymetric encryption (public/private). These will be used for results, encrypted on offline devices and only decryptable on central server.
- Prepare all storage (database/filesystem) to process encryption
- Scope the synchronisation to the test center organisation id
- Enable endpoints to provide credentials for sync user to allow him to be authenticated against Oauth2 service

```shell
sudo -u www-data php index.php "oat\taoOffline\scripts\tools\setup\SetupCentralServer"
```

> Documentation of encryption: https://hub.taocloud.org/techdocs/tao-encryption/readme-tao-encryption

#### 1B - Central server: Test centers data and content{#1b-central-server-test-centers-data-and-content}

In order to provide tests to testtakers, test centers have to follow these rules:

 - A valid organisation id property.
 - It can be assigned to one or more `test-center administrator` and `proctor`.
 - It has to contain eligibilities to assign `test-taker` to `delivery`.
 - Several test centers can have the "organisation id", all will be synchronized
 
> To create item/test/delivery don't hesitate to check the user guide : https://userguide.taotesting.com/3.2/introduction/what-is-tao.html
 
To import users, CSV importers exist:
```shell
  sudo -u www-data php index.php "oat\tao\scripts\tools\import\ImportUsersCsv" -t test-taker -f tao/test/user/import/example.csv
  sudo -u www-data php index.php "oat\tao\scripts\tools\import\ImportUsersCsv" -t proctor -f tao/test/user/import/example.csv
  sudo -u www-data php index.php "oat\tao\scripts\tools\import\ImportUsersCsv" -t test-center-admin -f tao/test/user/import/example.csv
```

#### 1C - Create sync users{#1c-create-sync-users}

To be able to identify an incoming synchronisation request, users are associated to an "organisation id".
This user will be allowed to synchronize test center(s) with associated "organisation id".
```shell
  sudo -u www-data php index.php "oat\tao\scripts\tools\import\ImportUsersCsv" -t sync-manager -f tao/test/user/import/example.csv
```
> User importer can ingest CSV files formatted similarly to the file located at `tao/test/user/import/example.csv`. Note, for sync-manger an "organisation id" column is also required!

#### 1D - Offline device initialization (This is an informational step, platform will be preconfigured with setup.json){#1d-offline-device-initialization-this-is-an-informational-step-platform-will-be-preconfigured-with-setupjson}

To prepare for synchronisation the offline device will:
- Prepare all storages (database/filesystem) to process encryption
- Scope the synchronisation to test center organisation id

These actions are grouped in one command line:
```shell
sudo -u www-data php index.php "oat\taoOffline\scripts\tools\setup\SetupClientServer"
```

To make "offline device" aware of "central server", the central server url has to be provided 
```shell
sudo -u www-data php index.php "oat\taoSync\scripts\tool\RegisterHandShakeRootURL" --rootUrl=http://central-server.test/
```

## 2°) Synchronization!{#20-synchronization}

> During synchronisation, the public key is retrieved from central server to manage results encryption.

#### 2A - Synchronization of data and contents{#2a-synchronization-of-data-and-contents}

At this point, central server has the data and allow connections for synchronisation. 
Offline devices are ready, USB/app/local server is setup with central server url and mechanism to fetch sync user has been registered. 

login/password from sync-manager csv are provided to school.

To make the process as easy as possible for synchronizer (e.q. teacher/school IT), it connects to the platform then a big button is available to synchronize data.

During synchronisation, data and contents are compared:
 - If does not exist then create
 - If exists but does not match then update
 - If exists locally from a previous synchronisation, but not anymore on central then delete
 
All received data are encrypted and cannot be read. To decrypt required data for delivery passation, test-taker has to log with his own login/password. 
> Each testtaker has his own application key to access only his own data .
Once test takers is logged in, a proctor can interact (depending on central server -> test center -> eligibility settings)
> If a testtaker has been added to a testcenter eligibility (or remove) or if any data have been changed since last synchronisation, offline device data will be updated as well

###### Time to deliver to test taker the test itself{#time-to-deliver-to-test-taker-the-test-itself}

Test takers pass the test, finish it and generate result variables (of course encrypted)
> Delivery passations do not require an internet connection to process
> All login/password pairs for sync-manager/test-takers/proctors have to be provided to schools

#### 2B - Synchronisation of results{#2b-synchronisation-of-results}

Sync-manager user have to synchronize again to synchronize results. 
Results are encrypted and synchronized as is.

> Only results of finished tests will be synchronized 

Behavior of steps 2A and 2B are exactly the same. The sync-manager click on synchronization to fetch data and send results
To make it automatic and/or scheduled, this synchronisation can be launched from shell, or included in CRON:
```shell
sudo -u www-data php index.php "oat\taoSync\scripts\tool\synchronisation\SynchronizeAll"
```
> Documentation of synchronisation process: https://github.com/oat-sa/extension-tao-sync

## 3°) Reporting and Results processing{#30-reporting-and-results-processing}

After an offline device send back results to central server, results are still encrypted.
In order to decrypt, a shell command exists, can also be part of CRON:
```shell
sudo -u www-data php index.php "oat\taoEncryption\scripts\tools\DecryptResults" -all
```

You should see results under tab results in backoffice of central server

Enjoy