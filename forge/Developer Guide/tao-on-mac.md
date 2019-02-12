<!--
parent: 'Developer Guide'
created_at: '2010-02-12 11:00:00'
updated_at: '2010-02-12 11:00:00'
authors:
    - 'Bartlomiej Marszal'
tags:
    - 'Onboarding'
    - 'Developer Guide'
-->

# Installation TAO Platform on MacOs

[Requirements](../Administrator%20Guide/requirements.md)

This instructions are base on online tutorials available 

[Apache, PHP Instructions](https://getgrav.org/blog/macos-mojave-apache-multiple-php-versions)

[Mysql, Vhosts Instructions](https://getgrav.org/blog/macos-mojave-apache-mysql-vhost-apc)

## Instructions

### Brew installation

PLease visit [brew website](https://brew.sh) for most actual instructions.

`$ /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

Now you can easily install missing packages such as wget or git using followed command:

`$ brew install wget`

### Git installation

Run in command line:

`$ brew install git`

You can now add your ssh key to GitHub account. [Here](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/) are instructions

You can now clone repository to your desired location on your mac 

`git clone https://github.com/oat-sa/package-tao package-tao-local`

### Apache Installation

First ensure if you do not have apache installed on your device. 

This command will stop your apache service:

`$ sudo apachectl stop`

This command will remove apache service from auto-loaded services

`$ sudo launchctl unload -w /System/Library/LaunchDaemons/org.apache.httpd.plist 2>/dev/null`

Now install brew apache:

`$ brew install httpd`

Add your newly installed service to brew autoload services:

`$ sudo brew services start httpd`

You can alway check your running brew services by command:

`$ brew services list`

You web server should work. Check in your browser url: `http://localhost:8080`

#### Webserver Configuration

It's recommended to make some changes in your default configuration to make your life easier.

##### Change listening port

Port 8080 is not very obvious so consider to change it to 80.

Your configuration file should be located here:

`/usr/local/etc/httpd/httpd.conf`

If you installed newest PhpStorm version you may use it to edit configuration files

`$ pstorm /usr/local/etc/httpd/httpd.conf`

Or you may use any other editor such as Vim, Nano or Sublime.

Find line:

`Listen 8080` 

and change it to:

`Listen 80`

##### Document root

if you already clone your repository copy full path and insert in line with:

`DocumentRoot "/usr/local/var/www"`

So it will looks like that:

`DocumentRoot "Users/Your_User/your_custom_location/`

###### Directory tag

To change Directory tag reference:

`<Directory>`

to

`<Directory /Users/Your_User/your_custom_location>`

In Directory block change AllowOverride behavior to:

`AllowOverride All`

To make this work you have to enable rewrite module. Find commented line with:

`LoadModule rewrite_module lib/httpd/modules/mod_rewrite.so`

remove initial `#` if exist.

##### Running user

As you are using your user to edit files I recommend you to change user under witch your web server is running by changing this lines:

```
User your_user
Group staff
```

###### Virtual hosts

To keep multiple instances of your application it is recommended to use virtual host configuration on your web server

Uncomment or add lines:

`LoadModule vhost_alias_module lib/httpd/modules/mod_vhost_alias.so`

add configuration location:

`Include /usr/local/etc/httpd/extra/httpd-vhosts.conf`

create file:

`pstorm /usr/local/etc/httpd/extra/httpd-vhosts.conf`

```apacheconfig
<VirtualHost *:80>
    DocumentRoot "/Users/Your_User/your_projects_location/package-tao"
    ServerName tao.local
    ServerAlias tao.local
        <Directory "/Users/Your_User/your_projects_location/package-tao">
            Options Indexes FollowSymLinks MultiViews
            AllowOverride all
            Order Allow,Deny
            Allow from all
        </Directory>
</VirtualHost>
```

To make that work you have to add entry in /etc/hosts

`$ sudo echo "127.0.0.1 tao.local" >> /etc/hosts`

Restart webserver

### Multiple PHP installation

Please consider to follow tutorial from [beginning](https://getgrav.org/blog/macos-mojave-apache-multiple-php-versions) of this document.

`$ brew install php@7.1`
`$ brew install php@7.2`
`$ brew install php@7.3`

To change between versions you may use this command:

`brew unlink php@7.3 && brew link --force --overwrite php@7.1`

Configuration file for each versions are store in corresponding version location:

`/usr/local/etc/php/7.1/php.ini`

`/usr/local/etc/php/7.2/php.ini`

`/usr/local/etc/php/7.3/php.ini`

You may now check your php version:

`php -v`

#### Apache configuration

Now we have to enable module in apache web server. add following:

```apacheconfig
#LoadModule php7_module /usr/local/opt/php@7.0/lib/httpd/modules/libphp7.so
#LoadModule php7_module /usr/local/opt/php@7.1/lib/httpd/modules/libphp7.so
LoadModule php7_module /usr/local/opt/php@7.2/lib/httpd/modules/libphp7.so
#LoadModule php7_module /usr/local/opt/php@7.3/lib/httpd/modules/libphp7.so
```

Wew are now have php 7.2 module enable under web server conf.

Replace directory indexes for php files:

find:

```apacheconfig
<IfModule dir_module>
    DirectoryIndex index.html
</IfModule>
```

and replace by:

```apacheconfig
<IfModule dir_module>
    DirectoryIndex index.php index.html
</IfModule>

<FilesMatch \.php$>
    SetHandler application/x-httpd-php
</FilesMatch>
```

restart your apache service:

`brew services restart httpd`

### Composer installation

You can either install it using brew:

`$ brew install composer`

or PHP:

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

### Mariadb installation

You may consider installing Oracle MySql instance or open source mariadb 

Below are infraction for mariadb

`$ brew install mariadb`

`$ brew services start mariadb`

To change ceredentials to your local database use command:

`$ /usr/local/bin/mysql_secure_installation`