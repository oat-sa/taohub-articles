<!--
author:
    - 'Lionel Lecaque'
created_at: '2014-07-14 18:04:23'
updated_at: '2014-07-14 18:04:23'
-->

Upgrade the TAO Platform from 2.4 to 2.5
========================================

An extension called taoUpdate is available since TAO 2.4 to allow System adminitrator to update your installation to the last version of TAO and replace preivous way of upgrade your TAO installation. First, we strongly advise any adminitrator to create database backup of their system before launching the update.

1.  Download the attached file [taoUpdate](http://releases.taotesting.com/taoUpdate2.4-2.5.2.zip) and extracted in content in your root folder.
2.  Connect to Extension Manager and install the extension taoUpdate\
    ![](http://forge.taotesting.com/attachments/download/2568/S%C3%A9lection_045.png)
3.  Make sure www-data have permission to write on all folder of your TAO root folder\
    ![](http://forge.taotesting.com/attachments/download/2567/S%C3%A9lection_046.png)
4.  Lauch the update\
    ![](http://forge.taotesting.com/attachments/download/2566/S%C3%A9lection_047.png)
5.  At this point a private link is provided and will be required to continue the update, from now on any attempt to connect to the platform will result to a redirection to a maintenance page execpt from the link provide that contain a unique key to continue the update process.<br/>

    ![](http://forge.taotesting.com/attachments/download/2570/S%C3%A9lection_048.png)
6.  If you loose this key, a file with the admin key had been created in a folder called deployNewTao, simply connect to “http://ROOT\_URL/deployNewTao/Main/index?key=\$key” where \$key is the key you found in the file.<br/>

    ![](http://forge.taotesting.com/attachments/download/2571/S%C3%A9lection_049.png)
7.  New Version of TAO is now deployed, the next step to finish the installation is install new extensions and migrate the data according to the new version. All extension are still jammed except taoUpdate that will allow you to do so. if once again you loose the link to continue the update just connect to “http://ROOT\_URL/taoUpdate/data/index?key=\$key” where key is still the same and had been now moved to taoUpdate/data/\
    ![](http://forge.taotesting.com/attachments/download/2573/S%C3%A9lection_050.png)

### Offline Upgrade

If you require an offline upgrade, simply copy the standard package [TAO\_2.5\_build.zip](http://releases.taotesting.com/TAO_2.5_build.zip) in the folder taoUpdate/data/local/ . It will then follow same procedure that the online update.

