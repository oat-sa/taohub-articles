<!--
author:
    - 'Antoine Robin'
created_at: '2016-12-12 13:49:42'
updated_at: '2016-12-13 08:54:05'
tags:
    - 'Developer Guide'
-->

Install from config file
========================

Since tao v7.36.2 we have a new way to install the tao platform. You can use a new script that is called taoSetup.php, it requires a config file as parameter.\
To call it simply use the command line :

    sudo -u www-data php tao/scripts/taoSetup.php /var/www/path/to/your/configFile.json

Config file
-----------

The config file can be wrote either in json or yaml. In order to use a yaml file you have to have the yaml extension for php on your server.\
The file will contain some mandatory and optional properties, they are listed below. You can find a example of this file [here](https://github.com/oat-sa/tao-core/blob/master/scripts/sample/config.json)

### Mandatory properties

#### super-user

This option is the one that will set your first tao user as a super user. It requires a login and a password. It can contain but not needed a first name, last name and an email.

      "super-user": {
        "login": "admin",
        "lastname": "",
        "firstname": "",
        "email": "",
        "password": "admin"
      }

#### configuration

This section have several properties, each property match a specific config in your final installation. Some of them are mandatory, some others are optional.\
Mandatory configuration :

-   global
-   generies

Optional configuration :

-   log
-   filesystem
-   awsClient
-   …

##### global

The global part of the configuration contains all the properties required for the tao installation.

-   lang that will set the default language
-   mode : debug or production
-   the name of the instance
-   the local namespace
-   the url to access the platform
-   the root path of your tao installation
-   session\_name : the name of the cookie that will contain the session
-   timezone
-   import\_data : should be import default data or not

<!-- -->

    "global": {
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
        },

##### generis

###### persistences

###### log

### Optionnal properties

#### extensions

This property allows you to choose which extensions you want to install by default for your instance

      "extensions": [
        "taoQtiTest",
        "taoProctoring"
      ],

By default if you let this array empty it will install taoCe.

#### configurable services

#### postInstall
Install from config file
========================

Since tao v7.36.2 we have a new way to install the tao platform. You can use a new script that is called taoSetup.php, it requires a config file as parameter.<br/>

To call it simply use the command line :

    sudo -u www-data php tao/scripts/taoSetup.php /var/www/path/to/your/configFile.json

Config file
-----------

The config file can be wrote either in json or yaml. In order to use a yaml file you have to have the yaml extension for php on your server.<br/>

The file will contain some mandatory and optional properties, they are listed below. You can find a example of this file [here](https://github.com/oat-sa/tao-core/blob/master/scripts/sample/config.json)

### Mandatory properties

#### super-user

This option is the one that will set your first tao user as a super user. It requires a login and a password. It can contain but not needed a first name, last name and an email.

      "super-user": {
        "login": "admin",
        "lastname": "",
        "firstname": "",
        "email": "",
        "password": "admin"
      }

#### configuration

This section have several properties, each property match a specific config in your final installation. Some of them are mandatory, some others are optional.<br/>

Mandatory configuration :

-   global
-   generies

Optional configuration :

-   log
-   filesystem
-   awsClient
-   …

##### global

The global part of the configuration contains all the properties required for the tao installation.

-   lang that will set the default language
-   mode : debug or production
-   the name of the instance
-   the local namespace
-   the url to access the platform
-   the root path of your tao installation
-   session\_name : the name of the cookie that will contain the session
-   timezone
-   import\_data : should be import default data or not

<!-- -->

    "global": {
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
        },

##### generis

###### persistences

###### log

### Optionnal properties

#### extensions

This property allows you to choose which extensions you want to install by default for your instance

      "extensions": [
        "taoQtiTest",
        "taoProctoring"
      ],

By default if you let this array empty it will install taoCe.

#### configurable services

#### postInstall

