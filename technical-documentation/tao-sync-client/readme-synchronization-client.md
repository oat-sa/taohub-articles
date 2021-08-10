# Readme: Synchronization Client

Synchronization logic specific only for the client server. 

## Available Scripts

List of console scripts available with this package

### Sync Package

Controls synchronization packages

#### Generate Package

**Command**

```php index.php 'oat\taoSyncClient\scripts\tools\syncPackage\GeneratePackage'```

**Options**

| Option | Description |
| --- | --- |
| `e` | Synchronize everything |
| `a` | Sync ALL data types that was not synchronized |
| `u` | Sync user data type |
| `d` | Sync delivery log data type |
| `r` | Sync results |
| `s` | Sync test sessions |
| `l n` | Limit of the data for one package (it means that only `n` rows will be taken from the sync queue to the package file) |
| `h` | Help |
| `v` | Force script to see more details |

**Example**

`php index.php 'oat\taoSyncClient\scripts\tools\syncPackage\GeneratePackage' -l 1 -e`

This command will generate packages for each row of the sync queue which has not been synchronized yet.