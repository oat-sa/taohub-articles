# TAO Frontend

This document describes how the TAO frontend architecture.

## Continuous improvement

Please remember the TAO software is an 15+ years old software. Yes.
Some headers in the source code can attest it :

```
 * Copyright (c) 2002-2008 (original work) Public Research Centre Henri Tudor & University of Luxembourg (under the project TAO & TAO2);
 *               2008-2010 (update and modification) Deutsche Institut für Internationale Pädagogische Forschung (under the project TAO-TRANSFER);
 *               2009-2012 (update and modification) Public Research Centre Henri Tudor (under the project TAO-SUSTAIN & TAO-DEV);
 *               2013-2014 (update and modification) Open Assessment Technologies SA;
```

And the software has also crossed the years by evolving, step by step. Some pieces of code being developed at some point, some other later. Some parts are very good, some other aren't.

Keeping this in mind, you'll always see exceptions to the rules described in this document. So takes those rules as guidelines, as a goal to reach. When doing something new, please follow them strictly, but when fixing a bug, sometimes it's worth refactoring, sometimes it isn't.

## The extension model

TAO use and "extension" model. This means the software is composed of many extensions using a hierarchical model : each extension can depend on another extension.

![extension model](./resources/extension.png)

This dependency model is defined at the level of the business logic but also at the level of the code.

**The code inside an extension can be dependent on the code inside another extension only if the dependency to the extension exists too**

For example, in the source code of `taoQtiItem` you can use code from `taoItems`. Given a file `taoQtiItem/views/js/controller/Main/index.js` :

```js
define([
    'taoItems/service/assets'
], function(assets){

})
```
The dependency in the `define` is allowed only because `taoQtiItem` depends on `taoItems`. To ensure a dependency exists, please check the extension `manifest.php` file :

```php
return array(
    'name'        => 'taoQtiItem',
    'label'       => 'QTI item model',
    'license'     => 'GPL-2.0',
    'version'     => '18.0.0',
    'author'      => 'Open Assessment Technologies',
    'requires' => array(
        'taoItems' => '>=6.0.0',
        'tao'      => '>=21.0.0',
        'generis'  => '>=7.3.0',
    ),
    //...
);
```

### In which extension should I write my code ?

 - if the code is considered as framework code, generic library or general enough it belongs to the TAO extension
 - otherwise to should be placed in the correct extension, based on the task

**Don't Repeat Yourself**
If a module, a function or a block is used across multiple extensions, you'll need to find the common ancestor extension, and define it there. It's one of the reason some GUI components are in the `tao-core` extension.

> In the near future we will try to push generalized code into `npm` libraries to prevent having too much code into the `tao-core` extension.


### Extension structure

The ideal structure :
```
views
├── build                  //build configuration
│   └── grunt              //where grunt loads the config for this extension
├── css                    //result of the SASS compilation
├── scss                   //SASS sources, should be extension generic styles
├── img
├── js                     //JavaScript folder
│   ├── component          //the graphical components
│   ├── controller         //contains the controlers,
│   │   └── routes.js      //mandatory, define how to load the controllers
│   ├── lib                //external libraries
│   ├── loader             //contains the bundles
│   ├── provider           //data providers (gives access to the data, usually through Ajax requests)
│   ├── runner             //runners (test, item, etc.) code
│   └── services           //business logic (loads data from providers and expose meaningfull services)
└── templates              //server side templates, usually page loaders
```

> This structure is unfortunately only theoretical. A huge refactoring would be great.





## Documentation

### File headers

Every file MUST contain the copyright and license header with the correct year.
Here is the default open source header :

```
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2018 Open Assessment Technologies SA;
 */

```

### JavaScript

We use a **subset** of the [jsdoc](http://usejsdoc.org/) format for the JavaScript code documentation.
Mostly we document :
 - functions and method parameters
 - complex types
 - return values
 - thrown errors
 - events
 - callbacks

The documentation doesn't target a tool, it target humans, other developers to be able to call your API.

For example :

```js
/**
 * A fooBar provides you the foo.
 * @type {fooBar}
 */
return {

  /**
   * This is how you get foo
   * @param {String[]} ids - the foo identifiers
   * @param {Object} [options]
   * @param {Boolean} [options.force = false] - force the foo
   * @returns {Promise<Number>} resolves with the number of updated foos
   * @fires fooBar#foo once the foo has foo
   * @throws {TypeError} if the parameters are invalid
   */
  foo : fuction foo(ids, options){
    //...
  }
};
```

## Coding style

### Format and linting

Please configure your IDE or development editor to support :
 - JavaScript ES5 and ES2015+ style
 - [EsLint](https://eslint.org), the configuration is available in [Github](https://github.com/oat-sa/tao-core/blob/master/views/build/.eslintrc.json) or under the folder `tao/views/build`
 - [EditorConfig](https://editorconfig.org/), the configuration is also available in [Github](https://gist.github.com/krampstudio/7fea73321d21865a2826583cf7997827)

### ES5 style

Most of the TAO JavaScript code is written in ES5 for obvious and historical reasons. We will be able to migrate to ES2015+ code style, extension by extension using Babel. But if an extension or a project uses ES5 code, you should comply with it.

Some of the code style rules :
 - prefer factories and closures over prototypes
 - always in strict mode
 - named function expressions for methods  `{ method : function method() }`


### ES2015+ style

> We will migrate everything to ES2015 and beyond code style. Some extensions and projects may already use them.

Some of the code style rules :
 - Do not use `class`, always prefer composition over inheritance. However there are a few use cases `class` would be allowed, for example to extend DOM prototypes, like `Error` to create new error types.
 - Try to use `const` everywhere
 - be careful with destructuring, this can  create code difficult to read

## TAO Framework

### AMD & Require.js

All JavaScript files are AMD modules.
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

Even without dependencies, a module needs to be wrapped into the `define` statement.

#### Module paths

The dependencies are declared using a module name, which is not necessarily a path. By default you can make the reference to a module by using the following pattern:  `${extensionName}/${pathInViews}/${moduleName}`.
For example to access `taoQtiTest/views/js/runner/plugins/control/timers/timer.js` you'll use `taoQtiTest/runner/plugins/control/timers/timer`.
You'll notice the `views/js` disappear as well as the file extension.

The base URL is always for JavaScript resources `tao/views/js` so for modules into the tao extension you don't need to prefix them with `tao`. For example to access `tao/views/js/core/eventifier.js`, `core/eventifier` should  be used.

Modules with an alias defined in the configuration can be called using this alias `lodash`, `jquery`, `moment`, `i18n`, etc. Since alias create some coupling between the source code and the configuration, we try to reduce their usage as much as possible.

#### Named modules

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

#### Dependency injection

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
````

If you require this module in a module A, and call `getFoo` then after in another module B, you also call `getFoo`, you'll get the value `2`, etc.

#### Loading Templates

TAO supports loading templates as AMD dependencies.

 - Templates are formatted using the Handlebars syntax (see https://handlebarsjs.com)
 - The template file extension is `.tpl`
 - They must be loaded through AMD, using `'tpl!path/to/module' (without the `.tpl` extension, since a template is considered as a JavaScript file)
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

#### Loading JSON data

TAO supports loading JSON files as AMD dependencies,  using `'json!path/to/module.json' (with the `.json` extension). The result is directly parsed to a JavaScript Object

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

#### Loading stylesheets

TAO supports loading CSS files as AMD dependencies,  using `'css!path/to/module.json' (with the `.css` extension).
 - The stylesheet are loaded when the module is loaded for the first time.
 - Stylesheets doesn't export something, so by convention, add them at the end of your dependencies

For example, consider the file `tao/views/js/ui/switch/css/switch.css`, to include in a JavaScript module :


```js
define([
    'css!ui/switch/css/switch.css'
], function(){
	'use strict';

 });
```

#### Bundling

**Client side source code must be optimized**

There are two distinct modes into TAO :

1. `DEBUG` mode (akka Development mode)
2. `PRODUCTION` mode (akka Bundle mode)

You can change the mode by switching the value of the constant `DEBUG_MODE` into `config/generis.conf.php`

On of the main difference between those two modes is the client side source code is optimized. Per extension, the source code is aggregated into bundles, transformed and optimized :

The bundler is available as a Grunt task in the repository [oat-sa/grunt-tao-bundle](https://github.com/oat-sa/grunt-tao-bundle).

![extension model](./resources/extension.png)

 - The bundler create bundles per extension and per target (backoffice, frontoffice, separate entry point, etc.)
 - Libraries and the core framework is in a `vendor` bundle
 - The optimizer supports UglifyJs and Babbel.
 - Each extension needs to configure its bundles into the files `views/build/grunt/bundle.js`
 - Bundling is done during the release of an extension, not during it's development.

For example :

```
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

![bundle taoce](./resources/bundle-taoce.png)

### Libraries 

#### require.js

#### jQuery

#### Lodash

#### Handlebars

#### Moment

#### D3/C3

#### CKEDitor

#### MathJax

#### Raphael

deprecated

#### Interact

#### Async

deprecated


### Patterns

 JavaScript is an open language, that let's you write code in very different ways, even in different paradigms, from prototypal object oriented to functional programming. In TAO we've selected some programming paradigms and patterns over others. The goal is to bing some consistency accross the platform.


#### Composition over inheriance

#### Factories

#### Observable

#### Provider

#### Service

#### Components



### Core components

 - eventifier
 - plugins
 - area broker
 - store

### Services

- data provider

### Routing and controllers

### Components

 - SASS scopes to component

### Tests


## CSS and SASS

## Coding in TAO

### Best Practices

### Conventions

### Recommendations 

## Pull requests

Code modification is done through pull requests. They have to follow some simple rules :

 - the branch should be named using the pattern `type/JIRA-ID/description` where type is either `fix`, `feature`, `breaking` (or `backport/`), according to semver (if the contribution is an open contribution, please set `OSS` as `JIRA-ID`)
 - the pull request is created against the `develop` branch.
 - the pull request contains minimal instructions : what has changed, how to reproduce and how to test. - any dependency is clearly set, if the pull request rely on another pull request it should be described.
 - the version number of the current extension should be increased according to semver (install and update)
 - the code style rules is valid (no ESLint warning)
 - the code is covered by tests (there are a few exceptions)
 - the code is documented
 - the code follows conventions, best practices and recommendations
