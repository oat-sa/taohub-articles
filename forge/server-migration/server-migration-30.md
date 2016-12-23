<!--
created_at: '2016-08-12 11:27:46'
updated_at: '2016-10-18 10:19:10'
authors:
    - 'Cyril Hazotte'
tags:
    - 'Server Migration'
    - 'TAO 3.0'
-->

Server Migration TAO 3.0
========================

This guide is intended to help you move TAO 3.0 from one server to another without data loss.

Please see Server Migration for the current version.

Requirements
------------

-   This guide assumes you have not heavily modified your configuration. If you are using alternative storage implementations (such as NoSql), the migration might be more complex.

Old Server
----------

-   Copy the entire TAO data and config directory from the old server (by default found in config and data).
-   Create a dump of the database making sure to include the routines (if you are using mysql, use mysqldump -R).

New Server
----------

### File migration

\* Replace the config and data directory and to set the correct file owner/rights.

\* Modify **config/generis.conf.php** to reflect your new domain and directories.<br/>

*Note: Do NOT change GENERIS_INSTANCE_NAME or LOCAL_NAMESPACE and watch out for the trailing slashes when writing paths!*

    define('ROOT_PATH','/var/www/newTaoDirectory/');
    define('ROOT_URL','http://www.newTaoDomain.com/');
    [...]
    define('FILES_PATH','/opt/newTaoDataDirectory/');

-   Modify in **config/tao/client_lib_registry.conf.php** and **config/taoQtiItem/local_shared_libraries.conf.php** the target URLs the list of extensions points to.

\* Modify **config/generis/persistences.conf.php** to reflect your new database configuration.

    'default' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'DbName',
        'user' => 'DbUserName',
        'password' => 'DbPassword',
    ),

\* Update the directory **path** value in **config/tao/websource_[CODE].conf.php** to point to your new TAO data directory. (Do NOT modify **fsUri**.)

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

### Database migration

\* Import the SQL dump into the new database

\* Update the file sources, this can either be done line by line or all in one go:

    UPDATE statements SET object = REPLACE (`object`, 'OLD_FILES_PATH', 'NEW_FILES_PATH') where object like 'OLD_FILES_PATH%';

An example, assuming your old data was stored in **/var/www/tao/data/** and your new environment will store its data in **/opt/taoData/** would be:

    UPDATE statements SET object = REPLACE (`object`, '/var/www/tao/data/', '/opt/taoData/') where object like '/var/www/tao/data/%';

### Finally

-   (Mandatory) Clear the cache of the file sources by emptying the folder **NEW_FILES_PATH/data/generis/cache/**. This can be achieved using the following command: rm -rf NEW_FILES_PATH/data/generis/cache/<br/>
*.
-   (Optional) Execute **NEW_FILES_PATH/tao/scripts/taoUpdate.php** to ensure all extensions are up to date and to regenerate the translation files


