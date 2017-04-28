Data abstractions
=================

This document describes abstractions available for TAO 3.0. Please see [[Data abstractions 2.6]] for TAO 2.6.

{{\>toc}}

There are currently 5 distinct storages that are used during the delivery:

Result storage abstraction
--------------------------

The choice of a Result Storage implementation is done by configuring a Result Server. Each delivery is configured with one result server.\
This happens in the back office user interface respectively in “Result Servers Management” and “Delivery” tabs.

Two major implementations of result Storage exist:

1.  taoResults
2.  keyValueResultStorage

The KeyValue Result storage implementation may be installed and configured under the following conditions:

-   If you are using Ubuntu, make sure you have the following packages installed:
    -   for Redis:\
        “redis-server” (on the server you want to use for the storage)\
        “php5-redis” on the TAO application server
    -   for Couchbase:\
        “couchbase-server” (on the server you want to use for the storage)\
        PECL “couchbase” library on the TAO application server

\* You have the **taoAltResultStorage** extension installed. See [[Installing a new extension]] or follow the following instructions:

**** Download and install the taoAltResultStorage extension found [here](https://github.com/oat-sa/extension-tao-outcomekeyvalue/releases/tag/v1.0). Unzip the contents of this, and rename the *extension-tao-outcomekeyvalue-1.0* folder to *taoAltResultStorage*. Place this renamed folder in the web root of the TAO app. Then add this line to the *vendor/composer/autoload\_psr4.php* file:

    'oat\\taoAltResultStorage\\' => array($baseDir . '/taoAltResultStorage'),

**** In the extension manager, install the extension called taoAltResultStorage. If you switch to the tab called “Manage Result Server”, you will be able to see a new result Server called KeyValueResults.

If you have chosen to use a remote Redis server or wanted to have Redis running on a different port than the default one (6379). You may edit the configuration file *config/generis/persistences.config.php*.:

\* For Redis:

    'keyValueResult' => array(
            'driver' => 'phpredis',
            'host' => '127.0.0.1',
            'port' => 6379
        )

\* For Couchbase:

    'keyValueResult' => array(
            'driver' => 'couchbase',
            'cluster' => 'couchbase://localhost',
            'bucket' => 'your_tao_bucket',
            'password' => 'your_tao_bucket_password' //optional
        )

-   When you configure a delivery, you may now decide to send the results to the Redis server, choose the option *KeyValueResultStorage* in the delivery configuration tool.

Service state storage abstraction
---------------------------------

The service state storage manages the state of any service that has been started. This can include among many the states of items (selected responses), states of the test (current item) and state of the delivery. This is always stored in the key-value persistence identified by **’serviceState’**.

### Storing service states in the filesystem (default)

The default persistence is defined in *config/generis/persistences.conf.php* and will store the state of the services in the directory *data/generis/serviceState*.

    'serviceState' => array(
        'driver' => 'phpfile',
    )

### Storing service states in a Redis or Couchbase server

If you prefer to store these states in an alternative storage, edit the file *config/generis/persistences.conf.php* and modify the ‘serviceState’ entry to the following:

\* for Redis:

    'serviceState' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )

\* for Couchbase:

    'serviceState' => array(
         'driver' => 'couchbase',
         'cluster' => 'couchbase://localhost',
         'bucket' => 'your_tao_bucket',
         'password' => 'your_tao_bucket_password' //optional
    )

Delivery execution informations storage abstraction
---------------------------------------------------

Delivery execution information cover everything related to what test taker has started/finished which delivery. The choice of the abstraction is done in *config/taoDelivery/execution\_service.conf.php*.

### Storing delivery execution informations in the ontology (default)

    return new taoDelivery_models_classes_execution_OntologyService();

### Storing delivery execution informations in a key-value server

To switch to a KeyValue persistence we need to first change the service to *taoDelivery\_models\_classes\_execution\_KeyValueService* in *config/taoDelivery/execution\_service.conf.php*:

    return new taoDelivery_models_classes_execution_KeyValueService(array('persistence' => 'deliveryExecution'));

Additionally the persistence used by the key value service needs to be defined in *config/generis/persistences.conf.php*.

If you would like to use Redis you would add the following block:

    'deliveryExecution' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )

If you would like to use Couchbase you would add the following block:

    'deliveryExecution' => array(
        'driver' => 'couchbase',
        'cluster' => 'couchbase://localhost',
        'bucket' => 'your_tao_bucket',
        'password' => 'your_tao_bucket_password' //optional
    )

PHP session storage abstraction
-------------------------------

This abstraction allows to use user-level session storage, for storing and retrieving data associated with a session.\
See also: http://php.net/manual/en/function.session-set-save-handler.php

### System session storage (default)

By default the PHP environment will handle all session storage and retrieval on a system-level.

### Storing the session in a key-value server

To use the key-value storage for the php session change the service used in *config/tao/session.conf.php*:

    return new common_session_php_KeyValueSessionHandler(array(
        common_session_php_KeyValueSessionHandler::OPTION_PERSISTENCE => 'session'
    ));

The persistence used for the session needs to be defined in *config/generis/persistences.conf.php*:

\* If you wish to use Redis add the following persistence:

    'session' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )

\* If you wish to use Couchbase add the following persistence:

    'session' => array(
        'driver' => 'phpredis',
        'cluster' => 'couchbase://localhost',
        'bucket' => 'your_tao_bucket',
        'password' => 'your_tao_bucket_password' //optional
    )

URI provider
------------

The URI provider is used to generate new URIs for newly created resources. If multiple application servers are used for delivering tests in Tao these application servers need to ensure that they don’t generate conflicting URIs and therefore should use a common URI provider.

### Using the SQL server as URI provider (default)

By default Generis uses the SQL database to generate new URIs:

    return new core_kernel_uri_DatabaseSerialUriProvider(array('persistence' => 'default','namespace' => LOCAL_NAMESPACE.'#'));

### Using the key-value server as URI provider

To switch to a the advanced key-value implementation the service in *config/generis/uriProvider.conf.php* needs to be changed to:

    return new core_kernel_uri_AdvKeyValueUriProvider(array('persistence' => 'uriProvider','namespace' => LOCAL_NAMESPACE.'#'));

    'uriProvider' => array(
        'driver' => 'phpredis',
        'host' => '127.0.0.1',
        'port' => 6379
    )
