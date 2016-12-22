<!--
created_at: '2014-01-15 09:35:04'
updated_at: '2014-10-21 09:35:14'
authors:
    - 'Dieter Raber'
tags:
    - 'Documentation for core components'
-->

JavaScript Guidelines
=====================

Require.js
----------

[Require.js](http://requirejs.org/) is the framework used by TAO to structure client side code.\
The JavaScript code is split into web modules using the [AMD](http://en.wikipedia.org/wiki/Asynchronous_module_definition) (Asynchronous module definition) standard.

> **Any piece of JavaScript code into TAO must be a valid AMD module!**

### Controllers and routing

In order to load code regarding the MVC routing used in TAO server side code, a routing strategy has been implemented on the client side.\
The strategy works for any Ajax request made inside the TAO backend that display HTML (using the mime-type set in the response headers).

> **Routing does not work with redirect** (due to the way the browser handles it), avoid AJAX redirect and prefer *forward*

Each extension has a `routes.js` file inside the folder `extensionName/views/js/controller/`. This file contains the list of JavaScript controllers to load for an action.

By example, the routes.js file below, contained in the *taoItems* extension, loads the controller `controller/preview/itemRunner` when an Ajax request is made to the URL `/taoItems/ItemPreview/index`

    define(function(){
        return {
             'Items': {
                'deps' : 'controller/items',
                'actions' : {
                    'getSectionActions' : 'controller/main/actions',
                    'getSectionTrees' : 'controller/main/trees'
                }
            },
            'ItemPreview' : {
                'actions' : {
                    'index' : 'controller/preview/itemRunner'
                }
            }
        };
    });

The structure of the routes object is the following, contained into : `$extensionName/views/js/controller/`

    {
            $moduleName : {
            'deps' :  || ,            
            'actions' : {
                    $actionName :  || 
                }
            }
    }

-   \$extensionName : the name of the extension where the `routes.js` file is located, this file is evaluated when the first token of the request match /\$extensionName/\$ModuleName/\$actionName
-   \$moduleName : the name of the module given by the request /\$extensionName/\$moduleName/\$actionName is used as the 1st level key
-   ‘deps’ : contains either the scripts to load or an array of scripts to load. They will be loaded for all requests that match /\$extensionName/\$moduleName
-   ‘deps’ : list the scripts to load by action
-   ’\$actionName : the scripts to load or an array of scripts to load. They will be loaded for all requests that match /\$extensionName/\$ModuleName/\$actionName

The loaded scripts are considered as controller, it means : if the script expose of function `start`, this function will be executed after load.\
In the preview example, the controller `controller/preview/itemRunner` will look like:

    define(function(){
        // we create a controller object 
        var itemRunnerController = {

            //the controller initialization
            start : function(){
                //this code will be executed each time the script is loaded
            }
        };

        // the controller is exposed
        return itemRunnerController;
    });

### Give arguments to the controller

Often the controller needs some data from the server, different solutions are available with each advantages and disadvantages:

#### Request parameters

The request parameters sent along with the Ajax request are by default available inside the controller. By example, a call to `/taoItems/ItemPreview/index?itemId=24` gives you an access to the `itemId` parameter. You can get from the [module configuration](http://requirejs.org/docs/api.html#config-moduleconfig) :

    //module is a reserved dependency key, that gives you access to the module configuration
    define(['module'], function(module){

        var itemRunnerController = {
            start : function(){
                var itemId = module.config().itemId;
                console.log(itemId); // -> 24
            }
        };

        // the controller is exposed
        return itemRunnerController;
    });

#### Module configuration

To add new options to the module configuration, you can update it outside the module. When you have **no other choices** it could be used inside the template:






    requirejs.config({
       config: {
           'taoItems/controller/preview/itemRunner' : {                     //the key must be the EXACT AMD module name
               previewUrl : <?=json_encode(get_data('previewUrl'))?>        //then create variables from your template
           }
       } 
    });

#### DOM

There is some use cases where the DOM can be used to store data: if you’ve already a list of data or a form with the needed values, why don’t you use them?

Your template:



        <?=$item->getLabel()?>

Then in your controller you can easily retrieve those values:

    define(['jquery'], function($){

        var myController = {
            start : function(){
                var $items = $('#my-item-list');
                console.log($items.find('li').data('uri'));  //Oh Yeah! : ['uri1', 'uri2', ...]
            }
        };
        return myController;
    });

#### Ajax

Some components needs to call directly the server to retrieve JSON data, this could be the best option if you’re able to limit the number of requests…

Available libraries
-------------------

Some libraries can change your life, some of them are available:

  Name          Description                                  Current version (\*)   Website                                  License
  ------------- -------------------------------------------- ---------------------- ---------------------------------------- -------------------------------------------------
  jQuery        Cross browser DOM and Ajax utility library   1.8.0                  http://jquery.com                        [MIT](http://opensource.org/licenses/MIT)
  jQuery UI     UI Components library                        1.8.23                 http://jqueryui.com/                     [MIT](http://opensource.org/licenses/MIT)
  qUnit         Client side unit testing                     1.12.0                 http://qunitjs.com                       [MIT](http://opensource.org/licenses/MIT)
  Lo-dash       functional sugar and utilities               2.2.1                  http://lodash.com                        [MIT](http://opensource.org/licenses/MIT)
  Async         Async utilities                              0.2.10                 https://github.com/caolan/async          [MIT](http://opensource.org/licenses/MIT)
  Require.js    AMD implementation and loader                2.1.9                  http://requirejs.org                     [MIT](http://opensource.org/licenses/MIT)
  Handlebars    Awesome client side templates                1.0.0                  http://handlebarsjs.com/                 [MIT](http://opensource.org/licenses/MIT)
  Moment        date, time, duration utility                 2.4.0                  http://momentjs.com                      [MIT](http://opensource.org/licenses/MIT)
  Raphael       JavaScript Vector Library                    2.1.1                  http://raphaeljs.com                     [MIT](http://opensource.org/licenses/MIT)
  CKEditor      Wysiwyg editor                               4.3.1                  http://ckeditor.com                      [GPLv2](http://opensource.org/licenses/GPL-2.0)
  Select2       Styled select boxes                          3.4.5                  http://ivaynberg.github.io/select2/      [GPLv2](http://opensource.org/licenses/GPL-2.0)
  Tooltipster   Hipe tooltips                                3.1.4                  http://iamceege.github.io/tooltipster/   [MIT](http://opensource.org/licenses/MIT)

(\*) Check the code, as it is difficult to maintain without a dependency manager like [Bower](http://bower.io)

### Optimizations

In production mode, TAO will not load each separate JavaScript files but bundles that contains some of these files concatenated and optimized. Those bundles are:

  Path                                          Description
  --------------------------------------------- --------------------------------------------------------------------------
  tao/views/js/main.min.js                      Contains external and local libraries as well as the core components
  {extension}/views/js/controllers.min.js       The controllers by extension
  taoQTI/views/js/runtime/qtiLoader.min.js      The QTI loader distributed into the items that loads scripts dynamically
  taoQTI/views/js/runtime/qtiBootstrap.min.js   The QTI Item Runtime

To run the optimization process, just do a

    grunt build

You can optimize one extension:

    grunt taoqtiitembundle

(`grunt {extensionName.toLowerCase()}bundle`}

Guidelines
----------

### Coding style and linting

In place of a formal guideline, lint your code. The following basic rules applies:

    {
        "bitwise" : true,
        "camelcase" : true,
        "curly" : true,
        "eqeqeq" : true,
        "freeze" : true,
        "latedef" : "nofunc",
        "newcap" : true,
        "noempty" : true,
        "undef" : true,
        "strict" : false,
        "smarttabs" : true,
        "immed" : true,
        "browser" : true,
        "node" : true,
        "globals" : {
            "require" : true,
            "define" : true,
            "requirejs" : true,
            "Modernizr" : true,
            "QUnit": true, 
            "module" :true, 
            "test" : true, 
            "asyncTest" : true, 
            "expect" : true, 
            "start" : true, 
            "stop" : true,
            "ok" : true, 
            "equal" : true, 
            "notEqual" : true, 
            "deepEqual" :true,
            "notDeepEqual" : true, 
            "strictEqual" : true, 
            "notStrictEqual" : true, 
            "raises" : true,
            "throws" : true
        }
    }

See the options descriptions at http://www.jshint.com/docs/options/

A Grunt task is dedicated to code checking:

For a particular extension

    grunt jshint:extension --extension=taoQtiItem

For a particular file

    grunt jshint:file --file=../../../taoQtiItem/views/js/runtime/qtiLoader.js

### Documentation

JavaScript code MUST be documented using the http://usejsdoc.org/ format. Even though no web site documentation is generated, this format is used to have consistent comments accross the source code.

You can see below an example of jsdoc documentation.

    /**
     * @author Bertrand Chevrier 
     */
    define(function(){
        'use strict';

        /**
         * Image manipulation utility library
         * @exports util/image 
         */
        return {

            /**
             * Get the size of an image before displaying it. (Asynchronous)
             * 
             * @example imageUtil.getSize('http://image.tld/cute-cate.png', function gotSize(size){
             *      console.log(size.width, size.height);
             * });
             * 
             * @param {String} src - the image source url
             * @param {Number} [timeout = 2] - image load timeout in secs
             * @param {ImageSizeCallback} cb - called back with the image size
             */
            getSize : function(src, timeout, cb){
                var timeoutId;
                var img = document.createElement('img');

                //params interchange
                if(typeof(timeout) === 'function'){
                    cb = timeout;
                    timeout = 2;
                }

                img.onload = function(){
                    if(timeoutId){
                        clearTimeout(timeoutId);

                        /**
                         * @callback ImageSizeCallback
                         * @param {Object|Null} [size] - null if the image can't be loaded
                         * @param {Number} size.width
                         * @param {Number} size.height
                         */ 
                        cb({
                            width   : img.naturalWidth || img.width,
                            height  : img.naturalHeight || img.height
                        });
                    }
                };    
                img.onerror = function(){
                    if(timeoutId){
                        clearTimeout(timeoutId);
                        cb(null);
                    }
                };
                timeoutId = setTimeout(function(){
                    cb(null);
                }, timeout * 1000);
                img.src = src;
            }
        };
    });
JavaScript Guidelines
=====================

Require.js
----------

[Require.js](http://requirejs.org/) is the framework used by TAO to structure client side code.<br/>

The JavaScript code is split into web modules using the [AMD](http://en.wikipedia.org/wiki/Asynchronous_module_definition) (Asynchronous module definition) standard.

> **Any piece of JavaScript code into TAO must be a valid AMD module!**

### Controllers and routing

In order to load code regarding the MVC routing used in TAO server side code, a routing strategy has been implemented on the client side.<br/>

The strategy works for any Ajax request made inside the TAO backend that display HTML (using the mime-type set in the response headers).

> **Routing does not work with redirect** (due to the way the browser handles it), avoid AJAX redirect and prefer *forward*

Each extension has a `routes.js` file inside the folder `extensionName/views/js/controller/`. This file contains the list of JavaScript controllers to load for an action.

By example, the routes.js file below, contained in the *taoItems* extension, loads the controller `controller/preview/itemRunner` when an Ajax request is made to the URL `/taoItems/ItemPreview/index`

    define(function(){
        return {
             'Items': {
                'deps' : 'controller/items',
                'actions' : {
                    'getSectionActions' : 'controller/main/actions',
                    'getSectionTrees' : 'controller/main/trees'
                }
            },
            'ItemPreview' : {
                'actions' : {
                    'index' : 'controller/preview/itemRunner'
                }
            }
        };
    });

The structure of the routes object is the following, contained into : `$extensionName/views/js/controller/`

    {
            $moduleName : {
            'deps' :  || ,
            'actions' : {
                    $actionName :  ||
                }
            }
    }

-   \$extensionName : the name of the extension where the `routes.js` file is located, this file is evaluated when the first token of the request match /\$extensionName/\$ModuleName/\$actionName
-   \$moduleName : the name of the module given by the request /\$extensionName/\$moduleName/\$actionName is used as the 1st level key
-   ‘deps’ : contains either the scripts to load or an array of scripts to load. They will be loaded for all requests that match /\$extensionName/\$moduleName
-   ‘deps’ : list the scripts to load by action
-   ’\$actionName : the scripts to load or an array of scripts to load. They will be loaded for all requests that match /\$extensionName/\$ModuleName/\$actionName

The loaded scripts are considered as controller, it means : if the script expose of function `start`, this function will be executed after load.<br/>

In the preview example, the controller `controller/preview/itemRunner` will look like:

    define(function(){
        // we create a controller object
        var itemRunnerController = {

            //the controller initialization
            start : function(){
                //this code will be executed each time the script is loaded
            }
        };

        // the controller is exposed
        return itemRunnerController;
    });

### Give arguments to the controller

Often the controller needs some data from the server, different solutions are available with each advantages and disadvantages:

#### Request parameters

The request parameters sent along with the Ajax request are by default available inside the controller. By example, a call to `/taoItems/ItemPreview/index?itemId=24` gives you an access to the `itemId` parameter. You can get from the [module configuration](http://requirejs.org/docs/api.html#config-moduleconfig) :

    //module is a reserved dependency key, that gives you access to the module configuration
    define(['module'], function(module){

        var itemRunnerController = {
            start : function(){
                var itemId = module.config().itemId;
                console.log(itemId); // -> 24
            }
        };

        // the controller is exposed
        return itemRunnerController;
    });

#### Module configuration

To add new options to the module configuration, you can update it outside the module. When you have **no other choices** it could be used inside the template:






    requirejs.config({
       config: {
           'taoItems/controller/preview/itemRunner' : {                     //the key must be the EXACT AMD module name
               previewUrl : <?=json_encode(get_data('previewUrl'))?>        //then create variables from your template
           }
       }
    });

#### DOM

There is some use cases where the DOM can be used to store data: if you’ve already a list of data or a form with the needed values, why don’t you use them?

Your template:



        <?=$item->getLabel()?>

Then in your controller you can easily retrieve those values:

    define(['jquery'], function($){

        var myController = {
            start : function(){
                var $items = $('#my-item-list');
                console.log($items.find('li').data('uri'));  //Oh Yeah! : ['uri1', 'uri2', ...]
            }
        };
        return myController;
    });

#### Ajax

Some components needs to call directly the server to retrieve JSON data, this could be the best option if you’re able to limit the number of requests…

Available libraries
-------------------

Some libraries can change your life, some of them are available:

  Name          Description                                  Current version (\*)   Website                                  License
  ------------- -------------------------------------------- ---------------------- ---------------------------------------- -------------------------------------------------
  jQuery        Cross browser DOM and Ajax utility library   1.8.0                  http://jquery.com                        [MIT](http://opensource.org/licenses/MIT)
  jQuery UI     UI Components library                        1.8.23                 http://jqueryui.com/                     [MIT](http://opensource.org/licenses/MIT)
  qUnit         Client side unit testing                     1.12.0                 http://qunitjs.com                       [MIT](http://opensource.org/licenses/MIT)
  Lo-dash       functional sugar and utilities               2.2.1                  http://lodash.com                        [MIT](http://opensource.org/licenses/MIT)
  Async         Async utilities                              0.2.10                 https://github.com/caolan/async          [MIT](http://opensource.org/licenses/MIT)
  Require.js    AMD implementation and loader                2.1.9                  http://requirejs.org                     [MIT](http://opensource.org/licenses/MIT)
  Handlebars    Awesome client side templates                1.0.0                  http://handlebarsjs.com/                 [MIT](http://opensource.org/licenses/MIT)
  Moment        date, time, duration utility                 2.4.0                  http://momentjs.com                      [MIT](http://opensource.org/licenses/MIT)
  Raphael       JavaScript Vector Library                    2.1.1                  http://raphaeljs.com                     [MIT](http://opensource.org/licenses/MIT)
  CKEditor      Wysiwyg editor                               4.3.1                  http://ckeditor.com                      [GPLv2](http://opensource.org/licenses/GPL-2.0)
  Select2       Styled select boxes                          3.4.5                  http://ivaynberg.github.io/select2/      [GPLv2](http://opensource.org/licenses/GPL-2.0)
  Tooltipster   Hipe tooltips                                3.1.4                  http://iamceege.github.io/tooltipster/   [MIT](http://opensource.org/licenses/MIT)

(\*) Check the code, as it is difficult to maintain without a dependency manager like [Bower](http://bower.io)

### Optimizations

In production mode, TAO will not load each separate JavaScript files but bundles that contains some of these files concatenated and optimized. Those bundles are:

  Path                                          Description
  --------------------------------------------- --------------------------------------------------------------------------
  tao/views/js/main.min.js                      Contains external and local libraries as well as the core components
  {extension}/views/js/controllers.min.js       The controllers by extension
  taoQTI/views/js/runtime/qtiLoader.min.js      The QTI loader distributed into the items that loads scripts dynamically
  taoQTI/views/js/runtime/qtiBootstrap.min.js   The QTI Item Runtime

To run the optimization process, just do a

    grunt build

You can optimize one extension:

    grunt taoqtiitembundle

(`grunt {extensionName.toLowerCase()}bundle`}

Guidelines
----------

### Coding style and linting

In place of a formal guideline, lint your code. The following basic rules applies:

    {
        "bitwise" : true,
        "camelcase" : true,
        "curly" : true,
        "eqeqeq" : true,
        "freeze" : true,
        "latedef" : "nofunc",
        "newcap" : true,
        "noempty" : true,
        "undef" : true,
        "strict" : false,
        "smarttabs" : true,
        "immed" : true,
        "browser" : true,
        "node" : true,
        "globals" : {
            "require" : true,
            "define" : true,
            "requirejs" : true,
            "Modernizr" : true,
            "QUnit": true,
            "module" :true,
            "test" : true,
            "asyncTest" : true,
            "expect" : true,
            "start" : true,
            "stop" : true,
            "ok" : true,
            "equal" : true,
            "notEqual" : true,
            "deepEqual" :true,
            "notDeepEqual" : true,
            "strictEqual" : true,
            "notStrictEqual" : true,
            "raises" : true,
            "throws" : true
        }
    }

See the options descriptions at http://www.jshint.com/docs/options/

A Grunt task is dedicated to code checking:

For a particular extension

    grunt jshint:extension --extension=taoQtiItem

For a particular file

    grunt jshint:file --file=../../../taoQtiItem/views/js/runtime/qtiLoader.js

### Documentation

JavaScript code MUST be documented using the http://usejsdoc.org/ format. Even though no web site documentation is generated, this format is used to have consistent comments accross the source code.

You can see below an example of jsdoc documentation.

    /**
     * @author Bertrand Chevrier
     */
    define(function(){
        'use strict';

        /**
         * Image manipulation utility library
         * @exports util/image
         */
        return {

            /**
             * Get the size of an image before displaying it. (Asynchronous)
             *
             * @example imageUtil.getSize('http://image.tld/cute-cate.png', function gotSize(size){
             *      console.log(size.width, size.height);
             * });
             *
             * @param {String} src - the image source url
             * @param {Number} [timeout = 2] - image load timeout in secs
             * @param {ImageSizeCallback} cb - called back with the image size
             */
            getSize : function(src, timeout, cb){
                var timeoutId;
                var img = document.createElement('img');

                //params interchange
                if(typeof(timeout) === 'function'){
                    cb = timeout;
                    timeout = 2;
                }

                img.onload = function(){
                    if(timeoutId){
                        clearTimeout(timeoutId);

                        /**
                         * @callback ImageSizeCallback
                         * @param {Object|Null} [size] - null if the image can't be loaded
                         * @param {Number} size.width
                         * @param {Number} size.height
                         */
                        cb({
                            width   : img.naturalWidth || img.width,
                            height  : img.naturalHeight || img.height
                        });
                    }
                };
                img.onerror = function(){
                    if(timeoutId){
                        clearTimeout(timeoutId);
                        cb(null);
                    }
                };
                timeoutId = setTimeout(function(){
                    cb(null);
                }, timeout * 1000);
                img.src = src;
            }
        };
    });

