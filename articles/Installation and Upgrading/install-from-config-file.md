<!--
created_at: '2016-12-12 13:49:42'
tags:
    - 'Developer Guide'
    - 'Installation and Upgrading'
-->

# Install the TAO platform from a configuration file

> This page aims to explain how you can install tao from a predefined configuration file, in order to make your deployments easier.

Since TAO v7.36.2 we have a new way to install the tao platform. You can use a new script that is called taoSetup.php, it requires a config file as parameter.

To call it simply use the command line :
```bash
sudo -u www-data php tao/scripts/taoSetup.php /var/www/path/to/your/configFile.json
```

Since TAO v10.19.1 we have the possibility to get more detailed logs about the installation.

| short | long        |                 description                |
|-------|-------------|--------------------------------------------|
| -v    | --verbose 1 | verbose mode(error level)                  |
| -vv   | --verbose 2 | verbose mode(error & notice levels)        |
| -vvv  | --verbose 3 | verbose mode(error & notice & info levels) |
| -vvvv | --verbose 4 | verbose mode(all levels)                   |
| -nc   | --no-color  | removing colors from the output            |

Example:
```bash
# Normal CLI setup with detailed logs
sudo -u www-data php tao/scripts/taoSetup.php /var/www/path/to/your/configFile.json -vvv

# Fully detailed logs with no color (recommended for build processes)
sudo -u www-data php tao/scripts/taoSetup.php /var/www/path/to/your/configFile.json -vvvv -nc
```


## Config file

The config file can be written either in json or yaml. In order to use a yaml file you have to have the yaml extension for php on your server.

The file will contain some mandatory and optional properties, they are listed below. You can find an example of this file [here](https://github.com/oat-sa/tao-core/blob/master/scripts/sample/config.json)

### Mandatory properties

#### Super User

This option is the one that will set your first tao user as a super user. It requires a login and a password. It can contain but not needed a first name, last name and an email.

```json
"super-user": {
  "login": "admin",
  "lastname": "",
  "firstname": "",
  "email": "",
  "password": "admin"
}
```  

#### Configuration

This section have several properties, each property match a specific config in your final installation. Some of them are mandatory, some others are optional.

Mandatory configuration:

-   global
-   generis

Optional configuration:

-   log
-   filesystem
-   awsClient
-   …

##### Global

The global part of the configuration contains all the properties required for the tao installation.

-   lang : the default language
-   mode : debug or production
-   instance_name : the name of the instance
-   namespace : the local namespace
-   url : the url to access the platform
-   file_path : the root path of your tao installation
-   session_name : the name of the cookie that will contain the session
-   timezone
-   import_data : should be import default data or not
-   anonymous_lang : the language that will be set for anonymous user (login page)

```json
"global": {
  "anonymous_lang": "fr-FR",
  "lang": "en-US",
  "mode": "debug",
  "instance_name": "mytao",
  "namespace": "http://tao.local/mytao.rdf",
  "url": "http://tao.dev/",
  "file_path": "/var/www/package-tao/data/",
  "root_path": "/var/www/package-tao/",
  "session_name": "tao_123AbC",
  "timezone": "Europe/Luxembourg",
  "import_data": true
}
```

##### Persistences

The persistences configuration is one of the most important because it will let you choose the database type where you want to install tao data.
It has to be under the generis configuration.

You must have at least the default key in order to set correctly the database, then you can choose the driver `pdo_pgsql`, `pdo_mysql`, it is the same structure than in your final `config/generis/persistences.conf.php`

You can also if you want set other persistences as the cache one or a redis connection for the delivery execution or the results.

```json
"generis": {
  "persistences": {
    "default": {
      "driver": "pdo_pgsql",
      "host": "localhost",
      "dbname": "tao_default",
      "user": "root",
      "password": "root"
    },
    "cache": {
      "driver": "phpfile"
    },
    "keyValueResult": {
      "driver": "phpredis",
      "host": "10.33.33.33",
      "port": 6379
    }
  }
}
```

Bellow is an example of setting up a read replica as the default persistence :

```json
"default": {
  "driver": "dbal",
  "connection": {
    "wrapperClass": "\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection",
    "driver": "pdo_pgsql",
    "master":{
      "host": "localhost",
      "dbname": "tao_default",
      "user": "postgres",
      "password": "postgres"
    },
    "slaves": [
      {
        "host": "localhost",
        "dbname": "tao_default",
        "user": "postgres",
        "password": "postgres"
      }
    ]
  }
}
```
You can see that we have to set different parameters.
First the type of connection, here a master slave connection.
Then the drive to use for your database, we are using a postgresql database so it is `pdo_pgsql`
Finally we have to configure a bit the connection. Typically the master and the slaves, so host, dbname, user and password. We could add the port if necessary. In this example we have only one slave but we could add more.


##### 

### Optional properties

#### Extensions

This property allows you to choose which extensions you want to install by default for your instance

```json
"extensions": [
  "taoQtiTest",
  "taoProctoring"
]
```

By default if you let this array empty it will install taoCe.

#### Configurable services

Under an extension configuration you can set a configurable service. For example you can set the awsClient configuration.
Their is three parts in a configurable service configuration. First you have to set the type ie configurableService, in order to make the script able to recognize as a service and not an array based configuration.
Then you will have to set the class of this service, it has to extend the ConfigurableService class of generis.
Finally you have to set the options that will be given to the service when instanciate.

This awsClient config will be under the generis configuration but for an other

```json
"awsClient": {
  "type": "configurableService",
  "class": "oat\\awsTools\\AwsClient",
  "options": {
    "region": "eu-west-1",
    "version": "latest",
    "credentials": {
      "secret": "Secret",
      "key": "Key"
    }
  }
}
```

#### Other configurations

Under each extension as for the configurable services you can add array based configurations.
In this example we have the log configuration (part of the `generis` key) that is an array of array with some properties. You can see them in [this file](https://github.com/oat-sa/generis/blob/master/config/header/log.conf.php)

```json
"log": {
        "type": "configurableService",
        "class": "oat\\oatbox\\log\\LoggerService",
        "options": {
          "logger": {
            "class": "oat\\oatbox\\log\\logger\\TaoLog",
            "options": {
              "appenders": [
                {
                  "class": "UDPAppender",
                  "host": "127.0.0.1",
                  "port": 5775,
                  "threshold": 1,
                  "prefix": "tao"
                },
                {
                  "class": "SingleFileAppender",
                  "file": "/path/to/logfile.log",
                  "max_file_size": 1048576,
                  "rotation-ratio": 5,
                  "format": "%m",
                  "threshold": 4
                }
              ]
            }
          }
        }
      }
```


#### postInstall

An other key of this configuration file is the postInstall key. It allows you to specify a script to run at the end of the installation process.
Under the postInstall key put a key that will make sense for you, then you have to specify two keys. The first one is the class, the script that you want to launch. It has to implement the `__invoke()` method.
The second parameter is the params that you want to give to the invoke method in order to run you script.

```json
"testSessionFilesystem": {
  "class": "oat\\taoQtiTest\\scripts\\install\\CreateTestSessionFilesystem",
  "params": {
    }
  }
}
```
