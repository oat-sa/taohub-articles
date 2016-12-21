<!--
author:
    - 'Joel Bout'
created_at: '2015-07-14 18:52:42'
updated_at: '2016-08-12 11:34:55'
tags:
    - 'Administrator Guide'
-->

Server Migration
================

This guide is intended to help you move TAO 3.1 from one server to another without data loss.

For older installations see:

-   [[Server Migration 2.5]].
-   [[Server Migration 3.0]].

Requirements
------------

-   (Optional) Please upgrade to the latest version of TAO first ([[Installation and Upgrading]]).
-   This guide assumes you have not heavily modified your configuration. If you are using alternative storage implementations (such as NoSql), the migration might be more complex.
-   This guide assumes that the technology stack did not change. There might be additional issues if you would like to migrate between different Operating Systems (Windows-\>Linux) or Databases (MySql =\> Postgres)

Old Server
----------

-   Copy the entire TAO data and config directory from the old server (by default found in config and data).
-   Create a dump of the database making sure to include the routines (if you are using mysql, use mysqldump -R).

New Server
----------

### File migration

\* Replace the config and data directory and to set the correct file owner/rights.

\* Modify **config/generis.conf.php** to reflect your new domain and directories. (Do NOT change GENERIS\_INSTANCE\_NAME or LOCAL\_NAMESPACE.)

\* watch out for the trailing slashes when writing paths !

    define('ROOT_PATH','/var/www/newTaoDirectory/');
    define('ROOT_URL','http://www.newTaoDomain.com/');
    .
    .
    define('FILES_PATH','/opt/newTaoDataDirectory/');

\* Modify **config/generis/filesystem.conf.php** to reflect your new file paths. For this change the **filesPath** and the **root** of each adapter:

    return new oat\oatbox\filesystem\FileSystemService(array(
        'filesPath' => 'NEW_FILE_DIRECTORY_HERE',
        'adapters' => array(
            'fileUploadDirectory' => array(
                'class' => 'Local',
                'options' => array(
                    'root' => 'NEW_FILE_DIRECTORY_HERE/tao/upload'
                )
            ),
            'public' => array(
                'class' => 'Local',
                'options' => array(
                    'root' => 'NEW_FILE_DIRECTORY_HERE/tao/public'
                )
            ),
    .
    .

\* Modify **config/generis/persistences.conf.php** to reflect your new database configuration.

    'default' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'DbName',
        'user' => 'DbUserName',
        'password' => 'DbPassword',
    ),

\* Update the directory **path** value in **config/tao/websource\_[CODE].conf.php** to point to your new TAO data directory. (Do NOT modify **fsUri**.)

    return array(
        'className' => 'oat\\tao\\model\\websource\\TokenWebSource',
        'options' => array(
            'secret' => 'a0c2ef52398c24d5347109f930d907d3',
            'path' => '/opt/newTaoDataDirectory/tao/public/',
            'ttl' => 1440,
            'fsUri' => 'http://YOUR_LOCAL_NAMESPACE#i1231456789',
            'id' => '55a53f75bf715',
        ),
    );

### Finally

-   (Mandatory) Clear the cache of the file sources by emptying the folder **NEW\_FILES\_PATH/data/generis/cache/**. This can be achieved using the following command: rm -rf NEW\_FILES\_PATH/data/generis/cache/\*.
-   (Optional) Execute **NEW\_FILES\_PATH/tao/scripts/taoUpdate.php** to ensure all extensions are up to date and to regenerate the translation files

Server Migration
================

This guide is intended to help you move TAO 3.1 from one server to another without data loss.

For older installations see:

-   [[Server Migration 2.5]].
-   [[Server Migration 3.0]].

Requirements
------------

-   (Optional) Please upgrade to the latest version of TAO first ([[Installation and Upgrading]]).
-   This guide assumes you have not heavily modified your configuration. If you are using alternative storage implementations (such as NoSql), the migration might be more complex.
-   This guide assumes that the technology stack did not change. There might be additional issues if you would like to migrate between different Operating Systems (Windows-\>Linux) or Databases (MySql =\> Postgres)

Old Server
----------

-   Copy the entire TAO data and config directory from the old server (by default found in config and data).
-   Create a dump of the database making sure to include the routines (if you are using mysql, use mysqldump -R).

New Server
----------

### File migration

\* Replace the config and data directory and to set the correct file owner/rights.

\* Modify **config/generis.conf.php** to reflect your new domain and directories. (Do NOT change GENERIS\_INSTANCE\_NAME or LOCAL\_NAMESPACE.)

\* watch out for the trailing slashes when writing paths !

    define('ROOT_PATH','/var/www/newTaoDirectory/');
    define('ROOT_URL','http://www.newTaoDomain.com/');
    .
    .
    define('FILES_PATH','/opt/newTaoDataDirectory/');

\* Modify **config/generis/filesystem.conf.php** to reflect your new file paths. For this change the **filesPath** and the **root** of each adapter:

    return new oat\oatbox\filesystem\FileSystemService(array(
        'filesPath' => 'NEW_FILE_DIRECTORY_HERE',
        'adapters' => array(
            'fileUploadDirectory' => array(
                'class' => 'Local',
                'options' => array(
                    'root' => 'NEW_FILE_DIRECTORY_HERE/tao/upload'
                )
            ),
            'public' => array(
                'class' => 'Local',
                'options' => array(
                    'root' => 'NEW_FILE_DIRECTORY_HERE/tao/public'
                )
            ),
    .
    .

\* Modify **config/generis/persistences.conf.php** to reflect your new database configuration.

    'default' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'DbName',
        'user' => 'DbUserName',
        'password' => 'DbPassword',
    ),

\* Update the directory **path** value in **config/tao/websource\_[CODE].conf.php** to point to your new TAO data directory. (Do NOT modify **fsUri**.)

    return array(
        'className' => 'oat\\tao\\model\\websource\\TokenWebSource',
        'options' => array(
            'secret' => 'a0c2ef52398c24d5347109f930d907d3',
            'path' => '/opt/newTaoDataDirectory/tao/public/',
            'ttl' => 1440,
            'fsUri' => 'http://YOUR_LOCAL_NAMESPACE#i1231456789',
            'id' => '55a53f75bf715',
        ),
    );

### Finally

-   (Mandatory) Clear the cache of the file sources by emptying the folder **NEW\_FILES\_PATH/data/generis/cache/**. This can be achieved using the following command: rm -rf NEW\_FILES\_PATH/data/generis/cache/\*.
-   (Optional) Execute **NEW\_FILES\_PATH/tao/scripts/taoUpdate.php** to ensure all extensions are up to date and to regenerate the translation files


