<!--
created_at: '2017-10-30 13:49:42'
tags:
    - 'Developer Guide'
    - 'Installation and Upgrading'
-->

# Upgrade the tao platform from 3.1 to 3.2

> This page aims to explain how you can upgrade tao from the version 3.1 to version 3.2

## Pre requis

To start this tutorial be sure to have the version 3.1 of the tao platform.
You can see your version at bottom left of the screen

![release 3.1 footer](../resources/release3.2/release3-1.png)

If you don't have a tao platform version 3.1 running please have a look to [installation guide](../../forge/Installation and Upgrading/installubuntuapachemysql.md)


Download the release 3.2 [here](https://www.taotesting.com/get-tao/official-tao-packages) and unzip it

## Upgrade

Copy files from the newly downloaded release 3.2 to the directory where is stored the release 3.1 on your server.
You should replace everything except data and config directories.
Make sure that the user that will access the directories (www-data) have the rights on them.

On your web server launch the command `sudo -u www-data php tao/scripts/taoUpdate.php`

You should now see something like the following image.

![release 3.2 footer](../resources/release3.2/release3-2.png)
