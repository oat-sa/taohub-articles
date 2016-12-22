<!--
created_at: '2014-09-16 13:25:52'
updated_at: '2014-09-16 13:52:22'
authors:
    - 'Jérôme Bogaerts'
tags:
    - 'Installation and Upgrading'
-->

InstallUnbuntuApacheMySQLComposer
=================================



Install your LAMP Stack
-----------------------

Installation Directory
----------------------

The very first thing to do is to decide where to install the TAO Platform. Because we want to install a Web Application, we will install TAO in the `/var/www` directory. Let’s create the actual directory that will host our TAO 3.0.0 Platform.

    cd /var/www
    mkdir tao300

Git Checkout
------------

Get Composer
------------

In this tutorial, we will use the latest version of composer.phar. To to so, type the following command in your favourite terminal.

    curl -sS https://getcomposer.org/installer | php

This will check some php.ini settings (to make sure Composer can be run), and download the latest version of composer.phar in the current working directory. If you can see the following output message, you’re done with this step!

    All settings correct for using Composer
    Downloading...

    Composer successfully installed to: /var/www/tao300/composer.phar
    Use it: php composer.phar

Get the Dependencies
--------------------

Install TAO
-----------
InstallUnbuntuApacheMySQLComposer
=================================



Install your LAMP Stack
-----------------------

Installation Directory
----------------------

The very first thing to do is to decide where to install the TAO Platform. Because we want to install a Web Application, we will install TAO in the `/var/www` directory. Let’s create the actual directory that will host our TAO 3.0.0 Platform.

    cd /var/www
    mkdir tao300

Git Checkout
------------

Get Composer
------------

In this tutorial, we will use the latest version of composer.phar. To to so, type the following command in your favourite terminal.

    curl -sS https://getcomposer.org/installer | php

This will check some php.ini settings (to make sure Composer can be run), and download the latest version of composer.phar in the current working directory. If you can see the following output message, you’re done with this step!

    All settings correct for using Composer
    Downloading...

    Composer successfully installed to: /var/www/tao300/composer.phar
    Use it: php composer.phar

Get the Dependencies
--------------------

Install TAO
-----------

