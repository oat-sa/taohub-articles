---
tags: Forge
---

{{\>toc}}

How to manage your Extensions
=============================

In this tutorial, we will focus on how to manage your TAO Extensions.

1. Introduction
---------------

TAO is a versatile product. It provides an Extension mechanism enabling you to fine tune your own TAO platform. We will focus on the discovery of dedicated tools that help you to install and configure TAO extensions. These tools are implemented as Command Line Interface (CLI) scripts, providing multiple *actions* you can perform on your Extensions.

2. TaoExtensions script
-----------------------

The TAOExtensions script can be accessed by CLI on your web server. It is located at *PATH\_TO\_PLATFORM/tao/scripts/taoExtensions.php*. It provides multiple *actions* you can call to install or configure your extensions.

### 2.1. setConfig action

The *setConfig* action allows you to configure the behaviour of your Extensions. With this tool, you can change 3 different configuration parameters that are:

-   **ghost** (boolean): the Extension has to be shown or not by the Graphical User Interface (GUI)

For instance, if you want the *taoCoding* Extension to be shown in the TAO GUI, just type the following command.

    cd PATH_TO_PLATFORM/tao/scripts
    php taoExtensions.php -v -u=user -p=password -a=setConfig -cP=ghost -cV=false -e=taoExtension

Some information about this command:

-   **-v** is the verbose mode *<span class="boolean"></span>*
-   **-u** is the TAO backoffice user who will connect to the TAO API to acquire Database access *<span class="string"></span>*
-   **-p** is the TAO backoffice password *<span class="string"></span>*
-   **-a** is the action to perform. In this case, set a configuration parameter to a given value *<span class="string"></span>*
-   **-cP** is the configuration parameter to change *<span class="string"></span>*
-   **-cV** is the configuration value *<span class="boolean"></span>*
-   **-e** is the extension your parameter will apply on *<span class="string"></span>*

### 2.2. install action

The *install* action enables you to install a third-party extension on your existing TAO platform instance. The procedure is split in two steps.

#### 2.2.1 Unzip your extension

Third-party extensions are packaged as ZIP archives. The first task you have to do is to unzip your extension in the root directory of your TAO installation, on the server-side. When done, you should find a directory named as the identifier of the extension. For instance, unzipping the *taoDocs* extension will produce a *taoDocs* folder in the root directory of your TAO installation.

#### 2.2.1 Install your extension

You now have to invoke the *install* action of the *TAOExtensions* script to activate the extension. You will find below an example that installs the *taoDocs* extension on your platform.

    cd PATH_TO_PLATFORM/tao/scripts
    php taoExtensions.php -v -u=user -p=password -a=install -e=taoDocs

where:

-   **-v** is the verbose mode *<span class="boolean"></span>*
-   **-u** is the TAO backoffice user who will connect to the TAO API to acquire Database access *<span class="string"></span>*
-   **-p** is the TAO backoffice password *<span class="string"></span>*
-   **-a** is the action to perform. In this situation, install an extension *<span class="string"></span>*
-   **-e** is the identifier of the extension to install *<span class="string"></span>*

