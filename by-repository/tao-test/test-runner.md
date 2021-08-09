# Test Runner

> This article describes the *new* TAO test driver.

- [Runner](#runner)
    - [Runner Usage](#runner-usage)
    - [Runner Provider](#runner-provider)
    - [Runner API](#runner-api)
    - [Runner Events](#runner-events)
    - [Runner States](#runner-states)
    - [Runner Life Cycle](#runner-life-cycle)
- [Proxy](#proxy)
    - [Create a Proxy Instance](#create-a-proxy-instance)
    - [Proxy Usage](#proxy-usage)
    - [Proxy Middlewares](#proxy-middlewares)
    - [Proxy Provider](#proxy-provider)
    - [Proxy API](#proxy-api)
    - [Proxy Events](#proxy-events)
    - [Proxy Life Cycle](#proxy-life-cycle)
- [Communicator](#communicator)
    - [Create a Communicator Instance](#create-a-communicator-instance)
    - [Communicator Usage](#communicator-usage)
    - [Communicator Provider](#communicator-provider)
    - [Communicator API](#communicator-api)
    - [Communicator Events](#communicator-events)
    - [Communicator States](#communicator-states)
    - [Communicator Life Cycle](#communicator-life-cycle)
- [Area Broker](#area-broker)
    - [Create an Area Broker Instance](#create-an-area-broker-instance)
    - [Area Broker Usage](#area-broker-usage)
    - [Area Broker API](#area-broker-api)
- [Probe Overseer](#probe-overseer)
    - [Create a Probe Overseer Instance](#create-a-probe-overseer-instance)
    - [Probe Overseer Usage](#probe-overseer-usage)
    - [Probe Overseer API](#probe-overseer-api)
- [Plugins](#plugins)
    - [Create a Plugin](#create-a-plugin)
    - [Plugins Usage](#plugins-usage)
    - [Plugins Provider](#plugins-provider)
    - [Plugins API](#plugins-api)
    - [Plugins Life Cycle](#plugins-life-cycle)


## Runner{#runner}

The new Test Runner is built using the *Delegation* design pattern.
This means most of the API is delegated to an external **provider** that provides the implementation.

When an instance of the Test Runner is created it picks up a provider from a registry and binds its API to it.
Different providers can be registered, but only one is bound to a runner and cannot be changed later.
Obviously the providers must be registered before their use, otherwise an exception will be thrown by the runner factory.
Even if the implementation is provided by a provider, the execution context remains on the runner's instance.
Thus all properties created by the provider's methods are bound to the runner's instance.
In corollary the only things a provider can bring are functions: all properties initially presents inside the provider are ignored.

Each implemented provider must bring some mandatory methods. However not all API is mandatory.
Most of the methods are optional, and when the runner does not found a delegated method,
it falls back in a gracious way by ignoring the missing method.

The runner architecture is mainly built around promises and events.
Each API that refers to a life cycle step is asynchronous and relies on a promise to be achieved.
Once the promise is resolved, an event is triggered.
The rejected promises are routed through the error handling that triggers `error` events.

The runner maintains a list of internal states, some of them can also persist in the browser storage.

In order to communicate with the outside (ie. the server), the Test Runner relies on a component that brings communication API.
This component is the **proxy** and must be brought by the provider when the runner requires it.

A bridge with the user interface is represented by a particular component, the **area broker**,
and must be brought by the provider when the runner requires it.

In addition to the standard components, the Test Runner behavior can be extended by plugins,
that can hook the life cycle steps or react to events.


### Runner Usage{#runner-usage}

First you need to require the modules.
```javascript
    define([
        'taoTests/runner/runner',
        'taoTests/runner/proxy',
        'core/communicator'
    ], function (runnerFactory, proxyFactory, communicatorFactory) {
        'use strict';
        ...
    });
```

Before to be able to get an instance of the runner you first need to register the providers.

The registration of runner's providers is mandatory. You cannot use the runner without a provider.
Of course you can register several providers, but only one can be linked to a runner instance.
```javascript
    runnerFactory.registerProvider(name, runnerProvider);
```

If your runner makes use of proxy, you also need to register proxy providers.
```javascript
    proxyFactory.registerProvider(name, proxyProvider);
```

When the communication channel is enabled, communicator providers must be registered as well.
```javascript
    communicatorFactory.registerProvider(name, communicatorProvider);
```

Once all required modules have been properly loaded and registered, you can get an instance of the runner.
```javascript
    var runner = runnerFactory(name, plugins, config);
```

The runner produces events you can listen to.
```javascript
    runner.on('error', onError)
          .on('ready', onReady)
          .after('destroy', tearDown);
```

And then the runner can start its life cycle.
```javascript
    runner.init();
```


### Runner Provider{#runner-provider}

A provider is an object that contains a list of particular methods expected by the runner API.
Some of these methods are mandatory, but most of them are not.

The provider cannot contains properties since only the methods are targeted by the runner.
However, the methods of the provider can create properties that will be bound to the runner instance.

The methods of the provider must reflect the runner API. Here is a list of these methods.

Methods | Mandatory | Promise | Purpose
------- | --------- | ------- | -------
`init()` | [x] | [x] | Initializes the runner.
`render()` | [ ] | [x] | Makes the rendering of the runner in the user interface.
`loadItem(itemRef)` | [ ] | [x] | Responsible of the item loading. The returned promise will be resolved with the item data.
`renderItem(itemRef, itemData)` | [ ] | [x] | Responsible of the item rendering.
`unloadItem(itemRef)` | [ ] | [x] | Responsible of the item removing.
`disableItem(itemRef)` | [ ] | [x] | Responsible of the item disabling.
`enableItem(itemRef)` | [ ] | [x] | Responsible of the item enabling.
`finish()` | [ ] | [x] | Terminates the test.
`flush()` | [ ] | [x] | Flushes the test data before the runner is destroyed.
`destroy()` | [ ] | [x] | Destroys the runner.
`loadAreaBroker()`| [x] | [ ] | Loads or creates the area broker that will give access to the user interface areas.
`loadProxy`| [x] | [ ] | Loads or creates the proxy that will enable communication with the outside.
`loadProbeOverseer`| [ ] | [ ] | Loads or creates the probe overseer that will manage the probes.
`loadPersistentStates`| [ ] | [x] | Loads or creates the persistent storage for the states. This method is called first from the runner `init()`.
`getPersistentState(name)`| [ ] | [ ] | Reads a persistent state. The value must be immediately provided.
`setPersistentState(name, active)`| [ ] | [x] | Writes a persistent state. The operation can be asynchronous.


### Runner API{#runner-api}

The runner provides an API its providers must reflect for a big part. Here is a list:

Methods | Provider | Promise | Plugin | Events | State | Purpose
------- | -------- | ------- | ------ | ------ | ----- | -------
`init()` | [x] | [ ] | `init()`, `install()` | `init` | `init` | Initializes the runner, instantiates the plugins and calls `.render()`.
`render()` | [x] | [ ] | `render` | `render`, `ready` | `ready` | Renders the runner.
`loadItem(itemRef)` | [x] | [ ] | | `loaditem` | item `loaded` | Loads an item then render it by calling `.renderItem()`.
`renderItem(itemRef, itemData)` | [x] | [ ] | | `renderitem` | item `ready` | Renders an item.
`unloadItem(itemRef)` | [x] | [ ] | | `unloaditem` | erase item states | Cleans up and remove an item.
`disableItem(itemRef)` | [x] | [ ] | | `disableitem` | item `disabled` | Disables an item. If the item is already disabled does nothing.
`enableItem(itemRef)` | [x] | [ ] | | `enableitem` | item erase `disabled` | Enables an item. If the item is already enabled does nothing.
`finish()` | [x] | [ ] | `finish()` | `finish` | `finish` | Terminates the test.
`flush()` | [x] | [ ] | `flush()` | `flush` | `flush` | Flushes the test data before the runner is destroyed.
`destroy()` | [x] | [ ] | `destroy()` | `destroy` | `destroy` | Destroys the runner. If a proxy has been involved also destroys it before.
`getPlugins()` | [ ] | [ ] | | | | Gets the list of installed plugins.
`getPlugin(name)` | [ ] | [ ] | | | | Gets a particular installed plugin.
`getConfig()` | [ ] | [ ] | | | | Gets the runner's config.
`getAreaBroker()` | [ ] | [ ] | | | | Gets the area broker. If the area broker is not present, load it through a call to the method `.loadAreaBroker()` the provider must implement.
`getProbeOverseer()` | [ ] | [ ] | | | | Gets the probe overseer. If the probe overseer is not present, load it through a call to the method `.loadProbeOverseer()` the provider must implement. As this method is not mandatory, the prove overseer may never exist.
`getProxy()` | [ ] | [ ] | | | | Gets the proxy. If the proxy is not present, load it through a call to the method `.loadProxy()` the provider must implement. Can throw error if the provider does not implement this method.
`getState(name)` | [ ] | [ ] | | | | Checks an internal state.
`setState(name, active)` | [ ] | [ ] | | | | Sets an internal state. Can throw error if the provided name is empty or is not a string.
`getPersistentState(name)` | [x] | [ ] | | | | Checks a persistent state. The provider must manage the persistent state storage.
`setPersistentState(name, active)` | [x] | [x] | | | | Sets a persistent state. Can throw error if the provided name is empty or is not a string. The provider must manage the persistent state storage. As the storage may be asynchronous, returns a promise.
`getItemState(itemRef, name)` | [ ] | [ ] | | | | Checks an item state. Can throw error if one of the provided name or item ref is empty.
`setItemState(itemRef, name, active)` | [ ] | [ ] | | | | Sets an item state. Can throw error if one of the provided name or item ref is empty.
`getTestData()` | [ ] | [ ] | | | | Gets the test data/definition.
`setTestData(data)` | [ ] | [ ] | | | | Sets the test data/definition.
`getTestContext()` | [ ] | [ ] | | | | Gets the test context/state.
`setTestContext(context)` | [ ] | [ ] | | | | Sets the test context/state.
`getTestMap()` | [ ] | [ ] | | | | Gets the test items map.
`setTestMap(map)` | [ ] | [ ] | | | | Sets the test items map.
`next(scope)` | [ ] | [ ] | | `move` | | Triggers a move forward for a particular scope.
`previous(scope)` | [ ] | [ ] | | `move` | | Triggers a move backward for a particular scope.
`jump(position, scope)` | [ ] | [ ] | | `move` | | Triggers a move to a position for a particular scope.
`skip(scope)` | [ ] | [ ] | | `skip` | | Triggers a skip for a particular scope.
`exit(reason)` | [ ] | [ ] | | `exit` | | Triggers a test exit for a particular reason.
`pause()` | [ ] | [ ] | | `pause` | `pause` | Triggers a test pause. If the test is already in pause state does nothing.
`resume()` | [ ] | [ ] | | `resume` | erase `pause` | Triggers a test pause. If the test is not in pause state does nothing.
`timeout(scope, ref)` | [ ] | [ ] | | `timeout` | | Triggers a timeout for a particular scope.


### Runner Events{#runner-events}

Events take a big place in the runner's life cycle. Here is the list of the standard events.
Each provider implementation can extend this list, so it is not an exhaustive enumeration.
An updated enumeration should be provided aside each provider implementation.

Event | Parameters | Purpose
----- | ---------- | -------
`init` | | Triggered when the `init()` method has been called.
`render` | | Triggered when the `render()` method has been called.
`ready` | | Triggered when the runner is ready to work.
`loaditem` | `itemRef`, `itemData` | Triggered when the `loadItem()` method has been called, so the item is loaded.
`renderitem` | `itemRef`, `itemData` | Triggered when the `renderItem()` method has been called, so the item is rendered.
`unloaditem` | `itemRef` | Triggered when the `unloadItem()` method has been called.
`disableitem` | `itemRef` | Triggered when the `disableItem()` method has been called.
`enableitem` | `itemRef` | Triggered when the `enableItem()` method has been called.
`finish` | | Triggered when the `finish()` method has been called.
`flush` | | Triggered when the `flush()` method has been called.
`destroy` | | Triggered when the `destroy()` method has been called.
`move` | `type` | Notifies a move. The first parameter provides the type of move to do, the rest is contextual to the move type.
`next` | `scope` | Notifies a move forward. The parameter provides the move scope.
`previous` | `scope` | Notifies a move backward. The parameter provides the move scope.
`jump` | `scope`, `position` | Notifies a jump to a particular position. The parameters provide the move scope and the target position.
`skip` | `scope` |  Notifies a skip move. The parameter provides the move scope.
`exit` | `reason` | Notifies a test exit. The parameter provides the reason why.
`pause` | | Notifies a test pause.
`resume` | | Notifies a test resume.
`timeout` | `scope`, `ref` | Notifies a timeout. The parameters provide the scope and the reference of the timed out element.


### Runner States{#runner-states}

The runner maintains some internal states. Here is the list of the standard states.
Each provider implementation can extend this list, so it is not an exhaustive enumeration.
An updated enumeration should be provided aside each provider implementation.

State | Persistent | Purpose
----- | ---------- | -------
`init` | [ ] | Set when the runner is initialized.
`ready` | [ ] | Set when the runner is ready to work.
`finish` | [ ] | Set when the test is terminated.
`flush` | [ ] | Set when the runner has cleaned up its context and is going to be destroyed.
`destroy` | [ ] | Set when the runner has been destroyed.
`pause` | [ ] | Set when the runner is paused.

In addition to the its internal states, the runner also maintains some internal states for the items.
These item states are gathered by item references.

State | Purpose
----- | -------
`loaded` | Set when the item is loaded.
`ready` | Set when the item is ready to work.
`disabled` | Set when the item is disabled.


### Runner Life Cycle{#runner-life-cycle}

The life cycle of the runner is quite complex. In addition, any provider implementation can extend this life cycle through the events.

The basic life cycle is described here. An updated description should be provided aside each provider implementation.

Here is a very simplified life cycle to illustrate the main workflow of the runner:

`init` -> `render` -> `loadItem` -> `renderItem` -> `unloadItem` -> `finish` -> `flush` -> `destroy`

In fact the life cycle of the runner is more complex, as it involves events and states.
A test runner does not carry on only one item, so the life cycle is manager through a loop.

![Runner Life Cycle](/resources/extension-tao-test/wiki/runner-flow.png)

## Proxy{#proxy}

The proxy brings the ability to communicate with the outside. Like the runner it is built using the *Delegation* design pattern.
Thus the remarks made about this design pattern regarding the Test Runner are also valid for the proxy:

- Most of the API is delegated to an external **proxy provider** that provides the implementation.
- When an instance of the proxy is created it picks up a provider from a registry and binds its API to it.
- Different providers can be registered, but only one is bound to a proxy and cannot be changed later.
- Obviously the providers must be registered before their use, otherwise an exception will be thrown by the proxy factory.
- The execution context remains on the proxy's instance, thus all properties created by the provider's methods are bound to this instance.
- A provider can only bring functions.
- If a provider does not provide a particular method, the proxy will ignore it and will fall back in a gracious way.

The purpose of a proxy is to communicate with the outside by requesting an endpoint. Its API provides a predefined list
of such requests. In addition the proxy allows to improve the communication by providing two others mechanisms:
the middlewares and the communication channels.

**Note:** The runner automatically catches the proxy errors. So you can listen to them through the `error` event.


### Create a Proxy Instance{#create-a-proxy-instance}

First you need to require the modules.
```javascript
    define([
        'taoTests/runner/proxy',
        'core/communicator'
    ], function (proxyFactory, communicatorFactory) {
        'use strict';
        ...
    });
```

Before to be able to get an instance of the proxy you first need to register the providers.

The registration of proxy's providers is mandatory. You cannot use the proxy without a provider.
Of course you can register several providers, but only one can be linked to a proxy instance.
```javascript
    proxyFactory.registerProvider(name, proxyProvider);
```

When the communication channel is enabled, communicator providers must be registered as well.
```javascript
    communicatorFactory.registerProvider(name, communicatorProvider);
```

Once all required modules have been properly loaded and registered, you can get an instance of the proxy.
```javascript
    var proxy = proxyFactory(name, config);
```

Example for a runner provider:
```javascript
    var proxyName = 'myProxy';

    proxyFactory.registerProvider(proxyName, proxyProvider);

    function loadProxy(){
        var config = this.getConfig();
        var proxyConfig = _.pick(config, [
            'testDefinition',
            'testCompilation',
            'serviceCallId',
            'bootstrap'
        ]);
        return proxyFactory(proxyName, proxyConfig);
    }
```


### Proxy Usage{#proxy-usage}

From inside the runner you can access to the proxy by the `.getProxy()` method.
If the proxy is not already created, this method will invoke the `.loadProxy()` method the provider must implement.
Once the proxy is created, the `.getProxy()` method will always return the same instance.

The destroy step of the runner will also destroy the proxy.

After you have got the proxy instance through `.getProxy()`, you can access all the proxy API. By example:

```javascript
    this.getProxy().channel('score', function(score) {});
    this.getProxy().channel('feedback', function(feedback) {});
    this.getProxy().init();
```

Almost all proxy methods return promises, so do not forget to catch them.

```javascript
    this.getProxy()
        .init()
        .then(function() {
            console.log('initialized!');
        });
```


### Proxy Middlewares{#proxy-middlewares}

A proxy middleware is a piece of code that acts as a filter and will be executed after each request and before the result is provided to the runner.
Each middleware is able to alter this result. Several middlewares can be registered onto a proxy and will be executed in order.

A middleware is represented by a callback function that will receive three arguments: `request`, `response`, `next`.

The `request` and the `response` arguments both refer to descriptors that encapsulate the actual data.

`request` is an object that contains:

- `command`: the name of the requested command (ie. the proxy API that has been called)
- `params`: the list of parameters sent to the endpoint

**Note:** When the middlewares are applied, the request has already been processed, thus make changes in the request data is useless.

`response` is an object that contains:

- `status`: the string representation of the response status, that can be either `'success'` or `'error'`
- `data`: a reference to the raw data as received from the endpoint.
At the end of the middlewares chain, this field will be produced as the endpoint response to the runner

**Note:** The middlewares are applied before the data are given to the requester, so you can alter the data, and even intercept or trigger errors.

Once a middleware has achieved its process it must give the relay to the next available middleware.
This is done by calling the third argument, which is a callback.
If this callback is not called, the request will never be achieved and the result will never be returned to the runner.

To register a middleware onto a proxy, just call the `.use()` method:

- for a particular command:
```javascript
    proxy.use(command, middleware);
```

- for all commands:
```javascript
    proxy.use(middleware);
```

You can also register several middlewares at once:

- for a particular command:
```javascript
    proxy.use(command, middleware1, middleware2, ...);
```

- for all commands:
```javascript
    proxy.use(middleware1, middleware2, ...);
```


### Proxy Provider{#proxy-provider}

A provider is an object that contains a list of particular methods expected by the proxy API.
Although no method is strictly mandatory, some of them must be present, otherwise the proxy will not work properly.
Depending to the config, some methods can however be mandatory.

The provider cannot contains properties since only the methods are targeted by the proxy.
However, the methods of the provider can create properties that will be bound to the proxy instance.

The methods of the provider must reflect the proxy API and must all return a promise.
Here is a list of these methods, with notices that a method is recommended to be implemented.

Methods | Recommended | Promise | Purpose
------- | ----------- | ------- | -------
`init(config, params)` | [ ] | [x] | Initializes the proxy with the provided config. Some parameters can be added.
`destroy()` | [ ] | [x] | Cleans up and destroys the proxy. If a communicator is involved, it will be destroyed after the proxy.
`loadCommunicator()` | [x] | [x] | Loads or creates the communicator. This method is required if the communicator is enabled. The returned promise must be resolved with the communicator instance.
`getTestData()` | [ ] | [x] | Returns the test definition and config.
`getTestContext()` | [ ] | [x] | Returns the current test context.
`getTestMap()` | [ ] | [x] | Returns the current test map.
`sendVariables(variables)` | [x] | [x] | Sends the test variables to the endpoint.
`callTestAction(action, params)` | [x] | [x] | Calls an action related to the test.
`getItem(uri)` | [x] | [x] | Gets an item definition by its URI, also gets its current state.
`submitItem(uri, state, response, params)` | [x] | [x] | Submits the state and the response of a particular item.
`callItemAction(uri, action, params)` | [x] | [x] | Calls an action related to a particular item.
`telemetry(uri, signal, params)` | [ ] | [x] | Sends a telemetry signal.


### Proxy API{#proxy-api}

The proxy provides a simple API its providers must reflect. Here is a list:

Methods | Provider | Promise | Middleware | Events | Purpose
------- | -------- | ------- | ---------- | ------ | -------
`use(command, middleware)` | [ ] | [ ] | [ ] | | Adds a middleware onto the proxy. If a command name is provided the middleware will only be applied on the requests related to this command, otherwise it will be applied on all requests. Returns the instance.
`init()`| [x] | [x] | [x] | `init` | Initializes the proxy. Forwards the config to the provider. If `addCallActionParams()` has been called before, the parameters will be extended.
`destroy()`| [x] | [x] | [x] | `destroy` | Cleans up and destroys the proxy. If a communicator has been loaded it will be destroyed once the proxy has been cleaned up.
`getTokenHandler()` | [ ] | [ ] | [ ] | | Gets the security token handler, to be used to secure the requests.
`hasCommunicator()` | [ ] | [ ] | [ ] | | Checks if a communicator has been requested.
`getCommunicator()` | [ ] | [x] | [ ] | | Gets access to the communication channel, loads it if not present. Can throw error if the provider does not provide the method `.loadCommunicator()`. Automatically bind some communicator events to the proxy: `error`, `receive`.
`channel(name, listener)` | [ ] | [ ] | [ ] | | Registers a listener on a particular channel. Does nothing if the communicator is disabled. Returns the instance.
`send(channel, message)` | [ ] | [x] | [ ] | | Sends an messages through the communication implementation. Can throw exception if the communicator is disabled or closed. The returned promise will be resolved with the endpoint response.
`addCallActionParams(params)` | [ ] | [ ] | [ ] | | Add extra parameters that will be added to the `init` or the next `callTestAction` or `callItemAction`. This enables plugins to place parameters for next calls. Returns the instance.
`getTestData()`| [x] | [x] | [x] | `getTestData` | Gets the test definition data. The test definition data will be provided by the resolved promise.
`getTestContext()`| [x] | [x] | [x] | `getTestContext` | Gets the test context. The context object will be provided by the resolved promise.
`getTestMap()`| [x] | [x] | [x] | `getTestMap` | Gets the test map. The map object will be provided by the resolved promise.
`sendVariables(variables)`| [x] | [x] | [x] | `sendVariables` | Sends the test variables.
`callTestAction(action, params)`| [x] | [x] | [x] | `callTestAction` | Calls an action related to the test. If `addCallActionParams()` has been called before, the parameters will be extended.
`getItem(uri)`| [x] | [x] | [x] | `getItem` | Gets an item definition by its URI, also gets its current state. The item data will be provided by the resolved promise.
`submitItem(uri, state, response, params)`| [x] | [x] | [x] | `submitItem` | Submits the state and the response of a particular item.
`callItemAction(uri, action, params)`| [x] | [x] | [x] | `callItemAction` | Calls an action related to a particular item. If `addCallActionParams()` has been called before, the parameters will be extended.
`telemetry(uri, action, params)`| [x] | [x] | [x] | `telemetry` | Sends a telemetry signal.


### Proxy Events{#proxy-events}

The proxy triggers events, and some of them are forwarded to the runner. Here is a list:

Event | Forwarded | Parameters | Purpose
----- | --------- | ---------- | -------
`error` | [x] | `error` | Triggered when any error occurs. The error details is provider as parameter.
`receive` | [ ] | `data` | Triggered each time the endpoint sends data through the communication channel. The provided parameter contains the raw received data.
`init` | [ ] | `promise` | Triggered when the `init()` method has been called. The result is provided as parameter.
`destroy` | [ ] | `promise` | Triggered when the `destroy()` method has been called. The result is provided as parameter.
`getTestData` | [ ] | `promise` | Triggered when the `getTestData()` method has been called. The result is provided as parameter.
`getTestContext` | [ ] | `promise` | Triggered when the `getTestContext()` method has been called. The result is provided as parameter.
`getTestMap` | [ ] | `promise` | Triggered when the `getTestMap()` method has been called. The result is provided as parameter.
`sendVariables` | [ ] | `promise`, `variables` | Triggered when the `sendVariables()` method has been called. The result is provided as parameter, then the rest of the parameters.
`callTestAction` | [ ] | `promise`, `action`, `params` | Triggered when the `callTestAction()` method has been called. The result is provided as parameter, then the rest of the parameters.
`getItem` | [ ] | `promise`, `uri` | Triggered when the `getItem()` method has been called. The result is provided as parameter, then the rest of the parameters.
`submitItem` | [ ] | `promise`, `uri`, `state`, `response`, `params` | Triggered when the `submitItem()` method has been called. The result is provided as parameter, then the rest of the parameters.
`callItemAction` | [ ] | `promise`, `uri`, `action`, `params` | Triggered when the `callItemAction()` method has been called. The result is provided as parameter, then the rest of the parameters.
`telemetry` | [ ] | `promise`, `uri`, `signal`, `params` | Triggered when the `telemetry()` method has been called. The result is provided as parameter, then the rest of the parameters.


### Proxy Life Cycle{#proxy-life-cycle}

The life cycle of the proxy is pretty simple.

init -> messages loop -> destroy

**Note:** Except for the communicator, the messages loop pass through the middlewares.


## Communicator{#communicator}

The proxy offers a bidirectional communication channel through an abstraction, called communicator,
that also relies on the *Delegation* design pattern.
Thus the remarks made about this design pattern regarding the Test Runner and the proxy are also valid for the communicator:

- Most of the API is delegated to an external **communicator provider** that provides the implementation.
- When an instance of the communicator is created it picks up a provider from a registry and binds its API to it.
- Different providers can be registered, but only one is bound to a communicator and cannot be changed later.
- Obviously the providers must be registered before their use, otherwise an exception will be thrown by the communicator factory.
- The execution context remains on the communicator's instance, thus all properties created by the provider's methods are bound to this instance.
- A provider can only bring functions.
- If a provider does not provide a particular method, the communicator will ignore it and will fall back in a gracious way.

The purpose of the communicator is to provide a continuous bidirectional communication with an endpoint.
To do so it brings two abilities: listen to a particular channel and send a message through a particular channel.

A communicator opens a communication with an endpoint, and unless this communication is closed, it will be able to be
notified of new messages from the endpoint at any time and can also send a message to the endpoint.

To receive messages from the endpoint through the communicator you just need to register a listener onto a particular channel.
Each time the endpoint pushes a message on this channel, your listener will be notified.
A listener is a callback function that accept only one argument: the received message.

**Notes:**

- There is no way to listen all channels at a glance, you always need to target a particular channel.
- The communicator needs to be enabled in the config.
If the communicator is disabled or fails in any way, errors will be thrown when trying to use it.
However the registration of channels will never fail.
- The communicator cannot be affected by the middlewares.


### Create a Communicator Instance{#create-a-communicator-instance}

First you need to require the module.
```javascript
    define([
        'core/communicator'
    ], function (communicatorFactory) {
        'use strict';
        ...
    });
```

Before to be able to get an instance of the communicator you first need to register the providers.

The registration of communicator's providers is mandatory. You cannot use the communicator without a provider.
Of course you can register several providers, but only one can be linked to a communicator instance.
```javascript
    communicatorFactory.registerProvider(name, communicatorProvider);
```

**Note:** For now there is only one existing provider, that polls the endpoint every period of time: `core/communicator/poll`.

Once all required modules have been properly loaded and registered, you can get an instance of the communicator.
```javascript
    var communicator = communicatorFactory(name, config);
```

Example for a proxy provider:
```javascript
    var communicatorName = 'myCommunicator';

    communicatorFactory.registerProvider(communicatorName, communicatorProvider);

    function loadCommunicator() {
        var config = this.config.communicator;
        return communicatorFactory(communicatorName, config);
    }
```


### Communicator Usage{#communicator-usage}

It is not needed to deal directly with the communicator as the proxy provides API to utilize seamlessly the communicator abilities.

- To register a listener, just call the `.channel()` method of the proxy.
```javascript
    proxy.channel(name, listener);
```

- To send a message to the endpoint you must precise on which channel communicate and provide the message to send.
This is achieved by calling the `.send()` method of the proxy.
This method returns a promise that will be resolved with the response data once the endpoint has responded.
The promise can be rejected if error occurs.
```javascript
    proxy.send(name, message).then(function(response) {...});
```

As the `.channel()` and the `.send()` method cover 99% of the needs, it is not recommended to directly address the communicator.
However for special cases, the proxy implements a `.getCommunicator()` method. This method is called internally to access the communicator.
If the communicator is not already created, this method will invoke the `.loadCommunicator()` method the provider must implement.
Once the communicator is created, the `.getCommunicator()` method will always return the same instance.

The `.getCommunicator()` does not return immediately the communicator, as some asynchronous steps may be involved.
So it returns a promise instead, that will be resolved with the communicator instance. Any errors will cause a promise reject.

When the proxy is destroyed, it also destroys the communicator, so do not bother with this.

```javascript
    proxy.getCommunicator().then(function(communicator) {
        ...
    });
```


### Communicator Provider{#communicator-provider}

A provider is an object that contains a list of particular methods expected by the communicator API.
Although no method is mandatory, some of them must be present, otherwise the communicator will not work properly.

The provider cannot contains properties since only the methods are targeted by the communicator.
However, the methods of the provider can create properties that will be bound to the communicator instance.

The methods of the provider must reflect the communicator API.
Here is a list of these methods, with notices that a method is recommended to be implemented.

Methods | Recommended | Promise | Purpose
------- | ----------- | ------- | -------
`init()`| [ ] | [x] | Initializes the communicator.
`destroy()`| [ ] | [x] | Cleans up and destroys the communicator.
`open()`| [x] | [x] | Opens the connection with the communicator endpoint.
`close()`| [x] | [x] | Closes the connection with the communicator endpoint.
`send(channel, message)`| [x] | [x] | Send a message to the endpoint through a particular channel. Can only be called if the connection is open.

**Note:** For now there is only one existing provider, that polls the endpoint every period of time: `core/communicator/poll`.


### Communicator API{#communicator-api}

The communicator provides a simple API its providers must reflect. Here is a list:

Methods | Provider | Promise | Events | State | Purpose
------- | -------- | ------- | ------ | ----- | -------
`init()`| [x] | [x] | `init`, `ready` | `ready` | Initializes the communicator. If the communicator is already initialized just return the promise.
`destroy()`| [x] | [x] | `destroy`, `destroyed` | erase all | Cleans up and destroys the communicator. Auto closes the connection if needed.
`open()`| [x] | [x] | `open`, `opened` | `open` | Opens the connection with the communicator endpoint. If the connection is already open, just return the promise.
`close()`| [x] | [x] | `close`, `closed` | erase `open` | Closes the connection with the communicator endpoint.
`send(channel, message)`| [x] | [x] | `send`, `sent` | | Send a message to the endpoint through a particular channel. If the connection is not open, throws error. Returns a promise with the endpoint response.
`channel(name, listener)`| [ ] | [ ] | | | Registers a listener on a particular channel. Throws errors if the name or the listener are missing or wrong. Returns the instance.
`getConfig()`| [ ] | [ ] | | | Returns the communicator's config set.
`setState(name, active)`| [ ] | [ ] | | | Sets a state.
`getState(name)`| [ ] | [ ] | | | Gets a state.


### Communicator Events{#communicator-events}

The communicator triggers events, and some of them are forwarded to the proxy. Here is a list:

Event | Forwarded | Parameters | Purpose
----- | --------- | ---------- | -------
`error` | [x] | `error` | Triggered when any error occurs. The error details is provider as parameter.
`init` | [ ] | `promise` | Triggered when the `init()` method has been called. The result is provided as parameter.
`ready` | [ ] | | Triggered when the communicator has been successfully initialized and is ready to work.
`destroy` | [ ] | `promise` | Triggered when the `destroy()` method has been called. The result is provided as parameter.
`destroyed` | [ ] | | Triggered when the communicator has been successfully destroyed.
`open` | [ ] | `promise` | Triggered when the `open()` method has been called. The result is provided as parameter.
`opened` | [ ] | | Triggered when the communication has been successfully opened.
`close` | [ ] | `promise` | Triggered when the `close()` method has been called. The result is provided as parameter.
`closed` | [ ] | | Triggered when the communication has been successfully closed.
`send` | [ ] | `promise`, `channel`, `message` | Triggered when the `send()` method has been called. The result is provided as parameter.
`sent` | [ ] | `channel`, `message`, `response` | Triggered when a message has been successfully sent.
`message` | [ ] | `channel`, `message` | Triggered when a message is received from the endpoint.
`channel-<name>` | [ ] | `message` | Triggered when a message is received from the endpoint on the channel `<name>`.
`receive` | [x] | `data` | Triggered each time the endpoint sends data. The provided parameter contains the raw received data.


### Communicator States{#communicator-states}

The communicator maintains some internal states. Here is a list:

State | Purpose
----- | -------
`ready` | Set when the communicator is ready to work. However the communication may not be open.
`open` | Set when the communicator has opened the communication with its endpoint. This state is erased when the communication is closed.


### Communicator Life Cycle{#communicator-life-cycle}

The life cycle of the communicator is pretty simple.

`init` -> `open` -> `messages loop` -> `close` -> `destroy`


## Area Broker{#area-broker}

The runner does not have a direct access to the user interface. It needs a particular component that provides entry points.
This component is the **Area Broker**.

The Area Broker acts as a hub that gives access to named areas:

Area | Description
---- | -----------
`content` | Where the content is rendered, by example an item
`toolbox` | The place to add arbitrary tools, like a zoom, a comment box, etc.
`navigation` | The navigation controls like next, previous, skip
`control` | The control center of the test, progress, timers, etc.
`header` | The area that could contains the test titles
`panel` | A panel to add more advanced GUI (item review, navigation pane, etc.)

The provider bound to the runner must provide a `.loadAreaBroker()` methods that returns a configured Area Broker.


### Create an Area Broker Instance{#create-an-area-broker-instance}

First you need to require the module.
```javascript
    define([
        'taoTests/runner/areaBroker'
    ], function (areaBrokerFactory) {
        'use strict';
        ...
    });
```

Then you can create an instance of the Area Broker and provides the links to the actual user interface.
```javascript
    var areaBroker = areaBrokerFactory($container, areas);
```

Example for a runner provider:
```javascript
   function loadAreaBroker(){
       var $layout = $(layoutTpl());
       return areaBrokerFactory($layout, {
           content:    $('.runner-content', $layout),
           toolbox:    $('.runner-toolbox', $layout),
           navigation: $('.runner-navigation', $layout),
           control:    $('.runner-control', $layout),
           panel:      $('.runner-panel', $layout),
           header:     $('.runner-header', $layout),
       });
   }
```


### Area Broker Usage{#area-broker-usage}

From inside the runner you can access to the area broker by the `.getAreaBroker()` method.
If the area broker is not already created, this method will invoke the `.loadAreaBroker()` method the provider must implement.
Once the area broker is created, the `.getAreaBroker()` method will always return the same instance.

After you have got the area broker instance through `.getAreaBroker()`, you can request for user interface area. By example:

```javascript
    this.getAreaBroker().getContentArea();
    this.getAreaBroker().getControlArea();
    this.getAreaBroker().getArea('panel');
```

Once you have got an access to a user interface area, what you can do with it depends on the implementation you are using.
Example with jQuery as a layer to manage the user interface:

```javascript
    var $content = this.getAreaBroker().getContentArea();
    $content.append('<div>Hello!</div>');
```


### Area Broker API{#area-broker-api}

The area broker provides a simple API. Here is a list:

Methods | Purpose
------- | -------
`defineAreas(mapping)` | Maps the areas to elements. This method needs to be called before getting areas, and the factory does it automatically.
`getContainer()` | Gets the main container.
`getArea()` | Gets a particular area.
`get<Name>Area()` | The factory creates an alias for each known area.


## Probe Overseer{#probe-overseer}

Optionally the runner can be audited in order to produce stats. To do so a particular component must be injected: the **Probe Overseer**.

The probe overseer provides a way to register probes that reacts to particular events.
There are two kinds of probes:

- probes that capture info when they are activated by an event
- probes that compute time spent from their activation to their deactivation and capture info at this time


### Create a Probe Overseer Instance{#create-a-probe-overseer-instance}

First you need to require the module.
```javascript
    define([
        'taoTests/runner/probeOverseer'
    ], function (probeOverseerFactory) {
        'use strict';
        ...
    });
```

Then you can create an instance of the Probe Overseer and provide a reference to the runner in order to enable the audit.
```javascript
    var probeOverseer = probeOverseerFactory(identifier, runner);
```

Example for a runner provider:
```javascript
    function loadProbeOverseer(){
        var config = this.getConfig();
        var identifier = config.serviceCallId || 'test-' + Date.now();
        return probeOverseerFactory(identifier, this);
    }
```


### Probe Overseer Usage{#probe-overseer-usage}

From inside the runner you can access to the probe overseer by the `.getProbeOverseer()` method.
If the probe overseer is not already created, this method will invoke the `.loadProbeOverseer()` method the provider must implement.
Once the probe overseer is created, the `.getProbeOverseer()` method will always return the same instance.

After you have got the probe overseer instance through `.getProbeOverseer()`, you can manage the probes.

To register a new probe you must call the `.add()` method. This method needs a single parameter, an object that describes the probe:

- *String* `name` - the probe name
- *Boolean* `latency` - simple (`false`) or latency (`true`) mode (default: `false`)
- *String[]* `events` - the list of events to listen (simple mode)
- *String[]* `startEvents` - the list of events to mark the start (latency mode)
- *String[]* `stopEvents` - the list of events to mark the end (latency mode)
- *Function* `capture` - a callback to define the data context, it receive the test runner and the event parameters: `function(runner, eventName)`

By example:

```javascript
    function capture(testRunner, eventName){
        var data = testRunner.getTestData();
        var context = testRunner.getTestContext();
        return {
            testId : data.identifier,
            itemId : context.itemIdentifier
        };
    }

    // add a probe that captures info when it will be activated by an event
    this.getProbeOverseer().add({
        name    : 'log-move',
        events  : 'move',
        capture : capture
    });

    // add a probe that computes time spent from its activation to is deactivation and captures info at this time
    this.getProbeOverseer().add({
        name        : 'log-attempt',
        startEvents : 'renderitem',
        stopEvents  : ['move', 'skip', 'timeout'],
        capture     : capture
    });
```

The probe overseer does not start automatically, so once you created it you need to explicitly start it:

```javascript
    if(this.getProbeOverseer()){
        this.getProbeOverseer().start();
    }
```

To get the data gathered by the probes you can call the `.flush()` method. When this method is called, all the data
gathered by the probes are sent through a promise and removed from the memory.

```javascript
    probeOverseer.flush().then(function(data){
        ...
    });
```

Do not forget to stop the probe overseer in order to clean the storage:

```javascript
    if(this.getProbeOverseer()){
        this.getProbeOverseer().stop();
    }
```

**Note:** As the probe overseer in an optional module, the runner only takes care of the instance creation.
You have to manage the life cycle of the probe overseer in the runner provider.


### Probe Overseer API{#probe-overseer-api}

The area broker provides an API to register probes and manage them. Here is a list:

Methods | Purpose
------- | -------
`add(probe)` | Adds a probe
`getQueue()` | Gets the time entries queue
`getProbes()` | Gets the list of defined probes
`push(entry)` | Pushes an time entry to the queue
`flush()` | Flushes the queue and get the entries
`start()` | Starts the probes
`stop()` | Stops the probes, then clears the store and the queue


## Plugins{#plugins}

Plugins also use the *Delegation* design pattern.
However they don't need to address several implementations through registered providers, and the plugin factory just
binds its API to a single implementation.

- The plugin factory binds a provider with its API, then returns a constructor that will build instances of the plugin.
- Most of the API is delegated to the provider.
- The provider is bound to the plugin API when you generate the constructor, so it cannot be changed later.
- The execution context remains on the plugin's instance, thus all properties created by the provider's methods are bound to this instance.
- A provider can only bring functions. However it must also bring its name as a property.
- If a provider does not provide a particular method, the plugin will ignore it and will fall back in a gracious way.

The plugin factory implements a comprehensive life cycle that can suit most of the use cases.
It also implements a layer for host binding and an API to forward events to the host.

**Note:** The host must implement an eventifier, otherwise an error will be thrown when you will try to bound a plugin to this host.


### Create a Plugin{#create-a-plugin}

First you need to require the module.
```javascript
    define([
        'core/plugin'
    ], function (pluginFactory) {
        'use strict';
        ...
    });
```

Then you can create a plugin constructor from your implementation.
```javascript
    var plugin = pluginFactory(implementation, defaultConfig);
```

When you create a plugin instance, you must provide the host to which the plugin will be bound.
You can also provide an area broker to allow access to the user interface, and a config set.

```javascript
    var instance = plugin(host, areaBroker, config);
```


### Plugins Usage{#plugins-usage}

After you have got a plugin instance you can access all the plugin API. By example:

```javascript
    plugin.install();
    plugin.init();
```

Almost all plugin methods return promises, so do not forget to catch them.

```javascript
    plugin
        .install()
        .then(function() {
            console.log('installed!');
        });
```


### Plugins Provider{#plugins-provider}

A provider is an object that contains a list of particular methods expected by the plugin API.
There is no mandatory method, however it is recommended to implement either `install()` or `init()`.

Except for its name, the plugin provider cannot contains properties since only the methods are targeted.
However, the methods of the provider can create properties that will be bound to the plugin instance.

The methods of the provider must reflect the plugin API. All responses will be translated to promise.
Here is a list of these methods, with notices that a method is recommended to be implemented.

Methods | Recommended | Promise | Purpose
------- | ----------- | ------- | -------
`install()` | [x] | [x] | Installs the plugin.
`init(content)` | [x] | [x] | Initializes the plugin with the provided content.
`render()` | [ ] | [x] | Ensures the rendering of the plugin.
`finish()` | [ ] | [x] | Reacts to the 'finish' step of the host.
`destroy()` | [ ] | [x] | Cleans up and destroys the plugin.
`show()` | [ ] | [x] | Shows the underlying component.
`hide()` | [ ] | [x] | Hides the underlying component.
`enable()` | [ ] | [x] | Enables the plugin.
`disable()` | [ ] | [x] | Disables the plugin.


### Plugins API{#plugins-api}

Plugins must suit to their host life cycle, so a big part of the plugin API is dedicated to this.
The rest is provided to manage the plugin itself.

Methods | Provider | Promise | Events | State | Purpose
------- | -------- | ------- | ------ | ----- | -------
`install()` | [x] | [x] | `install` | | Called when the host is installing the plugins.
`init(content)` | [x] | [x] | `init` | `init` | Called when the host is initializing. Some content can be provided at this step.
`render()` | [x] | [x] | `render`, `ready` | `ready` | Called when the host is rendering.
`finish()` | [x] | [x] | `finish` | `finish` | Called when the host is finishing.
`destroy()` | [x] | [x] | `destroy` | erase all | Called when the host is destroying. Erases states and config.
`trigger(name)` | [ ] | [ ] | | | Triggers the events on the host using the `pluginName` as namespace and prefixed by `plugin-`. Example: `trigger('foo')` will `trigger('plugin-foo.pluginA')` on the host.
`getHost()` | [ ] | [ ] | | | Gets the plugin host.
`getAreaBroker()` | [ ] | [ ] | | | Gets the bound `areaBroker`.
`getConfig()` | [ ] | [ ] | | | Gets current config set.
`setConfig(name, value)` | [ ] | [ ] | | | Sets a config value, or the whole config set.
`getState(state)` | [ ] | [ ] | | | Gets a state of the plugin.
`setState(state, active)` | [ ] | [ ] | | | Sets a state of the plugin. Can throw error if the name is empty or is not a string.
`getContent()` | [ ] | [ ] | | | Gets the plugin content.
`setContent(content)` | [ ] | [ ] | | | Sets the plugin content.
`getName()` | [ ] | [ ] | | | Gets the plugin's name.
`show()` | [x] | [x] | `show` | `visible` | Shows the component related to this plugin.
`hide()` | [x] | [x] | `hide` | erase `visible` | Hides the component related to this plugin.
`enable()` | [x] | [x] | `enable` | `enabled` | Enables the plugin.
`disable()` | [x] | [x] | `disable` | erase `enabled` | Disables the plugin.


### Plugins Life Cycle{#plugins-life-cycle}

The life cycle of a plugin depends of its host. However, regarding its API, a common life cycle can be described.

`install` -> `init` -> `render` -> `processing` -> `finish` -> `destroy`