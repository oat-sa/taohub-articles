<!--
author:
    - 'Thomas Garrard'
created_at: '2011-02-13 04:36:47'
updated_at: '2014-06-05 15:08:15'
tags:
    - 'Administrator Guide'
-->

Security and Performance
========================

For primary security purposes TAO can be considered to be a php website with DB storage. This page covers the basics and some TAO specific items; dependent on the security requirements further reading may be necessary. Fortunately, there is a wealth of data available around the web about securing php sites.

Encrypting connections between client and server
------------------------------------------------

SSL/TLS is the primary method of encrypting client/server communications (ie. “https://” rather than “http://”). Implementation of this is independent from TAO on the server.

\>h4. HTTPS principles\
\>\
\>HTTPS relies on [TLS](http://en.wikipedia.org/wiki/Transport_Layer_Security) (Transport Layer Security, formerly known as SSL). TLS encrypts the communication between two programs - in this case, a browser (client) and the server. The purpose is not only to encrypt the data but also to confirm the identity of the server to clients.

\>h4. HTTPS setup\
\>\
\>Most TAO implementations will be delivered via apache but similar documentation is available for alternatives:\
\>\
\>http://httpd.apache.org/docs/current/ssl/ssl\_howto.html\
\>\
\>In addition to the steps in the link above, you will also need to aquire a certificate. A self-signed certificate will generate warnings in users’ browsers. If this is a concern then consider purchasing a certificate from a trusted [certificate authority](http://en.wikipedia.org/wiki/Certificate_Authority)

Hardening PHP and encrypting user session data
----------------------------------------------

Depending on what is at stake, you may want to encrypt user data. So any server breakage will just provide the offender with encrypted data. For instance, the [Suhosin](http://www.hardened-php.net/suhosin/) component encrypts the session data on the server side. Unfortunately the Suhosin project has not been updated in a while and thus only PHP versions up to 5.3.9 are supported. Other possibilities are availaable to the experienced administrator willing to harden php ‘manually’ beginning with:

    display_errors = Off
    log_errors = On
    allow_url_fopen = Off
    safe_mode = On
    expose_php = Off
    enable_dl = Off
    disable_functions = exec, system, proc_open, popen, curl_exec, curl_multi_exec, parse_ini_file, show_source, system, show_source, symlink, exec, dl, shell_exec, passthru, phpinfo, escapeshellarg, escapeshellcmd

Backups
-------

TAO stores user information in database. As a typical web application, you can split TAO in four major parts:

-   the source code, that does not contain any data,
-   the configuration files, generated during the installation,
-   the generated local files, available for local work,
-   the generated user content (tests as well as results) in database.

Confidentiality and privacy
---------------------------

In many jurisdictions you are required to provide a statement regarding user data. In any case, it is a good idea to inform users of where and how you store their data. If deploying TAO with user information or data from outside sources it is important to secure agreements with both data owners and data keepers.

Security and Performance
========================

For primary security purposes TAO can be considered to be a php website with DB storage. This page covers the basics and some TAO specific items; dependent on the security requirements further reading may be necessary. Fortunately, there is a wealth of data available around the web about securing php sites.

Encrypting connections between client and server
------------------------------------------------

SSL/TLS is the primary method of encrypting client/server communications (ie. “https://” rather than “http://”). Implementation of this is independent from TAO on the server.

\>h4. HTTPS principles\
\>\
\>HTTPS relies on [TLS](http://en.wikipedia.org/wiki/Transport_Layer_Security) (Transport Layer Security, formerly known as SSL). TLS encrypts the communication between two programs - in this case, a browser (client) and the server. The purpose is not only to encrypt the data but also to confirm the identity of the server to clients.

\>h4. HTTPS setup\
\>\
\>Most TAO implementations will be delivered via apache but similar documentation is available for alternatives:\
\>\
\>http://httpd.apache.org/docs/current/ssl/ssl\_howto.html\
\>\
\>In addition to the steps in the link above, you will also need to aquire a certificate. A self-signed certificate will generate warnings in users’ browsers. If this is a concern then consider purchasing a certificate from a trusted [certificate authority](http://en.wikipedia.org/wiki/Certificate_Authority)

Hardening PHP and encrypting user session data
----------------------------------------------

Depending on what is at stake, you may want to encrypt user data. So any server breakage will just provide the offender with encrypted data. For instance, the [Suhosin](http://www.hardened-php.net/suhosin/) component encrypts the session data on the server side. Unfortunately the Suhosin project has not been updated in a while and thus only PHP versions up to 5.3.9 are supported. Other possibilities are availaable to the experienced administrator willing to harden php ‘manually’ beginning with:

    display_errors = Off
    log_errors = On
    allow_url_fopen = Off
    safe_mode = On
    expose_php = Off
    enable_dl = Off
    disable_functions = exec, system, proc_open, popen, curl_exec, curl_multi_exec, parse_ini_file, show_source, system, show_source, symlink, exec, dl, shell_exec, passthru, phpinfo, escapeshellarg, escapeshellcmd

Backups
-------

TAO stores user information in database. As a typical web application, you can split TAO in four major parts:

-   the source code, that does not contain any data,
-   the configuration files, generated during the installation,
-   the generated local files, available for local work,
-   the generated user content (tests as well as results) in database.

Confidentiality and privacy
---------------------------

In many jurisdictions you are required to provide a statement regarding user data. In any case, it is a good idea to inform users of where and how you store their data. If deploying TAO with user information or data from outside sources it is important to secure agreements with both data owners and data keepers.


