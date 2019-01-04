# Anatomy of a Javascript UI Component

> When we talk about a UI component, we usually mean an HTML element or small piece of the DOM, which is added to a page dynamically and has some specific behaviours attached to it, and maybe some state. This article will explain the way of building components we predominantly use within TAO.

## Starting point

As our example in this article we will look at a specific component: the dropdown menu ([tao/views/ui/dropdown.js](https://github.com/oat-sa/tao-core/blob/master/views/js/ui/dropdown.js)). It is not the most frequently used component, but is helpful for illustrating the key concepts.

## The Factory pattern

In any component's source code you will notice a specific pattern, the Factory pattern, which you will become very familiar with. The purpose of this pattern is to return a Factory function which we can use to instantiate one or more distinct instances of our component, wherever it is needed.

You also need to know about [RequireJS](https://requirejs.org/) to understand how the dependency system works.

```javascript
// A skeleton example of the Factory pattern
define([
    'jquery',
    'lodash'
], function ($, _) {
    'use strict';

    var defaults = {};

    function dropdownFactory(config, data) {
        var dropdownSpecs = {
            // ...
        }

        return component(dropdownSpecs, defaults)
    }

    return dropdownFactory;
});
```

In the above example, `config` and `data` are variables which will be passed into the factory by its calling script.

## Understanding the base component

Components are based on the constructor function defined in [`tao/views/js/ui/component.js`](https://github.com/oat-sa/tao-core/blob/master/views/js/ui/component.js). Be sure to read and understand this file well - it is crucial.

A component is always initialised with two parameters: its specs (API), and its default configuration.

```javascript
return component(componentApi, defaultConfig);
```

The following methods are always present in a component (and should not be overwritten without good reason): `init`, `destroy`, `render`, `show`, `hide`, `enable`, `disable`, `is`, `setState`, `getConfig` (and a few more!)

### The API

The API (or specs) of a component should be a plain object containing only a group of named functions which will be the public methods of your component instance. For example:

```javascript
var dropdownSpecs = {
    open : function open() {
        //
    },
    close : function close() {
        //
    },
    setHeader : function setHeader(html) {
        //
    },
    setItems: function setItems(items) {
        //
    }
};
```

The aim of the API object is to encapsulate the functionalities an instance of your componenent will possess. Follow the object-oriented principle to decide what to include here. If you have some helper functions which are not strictly related to the component, they do not need to go in the API - they can be included outside it.

*Pro tip:* If your methods are able to `return this`, it will help with chaining them together.

### The config

Most components will need a few configuration options. It has become standard practice to define a `defaults` (or `defaultConfig`) object alongside your component, and merge this with a config object which you pass in to your component's constructor at the point of use.

The config should contain properties which are needed to define how the component works, but not state-like variables. You may include things like width, height, classNames, strings, Boolean options.

The dropdown component has a very basic config:

```javascript
/**
  * Some default config
  * @type {Object}
  */
var defaults = {
    isOpen: false,
    activatedBy: 'hover'    // can be hover or click
};
```

## Dealing with the DOM

### Component templates

When a component needs to render itself (or a part of itself), we prefer to store the HTML in a Handlebars template whenever possible. The template is loaded as a dependency, using the `tpl!` helper:

```javascript
define([
    'jquery',
    'lodash',
    'ui/component',
    'tpl!ui/dropdown/tpl/dropdown',
    'tpl!ui/dropdown/tpl/list-item'
], function ($, _, component, dropdownTpl, itemTpl) {
    'use strict';
    ...
    return component(dropdownSpecs, defaults)
    .setTemplate(dropdownTpl); // specifies that the component's DOM will come from the first template file we loaded
});
```

If a smaller part of the component's DOM needs its own template, a subtemplate (its own file) can be called as a function, returning a DOM string which can be inserted using jQuery:

```javascript
setItems: function setItems(items) {
    var self = this;

    _.forEach(items, function(item) {
        self.controls.$listContainer.append(itemTpl(item));
    });
}
```

### renderTo

The most common way of telling your component where on the page to render is by passing into the `render` method a jQuery object or a string representing a selector.

```javascript
var $container = $('.my-container');
component(specs, {})
.render($container);
```

An alternative, but functionally identical way of doing this is by setting the `config.renderTo` property in the defaults or passed config.

```javascript
var ddMenu = dropdown({
    renderTo: '#user-menu'
});
```

### Managing DOM elements on the fly

A common practise is to use jQuery to select particular slots within the component's DOM, and store these references inside the component for future reference:

```javascript
myComponent.on('render', function () {
    var $component = this.getElement();
    this.controls = {
        $dropdown: $component.find('.dropdown'),
        $toggler: $component.find('.dropdown-header:after'),
        $headerItem: $component.find('.dropdown-header'),
        $listContainer: $component.find('.dropdown-submenu')
    };
});
```

For updating the contents of these slots on the fly, it can be best to use jQuery's methods: `.text()`, `.html()`, `.empty()`.

For example:

```javascript
setHeader: function setHeader(html) {
    if (this.is('rendered')) {
        this.controls.$headerItem.html(html);
    }
    return this;
}
```

## Events

### The component lifecycle

A component is intended to follow a simple 3-to-4-phase lifecycle:

`init` -> `render` -> `???` -> `destroy`

What happens in the `???` is rather flexible, and you may need to create an `update` or `change` event handler, to deal with whatever needs to happen while your component is alive on the page and interactive.

You can find an example of this in [tao/views/ui/breadcrumbs.js](https://github.com/oat-sa/tao-core/blob/master/views/js/ui/breadcrumbs.js).

### Eventifier

`Eventifier` is a custom event manager which we use to wrap the components in TAO. You can attach event handlers to an eventified component using the methods `.before`, `.on`, `.after`, whose syntax is similar to jQuery.

```javascript
myComponent.on('render', function() {
    // perform some tasks
});
```

This plugin also supports *event namespacing*: if you trigger an event called `render.mynamespace`, it will be picked up by a listener attached with `.on('render.mynamespace')`, but a plain `render` event will not trigger this listener and a `.on('render')` listener will not hear this event.

Read the source of [eventifier.js](https://github.com/oat-sa/tao-core/blob/master/views/js/core/eventifier.js) to better understand this aspect of components.

### Custom events

Triggering and listening for custom events can be a very helpful tool in structuring your component's code and making it able to interact with other pieces of Javascript.

```javascript
myComponent.trigger('statechange');

myComponent.on('statechange', function() {
    // do something
});
```

Designing your component so it talks to itself (or other components) through custom events can provide a nice way of managing its state when different parts of the application are split across multiple files.

## Component states

Components in TAO can have special state keywords, including `rendered`, `hidden`, `disabled`. You can check the Boolean value of a state of a component using `is`:

```javascript
myComponent.is('rendered'); // true
myComponent.is('hidden'); // false
myComponent.is('disabled'); // false
```

And set new states using `setState`:

```javascript
myComponent.setState('horizontal', true);
```

These states are always applied as class names on the component's root HTML element, which are added and removed whenever the state changes.

You can also make up your own state name, if needed. As long as it is a string, it will work the same way as the built-in keywords.

## Further reading

The following basic components are widely used in TAO or are particularly good examples to learn from:

-   [ui/dialog](https://github.com/oat-sa/tao-core/blob/master/views/js/ui/dialog.js)
-   [ui/datalist](https://github.com/oat-sa/tao-core/blob/master/views/js/ui/datalist.js)
-   [ui/actionBar]()
