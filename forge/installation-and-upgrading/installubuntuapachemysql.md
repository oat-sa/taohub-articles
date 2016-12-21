<!--
parent:
    title: Installation_and_Upgrading
author:
    - 'Gyula Szucs'
created_at: '2012-09-27 14:48:30'
updated_at: '2016-09-19 14:12:48'
tags:
    - 'Installation and Upgrading'
-->

TAO on Debian, Ubuntu with Apache2 & mySQL
==========================================

{{\>toc}}

This installation guide focuses on installing the TAO platform on Ubuntu using Apache2, PHP & mySQL.

1. Apache2, PHP & mySQL Installation
------------------------------------

### 1.1. Apache2.4 Installation

The first step of the installation of our environment is to install the Apache2 web server (recommended version 2.4). To do so, open up a terminal and type the following command lines. The *apt-get update* command aims at updating your system. You can skip this command if you think your system is up to date.

    sudo apt-get update
    sudo apt-get upgrade
    sudo apt-get install apache2

### 1.2. PHP Installation

The supported PHP versions are 5.4, 5.5 and 5.6. Support of PHP7 is on its way and will be released soon.

To install the latest PHP and modules needed by the TAO platform to run, open up a terminal and enter the following commands.

    sudo apt-get install php5
    sudo apt-get install php5-gd php5-mysql php5-tidy php5-curl php5-mbstring php5-zip php5-xml php-xml-parser

\> If you want to install a lower version of PHP and you already have a higher version installed on your system, then you can do it on two ways. The first is removing the higher version, the second is installing the other version straightaway so you will have the two version installed together. If you want the last option, skip the following block and start with adding a new PPA.

\> To remove the old php packages installed, use the following commands:<br/>

\> <pre><br/>
 \# replace PACKAGE with the proper names of the PHP packages installed, like “php5-cli php5-curl” etc.<br/>

 sudo apt-get remove —purge PACKAGE<br/>
 sudo apt-get update

</pre>
\> Use the following set of command to add PPA and install **PHP 5.5 or 5.6**<br/>
\><pre><br/>
sudo add-apt-repository ppa:ondrej/php<br/>
sudo apt-get update<br/>
sudo apt-get install -y php5.5 php5.5-gd php5.5-mysql php5.5-tidy php5.5-curl php5.5-mbstring php5.5-zip php5.5-xml php-xml-parser \#for PHP 5.5<br/>
sudo apt-get install -y php5.6 php5.6-gd php5.6-mysql php5.6-tidy php5.6-curl php5.6-mbstring php5.6-zip php5.6-xml php-xml-parser \#for PHP 5.6

</pre>
\> If you need **PHP 5.4**, use the these commands:<br/>

\><pre><br/>
sudo add-apt-repository ppa:ondrej/php5-oldstable<br/>
sudo apt-get update<br/>
sudo apt-get upgrade<br/>
sudo apt-get install -y php5 php5-gd php5-mysql php5-tidy php5-curl php5-mbstring php5-zip php5-xml php-xml-parser

</pre>
\> If you’ve selected the second option, you should have two php version installed on your system by now. To switch between the versions, use the following commands:<br/>

\> \* Apache <pre>sudo a2dismod php7.0 ; sudo a2enmod php5.6 ; sudo service apache2 restart</pre><br/>
\> \* CLI <pre>sudo ln -sfn /usr/bin/php5.6 /etc/alternatives/php</pre>

PHP and its modules required by TAO are now installed on the computer.

### 1.3. mySQL Installation

The last component to install is mySQL server.

    sudo apt-get install mysql-server

mySQL serveer will install and you’re prompt to put a *root* password.

2. Apache2, PHP & mySQL Setup
-----------------------------

### 2.1. Apache2 Setup

#### 2.1.1. Service Configuration

We just have to check if Apache2 is correctly running. Simply open up your web browser and access *http://localhost*. An Apache2 test page containing “It Works!” should be displayed in your web browser.

#### 2.1.2. Virtual Host

The TAO platform requires to be run with an *Apache Virtual Host*. We will create such a virtual host in the Apache2 configuration file. Edit the file located at */etc/apache2/sites-available/taoplatform.conf* with your favourite editor. We will use *nano*.

    sudo nano /etc/apache2/sites-available/taoplatform.conf

Now, we create a virtual host named *taoplatform*. Its *DocumentRoot* is */var/www/taoplatform*. This is where the TAO source code will be actually deployed. We will create this directory later at deployment-time. Feel free to change its name according to your needs. Insert the following lines at the end of the file we are currently editing.

    NameVirtualHost 127.0.0.1:80
    ServerName localhost


        ServerAdmin webmaster@taoplatform
        ServerName taoplatform

        DocumentRoot /var/www/taoplatform

        
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        

You can save the file now. Some explanations about this Virtual Host configuration:

-   **NameVirtualHost** with the NameVirtualHost directive you specify the IP address on which the server will receive requests for the name-based virtual hosts. This will usually be the address to which your name-based virtual host names resolve.
-   **ServerAdmin** sets the e-mail address that the server includes in any error messages it returns to the client.
-   **ServerName** sets hostname and port that the server uses to identify itself. Here we affect the hostname *taoplatform* but it could be *www.tao-platform.com* or *www.tao-platform.com:80*.
-   **DocumentRoot** is the root directory where we place the PHP source code that concerns the TAO Platform. We will create later in this tutorial the */var/www/taoplatform* directory.

Then you need to activate the site and reload the apache2 configuration

    sudo a2ensite taoplatform
    sudo service apache2 reload

More information about Apache directives and virtual hosting:

-   [Apache directives](http://httpd.apache.org/docs/2.4/mod/core.html)
-   [Apache virtual hosting](http://httpd.apache.org/docs/2.4/vhosts/)

#### 2.1.3. Rewrite Module

The TAO Platform requires the Apache2 module *rewrite\_module* to be installed to run perfectly. The Rewrite Module of Apache is most of the time enabled at installation time in major Linux distributions. To check if *rewrite\_module* is present and running, type the following command in your terminal.

    sudo apachectl -t -D DUMP_MODULES

You should see the list of running modules and the *rewrite\_module (shared)* entry. If you find it, you can skip this and go to the next section of this guide. If you do not see it, you will have to install it.

To install the Apache2 module *rewrite\_module* just type following command line

    sudo a2enmod rewrite

and restart your web server to make the modification effective.

    sudo service apache2 restart

#### 2.1.4. Folders, Rights and Host Resolution

We now have to create the *taoplatform* folder in /var/www. To do so, type the following commands.

    cd /var/www
    sudo mkdir taoplatform

By default, Apache2 runs as the *www-data* user that belongs to the *www-data* group. We then bind the *taoplatform* directory to the *www-data* group.

    sudo chgrp www-data taoplatform

We will deal with read-write-execute permissions later on. Finally, we add an entry in the *hosts* file of the Operating System to make Apache2 able to resolve *taoplatform*.

    sudo nano /etc/hosts

Append the following line in the file:

    127.0.0.1   taoplatform

Finally, we restart Apache to take this new configuration into account.

    sudo service apache2 restart

### 2.2. PHP Setup

The PHP Setup is quick and simple. Open the PHP configuration file located at */etc/php5/apache2/php.ini*.

    sudo nano /etc/php5/apache2/php.ini

Make sure that the following configuration options are correct.

    magic_quotes_gpc = Off (not needed in PHP 5.4)
    short_open_tag = On
    register_globals = Off (not needed in PHP 5.4)

In most versions of PHP, they are correctly set. However, if you have to make any change, save the file and restart your Apache2 web server to make this new configuration taken into account.

    sudo service apache2 restart

### 2.3. mySQL Setup

The following setup operation is optional. If you want to make a secure installation of mySQL by changing its *root* password, enter the following command in your terminal.

    mysql_secure_installation

The *mysql\_secure\_installation* program will simply ask you for a new *root* password.

**Important!** If you plan to access MySQL using a specific database user (not root), make sure it has the following privileges:<br/>

EXECUTE, SELECT, SHOW DATABASES, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, DELETE, DROP, INDEX, INSERT, UPDATE, RELOAD

If you need more information about database privileges and databases, please visit the [[DatabaseUserPrivileges|page dedicated to this topic]].

3. TAO Platform Deployment
--------------------------

### 3.1. Download the Latest Version of TAO

We will now download the latest version of the TAO source code and deploy it on the web server. Go to the official TAO download page and download the last [Stable Release](http://tao-assessment.com/resources/download-tao).

    wget http://releases.taotesting.com/TAO_3.1.0-RC3_build.zip

Suppose we saved the TAO source code zip archive in */home/myuser/TAO\_3.1.0-RC3\_build.zip*. Run the following command lines to extract the content of the archive in the dedicated directory */var/www/taoplatform* we created previously in this guide.

    cd /home/myuser
    sudo unzip TAO_3.1.0-RC3_build.zip -d /var/www/taoplatform

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

We now have to make sure that file system permission in the */var/www/taoplatform* directory makes Apache able to read, write, and execute correctly files belonging to the TAO platform. All files must be accessible by the *www-data* user & group.

    cd /var/www
    sudo chown -R www-data taoplatform
    sudo chgrp -R www-data taoplatform
    sudo chmod -R 775 taoplatform

### 3.3. TAO Installation Wizard

For this last step of the installation process, open up your favourite web browser at http://taoplatform/tao/install. The installation wizard appears.

Check if all the System Configuration entries are “green”. If it is not the case, please check that each step of this guide are done. If you still experience issues, feel free to contact us on the forum.

Finally, follow the instructions to finalize your TAO Platform installation.

