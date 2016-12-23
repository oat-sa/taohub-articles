<!--
created_at: '2015-02-04 14:36:01'
updated_at: '2015-12-17 15:52:16'
authors:
    - 'Ihor Siroshtan'
tags:
    - 'Users Management Model'
-->

LDAP Authentication
===================

This library is intended to connect Tao to an existing user directory and was designed for **Tao 3.0**.

To use it with Tao 2.6. please follow LDAP Authentication for Tao 2.6.

The Library can be found on github:

https://github.com/oat-sa/generis-auth-ldap

Installation
------------

### Preparation

-   Ensure the PHP LDAP module is installed, and enabled for your apache config.
-   Ensure composer is installed (https://getcomposer.org/download/)
-   Install Tao as you would normally

Follow the instructions in the GitHub readme by adding the repository and the require to the root composer.json:

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/oat-sa/generis-auth-ldap"
        }
    ],
    ...
    "require": {
        "oat-sa/generis-auth-ldap": "dev-develop"
        ...
    }

and run

    composer update

Configuration
-------------

Follow the instructions in the GitHub readme:

https://github.com/oat-sa/generis-auth-ldap/blob/develop/README.md

Usage
-----

You should now be able to use the credentials defined in you LDAP server to login to Tao.

As this is a new library, please report any bugs you should find to help us improve it.

Additional settings
-------------------

TAO uses ZendFramework 2 LDAP adapter, list of options it supports and some guidlines on usage can be found here:

https://packages.zendframework.com/docs/latest/manual/en/modules/zend.authentication.adapter.ldap.html\#server-options


