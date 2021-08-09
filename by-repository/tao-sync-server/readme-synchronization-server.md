# Readme: Synchronization Server

Synchronization logic specific only for the server server. 

## Available Scripts

List of console scripts available with this package

### Sync Package

Controls synchronization packages

#### Generate Package

**Command**

`php index.php 'oat\taoSyncServer\scripts\tools\syncPackage\GeneratePackage'`

**Options**

| Option | Description |
| --- | --- |
| `o` | Organization id |

**Example**

`php index.php 'oat\taoSyncServer\scripts\tools\syncPackage\GeneratePackage' -o 1`

This command will generate packages for test center with Organization id = 1