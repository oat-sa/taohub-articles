<!--
created_at: '2014-09-25 12:39:35'
updated_at: '2014-09-26 00:42:35'
authors:
    - 'Lionel Lecaque'
tags: {  }
-->

TAO Continuous Integration
==========================

Here are the different steps that are ran on a daily basis, all source code and config file are available on https://github.com/oat-sa/package-build

Build the package
-----------------

-   Download package-tao from github
-   Switch to develop branch
-   Retrieve all extensions and dependencies using composer
-   Create a zip package

Quality checks
--------------

-   Generate dependency report with other software metrics using [PHP_Depend](http://pdepend.org)
-   Look for several potential problems within the source [PHP Mess Detector](http://phpmd.org)
-   Find duplicate code using [PHPCPD](https://github.com/sebastianbergmann/phpcpd)
-   Measuring the size and analyzing the structure of the project using [PHPLOC](https://github.com/sebastianbergmann/phploc)
-   Tokenises PHP, JavaScript and CSS files and detects violations of a defined set of coding standards using [PHP_CodeSniffer](http://github.com/squizlabs/PHP_CodeSniffer). Ruleset considered are defined in conf/phpcs.xml

Unit Test
---------

-   Install the platform with all extensions
-   Run Unit test according to test configuration stored in conf/phpunit_mysql.xml
-   Generate code coverage report

How to setup Jenkins
-------------------

-   Create your jenkins project
-   Create the file build.properties



        release.version=nightly
        release.source.name=TAO_${release.version}_build

        db.driver=
        db.host=
        db.name=
        db.pass=
        db.user=

        module.mode=
        module.name=
        module.namespace=
        module.url=

        user.login=
        user.pass=

-   Git clone this repository



        git@github.com:oat-sa/package-build.git

-   Setup phing tasks
-   Setup PMD analysis



        build/logs/pmd-*.xml

-   Setup phploc report



        A - Lines of code
        Lines of Code
        build/logs/phploc.csv

        B - Structures
        Count
        build/logs/phploc.csv

        C - Testing
        Count
        build/logs/phploc.csv

        D - Types of Classes
        Count
        build/logs/phploc.csv

        E - Types of Methods
        Count
        build/logs/phploc.csv

        F - Types of Constants
        Count
        build/logs/phploc.csv

-   Setup PHPCS report



        build/logs/checkstyle.xml

-   Setup PHPCPD reports



        build/logs/pmd-cpd.xml

-   Setup Code Coverage



       **/*-test-suite.xml

-   Deploy zip file on taotesting.com

Reports
-------

Here are some example of generated reports

-   [Main Page](http://docs.taotesting.com/reports/main.pdf)
-   [PHPLOC](http://docs.taotesting.com/reports/phploc.pdf)
-   [PHP_Depend](http://docs.taotesting.com/reports/jdepend.pdf)
-   [phpunit](http://docs.taotesting.com/reports/build-tao%20%2352%20Test%20Results%20%5BJenkins%5D.pdf)
-   [coverage](http://docs.taotesting.com/coverage/)

Additional builds
-----------------

### Build Tag

In order to create the stable release version, we need to gather different utilities using\
https://github.com/oat-sa/package-build-tag

-   Download package-tao from github
-   Retrieve all extensions and dependencies using composer
-   Create a zip package
-   Create tag for all extensions that will be part of the release
-   Re create new develop branch in each extension to start a new cycle

### Build JS

This build available at https://github.com/oat-sa/package-build-js gather script to compile client side resources

-   Download package-tao from github
-   Retrieve all extensions and dependencies using composer
-   Run compilation of all JS file like explain in [Build](developer-guide/build.md)
-   Commit and push change into each extension repository

### Build Repository package

All extensions are registered on [Packagist](https://packagist.org). We also have composer backup repository of our packages built every night and available at http://packages.taocloud.org/. Build and configuration to build this backup are available https://github.com/oat-sa/repositories-packages and https://github.com/oat-sa/repositories-packages-utils


