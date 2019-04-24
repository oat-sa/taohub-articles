<!--
authors:
    - "Bertrand Chevrier"
tags:
   - "Frontend":
        - "Frontend Architecture"
-->
# AMD & Require.js

> How to deal with require.js and AMD into TAO.

For historical reasons, JavaScript files in TAO are AMD modules.
TAO is using AMD to define import and export, but also for dependency injection.

All modules have the same form :

```js
define([                            //you define a module
    'lodash',                       //declare the dependencies, here an alias
    'taoQtiItem/component/foo'      //here the resolved module name
], function(_, fooComponent){       //and use the exported values by the dependencies
    'use strict';                   //ES5 so enforce the strict

    return {                        //The module exports something
        bar : true
    }
});
```

Even without dependencies, a module needs to be wrapped into a `define` statement.

## Module paths

The dependencies are declared using a module name, which is not necessarily a path. By default you can make the reference to a module by using the following pattern:  `${extensionName}/${pathInViews}/${moduleName}`.
For example to access `taoQtiTest/views/js/runner/plugins/control/timers/timer.js` you'll use `taoQtiTest/runner/plugins/control/timers/timer`.
You'll notice the `views/js` disappear as well as the file extension.

The base URL is always for JavaScript resources `tao/views/js` so for modules into the tao extension you don't need to prefix them with `tao`. For example to access `tao/views/js/core/eventifier.js`, `core/eventifier` should  be used.

Modules with an alias defined in the configuration can be called using this alias `lodash`, `jquery`, `moment`, `i18n`, etc. Since alias create some coupling between the source code and the configuration, we try to reduce their usage as much as possible.

## Named modules

**Named modules are prohibited.**

```js
define(
    'bar',
[
    'lodash',
    'taoQtiItem/component/foo'
], function(_, fooComponent){
    'use strict';

    return {
        bar : true
    }
});
```
**They won't work once optimized**

Some libraries still uses named modules, to support this heresy we have to define an alias in the configuration.

## Dependency injection

The content of the callback function is executed this first time it is required by another module and the main scope lifecycle will remain until the page refresh.

Let's define a module :

```js
define([], function(){
	'use strict';

       var foo = 0;
       return {
            getFoo: function getFoo(){
                return ++foo;
            }
       };
 });
```

If you require this module in a module A, and call `getFoo` then after in another module B, you also call `getFoo`, you'll get the value `2`, etc.

## Configuration

### Runtime configuration

The main configuration is created by a dynamic service, through the URL  `/tao/ClientConfig/config` which generates the require.js configuration.
The configuration options can be modified through the template and the controller linked to that route :
 - `tao/actions/class.ClientConfig.php`
 - `tao/views/templates/client_config.tpl`

### Test and build configuration

A static and lighter version of the configuration is located at `tao/views/build/config/requirejs.build.json`.


### Module configuration

It's possible to give a configuration to a dedicated module. This can be done by modifying the configuration itself or by using the dedicated registry `oat\tao\model\ClientLibConfigRegistry` (a PHP helper that register configuration for a given module).
It creates an entry into the file `config/tao/client_lib-config_registry.conf.php` that will be used to configure a client side module.
From the JavaScript file, the configuration will be available through the `module` module.


### Example

The module `util/locale` needs a configuration from the server, the date time format.

In the install/update scripts, the `ClientLibConfigRegistry` is called in order to register the configuration :

```php
oat\tao\model\ClientLibConfigRegistry::getRegistry()->register(
    'util/locale', ['dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss']
);
```
The first argument of the `register` is obviously the name of the AMD module you want to configure.

To access this configuration the module `util/locale` will use the `module` module :

```js
define([
    'lodash',
    'module'    // the special dependency : module
], function(_, module) {

    var configuration = module.config();

    console.log(configuration.dateTimeFormat);  // will contain  'DD/MM/YYYY HH:mm:ss'
});
```

More information on this topic can be found at https://requirejs.org/docs/api.html#config-moduleconfig.

### Getting data from the server

There are multiple ways to get data from the server :

 - Using the module configuration (see above) :
 - Using HTTP requests
 - Using the DOM

In order to get data from the server, you will use the configuration only for system configuration and HTTP requests for anything else.

All other ways should be avoided as much as possible. You will see in the source code, dynamic reconfiguration of modules. This is an anti-pattern and should be removed.
```
<script>
    require.config({
        config : {
            'util/locale' : { 'dateTimeFormat' => 'DD/MM/YYYY HH:mm:ss' }
        }
    });
</script>
```


### Loading Templates

TAO supports loading templates as AMD dependencies.

 - Templates are formatted using the Handlebars syntax (see https://handlebarsjs.com)
 - The template file extension is `.tpl`
 - They must be loaded through AMD, using `'tpl!path/to/module'` (without the `.tpl` extension, since a template is considered as a JavaScript file)
 - Templates are compiled into JavaScript function during the build
 - The exported value is a function

For example, consider the file `tao/views/js/ui/switch/tpl/switch.tpl` :

```
<div class="switch" title="{{title}}">
    <input type="checkbox" name="{{name}}" {{#if on.active}}checked{{/if}}>
    <label>
        <span class="off {{#if off.active}}active{{/if}}">{{off.label}}</span>
        <span class="on  {{#if on.active}}active{{/if}}">{{on.label}}</span>
    </label>
</div>
```

and loading it in a JavaScript module :

```js
define([
    'tpl!ui/switch/tpl/switch'
], function(switchTemplate){
	'use strict';

    //this variable will contain astring
    var switchHTML = switchTemplate({
        name : 'light',
        on   : {
            active: true,
            label : 'On'
        }
    });
 });
```

### Loading JSON data

TAO supports loading JSON files as AMD dependencies,  using `'json!path/to/module.json'` (with the `.json` extension). The result is directly parsed to a JavaScript Object

For example, consider the file `tao/views/js/core/mimetype/categories.json` :

```
{
    "video" : {
       "category" : "media",
       "mimes" : ["application/ogg", "video/*"],
       "extensions" : ["avi", "mp4", "ogg", "mpeg", "flv"]
    },
    "audio" : {
        "category" : "media",
        "mimes" : ["audio/*"],
        "extensions" : ["mp3", "wav", "aac"]
    },
    //...
}
```

and loading it in a JavaScript module :

```js
define([
    'json!core/mimetype/categories.json'
], function(mimeTypeCategories){
	'use strict';

    var audioExtensions = mimeTypeCategories.audio.extensions;
 });
```

### Loading stylesheets

TAO supports loading CSS files as AMD dependencies,  using `'css!path/to/module.json'` (with the `.css` extension).
 - The stylesheet is loaded when the module is loaded for the first time.
 - Stylesheets doesn't export anything, so by convention, add them at the end of your dependencies

For example, consider the file `tao/views/js/ui/switch/css/switch.css`, to include in a JavaScript module :


```js
define([
    'css!ui/switch/css/switch.css'
], function(){
	'use strict';

 });
```

### Bundling

**Client side source code must be optimized**

There are two distinct modes into TAO :

1. `DEBUG` mode (akka Development mode)
2. `PRODUCTION` mode (akka Bundle mode)

You can change the mode by switching the value of the constant `DEBUG_MODE` into `config/generis.conf.php`

On of the main difference between those two modes is the client side source code is optimized. Per extension, the source code is aggregated into bundles, transformed and optimized :

The bundler is available as a Grunt task in the repository [oat-sa/grunt-tao-bundle](https://github.com/oat-sa/grunt-tao-bundle).

![bundler](../resources/tao-bundler.png)

 - The bundler create bundles per extension and per target (backoffice, frontoffice, separate entry point, etc.)
 - Libraries and the core framework is in a `vendor` bundle
 - The optimizer supports UglifyJs and Babbel.
 - Each extension needs to configure its bundles into the files `views/build/grunt/bundle.js`
 - Bundling is done during the release of an extension, not during it's development.

For example :

```js
module.exports = function(grunt) {      //it's a Grunt configuration so we're in a node.js process
    'use strict';

    grunt.config.merge({                //add it to the configuration
        bundle : {                      //the config entry is always bundle
            taoce : {                   //name the task like the extension, lowercase, by convention
                options : {             //define the bundles options
                    extension : 'taoCe',
                    outputDir : 'loader',
                    bundles : [{
                        name : 'taoCe',
                        default : true
                    }]
                }
            }
        }
    });
    grunt.registerTask('taocebundle', ['bundle:taoce']);    //register a task alias
};
```

Per extension you can generate the bundle using the following command, the task name is `${extensionNameLowerCase}bundle`, so to bundle the extension `taoCe` you'll have :

![bundle taoce](../resources/bundle-taoce.png)


## Routing

### The AMD loader

The TAO application can be seen has multiple Single Page Application (because of the transition of multiple pages to SPA).
Each page, which is the result of a navigation or a dedicated entrypoint contains the _loader_.

The _loader_ can take two appearances :

1. In _development_ (or `DEBUG_MODE`) :

The loader loader `require.js`, a bootstrap that will load the config and the given controller (based on the values from the `data-attr`).
Each module is loaded separately (the source files are loaded one by one) and when they're requested only.

```
<script
    id="amd-loader"
    data-config="https://taoce.taocloud.org/tao/ClientConfig/config?extension=tao&amp;module=Main&amp;action=login"
    src="https://taoce.taocloud.org/tao/views/js/lib/require.js?buster=3.3.0-sprint93"
    data-main="https://taoce.taocloud.org/tao/views/js/loader/bootstrap.js?buster=3.3.0-sprint93"
    data-controller="controller/login"
></script>
```

2. In _production_ :

A vendor bundle that contains shared libraries and SDK is first loaded, then the AMD loader loads the bundles for the entrypoint.
The bundle contains the bootstrap that will load the config and the controller

```
<script src="https://taoce.taocloud.org/tao/views/js/loader/vendor.min.js?buster=3.3.0-sprint93"></script>
<script id="amd-loader"
    data-config="https://taoce.taocloud.org/tao/ClientConfig/config?extension=tao&amp;module=Main&amp;action=login"
    src="https://taoce.taocloud.org/tao/views/js/loader/login.min.js?buster=3.3.0-sprint93"
    data-controller="controller/login"
></script>
```


![frontend initilization](../resources/loader-init.png)
