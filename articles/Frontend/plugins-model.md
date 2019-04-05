# Plugins model

<!-- 
tags:
    JavaScript Components:
        - "Plugins model"
-->

> A plugin abstraction is part of the TAO core library.
> This article explains how it works.

Sometimes a component needs to be augmented with new features, but not
necessarily as default features for every instance. This can be done using
config entries, but that might quickly turn into a config mess, especially
with complex features.

A good way to augment the ability of components is to rely on plugins. A plugin
is a module that can be dynamically added to a host component, on demand, and
that follows the host's life-cycle. Several plugins can be installed at the same
time, hence several features can be added in parallel.

A plugin must comply to a particular scheme, mostly regarding the life-cycle
methods. Compared to components, plugins get an additional life-cycle step.

![Plugin life-cycle](resources/plugin-life-cycle.png)

- `install`: Allows the plugin to perform some install related actions. This is
an extra step regarding the component's life-cycle. It should be invoked
immediately after creation of the plugin instance, as soon as the plugin is
linked to its host.
- `init`: This step is very important for plugins, as it is the main place where
the plugin's behavior can be initialized. The related method is mandatory, and
must be implemented by every plugin.
- `render`: This is the step where the UI is built, so the plugin can add its
own UI if any.
- `interact`: This is the step where the plugin is spending most of its life.
However, this is not a formal step, as it is not reflected by a life-cycle
method. It can be seen as the *stage* between `render` and `destroy`. At this
stage the UI should be rendered and ready.
- `destroy`: This is the last and final step, the plugin must dispose its
resources at this time. After this step the plugin will be deleted.

The plugin abstraction is represented by a factory function, that accepts a
plugin definition, represented by an object, and a default config that will be
used to prepare the config provided to the plugin instance.

To use the plugin factory you need to import the module `core/plugin`. Usually,
to better use the plugin factory, a wrapper is created, giving a proper alias
to the host object.

```javascript
define(['lodash', 'core/plugin'], function(_, pluginFactory){
    'use strict';

    return function fooPluginFactory(provider, defaultConfig) {
        return pluginFactory(provider, _.defaults({
            //alias getHost to getFoo
            hostName : 'foo'
        }, defaultConfig));
    };
});
```

This factory returns another factory, an instance creator, that will produce
instances of the defined plugin.

```javascript
var pluginCreator = pluginCreatorFactory(pluginDefinition, defaultConfig);
```

To be valid, a plugin definition must provide at least the following entries:
- `name`: a string giving the plugin's name. It should be unique among the
other plugins.
- `init(content)`: the initialization method, that will be called to initialize
the plugin at a proper time.

The default config can also contain a particular entry: `hostName`. This entry
should contain the name of the host, that will be used to alias the `getHost()`
method to `get<HostName>()`.

For instance, given the value `calculator` to the `hostName` config entry, the
alias to `getHost()` will be `getCalculator()`.

The plugin creator factory requires a reference to the host component, an area
broker and eventually some config.

```javascript
var plugin = pluginCreator(host, areaBroker, config);
```

A valid host is an *[eventified object](events-model.md)*, or at least an object
exposing a basic `eventifier`: the methods `on()` and `trigger()` should be
implemented.

The area broker is a particular object giving access to the display layout.

The plugin abstraction relies on a delegation pattern, mapping the exposed API
to the plugin definition object. It also relies on the [`eventifier`](events-model.md)
API the host should implement.

Basically, the way the plugin abstraction is working is as following:

![plugin abstraction](resources/plugin-abstraction.png) 

- the API is exposed as a plain object.
- the calls to the API are delegated to the defined plugin, no matter whether
the method exists or not, the lexical scope is bound to the exposed object.
- the result is turned into a `Promise`.
- a wrapper to the host `trigger` method is implemented, to emit events tagged
with the plugin's name.

Due to that particularity, the following effects must be mentioned:
- Only the functions are linked, other properties are ignored and cannot be
accessed through the exposed API, even if it referenced from the specifications
object. However, properties defined inside the plugin are accessible.
- The implementation of each functions inside the specifications object can be
changed at any time, without having to rebuild the plugin. This allows dynamic
implementation.

Even if the life-cycle of the host is reflected by the plugin, this is not the
only way to interact with the host. The events model brings a better layer for
that purpose. And the life-cycle methods should be seen as a way to properly
bind events listeners.

## Plugins API
Only the functions that are exposed by the API are linked. Any other functions
will be ignored, and won't be accessible. Here is the list of exposed API.

### `install()`
Called when the host is installing the plugins.

> Delegated to the `install()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-install.<pluginName>` event.

### `init(content)`
Called when the host is initializing. Initialize the `states` object, and set
the optional content.

> Delegated to the `init(content)` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-init.<pluginName>` event.

> Sets the `"init"` state.

### `render()`
Called when the host is rendering.

> Delegated to the `render()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-render.<pluginName>` event.

> Emits the `plugin-ready.<pluginName>` event.

> Sets the `"ready"` state.

### `finish()`
Called when the host is finishing.

> Delegated to the `finish()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-finish.<pluginName>` event.

> Sets the `"finish"` state.

### `destroy()`
Called when the host is destroying.

> Delegated to the `destroy()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-destroy.<pluginName>` event.

> Clears all states.

### `trigger(name)`
Triggers the events on the host using the `pluginName` as namespace and prefixed
by `plugin-`. For example `trigger('foo')` will call `trigger('plugin-foo.pluginA')`
on the host.

### `getHost()`
Returns the plugin host.

### `getAreaBroker()`
Returns the host's areaBroker.

### `getConfig()`
Returns the config.

### `setConfig(name, value)`
Sets a config entry.

### `getState(name)`
Checks if the plugin has a particular state.

### `setState(state, flag)`
Sets the plugin to a particular state. A state is a boolean flag, represented by
a string.

### `getContent()`
Returns the plugin's content.

### `setContent(content)`
Sets the plugin's content.

### `getName()`
Returns the plugin's name.

### `show()`
Shows the component related to this plugin.

> Delegated to the `show()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-show.<pluginName>` event

> Sets the `"visible"` state.

### `hide()`
Hides the component related to this plugin.

> Delegated to the `hide()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-hide.<pluginName>` event.

> Clears the `"visible"` state.

### `enable()`
Enables the plugin.

> Delegated to the `enable()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-enable.<pluginName>` event.

> Sets the `"enabled"` state.

### `disable()`
Disables the plugin.

> Delegated to the `disable()` method provided by the plugin definition.

> Always returns a `Promise`.

> Emits the `plugin-disable.<pluginName>` event.

> Clears the `"enabled"` state.

## Plugin manager
For now there is no plugin manager abstraction, and this management must be
performed specifically on each host that accept plugins. However, here is a
snippet for a basic plugin manager:

```javascript
/**
 * @type {Object} the registered plugins
 */
var plugins = {};

/**
 * Creates and install plugins 
 * @param {Object} host
 * @param {Object} areaBroker
 * @param {Function[]} pluginFactories
 * @param {Object} pluginsConfig
 * @returns {Promise} resolved when all plugins are installed
 */
function initPlugins(host, areaBroker, pluginFactories, pluginsConfig) {
    _.forEach(pluginFactories, function (pluginFactory) {
        var plugin = pluginFactory(host, areaBroker);
        var pluginName = plugin.getName();
        if (pluginsConfig[pluginName]) {
            plugin.setConfig(pluginsConfig[pluginName]);
        }
        plugins[plugin.getName()] = plugin;
    });
    
    return runPlugins('install');
}

/**
 * Runs a method over all plugins
 *
 * @param {String} method - the method to run
 * @returns {Promise} resolved when all plugins have performed the action
 */
function runPlugins(method) {
    var execStack = [];

    _.forEach(plugins, function (plugin) {
        if (_.isFunction(plugin[method])) {
            execStack.push(plugin[method]());
        }
    });

    return Promise.all(execStack);
}

/**
 * Gets all the plugins
 * @returns {plugin[]} the plugins
 */
function getPlugins() {
    return _.toArray(plugins);
}

/**
 * Gets a particular plugin
 * @param {String} name - the plugin name
 * @returns {plugin} the plugin
 */
function getPlugin(name) {
    return plugins[name];
}
```
