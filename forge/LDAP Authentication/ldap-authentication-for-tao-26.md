<!--
parent: 'LDAP Authentication'
created_at: '2015-03-30 14:18:33'
updated_at: '2015-03-30 14:18:33'
authors:
    - 'Joel Bout'
tags:
    - 'LDAP Authentication'
-->

LDAP Authentication for TAO 2.6
===============================

This library is intended to connect TAO to an existing user directory and was designed for Tao 3.0.

This pages describes how to use it with **TAO 2.6**. To use it with TAO 3.0 please follow LDAP Authentication.

The Library can be found on github:

https://github.com/oat-sa/generis-auth-ldap

Installation
------------

### Preparation

-   Ensure the PHP LDAP module is installed, and enabled for your apache config.
-   Ensure composer is installed (https://getcomposer.org/download/)
-   Install TAO as you would normally

TAO 2.6 does not yet use composer for the entire project, but it is used in generis. So in order to add a library:

\* place the attached [composer.json](../resources/composer.json) in /generis

\* delete the directories /generis/vendor/doctrine/ and /generis/vendor/easyrdf (they will be recreated)

\* change to the directory /generis and run

    composer install

-   make sure the newly created files are accessible to your apache user.

Configuration
-------------

TAO 2.6 does not support any Authentication configuration, so the only way to use the LDAP Adapter is to replace the TAO AuthAdapter:

-   replace the file /generis/core/kernel/users/class.AuthAdapter.php with the attached [class.AuthAdapter.php](../resources/class.AuthAdapter.php)
-   modify the configuration in class.AuthAdapter.php to your server

Usage
-----

You should now be able to use the credentials defined in you LDAP server to login to TAO.

Limitations
-----------

-   LDAP authentication in TAO 2.6 will replace the Tao user authentication, so you will not be able to use your TAO login anymore
-   LDAP authentication in TAO 2.6. only works for test-takers


