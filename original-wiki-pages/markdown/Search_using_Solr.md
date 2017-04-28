Search using Solr
=================

Tao 3.1 allows different search implementations. By default it uses a slightly modified version of the Zend Lucene engine, but it can also be connected to Solr.

Installing Solr
---------------

Download and install Solr from https://lucene.apache.org/solr/

-   [[Installation Solr Centos]]
-   [[Installation Solr MacOs]]

Install Solarium library
------------------------

To add solarium support to Tao you will need to manually add the library to your required packages, this will also install Solarium (http://www.solarium-project.org/)

    "require" : {
        "oat-sa/lib-tao-solarium" : "dev-master"
    }

Configure Solr
--------------

You have to run and create core based on default tao preset

solr start\
solr create\_core -c **CORE\_NAME** -d \*TAO\_ROOT\_DIRECTORY\*/vendor/oat-sa/lib-tao-solarium/doc/solr/conf

Activation script assumes that

CORE\_NAME = tao

If different name was used please make sure to change also [PATH] parameter on configuration step to **solr/CORE\_NAME**

Configure Tao
-------------

Modify the configuration to match your Solr server by specifying parameters:

sudo -u www-data php \*TAO\_ROOT\_DIRECTORY\*/vendor/oat-sa/lib-tao-solarium/bin/activateSolarium.php **TAO\_ROOT\_DIRECTORY [HOST] [PORT] [PATH]**

It should return “Switched to Solr search using Solarium”

Search engine configuration is stored in **TAO\_ROOT\_DIRECTORY/config/tao/search.conf.php**

