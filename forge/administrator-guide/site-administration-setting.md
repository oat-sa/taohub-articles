<!--
created_at: '2011-02-28 13:00:49'
updated_at: '2015-08-19 12:29:27'
authors:
    - 'Jagan Mohan'
tags:
    - 'Administrator Guide'
-->

Site Administration Settings
============================

The purpose of this section is to describe the settings needed to integrate the TAO instance in your infrastructure.

Most of these settings can be set into the main configuration file located at:

    config/generis.conf.php

or at

    generis/common/config.php

> Be careful with the configuration settings. The default configuration has been tested but you should test your TAO instance once you have changed the configuration parameters. The main reason is that all combinations haven’t been tested yet.

#### Common settings

• Change the database login and password:

    define('DATABASE_LOGIN', true);
    define('DATABSE_PASS', 'login');

• The URL to access TAO:

    define('ROOT_URL', 'http://mydomain.tld');

• The path of TAO:

    define('ROOT_PATH', '/var/www/');

#### HTTP Authentication

You can add an HTTP Authentication to protect your TAO instance.<br/>

**The following example outlines how to establish a Basic HTTP Authentication to protect all the TAO instances with one account.**

\# Edit the file: `.htaccess` at the root of the TAO folder.

\# Add the following line at the beginning of the file (it’s important to do it before the rewriting rules):

    AuthName "Protected Area"
    AuthType Basic
    AuthUserFile "/var/opt/.htpassword"
    Require valid-user

\# Create the password file using the command listed below. You can create it in the directory you want but consider these 2 security restrictions:<br/>

• the directoy (here /var/opt) must not be accessible via HTTP\
• the apache user (usualy www-data) can read it, bot the other cannot

    htpasswd -c login password

The `htpasswd` command is provided by Apache. You can have a look at [documentation page](http://httpd.apache.org/docs/current/programs/htpasswd.html) .

1.  Now you can reload your Apache server (if needed) and login with *login/password* in the browser authentication box.

\# The last step is to configure TAO to be aware of that authentication. So edit the main configuration file and set the value of the following constants:

    define('USE_HTTP_AUTH', true);
    define('USE_HTTP_USER', 'login');
    define('USE_HTTP_PASS', 'password');

