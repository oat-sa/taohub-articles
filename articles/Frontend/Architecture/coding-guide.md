<!--
authors:
    - "Bertrand Chevrier"
    - "Andrey Shaveko"
tags:
    Frontend Architecture:
        - "Coding guide"
-->

# TAO Frontend Coding guide

> This document describes the frontend coding guidelines

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
 * Copyright (c) 2022 Open Assessment Technologies SA;
 */

```

### JavaScript

We use a **subset** of the [jsdoc](https://jsdoc.app/) format for the JavaScript code documentation.

Mostly we document :

- functions and method parameters
- complex types
- return values
- thrown errors
- fired events
- callbacks/lambda

**The documentation doesn't target tools, it targets humans**. It is important to clearly and precisely document APIs, but it's even more important to communicate the intents.

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

> The golden rule is the consistency

### Format and linting

Please configure your IDE or development editor to support :

1.  JavaScript ES5 and ES2015+ style
2.  CSS, SASS, HTML, JSON and Handlebars templates, etc.
3.  [ESLint](https://eslint.org), make sure IDE uses `.eslintrc.js` which imports config from [eslint-config-tao](https://github.com/oat-sa/eslint-config-tao)
4.  [Prettier](https://prettier.io/), if `prettier.config.js` exists in repository, configure IDE to use, this file imports config from [prettier-config](https://github.com/oat-sa/prettier-config)
5.  [EditorConfig](https://editorconfig.org/), is one or the options to configure code formatting using [this configuration](../../resources/frontend/lint/.editorconfig)

### General rules

- Code should be consistent and easy to understand and self descriptive.
- Writing comments when it is necessary is highly appreciated. Comments shouldn't be redundant with the code itself (clear code document itself) but provide additional and useful information.
- Variable, function, method names should reflect the intent in a clear way.
- Variable definitions should be separated always by new lines to help readability.
- Variable should be defined using it's own statement (no comma after the declaration)
- Use 4 spaces for indents
- No more than one blank line
- No ASCII art within the source code
- Use single quotes for string literals
- Brace style [1TBS](https://en.wikipedia.org/wiki/Indentation_style#Variant:_1TBS_)
- Try to avoid using ternary operator in complex cases (or don't use at all?)
- Always use `===` instead of `==`
- Variable names for jQuery elements have to start with `$`
- No underscore to private variables functions

### ES5 style

If an extension or a project doesn't yet support ES2015+, the following rules apply :

- always in strict mode : `'use strict';` in the highest scope
- ensure to always code in a non global lexical scope (it's the case for AMD or CommonJS, otherwise use [IIFE](https://developer.mozilla.org/en-US/docs/Glossary/IIFE))
- named function expressions for methods : `{ method : function method() }`
- named callbacks for easier debugging : `on('click', function buttonOkClickHandler(e){`
- references to the lexical scope are made using the `self` variable name (for consistency)
- hoisting should be reflected by variable declaration, ie. `var` on top.
- `Promise` is available to manage asynchronous flow.

### ES2015+ style

Allowed features from the [ES2015 specification](http://www.ecma-international.org/ecma-262/6.0/index.html) :

- All features from previous specifications (ES3, ES5)
- `const` and `let`.
- `Object` and `Array` new built-in (`Objet.assign`, `Array.from`, `Array.of`, etc.)
- `String` new built-in (`String.includes`, `String.startWith`, etc.)
- `Promise`
- `Map`, `Set` (including `WeakMap` and `WeakSet`)
- [Typed arrays](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Typed_arrays)
- [default function parameters](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Default_parameters)
- [rest parameters](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/rest_parameters)
- [spread syntax on objects](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax)
- [shorthand object notation](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Object_initializer#New_notations_in_ECMAScript_2015)
- [for ... of](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...of)
- [template literals](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals)
- [destructuring](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment)
- [arrow function](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions)
- [import](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/import)/[export](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/export) only when the bundler supports it (library, side projects)

The following coding rules apply on ES2015 code :

- no `use strict` anymore in modules, but it needs to be kept outside ES2015 modules.
- Named function expressions can be replaced by the shorthand object notation `{ method(){ } }`
- Do not use `class`, always prefer composition over inheritance. However there are a few use cases `class` would be allowed, for example to extend DOM prototypes, like `Error` to create new error types.
- Try to use `const` by default (immutable) and `let` only for mutable variables (counters).
- Be careful with destructuring, this can create code difficult to read. A reviewer can ask to rewrite a destructred assignment if the produced code is cryptic.
- Use arrow functions for [lambda](https://en.wikipedia.org/wiki/Anonymous_function) to avoid unnecessary lexical scopes, but avoid them for top-level factories or [pure function](https://en.wikipedia.org/wiki/Pure_function) definitions.
- Use template literals instead of string concatenation.
- Use destructuring and default parameters for method's `options` parameter : `function({label = "", num = 0} = {}) { }`

### SASS/CSS

- Do not use `!important`, never.
- Do not use inline style, ie `style="font-size:16px"`, never.
- When grouping selectors, keep individual selectors on a single line.
- Include one space before the opening brace of declaration blocks for legibility.
- Each declaration should appear on its own line for more accurate error reporting.
- End all declarations with a semi-colon.
- Avoid specifying units for zero values.
- Keep classes lowercase and use hyphens (not underscores or camelCase). Dashes serve as natural breaks in related class.
- Use class names that describe the purpose of the element, rather than the presentation of the element : do not use classes like `.center` or `.column` nor `.button` but instead `.user-profile`, `.highlighted-stimulus` or `notification-area`.
- Except for base styles (reset, normalize, base and font) every rule must be scoped, by the class name of the component or a root component.
- Try to avoid IDs in selector as much as possible and global tag selectors. Instead try to always scope the selection.
- Selection must be done by following the semantic of the DOM ie. `.actions > button` or `.actions > [role=button]` instead of `.actions > .btn`
- Place media queries as close to their relevant rule sets whenever possible. Don't bundle them all in a separate stylesheet or at the end of the document.
- Don't write vendor prefixes (configure _autoprefixer_ instead).
- Avoid unnecessary nesting and too many nesting levels.
- Mixins and functions should be as simple as possible, serve only one purpose and be documented
- Use variables for colors, and units that are used in multiple locations

## Best practice & Patterns

JavaScript is an open language, that let's you write code in very different ways, even in different paradigms, from prototypal object oriented to functional programming. In TAO we've selected some programming paradigms and patterns over others. The goal is to bring some consistency and shared practices across the platform.

### Don't repeat Yourself

> "Every piece of knowledge must have a single, unambiguous, authoritative representation within a system."
> _Andy Hunt, The Pragmatic Programmer_

The simple principle will lead to code easier to maintain. So if you write the same code multiple time, think about abstractions. Abstractions doesn't need to be too high level.

### KISS

> "Sometimes, the elegant implementation is just a function. Not a method. Not a class. Not a framework. Just a function."
> _John Carmack, game developer_

If your module needs to expose a function, then your module can expose only a function, especially when there's no state, no side effect!

If multiple functions serve the same purpose they can be grouped into an object serving multiple and independent _static like_ methods :

```js
//a case module util
return {
  capitalize: function capitalize(inputString) {},
  camelToSnake: function camelToSnake(inputString) {},
};
```

### API first

> "Any fool can write code that a computer can understand. Good programmers write code that humans can understand"
> _Martin Fowler_

When writing your module think about it as an API, following the open/close principle, think about input and output. Try to avoid side effect and try to think as the developer that will use this API : "how ideally would you like to call this API".

Using [TDD](https://en.wikipedia.org/wiki/Test-driven_development) can help in having clear APIs, testing first the API usually lead to clear APIs.

### Composition over inheritance

> "You wanted a banana but what you got was a gorilla holding the banana and the entire jungle".
> _Joe Armstrong, creator of Erlang, about the classical inheritance_

To avoid strong coupling due to inheritance, we favor in TAO composition over classical inheritance. The main goal remains to separate the behavior from the implementation, in order to divide the responsibilities.

Composition can have multiple form, based on the use case :

1. Aggregation

This simple pattern consists in using another module.

```js

import jwtSignatureFactory from 'jwtSignatureFactory.js'

module.exports function jwtHandler(){

    //we use another module in the current module
    const jwtSignatureVerifier = jwtSignatureFactory('HMAC', 'SHA256');
}
```

2. Mixin

This pattern consists in assigning the method of an object to another in order to aggregate them into one object, or give the feature of an object to another.
For example,

```js
//the mixin, a separate behavior you'll add on multiple objects
const assignee = {
  getAssignments() {
    return this.assignments;
  },
  setAssignments(deliveries) {
    this.assignments = assignments;
  },
};
const aUser = {
  firstName: "john",
  lastName: "snow",
  getName() {
    return `${this.firstName} ${this.lastName}`;
  },
};

const testTaker = Object.assign(aUser, assignee);
```

The particularity of this pattern is the scope is shared between the target and the mixin : `this` will be shared.
There are multiple ways to achieve this pattern, including using prototypes.

_When to use it ?_
When mixins are pure methods or stateless by preference. There shouldn't be any strong coupling between the target and the mixin (for example the mixin expects a property to be available in the target).

3. Delegation

Delegation pattern is composition pattern where component delegates functionality to other module

```js
const person = {
  name: "Carl",
  allowanceLimit: 20,
};

const allowance = {
  substract(amount) {
    if (amount <= this.allowanceLimit) {
      this.allowanceLimit -= amount;
    }
  },
  getAllowanceLimit() {
    return this.allowanceLimit;
  },
};

function delegate(source, methods, provider) {
  methods.forEach((methodName) => {
    source[methodName] = function () {
      return provider[methodName].apply(source, arguments);
    };
  });
}

delegate(person, ["substract", "getAllowanceLimit"], allowance);

person.substract(5);
console.log(person.getAllowanceLimit()); //15

person.substract(10);
console.log(person.getAllowanceLimit()); //5

person.substract(10);
console.log(person.getAllowanceLimit()); //5 (did not substract because of limit)
```

`delegate` function does late binding of `provider` mathods to person objects.
Later we call `delegate` to attach allowance operation from `person` to `allowance` module. Allowance methods then update person state

4. Forwarding

Forwarding design pattern is used to completely forward data and control to other module. This is the good approach to manage shared states and distribute permission for shared state operation.

```js
const person1 = {
  name: "Bob",
};

const person2 = {
  name: "Alice",
};

const familyWallet = {
  balance: 0,
  earn(amount) {
    this.balance += amount;
  },
  spend(amount) {
    this.balance -= amount;
  },
  getBalance() {
    return this.balance;
  },
};

function forward(person, methods, provider) {
  methods.forEach((methodName) => {
    person[methodName] = function () {
      return provider[methodName].apply(provider, arguments);
    };
  });
}

forward(person1, ["earn", "spend", "getBalance"], familyWallet);
forward(person2, ["spend", "getBalance"], familyWallet);

person1.earn(30);
console.log(person1.getBalance()); // 30

person2.spend(10);
person1.spend(10);

console.log(person2.getBalance()); // 10
```

`forward` function does late binding of `provider` mathods to person objects.
Later we call `forward` to attach wallet operation from `person1` and `person2` to `familyWallet`.

### Factories

> "The best thing about JavaScript is its implementation of functions. It got almost everything right. But, as you should expect with JavaScript, it didn't get everything right."
> _Douglas Crockford, JavaScript: The Good Parts_

When a module needs to keep a state and hide some implementation details, the factory pattern will be selected.

```js
var countDownFactory = function countDownFactory(config) {
  var currentValue = config.value || 0; //private but accessible through the API
  var interval = null; //kept private

  return {
    getValue: function getValue() {
      //expose some internal va
      return currentValue;
    },
    start: function start() {
      interval = setInterval(function () {
        currentValue--;
      }, config.delay);
    },
    stop: function stop() {
      clearInterval(interval);
    },
    reset: function reset() {},
  };
};
```

### Event Emitter

> "JavaScript is especially suited for event-driven programming, because of the callback pattern, which enables your programs to work asynchronously, in other words, out of order."
> _Stoyan Stefanov, JavaScript Patterns_

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

TAO provides an implementation, the `core/eventifier` module, it has the following features :

- contextualized to an object (events are scoped)
- support [AOP](https://en.wikipedia.org/wiki/Aspect-oriented_programming) style listening (`before` -> `on` -> `after`)
- support namespaces
- support `Promise` (asynchronous handlers)
- supports context spreading

Please check out the [eventifier documentation](#eventifier).

### Provider

When multiples implementation of a given API can be defined, or dynamically defined, the provider pattern is used.

```js
const jsonDataProvider = {
  requestData() {
    //read some json file and return data
  },
};

const csvDataProvider = {
  requestData() {
    //read some csv file and return data
  },
};

const person = {
  dataProvider,
  data,
  updateData() {
    this.data = this.dataProvider.requestData();
  },
  registerProvider(provider) {
    this.dataProvider = provider;
  },
};
```

In this example two providers are defined, which have same `requestData` API method. `person` object does not request data directly and doesn't implement any data parsing logic, it just registers the appropriated provider and request data from it. This allows to decouple components, keep components small and easy testable.

### Components

In TAO we render and manipulate DOM using "components". A component is a chunk of the graphical user interface.
A component can be atomic (a button) or a larger part of the GUI (a dashboard) that uses other components.
The atomicity level is up to use cases and usually defined by the way the component will be used.
The purpose of a component is to render a DOM from a given set of data, react to the time and user events, and change based on a given state.

An article is dedicated to [components](./component-abstraction).

> The way to do components in TAO has evolved a lot and only stabilized a few years ago, but expect the way to build component to be changed again soon. Remember if the way change the concept remains the same.

### Plugins

An article is dedicated to [plugins](./plugins-model).
