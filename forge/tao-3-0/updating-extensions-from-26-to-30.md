<!--
parent: 'TAO 3 0'
created_at: '2014-08-19 14:29:10'
updated_at: '2015-04-13 13:32:00'
authors:
    - 'Joel Bout'
tags:
    - '"Legacy Versions:TAO 2.630"'
    - '"Legacy Versions:TAO 2.6"'
    - '"Legacy Versions:TAO 3.0"'
-->

Updating Extensions from 2.6 to 3.0
===================================

This is work in progress.

Steps required:

-   Autoloading has been delegated to composer, please add a composer.json to your extension with the required autoload directives. Please consider that these only get registered after you installed your extension using composer.



-   Update the structures.xml file from the 2.6 to the Tao 3.0 structures.xml format



-   “New Item” is no longer shared by all item types, but has been moved to taoQtiItem. Custom item types need to add their own “add Item” action.


