<!--
author:
    - 'Patrick Plichart'
created_at: '2015-05-27 14:29:13'
updated_at: '2015-05-27 14:30:28'
-->

Raspberry30
===========

*When open source meets open hardware ….*

Your Raspberry contains full apache mysql php stack, in short everything that is needed to run TAO !

As soon as it is powered and plugged into your network, you may start creating your own assessment and deliver them to your students.

Getting started
---------------

- plug a usb cable to power it on, all the software will automatically boot an start serving tao on your network

- The only tweaking consists in identifying the raspberry PI on your network and find out the right URL to be typed in into your favorite web browser.

Plug it on your network ! Find its IP on your network :\
If you are running Linux, you ay find the IP of the PI using this command line:

    fping -a -r1 -g 192.168.254.0/24  &> /dev/null arp –n| fgrep " b8:27:eb"

On your own workstation from which you would like either to create new tests or take tests, add this line to your *hosts* file

    YOUR.RASP.BERRY.IP  pitao

TAO account
-----------

TAO is presinstalled and contains already an admin account\
Access TAO using your web browser at http://pitao/\
TAO admin user : pitao/pitao

System account
--------------

You may want to tweak the sytem to your own needs, the default account is :\
Ssh: pi / raspberry

Raspberry30
===========

*When open source meets open hardware ….*

Your Raspberry contains full apache mysql php stack, in short everything that is needed to run TAO !

As soon as it is powered and plugged into your network, you may start creating your own assessment and deliver them to your students.

Getting started
---------------

- plug a usb cable to power it on, all the software will automatically boot an start serving tao on your network

- The only tweaking consists in identifying the raspberry PI on your network and find out the right URL to be typed in into your favorite web browser.

Plug it on your network ! Find its IP on your network :\
If you are running Linux, you ay find the IP of the PI using this command line:

    fping -a -r1 -g 192.168.254.0/24  &> /dev/null arp –n| fgrep " b8:27:eb"

On your own workstation from which you would like either to create new tests or take tests, add this line to your *hosts* file

    YOUR.RASP.BERRY.IP  pitao

TAO account
-----------

TAO is presinstalled and contains already an admin account\
Access TAO using your web browser at http://pitao/\
TAO admin user : pitao/pitao

System account
--------------

You may want to tweak the sytem to your own needs, the default account is :\
Ssh: pi / raspberry


