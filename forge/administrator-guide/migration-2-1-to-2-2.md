<!--
created_at: '2011-12-02 12:02:10'
updated_at: '2013-03-13 15:31:28'
authors:
    - 'Jérôme Bogaerts'
tags:
    - 'Administrator Guide'
-->

Migration 2.1 to 2.2
====================

Generis
-------

-   config.php file have been split in multiple files. Files that are completed during installation are stored in\_ generis/common/conf/sample\_ and are then duplicated in *generis/common/conf*. File in *generis/common/conf/default* are included if no version of the same file is found in *generis/common/conf*, so if you want to customize some behavior just copy and edit the file and put it *generis/common/conf*, this file will not be change by any new installation.
-   a new function createInstanceWithProperties() is available, that can create a new instance and assign several properties with a single call to the database.
    -   please use this instead of saveUser() to quickly create a user in testCases
-   New Uri Provider that have been developed to avoid redundant uri in high concurrency usage. You can set up which one you used in generis.db.conf

Extensions
----------

-   Services are no longer instantiated via the *ServiceFactory*, but are instead instantiated by calling the static function *singleton()* on the desired service (see [[Models]]).

Session
-------

-   core\_kernel\_classes\_Session now stores the user, his interface language, data language and roles. This object is no longer handled by the front-controller but stores itself in the session.

Access Control
--------------

-   Every module and actions in any extensions can now be address by a specific Role in order to set up your platform in order to configure the way platform’s user access different feature, more information in [[Functionality\_access\_control|dedicated page]]

Migration 2.1 to 2.2
====================

Generis
-------

-   config.php file have been split in multiple files. Files that are completed during installation are stored in\_ generis/common/conf/sample\_ and are then duplicated in *generis/common/conf*. File in *generis/common/conf/default* are included if no version of the same file is found in *generis/common/conf*, so if you want to customize some behavior just copy and edit the file and put it *generis/common/conf*, this file will not be change by any new installation.
-   a new function createInstanceWithProperties() is available, that can create a new instance and assign several properties with a single call to the database.
    -   please use this instead of saveUser() to quickly create a user in testCases
-   New Uri Provider that have been developed to avoid redundant uri in high concurrency usage. You can set up which one you used in generis.db.conf

Extensions
----------

-   Services are no longer instantiated via the *ServiceFactory*, but are instead instantiated by calling the static function *singleton()* on the desired service (see [[Models]]).

Session
-------

-   core\_kernel\_classes\_Session now stores the user, his interface language, data language and roles. This object is no longer handled by the front-controller but stores itself in the session.

Access Control
--------------

-   Every module and actions in any extensions can now be address by a specific Role in order to set up your platform in order to configure the way platform’s user access different feature, more information in [[Functionality\_access\_control|dedicated page]]


