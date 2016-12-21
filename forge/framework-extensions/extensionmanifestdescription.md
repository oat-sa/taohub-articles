<!--
author:
    - 'Joel Bout'
created_at: '2012-11-09 13:27:23'
updated_at: '2013-02-26 16:29:22'
tags:
    - Framework-Extensions
-->

Extension Manifests
===================

Extension Manifests are PHP files that describe TAO Extensions in order to be installed and loaded properly at runtime. On one hand, they essentially contain descriptive contents such as a *name*, *description*, *version* and *author*. On the other hand, they contains references to the *ontology models* to load, extensions they *depend on*, *installation files and checks*, …

From a technical point of view, Extension Manifests are simple PHP files containing an associative array describing the extension. The content of the file is required at runtime and evaluated by PHP at extension loading time.

1. A Minimal Manifest Example
-----------------------------

This manifest file describes a minimal TAO extension. As you can see below, a manifest returns an associative array to describe the extension it belongs to.


    /**
     * This lightweight manifest is based on the TAO filemanager one.
     * 
     * @author CRP Henri Tudor - TAO Team - {@link http://www.tao.lu}
     * @license GPLv2  http://www.opensource.org/licenses/gpl-2.0.php
     */

    return array(
        'name' => 'minimal',
        'description' => 'a minimal extension',
        'version' => '1.0',
        'author' => 'TAO Team',
        'classLoaderPackages' => array(
            dirname(__FILE__) . '/actions/'
         )
    );

2. A Complete Manifest Example
------------------------------

This manifest file describes a complex extension.


    /**
     * @author CRP Henri Tudor - TAO Team - {@link http://www.tao.lu}
     * @license GPLv2  http://www.opensource.org/licenses/gpl-2.0.php
     */
    $extpath = dirname(__FILE__).DIRECTORY_SEPARATOR;

    return array(
        'name' => 'myExtension',
        'description' => 'a more complex extension.',
        'version' => '2.4',
        'author' => 'TAO Team',
        'dependencies' => array('tao'),

        // Model URIs involved in this extension
        'models' => array(
            'http://www.tao.lu/Ontologies/TAO.rdf',
            'http://www.tao.lu/Ontologies/taoFuncACL.rdf'
        ),

        // Installation requirements
        'install' => array(

            // RDF Files to import at installation time
            'rdf' => array(
                    dirname(__FILE__). '/models/ontology/myOntology.rdf'
            ),
            // Requirement checks to perform prior to installation
            'checks' => array(
                    array('type' => 'CheckPHPRuntime', 'value' => array('min' => '5.3', 'max' => '5.3.18', 'optional' => false))
            )
        ),

        // Directories where class loaders will crawl for PHP classes and interfaces
        'classLoaderPackages' => array(
            dirname(__FILE__).'/vendors/'
        ),

        // Constants that will be either available as PHP constants or through the Extension API.
        'constants' => array(
            // web services
            'WS_ENDPOINT_TWITTER' => 'http://twitter.com/statuses/',
            'WS_ENDPOINT_FACEBOOK' => 'http://api.facebook.com/restserver.php'
         )
    );

3. Manifest File Location
-------------------------

The manifest file of an extension must be placed in its root directory. For instance, if you developed an extension in a directory named *documents*, the manifest should be placed at *[TAO\_INSTALL\_PATH]/documents/manifest.php*.

4. Manifest Model
-----------------

-   *string* name
-   *optional* *string* description
-   *string* version
-   *optional* *string* author
-   *optional* *array* dependencies
-   *optional* *array* models
-   *optional* *array* install
    -   *optional* *array* install[‘php’]
    -   *optional* *array* install[‘rdf’]
    -   *optional* *array* install[‘checks’]
-   *array* classLoaderPackages
-   *optional* constants


