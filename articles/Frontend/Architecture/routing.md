<!--
authors:
    - "Bertrand Chevrier"
tags:
    Frontend Architecture:
        - "Routing"
-->
# Routing

## Controllers

TAO uses the notion of _Controller_, as an entry point for the execution of JavaScript.
A controller is a JavaScript module that exports an object with a `start` method.
For example :

```js
define(function(){

    var myController = {
        start : function start() {
            console.log("Let's get started!");
        }
    };

    return myController;
});
```

Controllers can be called by 2 ways :

  - The controller is defined as the main controller of a page, using `data-controller` attribute of main loading tag (the `<script>` tag that loads the bundles)
  - Based on a route. A _router_ will load and run the controllers based on defined routes.


## Routes and controllers

Each extension has a `routes.js` file inside the folder `views/js/controller/`. This file contains the list of JavaScript controllers to load for a given route.

For example, the `routes.js` file below describes which action will trigger the execution of which controller. If the user navigate to the URL `/taoItems/ItemPreview/index` the controller `controller/preview/itemRunner` will be executed.

```js
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
```

The structure of the routes object is the following :

The module located at `i$extensionName/views/js/controller/routes.js` must export :

```js
{
    $moduleName : {
        deps : {
            css : [],
            actions : {
                $actionName : '$controller'
            }
        }
    }
}
```

Where :

 - `$extensionName` : the name of the extension where the `routes.js` file is located, this file is evaluated when the first token of the request match `/$extensionName/$moduleName/$actionName`
 - `$moduleName` : the name of the module given by the request `/$extensionName/$moduleName/$actionName`
 -  `deps` : contains either the scripts to load or an array of scripts to load. They will be loaded for all requests that match `/$extensionName/$moduleName`
 - `$actionName` : the scripts to load or an array of scripts to load. They will be loaded for all requests that match `/$extensionName/$moduleName/$actionName`
 - `$controller` : the controller module to load and execute

