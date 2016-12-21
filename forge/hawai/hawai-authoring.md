<!--
parent:
    title: Hawai
author:
    - 'Jérôme Bogaerts'
created_at: '2011-03-09 15:11:48'
updated_at: '2013-03-13 13:05:45'
tags:
    - Hawai
-->

Waterphoenix
============

documentation todo
------------------

-   Document:Why HAWAI format ? =\> make a link to the dev documentations of QTI items and free form items.
-   The Waterphoenix:Technologies =\> explain or make a link to a documentation of the WUIB library
-   The main config file has been updated, update the TAO install script functions of the changes

The Waterphoenix
----------------

###What is the waterphoenix platform ?{#what-is-the-waterphoenix-platform}

The waterphoenix platform has been developed initially to author XML documents. However the plateform is built upon the concept of extension what allows developers to extend the platform to specific requirements. By instance we extend the platform to author XML documents such as BLACK documents but also XHTML and XUL documents.

###Technology{#technology}

Because of the requirement of smoothness and the technologies used for the development of the TAO platform we decided to use javascript as main technology.\
In combination with this technology we use :

-   The framework [jQuery](http://jquery.com/) as main javascript framework;
-   The library [EJS](http://embeddedjs.com/) (embedded javascript) as templates engine;
-   The graphical library WUIB (Water User Interface Block) as building block of the GUI;

###The architecture{#the-architecture}

This section covers the architecture of the Waterphoenix plateform. As we said above the platform is build upon the concept of extension. Even the *Core* is considered as an extension - a *super extension* actually. So the architecture of the platform is strongly linked with this “pattern”.

*Folders structure of the platform:*

-   **waterphoenix** The platform root directory;
    -   **config** The config of the platform;
    -   **core** The *super extension* Core;
    -   **doc** The global documentation of the platform;
    -   **lib** Common libraries;
    -   **xt** Pool of extensions;

Each extension is composed by a separated file system and can be used in standalone, except if that extension depends of an other extension

*The following schema illustrates this: :*

![](http://forge.taotesting.com/attachments/download/359/wx_archi.png)

####Extensions’ architecture{#extensions-architecture}

Extensions are located in the pool of extensions which is by default the xt directory in the Waterphoenix root folder. Each extension contains the same folders structure in order to be exploited by the Waterphoenix platform.

*Folders structure of the extensions :*

-   **build** The minified file of the extension;
-   **classes** All the classes of the extensions;
    -   **models** Classes relative to the model of the extension;
    -   **ui** Classes relative to the graphical tools of the extension;
-   **helpers** Helpers used by the extension;
-   **lib** External libraries used by the extension;
-   **locales** Locales of the extension;
-   **test** Unit tests of the extension;
-   **views** File relative to the graphical interface of the extension (images, templates …);
    -   **css** Css files used by the extension;
    -   **images** Images used by the extension;
    -   **templates** Templates of the extension;

Moreover to be identified by the system an extension has to :

-   Define a manifest.xml file at its root folder
-   Extend the *Wx.Core.Classes.Models.Extension* class with a *Wx.Xt.{ExtensionName}.Classes.Extension* class

####Extension’s manifest{#extensions-manifest}

Each extension must have an xml manifest at its root. This manifest file describes some aspects of the extension (configuration variables, sources, required external libraries …). Based on this manifest the system will be able to load dynamically the extensions and their ressources. Moreover the system will be able to build a compiled version of each extension by minifying the sources in the directory *build* of each extension.

*Below is an example of manifest :*


        
            xml
        
        
            
                
                
                
                
                
                
                
                
                
                
            
            
                
                
            
        

-   **config** Description of the extension;
    -   **name** Name of the extension;
    -   **path** Path where the extension is located;
-   **ressource** The ressources used by the extension;
    -   **source** Reference to each source files of the extension. All these source files have to be located in the directory *classes* of the extension;
    -   **library** Reference to each libraries used by the extension. All these libraries have to be located in the directory *lib* of the extension;
    -   **css** Reference to each css files used by the extension. All these css files have to be located in the directory *views/css* of the extension;

####Extensions’ bootstrap{#extensions-bootstrap}

Each extension has to extend the *Wx.Core.Classes.Models.Extension* class with a *Wx.Xt.{ExtensionName}.Classes.Extension* class. This class will be used as extension bootstrap. By overriding some functions of the models developers could manage their specific needs.

*Below is the extension *abstract* class :*

    /** 
     * @name Extension
     * @class
     */
    Wx.Core.Classes.Models.Extension = Class.extend (
    /** @lends Wx.Core.Classes.Models#Bootstrap.prototype */{#bootstrapprototype}

    {   
        /** 
         * Constructor like
         * @param {string} name Name of the extension
         * @param {jSon} options Optional parameters
         * @param {object} options.object Object on which apply this extension [LEGACY]
         * @param {path} options.path Path of the extension
         * @private
         */
        init : function (name, options) { ... }

        /**
         * Treatment to do before the load.
         * Load ressources.
         * Load locales.
         * Override this function to implement specific behavior.
         * @protected
         */
        , beforeLoad : function () { ... }

        /**
         * Load the extension.
         * Override this function to implement specific behavior.
         * @protected
         */
        , load : function () { }

        /**
         * Load locales data
         * @private
         */
        , loadLocales : function (){ ... }

        /**
         * Load ressources required by the extension
         * @private
         */
        , loadRessource : function () { ... }

        /** 
         * Parse the extension manifest if existing
         * @private 
         */
        , parseManifest : function () { ... }

        /**
         * Action to execute when the extension is ready.
         * Override this function to implement a specific behavior.
         * @protected
         */
        , ready : function () { ... }

        /**
         * Setup the config
         * @private
         */
        , setup : function () { ... }
    });

###Configuration{#configuration}

The configuration of the platform is drived by a configuration file which is located in the config directory of the Waterphoenix folder.

*See below an example of configuration file :*

    ....

    /**
     * Url of the web site where the Waterphoenix is deployed
     * @type string
     */
    Wx.Config.URL = 'http://waterphoenix.local';

    /**
     * Root path of the Waterphoenix
     * @type string
     */
    Wx.Config.ROOT_PATH  = '/';

    ....

    /**
     * Define if the application will be deployed in production mode.
     * If set to true the system will load minified files, be sure that the minified files are updated. 
     * You can minify your code by executing the file make.php which is located at the root folder of the platform.
     * @type boolean
     */
    Wx.Config.PROD_MODE = true;

    /**
     * Define if the debug mode is enabled.
     * The debug mode works only on firefox.
     * @type boolean
     */
    Wx.Config.DEBUG_MODE = false;

    /**
     * Define which are the extensions to load.
     * @type array
     */
    Wx.Config.EXTENSIONS = ['xml', 'black', 'xul', 'xhtml', 'tao', 'workflow'];

    /**
     * Define a set of colors
     * @type array
     */
    Wx.Config.COLOR = {
        WIZARD_POSITION_ELEMENT_REF:    '#00FF0F',{#00ff0f}

        HIGHLIGHTED_NODE:               '#7999FF',{#7999ff}

        SELECTED_NODE:                  '#D00239',{#d00239}

        MOVE_NODE:                      '#D00239',{#d00239}

        PARENT_MOVE_NODE:               '#389438',{#389438}

        OUTSIDE:                        '#FF8000',{#ff8000}

        INSIDE:                         '#0080FF',{#0080ff}

        QM_HIGHLIGHTED_NODE:            '#FF6868',{#ff6868}

        QM_SELECTED_NODE:               '#FF3838',{#ff3838}

        SV_HIGHLIGHTED_NODE:            '#80A680',{#80a680}

        SV_SELECTED_NODE:               '#389438'{#389438}

    };

###The Core extension{#the-core-extension}

The core is considered as an extension - a *super extension*. An extension required by all others because it provides low and high level components (uri, document, element, attribute, perspective, workspace …) that will be used by other extensions. On the other hand, it provides also the architecture for the application layers that dependants extensions will use or change.

*Below is the class diagramm of the core model* :

![](http://forge.taotesting.com/attachments/download/338/wx_core_models_class_diagram.png)

###The application layers{#the-application-layers}

As we said below the core provides to other extensions the application layers which will drive the main behaviors of the software.

-   Add a new document type;
-   Associate a perspective to a document type;
-   Add new element model to the pool of managed element models;
-   Override the application access point;
-   …

By instance if an extension want to add a new document type to the list of documents managed by the system it has to :

-   Create a class which extend the *Wx.Core.Classes.Models.Document* of the core extension;
-   Register this new document class with the document factory of the core extension;

###The provided extensions{#the-provided-extensions}

The waterphoenix platform comes with several extension developed to manage various aspects and to group in each extension the features relative to a specific area.

####Xml{#xml}

Because the Waterphoenix has been developped to edit XML document the Xml extension like the Core extension is one of the pillar extension of the authoring tool.\
This extension allow to manage any type of XML document. It is required by the Xhtml, Xul and Black extensions. The Xhtml, Xul and Black are Xml based languages.

####BLACK{#black}

###TAO{#tao}

###Workflow{#workflow}

###XHTML{#xhtml}

###XUL{#xul}

###XulRunner{#xulrunner}

##Create a new extension{#create-a-new-extension}

