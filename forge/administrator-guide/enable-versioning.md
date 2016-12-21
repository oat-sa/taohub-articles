<!--
parent:
    title: Administrator_Guide
author:
    - 'Jérôme Bogaerts'
created_at: '2012-02-29 17:29:22'
updated_at: '2013-03-13 12:44:53'
tags:
    - 'Administrator Guide'
-->

{{\>toc}}

**TODO Content need to be update**\
New UI has been design to support versionning activation

Enable versioning
=================

By default the versioning feature is not enabled when you install TAO. The versioning require a versioning server which is not installed by default on your computer.\
If you have access to a versioning system, you can follow the next points to enable versioning into TAO.

Local working copy
------------------

Firstly you need to be sure that you have a local folder where the http user (www-data for apache) can checkout the remote repository.\
By instance be sure that the folder *generis/data/versioning/* and its subfolders are writable for the http user (www-data for apache).

Update the config file
----------------------

Secondly an option to configure the versioning is to use the generis config file. *It is not mandatory, but it is practical when you have to reinstall the versioning more than once*

The generis config file is located at *generis/common/conf/versionning.conf.php*. Change also the *generis/common/conf/default/versionning.conf.php* if you want to make setting persistent.

    define('GENERIS_VERSIONED_REPOSITORY_LOGIN' , 'my_login');
    define('GENERIS_VERSIONED_REPOSITORY_PASSWORD' , 'my_password');
    define('GENERIS_VERSIONED_REPOSITORY_TYPE' , 'svn');
    define('GENERIS_VERSIONED_REPOSITORY_URL' , 'http://url_of_my_repository/svn');
    define('GENERIS_VERSIONED_REPOSITORY_PATH' , GENERIS_FILES_PATH.'/versioning/DEFAULT');
    define('GENERIS_VERSIONED_REPOSITORY_LABEL' , 'Tao default versioned repository');
    define('GENERIS_VERSIONED_REPOSITORY_COMMENT' , 'The default repository used to manage versioned files');

Enable the versioning
---------------------

Execute the script *tao/script/taoVersioning.php*.

    php taoVersioning.php -e

If you did not use the generis config file, you can pass arguments to the script.

    php taoVersioning.php -e -type svn -u my_login -p my_password --path /path/to/the/local/working_copy --url http://url_of_the/svn

Be sure that the directory you choose as local working copy and its subfolders are writable for the http user (www-data for apache)

