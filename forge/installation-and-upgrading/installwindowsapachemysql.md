<!--
author:
    - 'Cyril Hazotte'
created_at: '2012-02-19 21:51:25'
updated_at: '2013-07-08 08:43:19'
tags:
    - 'Installation and Upgrading'
-->

TAO on Microsoft Windows with Apache2 & mySQL using WampServer
==============================================================



This installation guide focuses on installing the TAO platform on a Microsoft Windows environment using Apache2, PHP & mySQL. We will use a ready to use AMP (Apache mySQL PHP) stack named WampServer2. It is very simple to install and manage.

1. Installation & Setup of WampServer2
--------------------------------------

### 1.1. Installation

WampServer is the most famours and used AMP stack. It comes with an installer that takes care of everything to set up your web server. First, download the latest [WampServer2 package](http://www.wampserver.com/en/) on the official website. Download the 32 or 64 bit package depending on your Operating System version. Follow the instructions on the screen and launch WampServer.

### 1.2. Setup

A WampServer icon now appears in your Windows system tray. This icon in the tray is a tool that will help us to set up our newly created web server for TAO.

### 1.2.1. PHP Setup

The platform requires multiple PHP extensions to be loaded to run correctly on your Web Server. The PHP extensions that must be running on your web server are the following:

-   php\_mysql
-   php\_curl
-   php\_gd2
-   php\_zip (php\_zip is included in PHP version \> 5.3.10)
-   php\_tidy
-   php\_mbstring

Open WampServer in the system tray and go into **PHP/PHP extensions** and make sure that all extensions listed above are checked.

Your next task is to open the PHP configuration file (php.ini) and changes 3 directives. Open WampServer in the system tray and go to **PHP/php.ini**. Your text editor opens up. Modify the configuration file as below:

    magic_quotes_gpc = Off
    short_open_tag = On
    register_globals = Off

### 1.2.2. MySQL Setup

If you plan to access MySQL using a specific database user (not root), make sure it has the following privileges:\
EXECUTE, SELECT, SHOW DATABASES, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, DELETE, DROP, INDEX, INSERT, UPDATE, RELOAD

If you need more information about database privileges and databases, please visit the [[DatabaseUserPrivileges|page dedicated to this topic]].

### 1.2.3. Apache Setup

The last thing to do is to activate the **Apache Rewrite module**. TAO needs this module to run. To do so, open WampServer in the system tray and check “rewrite\_module” in the **Apache/Apache modules** list.

You are now ready to deploy the TAO platform.

2. TAO Platform Deployment
--------------------------

### 2.1. Download the Latest Version of TAO

We will now download the latest version of the TAO source code and deploy it on the web server. Go to the official TAO [download page](http://taotesting.com/resources/download-tao) and download the latest stable release.

Create a folder named **taoplatform** in the root directory of your web server. Depending on your installation settings, it should be located at **C:\\wamp\\www\\**. You can now unzip the TAO source code previously downloaded in the **taoplatform** folder. You should now have the following directory structure on your file system:

-   C:\\wamp\\www\\taoplatform\\filemanager
-   C:\\wamp\\www\\taoplatform\\generis
-   C:\\wamp\\www\\taoplatform\\taoDelivery
-   C:\\wamp\\www\\taoplatform\\taoGroups
-   …

### 2.2. Creation of a Virtual Host

The TAO platform needs to be run on an Apache Virtual Host to run correctly. We will create a new **Virtual Host** named **taoplatform** by editing the virtual host configuration file of Apache. Depending on your installation settings, it should be located at **C:\\wamp\\bin\\apache\\Apache2.x\\conf\\extra-httpd-vhosts.conf**. Open this file with your favourite text editor and add the following lines at its end.


        ServerAdmin webmaster@taoplatform
        ServerName taoplatform

        DocumentRoot C:\wamp\www\taoplatform

        
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Order allow,deny
            allow from all
        

Open the main Apache2 configuration file located at **C:\\wamp\\bin\\apache\\Apache2.x\\conf\\httpd.conf** and uncomment the following line by removing the leading **\#** character. This will integrate your virtual host configuration in the main Apache2 configuration file.

    Include conf/extra/httpd-vhosts.conf

Do not forget to make the host resolvable by editing your **hosts** file. Open notepad in **administrator mode** and open your hosts file located at **C:\\Windows\\System32\\drivers\\etc\\hosts**. Add the following instructions at the end of the file.

    127.0.0.1   taoplatform

You can now restart your web server to take the new configuration settings into account. To do so, click on the WampServer icon in the system tray and click the **Restart All Services** button.

### 2.3. TAO Installation Wizard

For this last step of the installation process, open up your favourite web browser at http://taoplatform/tao/install. The installation wizard appears. Follow the instructions to finalize your TAO Platform installation.

TAO on Microsoft Windows with Apache2 & mySQL using WampServer
==============================================================



This installation guide focuses on installing the TAO platform on a Microsoft Windows environment using Apache2, PHP & mySQL. We will use a ready to use AMP (Apache mySQL PHP) stack named WampServer2. It is very simple to install and manage.

1. Installation & Setup of WampServer2
--------------------------------------

### 1.1. Installation

WampServer is the most famours and used AMP stack. It comes with an installer that takes care of everything to set up your web server. First, download the latest [WampServer2 package](http://www.wampserver.com/en/) on the official website. Download the 32 or 64 bit package depending on your Operating System version. Follow the instructions on the screen and launch WampServer.

### 1.2. Setup

A WampServer icon now appears in your Windows system tray. This icon in the tray is a tool that will help us to set up our newly created web server for TAO.

### 1.2.1. PHP Setup

The platform requires multiple PHP extensions to be loaded to run correctly on your Web Server. The PHP extensions that must be running on your web server are the following:

-   php\_mysql
-   php\_curl
-   php\_gd2
-   php\_zip (php\_zip is included in PHP version \> 5.3.10)
-   php\_tidy
-   php\_mbstring

Open WampServer in the system tray and go into **PHP/PHP extensions** and make sure that all extensions listed above are checked.

Your next task is to open the PHP configuration file (php.ini) and changes 3 directives. Open WampServer in the system tray and go to **PHP/php.ini**. Your text editor opens up. Modify the configuration file as below:

    magic_quotes_gpc = Off
    short_open_tag = On
    register_globals = Off

### 1.2.2. MySQL Setup

If you plan to access MySQL using a specific database user (not root), make sure it has the following privileges:\
EXECUTE, SELECT, SHOW DATABASES, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, DELETE, DROP, INDEX, INSERT, UPDATE, RELOAD

If you need more information about database privileges and databases, please visit the [[DatabaseUserPrivileges|page dedicated to this topic]].

### 1.2.3. Apache Setup

The last thing to do is to activate the **Apache Rewrite module**. TAO needs this module to run. To do so, open WampServer in the system tray and check “rewrite\_module” in the **Apache/Apache modules** list.

You are now ready to deploy the TAO platform.

2. TAO Platform Deployment
--------------------------

### 2.1. Download the Latest Version of TAO

We will now download the latest version of the TAO source code and deploy it on the web server. Go to the official TAO [download page](http://taotesting.com/resources/download-tao) and download the latest stable release.

Create a folder named **taoplatform** in the root directory of your web server. Depending on your installation settings, it should be located at **C:\\wamp\\www\\**. You can now unzip the TAO source code previously downloaded in the **taoplatform** folder. You should now have the following directory structure on your file system:

-   C:\\wamp\\www\\taoplatform\\filemanager
-   C:\\wamp\\www\\taoplatform\\generis
-   C:\\wamp\\www\\taoplatform\\taoDelivery
-   C:\\wamp\\www\\taoplatform\\taoGroups
-   …

### 2.2. Creation of a Virtual Host

The TAO platform needs to be run on an Apache Virtual Host to run correctly. We will create a new **Virtual Host** named **taoplatform** by editing the virtual host configuration file of Apache. Depending on your installation settings, it should be located at **C:\\wamp\\bin\\apache\\Apache2.x\\conf\\extra-httpd-vhosts.conf**. Open this file with your favourite text editor and add the following lines at its end.


        ServerAdmin webmaster@taoplatform
        ServerName taoplatform

        DocumentRoot C:\wamp\www\taoplatform


            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Order allow,deny
            allow from all


Open the main Apache2 configuration file located at **C:\\wamp\\bin\\apache\\Apache2.x\\conf\\httpd.conf** and uncomment the following line by removing the leading **\#** character. This will integrate your virtual host configuration in the main Apache2 configuration file.

    Include conf/extra/httpd-vhosts.conf

Do not forget to make the host resolvable by editing your **hosts** file. Open notepad in **administrator mode** and open your hosts file located at **C:\\Windows\\System32\\drivers\\etc\\hosts**. Add the following instructions at the end of the file.

    127.0.0.1   taoplatform

You can now restart your web server to take the new configuration settings into account. To do so, click on the WampServer icon in the system tray and click the **Restart All Services** button.

### 2.3. TAO Installation Wizard

For this last step of the installation process, open up your favourite web browser at http://taoplatform/tao/install. The installation wizard appears. Follow the instructions to finalize your TAO Platform installation.


