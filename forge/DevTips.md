<!--
created_at: '2016-03-30 14:39:43'
updated_at: '2016-07-20 10:37:38'
authors:
    - 'Christophe Noel'
-->

Development tips
================

Install XMLEditQtiDebugger Extension
------------------------------------

This extension adds a XML button to the authoring screen, which display the current content of the QTI Item XML.\
To install, add the following to composer.json:

    "repositories" : [
    {
     "type" : "vcs",
     "url" : "https://github.com/oat-sa/extension-tao-xmledit.git"
    },
    ...

    require" : {
    "oat-sa/extension-tao-xmledit": "dev-develop",
    "oat-sa/extension-tao-xmledit-qtidebugger": "dev-develop",
    ...

Then run:

    composer update oat-sa/extension-tao-xmledit-qtidebugger

    php tao/scripts/installExtension.php xmlEditQtiDebugger

Redirect tao output to the console
----------------------------------

- install TaoDevTools extension\
- configure a UPD appender in /tao/config/generis/log.conf.php\
- launch the UDP listener

    php /tao/taoDevTools/scripts/UDPListener.php
Development tips
================

Install XMLEditQtiDebugger Extension
------------------------------------

This extension adds a XML button to the authoring screen, which display the current content of the QTI Item XML.<br/>

To install, add the following to composer.json:

    "repositories" : [
    {
     "type" : "vcs",
     "url" : "https://github.com/oat-sa/extension-tao-xmledit.git"
    },
    ...

    require" : {
    "oat-sa/extension-tao-xmledit": "dev-develop",
    "oat-sa/extension-tao-xmledit-qtidebugger": "dev-develop",
    ...

Then run:

    composer update oat-sa/extension-tao-xmledit-qtidebugger

    php tao/scripts/installExtension.php xmlEditQtiDebugger

Redirect tao output to the console
----------------------------------

- install TaoDevTools extension\
- configure a UPD appender in /tao/config/generis/log.conf.php\
- launch the UDP listener

    php /tao/taoDevTools/scripts/UDPListener.php

