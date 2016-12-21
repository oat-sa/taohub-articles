<!--
parent:
    title: Installation_and_Upgrading
author:
    - 'Jérôme Bogaerts'
created_at: '2012-03-09 16:42:44'
updated_at: '2013-06-17 08:20:12'
tags:
    - 'Installation and Upgrading'
-->

TAO on CentOS, Red Hat, Fedora, Amazon Linux with Apache2 & mySQL
=================================================================

{{\>toc}}

This installation guide focuses on installing the TAO platform on CentOS, Red Hat, Amazon Linux using Apache2, PHP & mySQL.

1. Apache2, PHP & mySQL Installation
------------------------------------

### 1.1. Apache2 Installation

The first step of the installation of our environment is to install the Apache2 web server. To do so, open up a terminal and type the following command lines. The *yum update* command aims at updating your system. You can skip this command if you think your system is up to date.

    sudo yum update
    sudo yum install httpd

### 1.2. PHP Installation

To Install PHP and modules needed by the TAO platform to run, open up a terminal and enter the following commands.

    sudo yum install php
    sudo yum install php-gd
    sudo yum install php-mysql
    sudo yum install php-tidy
    sudo yum install curl
    sudo yum install php-mbstring
    sudo yum install php-xml

PHP and its modules required by TAO are now installed on the computer.

### 1.3. mySQL Installation

The last component to install is mySQL server.

    sudo yum install mysql-server

mySQL server is now installed with a preconfigured mySQL user *root* without password.

2. Apache2, PHP & mySQL Setup
-----------------------------

### 2.1. Apache2 Setup

#### 2.1.1. Service Configuration

We now have to configure Apache2. First, we will make the Apache2 service start when the Operating System starts up. We will also start the service for the first time.

    sudo chkconfig --level 35 httpd on
    sudo service httpd start

To check if Apache2 is running, simply open up your web browser and access *http://localhost*. An Apache2 test page should be displayed in your web browser.

#### 2.1.2. Virtual Host

The TAO platform requires to be run with an *Apache Virtual Host*. We will create such a virtual host in the Apache2 configuration file. Edit the file located at */etc/httpd/conf/httpd.conf* with your favourite editor. We will use *nano*.

    sudo nano /etc/httpd/httpd.conf

Now, we create a virtual host named *taoplatform*. Its *DocumentRoot* is */var/www/taoplatform*. This is where the TAO source code will be actually deployed. We will create this directory later at deployment-time. Feel free to change its name according to your needs. Insert the following lines at the end of the file we are currently editing.

    NameVirtualHost 127.0.0.1:80
    ServerName localhost


        ServerAdmin webmaster@taoplatform
        ServerName taoplatform

        DocumentRoot /var/www/taoplatform

        
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Order allow,deny
            allow from all
        

You can save the file now. Some explanations about this Virtual Host configuration:

-   **NameVirtualHost** with the NameVirtualHost directive you specify the IP address on which the server will receive requests for the name-based virtual hosts. This will usually be the address to which your name-based virtual host names resolve.
-   **ServerAdmin** sets the e-mail address that the server includes in any error messages it returns to the client.
-   **ServerName** sets hostname and port that the server uses to identify itself. Here we affect the hostname *taoplatform* but it could be *www.tao-platform.com* or *www.tao-platform.com:80*.
-   **DocumentRoot** is the root directory where we place the PHP source code that concerns the TAO Platform. We will create later in this tutorial the */var/www/taoplatform* directory.

More information about Apache directives and virtual hosting:

-   [Apache directives](http://httpd.apache.org/docs/2.0/mod/core.html)
-   [Apache virtual hosting](http://httpd.apache.org/docs/2.0/vhosts/)

#### 2.1.3. Rewrite Module

The TAO Platform requires the Apache2 module *rewrite\_module* to be installed to run perfectly. The Rewrite Module of Apache is most of the time enabled at installation time in major Linux distributions. To check if *rewrite\_module* is present and running, type the following command in your terminal.

    sudo apachectl -t -D DUMP_MODULES

You should see the list of running modules and the *rewrite\_module (shared)* entry. If you find it, you can skip this and go to the next section of this guide. If you do not see it, please go the [*rewrite\_module* official page](http://httpd.apache.org/docs/current/mod/mod_rewrite.html) to get information about how to install it.

#### 2.1.4. Folders, Rights and Host Resolution

We now have to create the *taoplatform* folder in /var/www. To do so, type the following commands.

    cd /var/www
    sudo mkdir taoplatform

By default, Apache2 runs as the apache user that belongs to the *apache* group. We then bind the *taoplatform* directory to the *apache* group.

    sudo chgrp apache taoplatform

We will deal with read-write-execute permissions later on. Finally, we add an entry in the *hosts* file of the Operating System to make Apache2 able to resolve *taoplatform*.

    sudo nano /etc/hosts

Append the following line in the file:

    127.0.0.1   taoplatform

Finally, we restart Apache to take this new configuration into account.

    sudo service httpd restart

### 2.2. PHP Setup

The PHP Setup is quick and simple. Open the PHP configuration file located at */etc/php.ini*.

    sudo nano /etc/php.ini

Make sure that the following configuration options are correct.

    magic_quotes_gpc = Off (not needed in PHP 5.4)
    short_open_tag = On
    register_globals = Off (not needed in PHP 5.4)

In most versions of PHP, they are correctly set. However, if you have to make any change, save the file and restart your Apache2 web server to make this new configuration taken into account.

    sudo service httpd restart

### 2.3. mySQL Setup

Your first task is to configure the service to start it when the Operating System starts up.

    sudo chkconfig --level 35 mysqld on
    sudo service mysqld start

The following setup operation is optional. If you want to make a secure installation of mySQL by changing its *root* password, enter the following command in your terminal. The *mysql\_secure\_installation* program will simply ask you for a new *root* password.

**Important!** If you plan to access MySQL using a specific database user (not root), make sure it has the following privileges:\
EXECUTE, SELECT, SHOW DATABASES, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, DELETE, DROP, INDEX, INSERT, UPDATE, RELOAD

If you need more information about database privileges and databases, please visit the [[DatabaseUserPrivileges|page dedicated to this topic]].

3. TAO Platform Deployment
--------------------------

### 3.1. Download the Latest Version of TAO

We will now download the latest version of the TAO source code and deploy it on the web server. Go to the official TAO download page and download the last [Stable Release](http://www.tao.lu/html/index.php?option=com_content&view=article&id=62&Itemid=139).

Suppose we saved the TAO source code zip archive in */home/myuser/TAO\_2.1.01\_build.zip*. Run the following command lines to extract the content of the archive in the dedicated directory */var/www/taoplatform* we created previously in this guide.

    cd /home/myuser
    sudo unzip TAO_2.1.01_build.zip -d /var/www/taoplatform

If you list the content of */var/www/taoplatform*, you should see the following file & directory structure:

-   */var/www/taoplatform/crossdomain.xml*
-   */var/www/taoplatform/favicon.ico*
-   */var/www/taoplatform/fdl-1.3.txt*
-   */var/www/taoplatform/filemanager*
-   */var/www/taoplatform/generis*
-   */var/www/taoplatform/gpl-2.0.txt*
-   */var/www/taoplatform/index.php*
-   */var/www/taoplatform/tao*
-   */var/www/taoplatform/taoDelivery*
-   */var/www/taoplatform/taoGroups*
-   */var/www/taoplatform/taoItems*
-   */var/www/taoplatform/taoResults*
-   */var/www/taoplatform/taoSubjects*
-   */var/www/taoplatform/taoTests*
-   */var/www/taoplatform/wfEngine*

### 3.2. File System Permissions

We now have to make sure that file system permission in the */var/www/taoplatform* directory makes Apache able to read, write, and execute correctly files belonging to the TAO platform. All files must be accessible by the *apache* user & group.

    cd /var/www
    chown -R apache taoplatform
    chgrp -R apache taoplatform
    chmod -R 775 taoplatform

### 2.3. TAO Installation Wizard

For this last step of the installation process, open up your favourite web browser at http://taoplatform/tao/install. The installation wizard appears.

Check if all the System Configuration entries are “green”. If it is not the case, please check that each step of this guide are done. If you still experience issues, feel free to contact us on the forum.

Finally, follow the instructions to finalize your TAO Platform installation.

