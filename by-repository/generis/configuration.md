# Configuration

The configuration of this extension can be found in two locations:
* the file `config/generis.conf`
* the directory `config/generis/`

# generis.conf.php

This is the original configuration that is just loaded into global constants. Please do not add
anything to this file, but register a service instead.

* LOCAL_NAMESPACE
* GENERIS_INSTANCE_NAME
* GENERIS_SESSION_NAME
* ROOT_PATH
* ROOT_URL
* DEFAULT_LANG
* DEFAULT_ANONYMOUS_INTERFACE_LANG
DEBU* G_MODE
* SYS_READY
* TIME_ZONE
* PASSWORD_HASH_ALGORITHM
* PASSWORD_HASH_SALT_LENGTH
* USE_HTTP_AUTH
* USE_HTTP_USER
* USE_HTTP_PASS
* VENDOR_PATH
* EXTENSION_PATH
* FILES_PATH
* GENERIS_CACHE_PATH
* CONFIG_PATH
* GENERIS_CACHE_USERS_ROLES

# Common system configurations

## filesystem.conf.php

Defines the filesystem abstraction, based on https://flysystem.thephpleague.com/v1/docs/

### log.conf.php

Defines the log files, see [[Psr3-logger]]

### persistences.conf.php

Defines the abstraction for SQL and keyvalue databases

# Advanced configurations

## auth.conf.php

### event.conf.php

## LockService.conf.php

### ontology.conf.php

## passwords.conf.php

### permissions.conf.php

## SimpleCache.conf.php

### UserLanguageService

 Do not change