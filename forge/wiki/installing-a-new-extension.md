<!--
parent:
    title: Wiki
author:
    - 'Cyril Hazotte'
created_at: '2015-08-10 10:43:24'
updated_at: '2016-09-15 14:59:21'
tags:
    - Wiki
-->

Installing a new extension
==========================

Description on how to install extensions that are not part of the default TAO package. Some extensions are deprecated or experimental so please proceed at your own risk.

A list of released extensions can be found [here](https://packagist.org/packages/oat-sa/).

Download
--------

Depending on your install there are two different ways to obtain an extension:

### Composer Install

If you installed TAO using composer simply run the following line in the root of TAO:

    composer require PACKAGE_NAME

### Packaged Version

If you installed TAO from a package downloaded at http://www.taotesting.com you will need to:

-   Download the extension from Github (https://github.com/oat-sa).
-   Unzip the content and rename it according to the **tao-extension-name** specified in the composer.json. Place this renamed folder in the web root of TAO.
-   Manually modify the composer autoloader.

For example: If the composer.json includes

    "psr-4" : {
        "oat\\SOMENAME\\" : ""
    }

the following line would need to be added to */vendor/composer/autoload\_psr4.php*:

    'oat\\SOMENAME\\' => array($baseDir . '/SOMENAME'),

Install
-------

-   Log into TAO as a System Administrator.
-   Open the Extensions Manager (Under “Settings” in the upper right corner).
-   Select the extension you downloaded and click on install (If the extension is missing in the list please verify the path and the file permissions).

