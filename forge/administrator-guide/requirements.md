<!--
created_at: '2011-02-15 15:27:25'
updated_at: '2015-09-07 15:27:07'
authors:
    - 'Joel Bout'
tags:
    - 'Administrator Guide'
-->



Requirements
============

In this section, you will learn about the technical requirements necessary to successfully run TAO on your own web server.

TAO relies on a free and open source solution stack called AMP. This acronym stands for Apache (web server), MySQL (database) and PHP (application). This combination of software can be executed on any Operating System such as Linux, Mac OS or Microsoft Windows. This makes the TAO platform compliant with the greatest number of Operating Systems.

The following sections describe how to install the AMP stack on a web server. If you want to install the TAO platform on your own computer to get a development environment or simply try it out, we recommend that you install the following ready to use AMP stacks to set up your environment:

-   [WAMP Server for Windows](http://www.wampserver.com)
-   [XAMPP for Linux, Windows, Mac OS and Solaris](http://www.apachefriends.org/en/xampp.html)
-   [MAMP for Mac OS](http://www.mamp.info)

If you are familiar with Linux distributions, you can download specific packages to achieve the requirements on this page. Even if most of these packages come well configured, please make sure their settings meet TAO requirements.

-   [AMP on Ubuntu Linux](https://help.ubuntu.com/community/ApacheMySQLPHP)
-   [AMP on a Debian Linux](http://linux.justinhartman.com/Setting_up_a_LAMP_Server)

Apache HTTP Server
------------------

TAO is a web application and needs to be hosted on a web server to be reachable on the internet. We recommend the [Apache HTTP Server](http://httpd.apache.org). This is the most popular web server, hosting over 59% of all websites on the Internet. The Apache HTTP Server version needed by TAO is 2.0 or higher.

TAO needs Apache to be loaded with a specific module which is [mod\_rewrite](http://httpd.apache.org/docs/2.0/mod/mod_rewrite.html). It enables TAO to rewrite requested URLs on the fly. To check if mod\_rewrite is up and running on your Apache instance, launch the following command in a console: *httpd -l*. This command lists all Apache modules running. You should see mod\_rewrite.c in the output list. If not please make sure that:

-   the */modules* directory of your Apache folder contains *mod\_rewrite.so* file.
-   the *LoadModule rewrite\_module modules/mod\_rewrite.so* directive exists in your httpd.conf configuration file. Remove any comment sign (‘\#’) if it is the first character of the related line.

Please also check that the *AllowOverride All* directive is set for your DocumentRoot. You can find it in httpd.conf as\
in the following example:

    #
    # This Directory must point where your Root Directory is.
    #

        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
        Order Allow,Deny
        Allow from all

Finally, reboot your Apache web server to apply the changes.

PHP 5
-----

PHP runs the applicative part of TAO and must be installed as an Apache module. TAO requires PHP **5.4** or higher.

### Compilation & Configuration

-   Make sure that PHP was not compiled with *—disable-all* or *—disable-json* or *—disable-dom*
-   Make sure that PHP was compile with the following *configure* options
    -   *—enable-mbstring*

### Extensions

TAO also needs several extensions to run correctly:

-   [mysql](http://us.php.net/manual/en/book.mysql.php), [mysqli](http://us.php.net/manual/en/book.mysqli.php), [pdo\_mysql](http://us.php.net/manual/en/ref.pdo-mysql.php) or [pgsql](http://us.php.net/manual/en/book.pgsql.php)
-   [curl](http://us.php.net/manual/en/book.curl.php)
-   [json](http://us.php.net/manual/en/book.json.php)
-   [gd](http://us.php.net/manual/en/book.image.php)
-   [zip](http://us.php.net/manual/en/book.zip.php) (or compiled with zip support on Linux)
-   [tidy](http://us.php.net/manual/en/book.tidy.php)
-   [DOM](http://us.php.net/manual/en/book.dom.php)
-   [SPL](http://us.php.net/manual/en/book.spl.php) (Standard PHP Library)
-   [MB String](http://php.net/manual/en/book.mbstring.php) (Multibyte String)

All the settings listed above can be checked using the [phpinfo](http://us.php.net/manual/en/function.phpinfo.php) function of PHP.

Database
--------

TAO requires either

-   mySQL 5.0 or higher and does not need any specific configuration settings.
-   PostgreSQL 8.4 or higher and does not need any specific configuration settings.

Next step
---------

You now have to configure TAO itself. For this purpose, the [[Installation and Upgrading]] section is at your disposal.\
You will learn how to set up the MySQL connection, create the knowledge base and the very first administrator user.



Requirements
============

In this section, you will learn about the technical requirements necessary to successfully run TAO on your own web server.

TAO relies on a free and open source solution stack called AMP. This acronym stands for Apache (web server), MySQL (database) and PHP (application). This combination of software can be executed on any Operating System such as Linux, Mac OS or Microsoft Windows. This makes the TAO platform compliant with the greatest number of Operating Systems.

The following sections describe how to install the AMP stack on a web server. If you want to install the TAO platform on your own computer to get a development environment or simply try it out, we recommend that you install the following ready to use AMP stacks to set up your environment:

-   [WAMP Server for Windows](http://www.wampserver.com)
-   [XAMPP for Linux, Windows, Mac OS and Solaris](http://www.apachefriends.org/en/xampp.html)
-   [MAMP for Mac OS](http://www.mamp.info)

If you are familiar with Linux distributions, you can download specific packages to achieve the requirements on this page. Even if most of these packages come well configured, please make sure their settings meet TAO requirements.

-   [AMP on Ubuntu Linux](https://help.ubuntu.com/community/ApacheMySQLPHP)
-   [AMP on a Debian Linux](http://linux.justinhartman.com/Setting_up_a_LAMP_Server)

Apache HTTP Server
------------------

TAO is a web application and needs to be hosted on a web server to be reachable on the internet. We recommend the [Apache HTTP Server](http://httpd.apache.org). This is the most popular web server, hosting over 59% of all websites on the Internet. The Apache HTTP Server version needed by TAO is 2.0 or higher.

TAO needs Apache to be loaded with a specific module which is [mod\_rewrite](http://httpd.apache.org/docs/2.0/mod/mod_rewrite.html). It enables TAO to rewrite requested URLs on the fly. To check if mod\_rewrite is up and running on your Apache instance, launch the following command in a console: *httpd -l*. This command lists all Apache modules running. You should see mod\_rewrite.c in the output list. If not please make sure that:

-   the */modules* directory of your Apache folder contains *mod\_rewrite.so* file.
-   the *LoadModule rewrite\_module modules/mod\_rewrite.so* directive exists in your httpd.conf configuration file. Remove any comment sign (‘\#’) if it is the first character of the related line.

Please also check that the *AllowOverride All* directive is set for your DocumentRoot. You can find it in httpd.conf as\
in the following example:

    #
    # This Directory must point where your Root Directory is.
    #

        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
        Order Allow,Deny
        Allow from all

Finally, reboot your Apache web server to apply the changes.

PHP 5
-----

PHP runs the applicative part of TAO and must be installed as an Apache module. TAO requires PHP **5.4** or higher.

### Compilation & Configuration

-   Make sure that PHP was not compiled with *—disable-all* or *—disable-json* or *—disable-dom*
-   Make sure that PHP was compile with the following *configure* options
    -   *—enable-mbstring*

### Extensions

TAO also needs several extensions to run correctly:

-   [mysql](http://us.php.net/manual/en/book.mysql.php), [mysqli](http://us.php.net/manual/en/book.mysqli.php), [pdo\_mysql](http://us.php.net/manual/en/ref.pdo-mysql.php) or [pgsql](http://us.php.net/manual/en/book.pgsql.php)
-   [curl](http://us.php.net/manual/en/book.curl.php)
-   [json](http://us.php.net/manual/en/book.json.php)
-   [gd](http://us.php.net/manual/en/book.image.php)
-   [zip](http://us.php.net/manual/en/book.zip.php) (or compiled with zip support on Linux)
-   [tidy](http://us.php.net/manual/en/book.tidy.php)
-   [DOM](http://us.php.net/manual/en/book.dom.php)
-   [SPL](http://us.php.net/manual/en/book.spl.php) (Standard PHP Library)
-   [MB String](http://php.net/manual/en/book.mbstring.php) (Multibyte String)

All the settings listed above can be checked using the [phpinfo](http://us.php.net/manual/en/function.phpinfo.php) function of PHP.

Database
--------

TAO requires either

-   mySQL 5.0 or higher and does not need any specific configuration settings.
-   PostgreSQL 8.4 or higher and does not need any specific configuration settings.

Next step
---------

You now have to configure TAO itself. For this purpose, the [[Installation and Upgrading]] section is at your disposal.<br/>

You will learn how to set up the MySQL connection, create the knowledge base and the very first administrator user.


