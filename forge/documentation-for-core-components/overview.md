<!--
author:
    - 'Jérôme Bogaerts'
created_at: '2011-03-04 17:33:54'
updated_at: '2013-03-13 12:55:18'
tags:
    - 'Documentation for core components'
-->

Framework Overview
==================



The big picture
---------------

In order to understand how to use or extend the TAO Framework, you should have an overview of what happens from the moment the request is handled by the web-server until the moment when the response is sent back. The schema below outlines the request cycle. The responsibility of each layer will be described later in this document.

![](http://forge.taotesting.com/attachments/384/app-loop.png)

The Bootstrap
-------------

The bootstrap is a class that helps you start the application. To begin with, the bootstrap’s job is to start the transverse functionalities: session, i18n, configuration, the connection to the API (and so on to the database). If you create a tool, a service or a function that would perform an operation for each request, you should add it to the *Bootstrap::start* method, even though it’s not common to do so.\
Then, the bootstrap can start the MVC loop, where the URL is resolved, the controller called, etc. We will see how this loop works later. Now, you’re aware that it is started by the Bootstrap. For the command line scripts, the unit tests, or any no-MVC related services, this second step can be skipped.

The example below lists the source of the taoItem’s extension bootstrap, located in `taoItems/index.php`:


    require_once dirname(__FILE__). '/../tao/includes/class.Bootstrap.php';

    $bootStrap = new BootStrap('taoItems');
    $bootStrap->start();
    $bootStrap->dispatch();

![](http://forge.taotesting.com/attachments/download/215/returnTopArrow.JPG)[[Overview|Return to Top]]

Framework Overview
==================



The big picture
---------------

In order to understand how to use or extend the TAO Framework, you should have an overview of what happens from the moment the request is handled by the web-server until the moment when the response is sent back. The schema below outlines the request cycle. The responsibility of each layer will be described later in this document.

![](http://forge.taotesting.com/attachments/384/app-loop.png)

The Bootstrap
-------------

The bootstrap is a class that helps you start the application. To begin with, the bootstrap’s job is to start the transverse functionalities: session, i18n, configuration, the connection to the API (and so on to the database). If you create a tool, a service or a function that would perform an operation for each request, you should add it to the *Bootstrap::start* method, even though it’s not common to do so.<br/>

Then, the bootstrap can start the MVC loop, where the URL is resolved, the controller called, etc. We will see how this loop works later. Now, you’re aware that it is started by the Bootstrap. For the command line scripts, the unit tests, or any no-MVC related services, this second step can be skipped.

The example below lists the source of the taoItem’s extension bootstrap, located in `taoItems/index.php`:


    require_once dirname(__FILE__). '/../tao/includes/class.Bootstrap.php';

    $bootStrap = new BootStrap('taoItems');
    $bootStrap->start();
    $bootStrap->dispatch();

![](http://forge.taotesting.com/attachments/download/215/returnTopArrow.JPG)[[Overview|Return to Top]]


