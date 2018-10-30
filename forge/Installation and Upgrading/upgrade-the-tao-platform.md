<!--
parent: 'Installation and Upgrading'
created_at: '2015-04-16 08:04:18'
updated_at: '2015-04-16 08:04:35'
authors:
    - 'Lionel Lecaque'
tags:
    - 'Installation and Upgrading'
-->

Upgrade the TAO Platform
========================

An extension called taoUpdate is available since TAO 2.5 to allow System administrator to update your installation to the last version of TAO and replace previous way of upgrade your TAO installation. First, we strongly advise any administrator to create database backup of their system before launching the update.

1.  Download the attached file [taoUpdate](http://releases.taotesting.com/taoUpdate2.5-2.6.zip) and extracted in content in your root folder.
2.  Connect to Extension Manager and install the extension taoUpdate\
    ![](http://forge.taotesting.com/attachments/download/2568/S%C3%A9lection_045.png)
3.  Make sure www-data has permission to write on all folder of your TAO root folder\
    ![](http://forge.taotesting.com/attachments/download/2567/S%C3%A9lection_046.png)
4.  Launch the update\
    ![](http://forge.taotesting.com/attachments/download/2566/S%C3%A9lection_047.png)
5.  At this point a private link is provided and will be required to continue the update, from now on any attempt to connect to the platform will result to a redirection to a maintenance page except from the link provide that contain a unique key to continue the update process.

    ![](http://forge.taotesting.com/attachments/download/2570/S%C3%A9lection_048.png)
6.  If you loose this key, a file with the admin key had been created in a folder called deployNewTao, simply connect to “http://ROOT_URL/deployNewTao/Main/index?key=
$key” where 
$key is the key you found in the file.

    ![](http://forge.taotesting.com/attachments/download/2571/S%C3%A9lection_049.png)
7.  New Version of TAO is now deployed, the next step to finish the installation is install new extensions and migrate the data according to the new version. All extension are still jammed except taoUpdate that will allow you to do so. if once again you loose the link to continue the update just connect to “http://ROOT_URL/taoUpdate/data/index?key=
$key” where key is still the same and had been now moved to taoUpdate/data/

    ![](http://forge.taotesting.com/attachments/download/2573/S%C3%A9lection_050.png)

### Offline Upgrade

If you require an offline upgrade, simply copy the standard package [TAO_2.6_build.zip](http://releases.taotesting.com/TAO_2.6_build.zip) in the folder taoUpdate/data/local/ . It will then follow same procedure that the online update.


