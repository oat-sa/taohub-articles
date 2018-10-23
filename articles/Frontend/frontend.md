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

 - if the code is considered as framework code, generic library or general enough it belongs to the tao extension
 - otherwise to should be placed in the correct extension, based on the task

**Don't Repeat Yourself**
If a module, a function or a block is used across multiple extensions, you'll need to find the common ancestor extension. and define it there. It's one of the reason some GUI components are in the tao extension.

> In the near future we will try to push generalized code into `npm` libraries to prevent having too much code into the tao extension.


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
│   ├── lib                //externam libraries
│   ├── loader             //contains the bundles
│   ├── provider           //data providers (gives access to the data)
│   ├── runner             //runners (test, item, etc.) code
│   └── services           //business logic
└── templates              //server side templates, usually page loaders
```

> This structure is unfortunately only theoretical. A huge refactoring would be great. 


## AMD & Require.js

All JavaScript files are AMD modules. 
TAO is using AMD to define import and export, but also for dependency injection.

All modules have the same form : 

```js 
define([
    'lodash',
    'taoQtiItem/component/foo'
], function(_, fooComponent){
    'use strict';
    
    return {
        bar : true
    }
});
```

Even without dependencies, a module needs to be wrapped into the `define` statement. 

### Module paths

The dependencies are declared using a module name, which is not necessarily a path. By default you can make the reference to a module by using the following pattern:  `${extensionName}/${pathInViews}/${moduleName}`.
For example to access `taoQtiTest/views/js/runner/plugins/control/timers/timer.js` you'll use `taoQtiTest/runner/plugins/control/timers/timer`.
You'll notice the `views/js` disappear as well as the file extension.

The base URL is always for JavaScript resources `tao/views/js` so for modules into the tao extension you don't need to prefix them with `tao`. For example to access `tao/views/js/core/eventifier.js`, `core/eventifier` should  be used.

and those who have an alias defined in the configuration can be called using the alias `lodash`, `jquery`, `moment`, `i18n`, etc.

### Named modules

Named modules are prohibited. 
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

### Dependency injection

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
