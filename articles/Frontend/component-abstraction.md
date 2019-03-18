# Component abstraction

<!-- 
tags:
    JavaScript Components:
        - "Component abstraction"
-->

> A component abstraction is part of the TAO core library.
> This article explains how it works.

UI components are built on top of a component abstraction, supplied by a core
module exposing a factory function. This abstraction relies on the delegation
pattern, augmenting the default API by linking a definition object to the
created instance. It also integrates the [`eventifier`](events-model.md) API,
giving to any component the ability to communicate through events.

Basically, the way the component abstraction is working is as following:

![component abstraction](resources/component-abstraction.png) 

- a core API is exposed as a plain object
- the [`eventifier`](events-model.md) mixin is applied
- optionally, a definition object can be provided to augment the default API

It is worth to mention that the definition object is not directly merged
into the component object, but a delegation call is made instead. This means
all functions exposed by the object are linked to the component through
delegated calls, so that the target function remains inside the definition
object, and the lexical scope is set inside the component.

Here is a snippet showing how the call is delegated:

```javascript
componentApi[functionName] = function delegate(){
    return definitionObject[functionName].apply(componentApi, [].slice.call(arguments));
};
```

Due to that particularity, the following effects must be mentioned:
- Only the functions are linked, other properties are ignored and cannot be
accessed through the exposed API, even if it is referenced from the
definition object. However, the properties **defined inside** the component
are accessible through the lexical scope.
- The implementation of each function inside the definition object can be
changed at any time, without having to rebuild the component. This allows 
dynamic implementation.

To use the component abstraction you need to import the module `ui/component`: 

```javascript
define(['ui/component'], function (componentFactory) {
    'use strict';

    // ...

});
```

To create a new component you need to use the factory:

```javascript
// create a simple component, without additional API
var component = componentFactory();
```

Adding an additional API is straight forward:

```javascript
// create a simple component, with addition API
var component = componentFactory({
    pythagoras: function pythagoras() {
        return Math.sqrt(this.a * this.a + this.b * this.b);
    },
    update: function update(a, b) {
        this.a = a;
        this.b = b;
        return this;
    }
});

// use the additional API
var p = component.update(3, 4).pythagoras();
```

Usually a component needs to be initialized before it can be used.
Its abstraction creates and manages the life cycle.

![component life-cycle](resources/component-life-cycle.png)

- `init`: This is the step where the component is initialized. Usually, this is
done immediately after the component is created.
- `render`: This is the step where the UI is built. This step introduces the
next one. Since `render` is a step, related to the `rendered` state, the related
function is not meant to be called several times. To update the UI the component
must provide its own process.
- `interact`: This is the step where the component is spending most of its life.
However, this is not a formal step, as it is not reflected by a life-cycle
method. It can be seen as the *stage* between `render` and `destroy`. At this
stage the UI should be rendered and ready.
- `destroy`: This is the last and final step, where the component is tearing
down the UI and disposing the resources. After this step the component should
be deleted.

To initialize a component, you need to call the init method:

```javascript
// create a simple component, without additional API
var component = componentFactory();
component.init(config);
```

The component configuration is passed on during this step. Usually, this is done
by the component factory:

```javascript
function myComponentFactory(config) {
    var component = componentFactory();
    component.init(config);
    return component;
}
```

It is also a good practice to defer the initialization, giving the ability to
listen to the `init` event. However, please note the component won't be
available immediately, and in this case it is mandatory to rely only on events.

```javascript
function myComponentFactory(config) {
    var component = componentFactory();
    _.defer(function() {
        component.init(config);        
    });
    return component;
}

// the component is available asynchronously
myComponentFactory(config)
    .on('init', function() {
        this.render($container);
    })
    .on('render', function() {
        this.trigger('ready')
    });

// this won't work since the init is deferred.
myComponentFactory(config).render($container);
```

A default configuration can be built-in with the component. The signature of the
component abstraction factory is as follows: `component(specs, defaults)`;
- `specs`: the definition object, some extra methods to assign to the
component instance
- `defaults`: some default config entries

## Component built-in events
The life-cycle related methods are not meant to be replaced. This means a
component cannot implement its own version of the `init` method for instance.
This is the same for any other built-in life-cycle methods. Otherwise, the
built-in behavior would be broken.

To allow a component to add behavior to each life-cycle step, some particular
events are built-in, and the component implementation can listen to them in
order to react to each one. By convention those events use the same name as the
life-cycle step:

- `init`: Emitted while the component is initializing. The config should be set
at this time, but initialization is still running.
- `render`: Emitted while the component is rendering. The DOM will be ready soon.
- `show`: Emitted each time the component is set to the visible state.
- `hide`: Emitted each time the component is set to the hidden state.
- `enable`: Emitted each time the component is set to the enabled state.
- `disable`: Emitted each time the component is set to the disabled state.
- `destroy`: Emitted while the component is disposing its resources. It will be
destroyed soon, and won't be available anymore.

In order to execute code during initialization and rendering:
```javascript
componentFactory()
    .on('init', function() {
        // do some extra initialization tricks  
    })
    .on('render', function() {
        // access the rendered content and apply some change  
    })
    .init(config)
    .render(where);
```

To summarize: the component abstraction already implements the life-cycle
functions, and therefore a component implementation should not redefine them.
The correct way to add behavior is to listen to life-cycle events.

## State handling
The component abstraction comes with a particular mechanism called `state handling`.
This is a set of `states`, which can be seen as boolean flags. The particularity
is tat those flags are synchronized with the rendered HTML and the associated
CSS classes on the component's markup. This is useful to quickly adapt the
displayed content by adding a state and reacting to it by applying CSS rules.

Look for instance at the following instruction:
```javascript
component.setState('foo', true);
```

It will be reflected by:
```html
<div class="component rendered foo">
    ...
</div>
```

And the state can be removed later:
```javascript
component.setState('foo', false);
```

So the HTML is updated accordingly:
```html
<div class="component rendered">
    ...
</div>
```

The downside is obviously that the component has to be rendered to be able to
modify the HTML. If a state is set before the component is rendered, it won't
be reflected as CSS class.

To summarize: the name of the state is also used as a CSS class on the
component's markup, as long as it is already rendered. 

## Template
The component abstraction is relying on the MVC pattern, using 
[Handlebars](https://handlebarsjs.com/) as template engine.
A default template is provided, exposing a very simple HTML markup.
```HTML
<div class="component"></div>
``` 

A dedicated API is available to change the template. However, this has to be
done before the component is rendered, as the template cannot be changed after.

```javascript
component.setTemplate(myTemplate);
```

**Note**: Every UI composition should pass through a template, manually
building HTML breaks the MVC pattern. 

## Component API
The component abstraction exposes a basic API, described here.

### `init(config)`
The component initialization method. Depending on the component implementation,
it should not be called directly from the outside, as it is for internal purposes
only. The component factory should call it while building the instance. The
important thing to know is that this initialization can be deferred, so the
component might not be immediately available. However, this allows to listen to
the `init` event to be able to extend the initialization process.

A config option allows to auto render the component just after the initialization
(config: `renderTo: container`).

> Emits the `init` event, once config initialized, but before any rendering
process.

### `destroy()`
The usual way to dispose a component. Should be called when the component has to
be removed and its resources disposed. 

> Emits the `destroy` event, before actually removing the DOM and freeing the
internal state.

### `render(container)`
Renders the component in the provided container. The component can automatically
call this method, during the instance building process. So depending on the
implementation it should not be called directly.

To render the component, the abstraction is applying the linked template with
the component's config, then it wraps it in a `jQuery` selection and appends
it to the `container`. The `element` property is set with this value.

By default, the content is added to the container. However, there is an option
that allows to replace the container's content (config: `replace: true`).

The `container` parameter can be either a `jQuery` selection, an `HTMLElement`
or a `string` representing a CSS selector. Internally the `container` will be
wrapped as a `jQuery` selection to ease DOM manipulations.

**Note**: this is a life cycle method, and must not be called more than one
time. The *update* of the component has to be managed by the component itself.

> Emits the `render` event.

> Sets the `"rendered"` state.

### `setSize(width, height)`
As the name implies, this sets the component's size. The size is given in
pixels, but the string `auto` is supported too in order to use the
container's size.

If the component is not yet rendered, the size will be kept in memory and will
be used at rendering time.

> Emits the `setsize` event.

### `getSize()`
Get the component's size, as an object containing the properties `width` and
`height`. The values are given in pixels. 

**Note**: the size is only available after the component has been rendered.

### `getOuterSize(includeMargin)`
Get the component rendered size, with or without taking care of the margins.
The result is an object containing the properties `width` and `height`. The
values are given in pixels.

**Note**: the size is only available after the component has been rendered.

### `show()`
Shows the component by removing the `hidden` CSS class.

> Emits the event `show`.

> Clears the state `"hidden"`.

### `hide()`
Hides the component by using the `hidden` CSS class.

> Emits the event `hide`.

> Sets the state `"hidden"`.

### `enable()`
Enables the component by removing the `disabled` CSS class.

> Emits the event `enable`.

> Clears the state `"disabled"`.

### `disable()`
Disables the component by using the `disabled` CSS class.

> Emits the event `disable`.

> Sets the state `"disabled"`.

### `setState(state, flag)`
Sets the component to a particular state. A state is a boolean flag,
represented by a string. If the component is rendered, the state is reflected
as a CSS class, and added to the component's DOM element. When the state is
set to true, the class is added, and when the state is set to false, the class
is removed.

> Emits the `state` event, with the state and its value as parameters.

### `is(state)`
Checks if the component has a particular state.

### `getContainer()`
Gets the underlying DOM element's container. Obviously the method won't return
anything if the component is not rendered.

**Note**: the container is internally wrapped by a `jQuery` selection, so the
returned value is a `jQuery` object.

### `getElement()`
Gets the underlying DOM element. Obviously the method won't return anything if
the component is not rendered.

**Note**: the element is internally wrapped by a `jQuery` selection, so the
returned value is a `jQuery` object.

### `getTemplate()`
Gets the template used to render this component. Usually this is a compiled
[Handlebars](https://handlebarsjs.com/) template.

### `setTemplate(template)`
Sets the template used to render this component. Usually this is a compiled
[Handlebars](https://handlebarsjs.com/) template.

**Note**: this won't change the display, the layout won't change if the 
component is already rendered, so it needs be called before `render()`.

> Emits the `template` event, with the new template as parameter.

### `getConfig()`
Gets the component's configuration.
