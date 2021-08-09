# Readme: Tao Encryption

> This article describes the functioning of tao encryption, focusing of encryption of sensitive data information on a database level.

## Installation

You can add the Tao Encryption as a standard TAO extension to your current TAO instance.

```bash
 $ composer require oat-sa/extension-tao-encryption
```

## Encrypted services supported{#encrypted-services-supported}

## 1. Results Encryption

- #### Setup scripts for Tao Server instance

###### Encrypt{#encrypt}

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupAsymmetricKeys' generate
```
_Note_: 
> This command will generate two keys (public and private) and save them on the filesystem.

_Note_: 
> On Client Tao instance. You have to copy the public key.

_Note_: 
> On Server Tao instance. You need both keys

###### Decrypt{#decrypt}

In order to decrypt your results use the following script by passing a delivery id.

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\DecryptResults' -d <delivery_id>
```

Or by passing the -all argument

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\DecryptResults' -all
```
_Note_: 
> This command will decrypt results and store in the delivery result storage setup.
  
- #### Setup scripts for Tao Client instance

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupEncryptedResultStorage'
```

- #### Sync Encrypted Result (Run on Server and client)
In order to sync encrypted results the script needs to be run on the server tao instance and client as well.

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupEncryptedSyncResult'
 ```
 
![alt text](docs/result_encryption.png)

### 2. Test State data encryption{#2-test-state-data-encryption}

- #### Setup scripts for Tao Client instance

In order to use the encrypted state test service you have to run the following command on tao client instance:

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupEncryptedStateStorage'
```

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupEncryptedMonitoringService'
```

This service it's using the symmetric algorithm in order to encrypt information.

![alt text](docs/state_encryption.png)

### 3. User Encryption{#3-user-encryption}

- #### Setup scripts for Tao Client instance

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupEncryptedUser'
```

- #### Setup scripts for Tao Server instance

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupUserEventSubscription'
```
- #### Both Instances

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupUserSynchronizer'
```

_Note_: 
>  You should ran this command on client tao instance

![alt text](docs/user_encryption.png)

### 4. Setup Encrypted File Systems{#4-setup-encrypted-file-systems}

- #### Setup scripts for Tao Client instance

```bash
 $ sudo -u www-data php index.php "oat\taoEncryption\scripts\tools\SetupEncryptedFileSystem" -f private -e taoEncryption/symmetricEncryptionService -k taoEncryption/symmetricFileKeyProvider
```


```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupDeliveryEncrypted'
```

- #### Setup scripts for Tao Server instance


```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupUserApplicationKey'
 ```

```bash
 $ sudo -u www-data php index.php 'oat\taoEncryption\scripts\tools\SetupRdfDeliveryEncrypted'
```
_Note_: 
> Extra
You can make TAO file systems encrypted. The following command line enables encryption
for the `private` file system, using the service registered with ID 
`taoEncryption/symmetricEncryptionService` for data encryption/decryption.

```bash
sudo -u www-data php index.php "oat\taoEncryption\scripts\tools\SetupEncryptedFileSystem" -f private -e taoEncryption/symmetricEncryptionService
```

![alt text](docs/file_encryption.png)