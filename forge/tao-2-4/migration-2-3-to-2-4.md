<!--
author:
    - 'Joel Bout'
created_at: '2013-03-15 08:43:02'
updated_at: '2013-08-07 08:12:30'
tags:
    - 'TAO 2 4'
-->

Migration 2 3 to 2 4\
\*\
In progress\*
=====================



Database Migration
------------------

We usually provide automatic scripts that handle operation to convert the database from last version to the actual. For this new 2.4 version, we will not be able to do so because of the deep change that occurs on the User/Role Model.<br/>

In the future we planned to provide better tools to help platform administrator to automaticaly update their data to the last version, in order to do so, we have changed the logic of the update process, we now start from the last version that is able to retrieve data from previous version though a dedicate extension.

So you need to create a fresh install of new TAO 2.4, and then install the extension found in attachment of this guide called taoMigration, extract the zip file a the root of your TAO installation. This extension is still experimental and for now do not require any installation but we are really interest in having any feedback about it. It only provides a script you may call providing data about your previous TAO 2.3 database and installation, the script will then manage to retrieve all the items, test taker, user and roles in a dedicated language you may have created in TAO 2.3 with all their meta-data and their content. You may found this script in taoMigration/scripts/taoMigrate.php

    Usage:php taoMigrate.php [arguments]

    Arguments list:
            --driver|-d             Database driver option mysql,postgres
            --host|-host            Database host
            --db|-db                Database name
            --user|-u               Database user
            --pass|-p               Database password
            --lang|-l               Language to migrate
            --namespace|-ns         Old Namespace to migrate
            --option|-o             what to migrate, options available: testtakers, items, users, all

    sudo -u www-data php taoMigrate.php -d mysql -host localhost -db tao23 -u user -p password -ns http://tao23.localdomain/tao23.rdf -o all

Extension Migration
-------------------

-   retired constants: DIR\_HELPERS, DIR\_MODELS
-   added pre install checks by extension, in [‘install’][‘checks’]
-   added the possibility for every extension to add local data using [‘local’][’php]


