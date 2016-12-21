<!--
author:
    - 'Cyril Hazotte'
created_at: '2013-10-28 11:12:15'
updated_at: '2016-10-18 10:19:29'
tags:
    - 'Server Migration'
-->

Server Migration TAO 2.5-2.6
============================

This guide is intended to help you move Tao from one server to another without dataloss.

Requirements
------------

A clean migration of Tao is only possible for Tao 2.5 or newer. If you want to move an older instance please upgrade to 2.5 first ([[Installation and Upgrading]]).

Migration steps
---------------

### File migration

-   Copy the entire tao directory from the old server to the new server, make sure to include the .htaccess in the root folder and to set the correct file owner/rights
-   Modify **install/directory/generis/common/conf/db.conf.php** to reflect your new database configuration\
    \><pre>define(‘DATABASE\_NAME’,‘tao\_head’);<br/>

    define(‘DATABASE\_LOGIN’,‘root’);<br/>

    define(‘DATABASE\_PASS’,‘’);<br/>

    define(’DATABASE\_URL’,‘localhost’);<br/>

    define(‘SGBD\_DRIVER’,‘pdo\_mysql’);</pre>
-   In **install/directory/generis/common/conf/generis.conf.php** update the ROOT\_PATH and ROOT\_URL each ending with a trailing slash/directory delimiter. (Do NOT change GENERIS\_INSTANCE\_NAME or LOCAL\_NAMESPACE)\
    \><pre>define(‘ROOT\_PATH’,‘/install/directory/’);<br/>

    define(‘ROOT\_URL’,‘http://tao.lan/’);</pre>
-   Update the folder value in **install/directory/tao/includes/configGetFile.php** to point to your **install/directory/taoDelivery/data/compiled/** directory\
    \><pre><?php return array(0 => array(‘secret’ =\> ‘1234567890abcde1234567890abcde12’,‘folder’ =\> ‘/install/directory/generis/data/tao/public/’));</pre>

### Database migration

\* Create a dump of the database, and make sure to include the routines (if you are using mysql, use mysqldump -R) and reimport it in the new system

\* Update the filesources, this can either be done line by line or all in one go:

    UPDATE statements SET object = REPLACE (`object`, '/path/to/OLD_DIRECTORY/', '/path/to/NEW_DIRECTORY/') where object like '/path/to/OLDFOLDERS/%';

In a standard install it is likely the path would end with /generis/data/

\> For 2.6 onwards it is possible to store data outside the default directory, it is important to ensure that the FILES\_PATH in **install/directory/generis/common/conf/generis.conf.php** corresponds to the required directory:<br/>

\><pre>\
\#generis paths\
…\
define(‘FILES\_PATH’,‘/path/to/NEW\_DIRECTORY/’);

</pre>
### Finaly

-   Clear the cache of the filesources by emptying the folder **install/directory/generis/data/generis/cache/**

Open Issues
-----------

\* QTI items that reference images in the Media Manager do so using the absolute URL, and will still point to the old instance. Since the content of the QTI items is stored in files we can update them using a batch process, however some human oversight might be required. An example script for GNU Operating Systems using findutils and sed would be:

    find taoItems/data/ -iname qti.xml -exec sed -i 's/http:<br/>
/\/OLD_URL\/filemanager/http:<br/>
/\/NEW_URL\/filemanager/g' {} \;

This line might change the owner of the qti.xml and you might have to correct them.


