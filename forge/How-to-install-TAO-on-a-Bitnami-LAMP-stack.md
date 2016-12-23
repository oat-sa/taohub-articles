<!--
created_at: '2015-06-24 10:16:00'
updated_at: '2016-02-14 11:38:48'
authors:
    - 'Rex Wallen Tan'
contributors:
    - 'Cyril Hazotte'
tags: {  }
-->

How to install TAO on a Bitnami LAMP stack / Bitnami on Amazon Web Services
===========================================================================

Here is a short tutorial to get a Bitnami LAMP stack ready for TAO 2.6 and TAO 3.0. You may install any of these versions or both as it was done below.

**Note:** It is good practice (and let’s say mandatory for a production stack) to change all default passwords in such stacks and especially in this case the MySQL root and tao users. The MySQL root user already exists (default password is ‘bitnami’, the local ‘tao’ user is created at step 2 (at the same time as when privileges are granted for the database used for TAO).

In the following part, we assume that you may want to install TAO 2.6 and TAO 3.0 in two separate folders. Furthermore, no specific virtual host needs to be created, as TAO can be installed safely on any subfolder.

Step 1: Get TAO ready for installation
--------------------------------------

Download TAO builds on the document root, extract them and rename extracted folders for conveniency:

    cd /opt/bitnami/apache2/htdocs/
    wget http://releases.taotesting.com/TAO_2.6.7_build.zip
    wget http://releases.taotesting.com/TAO_3.0.0_build.zip
    unzip TAO_2.6.7_build.zip && mv TAO_2.6.7_build tao267
    unzip TAO_3.0.0_build.zip && mv TAO_3.0.0_build tao3

The TAO 2.6.7 installer gives such outcome:<br/>

![](resources/{width:1024px}/attachments/download/3805/bitnami_lamp_stack_tao267_requirements_check_1.png)

(Optional, for TAO 2.6 only) The ‘short_open_tag’ PHP directive needs to be set to ‘On’.

    sudo sed -i -r "s/^short_open_tag = .*/short_open_tag =  On/g" /opt/bitnami/php/etc/php.ini

For this change to be taken into account, we need to restart PHP-FPM:

    sudo /opt/bitnami/ctlscript.sh restart php-fpm

As we can see on the Apache2 main configuration (httpd.conf, path depends on the target appliance), URL rewriting is uncommented so enabled by default.

    LoadModule rewrite_module modules/mod_rewrite.so

We set the right permissions for the right owners (daemon is the user and group for Apache2)

    sudo chmod -R ug+rwX tao267 tao3
    sudo chown -R daemon:daemon tao267 tao3

The TAO 2.6.7 installer gives now such outcome:<br/>

![](resources/{width:1024px}/attachments/3804/bitnami_lamp_stack_tao267_requirements_check_2.png)

Same goes for the TAO 3.0 installer:<br/>

![](resources/{width:1024px}/attachments/3799/bitnami_lamp_stack_tao3_requirements_check.png)

Step 2: Prepare MySQL for a TAO database and user
-------------------------------------------------

    mysql -u root -p

    mysql> CREATE DATABASE tao267;
    mysql> GRANT ALL PRIVILEGES ON tao267.* TO 'tao'@'localhost' IDENTIFIED BY 'mytaopassword';

    mysql> CREATE DATABASE tao3;
    mysql> GRANT ALL PRIVILEGES ON tao3.* TO 'tao'@'localhost' IDENTIFIED BY 'mytaopassword';

    mysql> FLUSH PRIVILEGES;
    mysql> EXIT

Step 3: Installation
--------------------

Go through the installation of TAO, from the GUI or using the taoInstall.php script.

![](resources/{width:1024px}/attachments/3803/bitnami_lamp_stack_tao267_login.png)

![](resources/{width:1024px}/attachments/3800/bitnami_lamp_stack_tao267_backoffice.png)

![](resources/{width:1024px}/attachments/3797/bitnami_lamp_stack_tao3_login.png)

![](resources/{width:1024px}/attachments/3798/bitnami_lamp_stack_tao3_backoffice.png)

Additional errors
-----------------

### Error 1: Errors with Vhosts and Aliases\
If you find some errors when installing such as: Not Found e.g. The requested URL /taotesting/tao/Main/entry was not found on this server.<br/>

Please note that alias/prefixes have some errors when installing TAO testing e.g. httpd-prefix.conf or Alias /taotesting/ “/opt/bitnami/apps/taotesting/htdocs/”

TAO 3.0 was successfully installed onto a Bitnami stack (Amazon Web Services) when using Virtual Hosts e.g. httpd-vhosts.conf or <VirtualHost *:80>

### Error 2: Errors with mod_rewrite\
Even if mod_rewrite is successfully enabled, you may have to edit tao/.htaccess as there is a strange error being thrown on install (mod_rewrite not being detected)

Please see this link on how to fix mod_rewrite problems on install: http://forge.taotesting.com/issues/3434<br/>

That’s all folks!

References:
-----------

- https://wiki.bitnami.com/Components/Apache\#How_to_configure_the_Apache_server.3f\
- https://wiki.bitnami.com/Components/MySQL


