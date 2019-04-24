<!--
authors:
    - "Bertrand Chevrier"
tags:
   - "Frontend":
        - "Frontend Architecture"
-->

# TAO Frontend Coding guide

This document describes the TAO frontend architecture.


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
 - callbacks/lambda

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
   * @fires fooBar#foo once the foo has foo the foo event is triggered
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

 1. JavaScript ES5 and ES2015+ style
 2. CSS, SASS, HTML, JSON and Handlebars templates, etc.
 3. [ESLint](https://eslint.org), using this [configuration](../resources/lint/.eslintrc.json) or under the folder `tao/views/build`
 3. [SassLint](https://github.com/sasstools/sass-lint), using this [configuration](../resources/lint/.sasslintrc) or under the folder `tao/views/build`
 4. [EditorConfig](https://editorconfig.org/), using this [configuration](../resources/lint/.editorconfig)



> Every project should 

### ES5 style

Most of the TAO JavaScript code is written in ES5 for obvious and historical reasons. We will be able to migrate to ES2015+ code style, extension by extension using Babel. But if an extension or a project uses ES5 code, you should comply with it.

Some of the code style rules :
 - always in strict mode : `'use strict';` in the upper scope
 - named function expressions for methods :  `{ method : function method() }`
 - name callbacks for easier debugging : `on('click', function buttonOkClickHandler(e){`
 - references to the lexical scope are made using the `self` variable name
 - hoisting should be reflected by variable declaration, ie. `var` on top.
 - `Promise` is available to manage asynchronous flow.

### ES2015+ style

> We will migrate everything to ES2015 and beyond code style. Some extensions and projects may already use them. The goal is to support the EcmaScript features available in last version of Chrome and Firefox and transpile using babel for the other browsers.

Allowed features :
 - `const` and `let`
 - `Object` and `Array` new built-in (`Objet.assign`, `Array.from`, `Array.of`)
 - `String` new built-in (`String.includes`, `String.startWith`, etc.)
 - `Promise`
 - `Map`, `Set` (including `WeakMap` and `WeakSet`) as well as typed arrays
 - [default function paramters](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Default_parameters)
 - [rest parameters](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/rest_parameters)
 - [spead syntax on objects](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax)
 - [shorthand object notation](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Object_initializer#New_notations_in_ECMAScript_2015)
 - [for ... of](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...of)
 - [template litterals](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals)
 - [destructuring](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment)
 - [arrow function](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions)

 - `import/export` only when the bundler supports it (library, side projects)
 - Everything from ES5
 - No `use strict` anymore
 - Named function expressions can be replaced by the shortand object notation `{ method(){ } }`
 - Do not use `class`, always prefer composition over inheritance. However there are a few use cases `class` would be allowed, for example to extend DOM prototypes, like `Error` to create new error types.
 - Try to use `const` by default (immutable) and `let` only for mutable variables (counters).
 - Bhe careful with destructuring, this can  create code difficult to read. A reviewer can ask to rewrite a destructred assignment if the produced code is cryptic.
 - Use arrow functions for lambda to avoid unnecessary lexical scopes, but avoid them for top-level factories or pure function definitions. 
 - Use template literals instead of string concatenation.
 - shortand object notation is allowed `{ method(){ } }`
 - Use destructuring and default parameters for method's `options` parameter : `function({label = "", num =0} = {}) { }

### Static analysis

You can verify (and we do it automatically) the style and formatting using the Grunt task.

First move to the build folder :

```sh
cd tao/views/build
```

To verify a file :

```sh
npx grunt eslint:file --file=${PATH_TO_FILE}
```

To verify a complete extension :

```sh
npx grunt eslint:extension --extension=${EXTENSION_NAME}
```




### Patterns

 JavaScript is an open language, that let's you write code in very different ways, even in different paradigms, from prototypal object oriented to functional programming. In TAO we've selected some programming paradigms and patterns over others. The goal is to bing some consistency accross the platform.


#### Composition over inheriance

Joe Armstrong, creator of Erlang, about the classical inheritance :
> "You wanted a banana but what you got was a gorilla holding the banana and the entire jungle".

To avoid strong coupling due to inheritance, we favor in TAO composition over classical inheritance. The main goal remains to separate the behavior from the implementation, in order to divide the responsibilities.

Composition can have multiple form, based on the use case :

1. Aggregation

This simple pattern consists in using another component/

2. Mixin

This pattern consists in assigning the method of an object to another in order to aggregate them into one object, or give the feature of an object to another.
For example,

```js
//the mixin, a separate behavior you'll add on multiple objects
const assignee = {
    getAssignments(){
        return this.assignments;
    },
    setAssignments(deliveries){
        this.assignments = assignments;
    }
};
const aUser = {
    firstName : 'john',
    lastName  : 'snow',
    getName(){
        return `${this.firstName} ${this.lastName}`;
    }
};

const testTaker = Object.assign(aUser, assignee);
```

The particularity of this pattern is the scope is shared between the target and the mixin : `this` will be shared.
There are multiple ways to achieve this pattern, including using prototypes.

*When to use it ?*
When mixins are pure methods or stateless by preference. There shouldn't be any strong coupling between the target and the mixin (for example the mixin expects a property to be available in the target).

3. Delegation

The delegation is a form of composition, when

4. Forwarding


#### Factories

When a module needs to keep a state and hide some implementation details, the factory pattern will be selected.

```js
var countDownFactory = function countDownFactory(config){
    var currentValue = config.value || 0;   //private but accessible through the API
    var interval = null;                    //kept private

    return {
        getValue : function getValue(){
            //expose some internal va
            return currentValue;
        },
        start: function start(){
            interval = setInterval(function(){
                currentValue--;
            }, config.delay);
        },
        stop : function stop(){
            clearInterval(interval);
        },
        reset : function reset(){

        }
    };
};
```

#### Event Emitter

The goal of this pattern is to listen some events from a source and attach a behavior when they're triggered.

This is the pattern used by the DOM to react on user's interactions, like a `click` (see [DOM Events](https://developer.mozilla.org/en-US/docs/Web/API/Event). The node.js [EventEmitter](https://nodejs.org/api/events.html#events_class_eventemitter) is also a popular implementation of this pattern.

For example ,

```js
const countdown = eventifier({
    start(counter){
        if(!this.started){
            this.value = counter;

            this.interval = setInterval( () => {
                this.value--;

                this.trigger('update', value));

                if(this.value <= 0){
                    this.stop();
                }
            });

            this.trigger('start');

            this.started = true;
        }
    },
    stop(){
        if(this.started){

            clearInterval(this.interval);

            this.trigger('stop');

            this.started = false
        }
    }
});

countdown
    .on('update', value => console.log(`Please wait ${value}seconds.`))
    .on('stop',  () => console.log('Please enter'))
    .start();

```

TAO provides an implementation, the `core/eventifier` module ti has the following features :
 - contextualized to an object
 - support AOP style listening (`before` -> `on` -> `after`)
 - support namespaces
 - support `Promise` (asynchronous handlers)
 - supports context spreading

Please check out the [eventifier documentation](#eventifier).

#### Provider

When multiples implementation of a given API can be defined, or dynamically defined, the provider pattern is used.

#### Components

In TAO we render and manipulate DOM using "components". A component is a chunk of the graphical user interface.
A component can be atomic (a button) or a larger part of the GUI (a dashboard) that uses other components.
The atomicity level is up to use cases and usually defined by the way the component will be used.
The purpose of a component is to render a DOM from a given set of data, react to the time and user events, and change  based on a given state.

The `ui/component` [documentation](#component) describes how to create a component.

> The way to do components in TAO has evolved a lot and only stabilized a few years ago, but expect the way to build component to be changed again soon. Remember if the way change the concept remains the same.

#### KISS

John Carmack, game developer :
> "Sometimes, the elegant implementation is just a function.  Not a method.  Not a class.  Not a framework. Just a function."

If your module needs to expose a function, then your module can expose only  a function, especially when there's no state, no side effect!

If multiple functions serve the same purpose they can be groupped into an object serving multiple and independant static methods :

```js
//a case module util
return {
    capitalize : function capitalize(inputString){

    },
    camelToSnake : function camelToSnake(inputString){

    }
}
```

### Core components

#### Eventifier
#### Plugins
#### Area broker
#### Store

### Services

- data provider



### Components

 - SASS scopes to component
 - lifecycle
 - API and events
 - DOM and Template
 - State

### Tests


## CSS and SASS

## Coding in TAO


 - do not assign a value to the `arguments` special object


## Pull requests

Code modification is done through pull requests. They have to follow some simple rules :

 - the branch should be named using the pattern `type/JIRA-ID/description` where type is either `fix`, `feature`, `breaking` (or `backport/`), according to semver (if the contribution is an open contribution, please set `OSS` as `JIRA-ID`)
 - the pull request is created against the `develop` branch.
 - the pull request contains minimal instructions : what has changed, how to reproduce and how to test. - any dependency is clearly set, if the pull request rely on another pull request it should be described.
 - the version number of the current extension should be increased according to semver (install and update)
 - the code style rules is valid (no ESLint warning)
 - the code is covered by tests (there are a few exceptions)
 - the code is documented
 - the pull request doesn't contain the bundles (bundles are created during the release)
 - the commits that compose a pull requests have meaningful comments
 - the code follows conventions, best practices and recommendations
