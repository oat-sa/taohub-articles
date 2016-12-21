<!--
author:
    - 'Joel Bout'
created_at: '2011-02-08 11:14:38'
updated_at: '2014-03-07 13:53:18'
tags:
    - 'Documentation for core components'
-->

![](http://forge.taotesting.com/attachments/download/760/attention.png)**This page is deprecated and needs to be rewritten**

Items’ migration
================

Why migrate items
-----------------

Since the version 1.3 of TAO, we focus on new kind of Items and have decided to define the others as deprecated. In order to prevent the lost of your item and to use the new technologies, we provide a tool to migrate your deprecated items into one of the new item type.

  ---------------------------- --------------------------------------------------------------------- --------------------------------------------------------------------- -------------------------------------------------------------------
  \\4=.**Items types state**
  \_.Type
  QCM
  Campus
  Khos
  CTest
  HAWAI
  QTI
  Open Web Item
  ---------------------------- --------------------------------------------------------------------- --------------------------------------------------------------------- -------------------------------------------------------------------

  ----------------- -------------------------------------------------------------------
  \\2=.States
  Normal
  Deprecated
  Not implemented
  Exeperimental
  ----------------- -------------------------------------------------------------------

How to migrate items
--------------------

There is a command line script to run with a few arguments to migrate your items.

The script is located in `taoItems/scripts` and is called `migrateLegacy.php`\
To run it

\* On a Mac/Unix/Linux System:

    cd taoItems/scripts
    php migrateLegacy.php --arg1=value1 --arg2=value2

\* On a Windows System:

    CD taoItems\scripts
    C:\PHP5\php.exe -f "migrateLegacy.php" -- -arg1=value1 -arg2=value2

To get the description of the script options, just launch it with the help argument.

Usage:`php migrateLegacy.php [arguments]`

  -------------------- ------------- ------------- --------- -------------------------------------------------------------------------------
  \\5=.**Arguments**
  \_.Name
  input
  output
  uri
  addResource
  class
  pack
  -------------------- ------------- ------------- --------- -------------------------------------------------------------------------------

We can distinguish 3 scenarios:

1.  You have a TAO installation of a previous version (1.1 for instance) and you want to migrate all your items.
2.  You have some items files that you would like to convert but independently of a TAO installation.
3.  You have some items files that you would like to insert in a recent TAO distribution.

Regarding the scenario that match the best to your needs, you will run the script with a specific combination of arguments.\
For example, for the second scenario, we will use the *input*, *output* and *pack* arguments. The command will look like this:

    php migrateLegacy.php --input=path/to/myQCM.xml --output=path/to/newitem/folder/ --pack=true

*or using the shortcuts syntax*

    php migrateLegacy.php -i path/to/myQCM.xml -o path/to/newitem/folder/ -p true
![](http://forge.taotesting.com/attachments/download/760/attention.png)**This page is deprecated and needs to be rewritten**

Items’ migration
================

Why migrate items
-----------------

Since the version 1.3 of TAO, we focus on new kind of Items and have decided to define the others as deprecated. In order to prevent the lost of your item and to use the new technologies, we provide a tool to migrate your deprecated items into one of the new item type.

  ---------------------------- --------------------------------------------------------------------- --------------------------------------------------------------------- -------------------------------------------------------------------
  \\4=.**Items types state**
  \_.Type
  QCM
  Campus
  Khos
  CTest
  HAWAI
  QTI
  Open Web Item
  ---------------------------- --------------------------------------------------------------------- --------------------------------------------------------------------- -------------------------------------------------------------------

  ----------------- -------------------------------------------------------------------
  \\2=.States
  Normal
  Deprecated
  Not implemented
  Exeperimental
  ----------------- -------------------------------------------------------------------

How to migrate items
--------------------

There is a command line script to run with a few arguments to migrate your items.

The script is located in `taoItems/scripts` and is called `migrateLegacy.php`\
To run it

\* On a Mac/Unix/Linux System:

    cd taoItems/scripts
    php migrateLegacy.php --arg1=value1 --arg2=value2

\* On a Windows System:

    CD taoItems\scripts
    C:\PHP5\php.exe -f "migrateLegacy.php" -- -arg1=value1 -arg2=value2

To get the description of the script options, just launch it with the help argument.

Usage:`php migrateLegacy.php [arguments]`

  -------------------- ------------- ------------- --------- -------------------------------------------------------------------------------
  \\5=.**Arguments**
  \_.Name
  input
  output
  uri
  addResource
  class
  pack
  -------------------- ------------- ------------- --------- -------------------------------------------------------------------------------

We can distinguish 3 scenarios:

1.  You have a TAO installation of a previous version (1.1 for instance) and you want to migrate all your items.
2.  You have some items files that you would like to convert but independently of a TAO installation.
3.  You have some items files that you would like to insert in a recent TAO distribution.

Regarding the scenario that match the best to your needs, you will run the script with a specific combination of arguments.<br/>

For example, for the second scenario, we will use the *input*, *output* and *pack* arguments. The command will look like this:

    php migrateLegacy.php --input=path/to/myQCM.xml --output=path/to/newitem/folder/ --pack=true

*or using the shortcuts syntax*

    php migrateLegacy.php -i path/to/myQCM.xml -o path/to/newitem/folder/ -p true

