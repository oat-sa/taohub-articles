<!--
parent: 'Installation and Upgrading'
created_at: '2012-09-27 14:48:30'
updated_at: '2017-03-15 14:45:48'
authors:
    - 'Tom Verhoof'
tags:
    - 'Installation and Upgrading'
-->

# TAO on Debian, Ubuntu with Apache2 & mySQL

This installation guide focuses on installing the TAO platform on Ubuntu using Apache2, PHP & mySQL.

## 1. Apache2, PHP & mySQL Installation
------------------------------------

### 1.1. Apache2.4 Installation

The first step of the installation of our environment is to install the Apache2 web server (recommended version 2.4). To do so, open up a terminal and type the following command lines. The *apt-get update* command aims at updating your system. You can skip this command if you think your system is up to date.

```shell
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install apache2
```

### 1.2. PHP Installation

The supported PHP version is 7.

To install the latest PHP and modules needed by the TAO platform to run, open up a terminal and enter the following commands.

```shell
sudo apt-get install php
sudo apt-get install php-gd php-mysql php-tidy php-curl php-mbstring php-zip php-xml php-xml-parser
```

You'll also need to insert this commands to enable PHP with Apache.

```shell
sudo apt-get install libapache2-mod-php
sudo a2dismod worker
sudo a2enmod php7.0
sudo /etc/init.d/apache2 restart
```

PHP and its modules required by TAO are now installed on the computer.

### 1.3. MySQL Installation

The last component to install is MySQL server.

```shell
sudo apt-get install mysql-server
```

MySQL server will install and you’re prompt to put a *root* password.

## 2. Apache2, PHP & mySQL Setup
-----------------------------

### 2.1. Apache2 Setup

#### 2.1.1. Service Configuration

We just have to check if Apache2 is correctly running. Simply open up your web browser and access *http://localhost*. An Apache2 test page containing “It Works!” should be displayed in your web browser.

#### 2.1.2. Virtual Host

The TAO platform requires to be run with an *Apache Virtual Host*. We will create such a virtual host in the Apache2 configuration file. Edit the file located at */etc/apache2/sites-available/taoplatform.conf* with your favourite editor. We will use *nano*.

```shell
sudo nano /etc/apache2/sites-available/taoplatform.conf
```


Now, we create a virtual host named *taoplatform*. Its *DocumentRoot* is */var/www/taoplatform*. This is where the TAO source code will be actually deployed. We will create this directory later at deployment-time. Feel free to change its name according to your needs. Insert the following lines at the end of the file we are currently editing.

```md
NameVirtualHost 127.0.0.1:80
ServerName localhost

<VirtualHost *:80>
	ServerAdmin webmaster@taoplatform
	ServerName taoplatform
	DocumentRoot /var/www/taoplatform    

	<Directory /var/www/taoplatform>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>
```

You can save the file now. Some explanations about this Virtual Host configuration:

-   **NameVirtualHost** with the NameVirtualHost directive you specify the IP address on which the server will receive requests for the name-based virtual hosts. This will usually be the address to which your name-based virtual host names resolve.
-   **ServerAdmin** sets the e-mail address that the server includes in any error messages it returns to the client.
-   **ServerName** sets hostname and port that the server uses to identify itself. Here we affect the hostname *taoplatform* but it could be *www.tao-platform.com* or *www.tao-platform.com:80*.
-   **DocumentRoot** is the root directory where we place the PHP source code that concerns the TAO Platform. We will create later in this tutorial the */var/www/taoplatform* directory.

Then you need to activate the site and reload the apache2 configuration

```shell
sudo a2ensite taoplatform
sudo service apache2 reload
```

More information about Apache directives and virtual hosting:

-   [Apache directives](http://httpd.apache.org/docs/2.4/mod/core.html)
-   [Apache virtual hosting](http://httpd.apache.org/docs/2.4/vhosts/)

#### 2.1.3. Rewrite Module

The TAO Platform requires the Apache2 module *rewrite_module* to be installed to run perfectly. The Rewrite Module of Apache is most of the time enabled at installation time in major Linux distributions. To check if *rewrite_module* is present and running, type the following command in your terminal.

```shell
sudo apachectl -t -D DUMP_MODULES
```

You should see the list of running modules and the *rewrite_module (shared)* entry. If you find it, you can skip this and go to the next section of this guide. If you do not see it, you will have to install it.

To install the Apache2 module *rewrite_module* just type following command line

```shell
sudo a2enmod rewrite
```

and restart your web server to make the modification effective.

```shell
sudo service apache2 restart
```

#### 2.1.4. Folders, Rights and Host Resolution

We now have to create the *taoplatform* folder in /var/www. To do so, type the following commands.

```shell
cd /var/www
sudo mkdir taoplatform
```

By default, Apache2 runs as the *www-data* user that belongs to the *www-data* group. We then bind the *taoplatform* directory to the *www-data* group.

```shell
sudo chgrp www-data taoplatform
```

We will deal with read-write-execute permissions later on. Finally, we add an entry in the *hosts* file of the Operating System to make Apache2 able to resolve *taoplatform*.

```shell
sudo nano /etc/hosts
```

Append the following line in the file:

```shell
127.0.0.1   taoplatform
```

Finally, we restart Apache to take this new configuration into account.

```shell
sudo service apache2 restart
```

### 2.2. PHP Setup

The PHP Setup is quick and simple. Open the PHP configuration file located at */etc/php/7.0/cli/php.ini* or *php/7.x* if you have a newer version of PHP.

```shell
sudo nano /etc/php/7.0/cli/php.ini
```

Make sure that the following configuration options are correct.

```shell
short_open_tag = On
```

In most versions of PHP, they are correctly set. However, if you have to make any change, save the file and restart your Apache2 web server to make this new configuration taken into account.

```shell
sudo service apache2 restart
```

### 2.3. mySQL Setup

The following setup operation is optional. If you want to make a secure installation of mySQL by changing its *root* password, enter the following command in your terminal.

```shell
mysql_secure_installation
```

The *mysql_secure_installation* program will simply ask you for a new *root* password.

**Important!** If you plan to access MySQL using a specific database user (not root), make sure it has the following privileges:<br/>

EXECUTE, SELECT, SHOW DATABASES, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, DELETE, DROP, INDEX, INSERT, UPDATE, RELOAD

If you need more information about database privileges and databases, please visit the DatabaseUserPrivileges|page dedicated to this topic.

## 3. TAO Platform Deployment
--------------------------

### 3.1. Download the Latest Version of TAO

We will now download the latest version of the TAO source code and deploy it on the web server. Go to the official TAO download page and download the last [Stable Release](https://www.taotesting.com/get-tao/official-tao-packages/).
Unzip that folder under the /var/www/taoplatform directory. Make sure the files are directly accessible, not through a subdirectory.

```shell
cd /var/www
sudo rmdir taoplatform
sudo wget http://releases.taotesting.com/TAO_3.1.0-RC7_build.zip
sudo unzip TAO_3.1.0-RC7_build.zip
sudo mv TAO_3.1.0-RC7_build taoplatform/
sudo rm TAO_3.1.0-RC7_build.zip 
```

If you list the content of */var/www/taoplatform*, you should see the following file & directory structure:

-    */var/www/taoplatform/composer.json*
-    */var/www/taoplatform/composer.lock*
-    */var/www/taoplatform/config*
-    */var/www/taoplatform/data*
-    */var/www/taoplatform/favicon.ico*
-    */var/www/taoplatform/fdl-1.3.txt*
-    */var/www/taoplatform/funcAcl*
-    */var/www/taoplatform/generis*
-    */var/www/taoplatform/gpl-2.0.txt*
-    */var/www/taoplatform/.htaccess*
-    */var/www/taoplatform/index.php*
-    */var/www/taoplatform/LICENSE*
-    */var/www/taoplatform/tiDeliveryProvider*
-    */var/www/taoplatform/pciSamples*
-    */var/www/taoplatform/phpunit.xml*
-    */var/www/taoplatform/qtiItemPci*
-    */var/www/taoplatform/qtiItemPic*
-    */var/www/taoplatform/README.md*
-    */var/www/taoplatform/tao*
-    */var/www/taoplatform/taoBackOffice*
-    */var/www/taoplatform/taoCe*
-    */var/www/taoplatform/taoDacSimple*
-    */var/www/taoplatform/taoDelivery*
-    */var/www/taoplatform/taoDeliveryRdf*
-    */var/www/taoplatform/taoGroups*
-    */var/www/taoplatform/taoItems*
-    */var/www/taoplatform/taoLti*
-    */var/www/taoplatform/taoLtiBasicOutcome*
-    */var/www/taoplatform/taoMediaManager*
-    */var/www/taoplatform/taoOpenWebItem*
-    */var/www/taoplatform/taoOutcomeRds*
-    */var/www/taoplatform/taoOutcomeUi*
-    */var/www/taoplatform/taoQtiItem*
-    */var/www/taoplatform/taoQtiTest*
-    */var/www/taoplatform/taoResultServer*
-    */var/www/taoplatform/taoRevision*
-    */var/www/taoplatform/taoTestLinear*
-    */var/www/taoplatform/taoTests*
-    */var/www/taoplatform/taoTestTaker*
-    */var/www/taoplatform/taoWorkspace*
-    */var/www/taoplatform/tests*
-    */var/www/taoplatform/vendor*

### 3.2. File System Permissions

We now have to make sure that file system permission in the */var/www/taoplatform* directory makes Apache able to read, write, and execute correctly files belonging to the TAO platform. All files must be accessible by the *www-data* user & group.

```shell
cd /var/www
sudo chown -R www-data taoplatform
sudo chgrp -R www-data taoplatform
sudo chmod -R 775 taoplatform
```

### 3.3. TAO Installation Wizard

For this last step of the installation process, open up your favourite web browser at http://taoplatform/tao/install. The installation wizard appears.

Check if all the System Configuration entries are “green”. If it is not the case, please check that each step of this guide are done. If you still experience issues, feel free to contact us on the forum.

Finally, follow the instructions to finalize your TAO Platform installation.


