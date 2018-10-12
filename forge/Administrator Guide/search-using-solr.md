<!--
parent: 'Administrator Guide'
created_at: '2015-05-22 10:21:13'
updated_at: '2015-08-18 14:13:49'
authors:
    - 'Mikhail Kamarouski'
tags:
    - 'Administrator Guide'
-->

Search using Solr
=================

TAO 3.1 allows different search implementations. By default it uses a slightly modified version of the Zend Lucene engine, but it can also be connected to Solr.

Installing Solr
---------------

Download and install Solr from https://lucene.apache.org/solr/

-   Installation Solr Centos
-   Installation Solr MacOs

Install Solarium library
------------------------

To add solarium support to TAO you will need to manually add the library to your required packages, this will also install Solarium (http://www.solarium-project.org/)

    "require" : {
        "oat-sa/lib-tao-solarium" : "dev-master"
    }

Configure Solr
--------------

You have to run and create core based on default TAO preset

solr start\
solr create_core -c **CORE_NAME** -d <br/>
*TAO_ROOT_DIRECTORY\*/vendor/oat-sa/lib-tao-solarium/doc/solr/conf

Activation script assumes that

CORE_NAME = tao

If different name was used please make sure to change also [PATH] parameter on configuration step to **solr/CORE_NAME**

Configure TAO
-------------

Modify the configuration to match your Solr server by specifying parameters:

sudo -u www-data php <br/>
*TAO_ROOT_DIRECTORY\*/vendor/oat-sa/lib-tao-solarium/bin/activateSolarium.php **TAO_ROOT_DIRECTORY [HOST] [PORT] [PATH]**

It should return “Switched to Solr search using Solarium”

Search engine configuration is stored in **TAO_ROOT_DIRECTORY/config/tao/search.conf.php**


