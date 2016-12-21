<!--
parent:
    title: Data_abstractions
author:
    - 'Cyril Hazotte'
created_at: '2015-06-19 09:23:35'
updated_at: '2015-08-10 11:03:29'
tags:
    - 'Data abstractions'
-->

Data abstractions 2.6
=====================

This document describes abstractions available for Tao 2.6. Please see [[Data abstractions]] for the current version of Tao.

{{\>toc}}

There are currently 5 distinct storages that are used during the delivery:

Result storage abstraction
--------------------------

The choice of a Result Storage implementation is done by configuring a Result Server. Each delivery is configured with one result server.\
This happens in the back office user interface respectively into the “Result Servers Management” and “Delivery” tabs.

Two major implementation of result Storage exist:

1.  taoResults
2.  keyValueResultStorage

The KeyValue Result storage implementation may be installed and configured under the following conditions:

-   Make sure you have installed the packages :\
    “redis-server” (on the server you want to use for the storage)\
    “phpredis” on the TAO application server

<!-- -->

-   In the extension manager, install the extension called taoAltResultStorage. If you switch to the tab called “Manage Result Server”, you will be able to see a new result Server called KeyValueResults.

<!-- -->

-   If you have chosen to use a remote redis server or wanted to have redis running on a different port than the default one (6379). You may have to adapt the configuration file *generis/common/conf/default/persistences.conf.php*

<!-- -->

    'keyValueResult' => array(
            'driver' => 'phpredis',
                'host' => '127.0.0.1',
                'port' => 6379
        )

-   When you configure a delivery, you may now decide to send the results to the redis server, choose the option *KeyValueResultStorage* in the delivery configuration tool.

Service state storage abstraction
---------------------------------

The service state storage manages the state of any service that has been started. This can include among many the states of items (selected responses), states of the test(current item) and state of the delivery. This is always stored in the key-value persistence identified by **’serviceState’**.

### Storing service states in the filesystem (default)

The default persistence is defined in *generis/common/conf/default/persistences.conf.php* and will store the state of the services in the directory *generis/data/serviceState*.

    'serviceState' => array(
        'driver' => 'phpfile',
    )

### Storing service states in a Redis server

If you prefer to store these states in an alternativ storage copy the file *generis/common/conf/default/persistences.conf.php* to *generis/common/conf/persistences.conf.phpgeneris.conf.php* and modify the ‘serviceState’ entry to the following:

    'serviceState' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )

Delivery execution informations storage abstraction
---------------------------------------------------

Delivery execution information cover everything related to what test taker has started/finished which delivery. The choice of the abstraction is done via the constant *DELIVERY\_EXECUTION\_HANDLER* in *generis/common/conf/generis.conf.php*.

### Storing delivery execution informations in the ontology (default)

    define('DELIVERY_EXECUTION_HANDLER', 'taoDelivery_models_classes_execution_OntologyService');

### Storing delivery execution informations in a key-value server

To switch to a KeyValue persistence the constant *DELIVERY\_EXECUTION\_HANDLER* in *generis.conf.php* needs to be set to *taoDelivery\_models\_classes\_execution\_KeyValueService*:

    define('DELIVERY_EXECUTION_HANDLER', 'taoDelivery_models_classes_execution_KeyValueService');

Additionally the persistence used by the key value service needs to be defined in *persistences.conf.php*. If you would like to use Redis you would add the following block:

    'deliveryExecution' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )

PHP session storage abstraction
-------------------------------

This abstraction allows to use user-level session storage, for storing and retrieving data associated with a session.\
See also: http://php.net/manual/en/function.session-set-save-handler.php

### System session storage (default)

By default the PHP environment will handle all session storage and retrieval on a system-level.

### Storing the session in a key-value server

To enable the user-level key-value storage of the php session uncomment the following line in *generis/common/conf/generis.conf*:

    # default will use defautl php session handling
    define('PHP_SESSION_HANDLER', 'common_session_php_KeyValueSessionHandler');

The persistence used for the session is defined in *persistences.conf.php* and set to *SqlKvWrapper* by default. If you wish to switch to Redis exchange the session configuration with the following:

    'session' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )

URI provider
------------

The URI provider is used to generate new URIs for newly created resources. If multiple application servers are used for delivering tests in Tao these application servers need to ensure that they don’t generate conflicting URIs and therefore should use a common URI provider.

### Using the SQL server as URI provider (default)

By default Generis uses the SQL database to generate new URIs

    define('GENERIS_URI_PROVIDER', 'DatabaseSerialUriProvider');

### Using the key-value server as URI provider

To switch to a the advanced key-value implementation the constant GENERIS\_URI\_PROVIDER in generis.conf.php needs to be changed:

    define('GENERIS_URI_PROVIDER', 'AdvKeyValueUriProvider');

    'uriProvider' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )
