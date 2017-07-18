<!--
parent: 'Administrator Guide'
created_at: '2014-02-12 11:44:13'
authors:
    - 'Cyril Hazotte'
tags:
    - 'Administrator Guide'
-->

# Data abstractions

> This document describes abstractions available for TAO 3.0. Please see [Data abstractions 2.6 for TAO 2.6](https://hub.taocloud.org/articles/data-abstractions/data-abstractions-26).

The key-value storage implementation may be installed and configured under the following conditions:

-   If you are using Ubuntu, make sure you have the following packages installed:
    -   for Redis:
        *redis-server* on the server you want to use for the storage
        *php5-redis* on the TAO application server
    -   for Couchbase:
        *couchbase-server* (on the server you want to use for the storage)
        PECL *couchbase* library on the TAO application server
-   If you are using Fedora/CentOS/RHEL, make sure you have the following packages installed:
    -   for Redis: *php56u-pecl-redis*, *php56w-pecl-redis* or prior versions of these packages
    -   for Couchbase: install the rpm package [available at this page](http://docs.couchbase.com/admin/admin/Install/rhel-installing.html).

There are currently 6 distinct storages that are used during the delivery.


## Delivery execution informations storage abstraction

Delivery execution information cover everything related to what test taker has started/finished which delivery. The choice of the abstraction is done in *config/taoDelivery/execution_service.conf.php*.

### Storing delivery execution informations in the ontology (default)

```php 
return new taoDelivery_models_classes_execution_OntologyService();
```

### Storing delivery execution informations in a key-value server

To switch to a KeyValue persistence we need to first change the service to `taoDelivery_models_classes_execution_KeyValueService` in *config/taoDelivery/execution_service.conf.php*:

```php 
return new taoDelivery_models_classes_execution_KeyValueService(array('persistence' => 'deliveryExecution'));
```

Additionally the persistence used by the key value service needs to be defined in *config/generis/persistences.conf.php*.

If you would like to use Redis you would add the following block:
```php
    'deliveryExecution' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )
```

If you would like to use Couchbase you would add the following block:
```php
    'deliveryExecution' => array(
        'driver' => 'couchbase',
        'cluster' => 'couchbase://localhost',
        'bucket' => 'your_tao_bucket',
        'password' => 'your_tao_bucket_password' //optional
    )
```

## URI provider

The URI provider is used to generate new URIs for newly created resources. If multiple application servers are used for delivering tests in Tao these application servers need to ensure that they don’t generate conflicting URIs and therefore should use a common URI provider.

### Using the SQL server as URI provider (default)

By default Generis uses the SQL database to generate new URIs:

```php
return new core_kernel_uri_DatabaseSerialUriProvider(array('persistence' => 'default','namespace' => LOCAL_NAMESPACE.'#'));
```

### Using the key-value server as URI provider

To switch to a the advanced key-value implementation the service in *config/generis/uriProvider.conf.php* needs to be changed to:

```php
return new core_kernel_uri_AdvKeyValueUriProvider(array('persistence' => 'uriProvider','namespace' => LOCAL_NAMESPACE.'#'));

    'uriProvider' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )
```


## Service state storage abstraction

The service state storage manages the state of any service that has been started. This can include among many the states of items (selected responses), states of the test (current item) and state of the delivery. This is by default stored in the key-value persistence identified by `serviceState` (key is defined in *config/tao/stateStorage.conf.php*).

### Storing service states in the filesystem (default)

The default persistence is defined in *config/generis/persistences.conf.php* and will store the state of the services in the directory *data/generis/serviceState*.
```php
    'serviceState' => array(
        'driver' => 'phpfile',
    )
```
### Storing service states in a Redis or Couchbase server

If you prefer to store these states in an alternative storage, edit the file *config/generis/persistences.conf.php* and modify the ‘serviceState’ entry to the following:

For Redis:
```php
    'serviceState' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )
```

For Couchbase:
```php
    'serviceState' => array(
         'driver' => 'couchbase',
         'cluster' => 'couchbase://localhost',
         'bucket' => 'your_tao_bucket',
         'password' => 'your_tao_bucket_password' //optional
    )
```

## PHP session storage abstraction

This abstraction allows to use user-level session storage, for storing and retrieving data associated with a session.

See also: http://php.net/manual/en/function.session-set-save-handler.php

### System session storage (default)

By default the PHP environment will handle all session storage and retrieval on a system-level.

### Storing the session in a key-value server

To use the key-value storage for the php session change the service used in *config/tao/session.conf.php*:

```php
    return new common_session_php_KeyValueSessionHandler(array(
        common_session_php_KeyValueSessionHandler::OPTION_PERSISTENCE => 'session'
    ));
```
The persistence used for the session needs to be defined in *config/generis/persistences.conf.php*:

For Redis add the following persistence:

```php
    'session' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )
```

For Couchbase add the following persistence:

```php
    'session' => array(
        'driver' => 'phpredis',
        'cluster' => 'couchbase://localhost',
        'bucket' => 'your_tao_bucket',
        'password' => 'your_tao_bucket_password' //optional
    )
```

## User authentication storage abstraction

Currently, there are at least two user authentication methods available:
    - using the Generis model user adapter (default method)
    - using the key-value user adapter

**Note:** Key-value authentication currently works solely for test-takers.

The default authentication method is the following:

```php
    return array(
        array(
            'driver' => 'oat\\generis\\model\\user\\AuthAdapter',
            'hash' => array(
                'algorithm' => 'sha256',
                'salt' => 10
            )
        )
    );
```

To support key-value authentication, you will need the [generis-auth-keyvalue](https://github.com/oat-sa/generis-auth-keyvalue/) library to be installed. The configuration to apply to broaden user authentication methods to key-value is [detailed here](https://github.com/oat-sa/generis-auth-keyvalue/blob/master/README.md).

With the following configuration, key-value user authentication will come first and default authentication will be kept either as a fallback or for non-test-takers users:

```php
    return array(
        0 => array(
            'driver' => 'oat\\authKeyValue\\AuthKeyValueAdapter',
        ),
        1 => array(
            'driver' => 'oat\\generis\\model\\user\\AuthAdapter',
            'hash' => array(
                'algorithm' => 'sha256',
                'salt' => 10,
            ),
        ),
    );
```

Importing test-takers to Redis is achieved through a CSV import script.


## Result storage abstraction

The choice of a Result Storage implementation is done by configuring a Result Server. Each delivery is configured with one result server. This happens in the back office user interface respectively in *Result Servers Management* and *Delivery* tabs.

Two major implementations of Result Storage exist:

    1.  taoResults
    2.  keyValueResultStorage

The second implementation requires the [taoAltResultStorage](https://github.com/oat-sa/extension-tao-outcomekeyvalue/) extension to be installed. Use composer with extension-tao-outcomekeyvalue as package name or clone the GitHub repository of this extension separately. See Installing a new extension for that purpose.

If you have chosen to use a remote Redis server or wanted to have Redis running on a different port than the default one (6379), you may edit the configuration file *config/generis/persistences.conf.php*:

For Redis:
```php
    'keyValueResult' => array(
            'driver' => 'phpredis',
            'host' => '127.0.0.1',
            'port' => 6379
        )
```
For Couchbase:
```php
    'keyValueResult' => array(
            'driver' => 'couchbase',
            'cluster' => 'couchbase://localhost',
            'bucket' => 'your_tao_bucket',
            'password' => 'your_tao_bucket_password' //optional
        )
```

When you configure a delivery, you may now decide to send the results to the Redis server, in that case choose the option *KeyValueResultStorage* in the delivery configuration tool.



