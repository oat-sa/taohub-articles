# Test Runner

- [Runner](#runner)
- [Runner Provider](#provider)
- [Runner Events](#events)
- [Runner Life Cycle](#life-cycle)
- [Runner Proxy](#proxy)
    - [Security](#security)
        - [Token](#token)
        - [TimeLine](#timeline)
- [Runner Controller](#controller)
- [Runner Layout](#layout)
- [Runner Helpers](#helpers)
    - [Map Helper](#map)
    - [Messages Helper](#messages)
- [Runner Plugins](#plugins)
- [Runner Configuration](#options)


## Runner{#runner}

There is currently two versions of the QTI Test Runner.

The first version, let call it the Old Test Runner, is based on iframes and use a monolithic architecture, which is not easy to extend.

The new version, let call it the New Test Runner, is based on a modular approach.
It is built using the test engine provided by the [taoTests extension](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner).
This engine is based on the *Delegation* design pattern and provide a way to extend the features by using plugins.

Both versions are configurable through the same set of options. [A chapter is dedicated to this aspect](Test-Runner-Config).

The following documentation is only related to the new version of the Test Runner.

To get more info on the runner implementation, please refer to the [taoTests extension](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner#runner).


## Provider{#provider}

The Test Runner engine is based on the *Delegation* design pattern.
This means the engine delegates most of its API to an external **provider** that brings the implementation.

The runner architecture is mainly built around [promises](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise) and events.
Each API that refers to a life cycle step is asynchronous and relies on a promise to be achieved.
Once the promise is resolved, an event is triggered.
The rejected promises are routed through the error handling that triggers `error` events.

The runner maintains a list of internal states, some of them can also persist in the browser storage.

To communicate with the server, the provider instantiates a particular component: the [proxy](#proxy).
This component brings a communication API, and this must be the only way to communicate with the outside.

The provider also has in charge to build and inject the UI layout, and this is done by a [particular component](#layout).

In addition to the standard components, the Test Runner behavior can be extended by [plugins](#plugins),
that can hook the life cycle steps or react to events.

To get more info on the provider implementation, please refer to the [taoTests extension](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner#runner-provider).


## Events{#events}

Events take a big place in the runner's life cycle. Here is the list of the events handled by the new Test Runner.

Event | Parameters | Purpose
----- | ---------- | -------
`init` | | The runner is initializing
`render` | | The runner has been rendered
`ready` | |  The runner is ready to work
`loadrubricblock` | | Some rubric blocks have been loaded
`loaditem` | `itemRef` | An item has been loaded
`renderitem` | | The item will be rendered
`disableitem` | | The current item has been disabled
`disablenav` | | The navigation is disabled
`disabletools` | | The tools are disabled
`unloaditem` | | The current item has been unloaded
`resumeitem` | | The current item is resumed, for instance after the server has rejected the submit
`enableitem` | | The item is enabled
`enablenav` | | The navigation is enabled
`enabletools` | | The tools are enabled
`disconnect` | | The runner is disconnected
`reconnect` | | The runner is reconnected
`alert` | `message`, `callback` | An alert dialog will be displayed with the provided message, and the callback will be called once the message has been acknowledged
`confirm`  | `message`, `callbackOk`, `callbackCancel` | A confirm dialog will displayed with the provided message, and the corresponding callback will be called once the message has been validated or rejected
`closedialog` | `accept` | Close all the opened dialogs with the provided response (default: false)
`modalFeedbacks` | `queue`, `callback` | Request the display of a modal feedback. The callback will be called once all the feedbacks have been acknowledged.
`move` | `direction`, `scope`, `position` | A move has been requested
`next` | `scope` | Notifies a move forward. The parameter provides the move scope.
`previous` | `scope` | Notifies a move backward. The parameter provides the move scope.
`jump` | `scope`, `position` | Notifies a jump to a particular position. The parameters provide the move scope and the target position.
`skip` | `scope` | A move skip has been requested
`flag` | `position`, `flagged` | Flags the item at the given position
`timeout` | `scope`, `ref` | A timeout occurred
`exit` | `why` | The test will be exited with the provided reason
`endsession` | | The current session is ended
`pause` | | The test has been paused
`resume` | | The test has been resumes
`leave` | | The test session will be ended
`finish` | | The test is finished, and will be flushed
`flush` | | The test has been flushed and the component will be destroyed
`storechange` | | The local storage must be changed
`destroy` | | The runned is destroying
`error` | `err` | An error occurred, a message will be displayed
`danger` | `message` | A danger message will be displayed
`warning` | `message` | A warning message will be displayed
`info` | `message` | An info message will be displayed

## Life Cycle{#life-cycle}

The life cycle of the runner is quite complex.
Here is a very simplified life cycle to illustrate the main workflow of the runner:

`init` -> `render` -> `loadItem` -> `renderItem` -> `unloadItem` -> `finish` -> `flush` -> `destroy`

In fact the life cycle of the runner is more complex, as it involves events and states.
A test runner does not carry on only one item, so the life cycle is manager through a loop.

![Runner Life Cycle](/resources/extension-tao-testqti/wiki/runner-flow.png)

To get more info on the standard life cycle of the runner, please refer to the [taoTests extension](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner#runner-life-cycle).

## Proxy{#proxy}

The proxy brings the ability to communicate with the outside.
Like the runner it is built using the *Delegation* design pattern.

To get more info on this component, please refer to the [taoTests extension](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner#proxy).

Each time a component needs to interact with the server it must use the proxy.
For instance to request a test action:

```javascript
    runner.getProxy().callTestAction(...);
```

All the proxy API are linked to backend actions:

Methods | Controller | Action | Purpose
------- | ---------- | ------ | -------
`init(config, params)` | `runner` | `init` | Initializes the proxy with the provided config. Some parameters can be added.
`getTestData()` | `runner` | `getTestData` | Returns the test definition and config.
`getTestContext()` | `runner` | `getTestContext` | Returns the current test context.
`getTestMap()` | `runner` | `getTestMap` | Returns the current test map.
`sendVariables(variables)` | `runner` | `storeTraceData` | Sends the test variables to the endpoint.
`getItem(uri)` | `runner` | `getItem` | Gets an item definition by its URI, also gets its current state.
`submitItem(uri, state, response, params)` | `runner` | `submitItem` | Submits the state and the response of a particular item.
`callTestAction(action, params)` | `runner` | `*` | Calls an action related to the test.
`callItemAction(uri, action, params)` | `runner` | `*` | Calls an action related to a particular item.
`telemetry(uri, signal, params)` | `runner` | `*` | Sends a telemetry signal.

To setup the proxy, the provider relies on a config object that will translate and maintain the runner config set.
This is the purpose of the `qtiServiceConfig` component.

### Security{#security}

Some mechanisms are provided to enforce the securgity of the test. A security token is provided to validate the actions, and the time duration of the test is stored using a time line.

#### Token{#token}

Most of the interactions with the server will require a security token.
This security token is unique and is generated with each action.

Each time the client request the server it must provide this token. If it is valid, the server allows the action to be performed, otherwise an error is triggered.
Once the action is done, the server generates and sens a new token to the client. The latest will have to provide the new token on the next request, and so on.

Not all actions require a security token, but the majority does.

#### TimeLine{#timeline}

The time line is a a way to compute the time elapsed during the test both on the server and the client sides, and is intended to synchronize the two.

Client side, the time spent by the test taker to take the test is computed between requests:
- it starts when the item is received and displayed
- it ends when the item responses are submitted

So the time spent to query the server is not added to the elapsed time.

Server side, the time is captured and updated as this:
- it starts when the item data are sent back to the client
- it ends when the item responses are received

As you can see, a delay can be found between the client side and the server side. This is especially true if the client time is not perfectly synchronised with the server.
For this reason, the client and the server time lines are separated. However, the client time line must be circumscribed by the server time line.

A time line is a suite of time point pairs: [start, end]. To be able to compute the elapsed time, we need a list of valid pairs.
If a pair is incomplete the result cannot be computed. The same if the pair is bad built (like 2 starts for 1 end, or vice-versa).
This is why the time points are set as often as possible.

## Controller{#controller}

A particular controller is dedicated to the Test Runner life cycle: `taoQtiTest_actions_Runner`

A dedicated service is implemented to manage the Test Runner. The controller only provides a link to this service.
To maintain the persistence, a service context must be provided each time a service API is called.

Each action of the controller returns a JSON content, which is always formatted like this:

```
    // success:
    {
        "success": true,
        "token": "<the new security token>"
        ...
    }

    // error
    {
        "success": false,
        "type": "error"|"exception"|"TestState"|"FileNotFound",
        "message: "<some message>",
        "token": "<the new security token if the error is not related to the security (403)>"
        "code": 403|404|500
    }
```

Beside the action related parameters, each time the client request the server it must provide this set of parameters:

- `serviceCallId` or `testServiceCallId`: The identifier of the text execution
- `testDefinition`: The identifier of the test itself
- `testCompilation`: The identifier of the test delivery

Mots of the actions are secured, and a security token must also be provided through the HTTP header `X-Auth-Token`.


The exposed TestRunner actions are:

- **`init`**
    - *Parameters*:
        - `clientState`: An optional state the client want the server to be aware
        - `storeId`: An optional identifier for the local storage

    - *Security Token*: not needed

    - *Description*: Initializes the delivery session. If the client claimed it was paused, the server will set the state to pause and close the test session.
    The test taker will then need to resume the test. The client store identifier is also persisted server side, in order to trace the change of computer.
    This action is called as well as for a new test session or to resume an existing session. So this the fist action called by the client.
    The timer and the security token are also reset.

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testData`: The definition data of the test, this also cover the config and options.
        - `testContext` The context data of the current item.
        - `testMap`: The full map of the test.
        - `lastStoreId`: The identifier of the local storage the client should use.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`getTestData`**
    - *Parameters*: none

    - *Security Token*: required

    - *Description*: Provides the test definition data

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testData`: The definition data of the test, this also cover the config and options.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`getTestContext`**
    - *Parameters*: none

    - *Security Token*: required

    - *Description*: Provides the test context object

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testContext` The context data of the current item.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`getTestMap`**
    - *Parameters*: none

    - *Security Token*: required

    - *Description*: Provides the full map of the test items

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testMap`: The full map of the test.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`getItem`**
    - *Parameters*:
        - `itemDefinition`: The identifier of the item

    - *Security Token*: required

    - *Description*: Provides the definition data and the state for a particular item. Starts the timer.

    - *Response*: The action sends back to the client a JSON object that contains:
        - `itemData`: The definition data of the item
        - `itemState`: The item state
        - `baseUrl`: The base url of the item, needed to resolve the assets
        - `rubrics`: The optional rubric blocks that comes with the item

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`submitItem`**
    - *Parameters*:
        - `itemDefinition`: The identifier of the item
        - `itemDuration`: The time elapsed on the item at the client side
        - payload: The item responses and its state are provided through the request payload using a JSON format:
            - `itemState`: The new item state
            - `itemResponse`: The item responses
            - `emptyAllowed`: A flag that tells if empty responses are allowed

    - *Security Token*: required

    - *Description*: Stores the state object and the response set of a particular item. End the timer.

    - *Response*: The action sends back to the client a JSON object that contains:
        - `displayFeedbacks`: A flag telling if some feedbacks need to be displayed
        - `feedbacks`: The optional feedbacks to display
        - `itemSession`: The new item session state
        - `notAllowed`: A flag telling if the response has been rejected by the server, in that case the client should stay on the current item.
        - `message`: A message to display if the `notAllowed` flag is set
        - `testContext`: The new test context, when the `notAllowed` flag is set, in order to synchronize the timer

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`storeTraceData`**
    - *Parameters*:
        - `itemDefinition`: The identifier of the item, when the storage is related to an item. *(optional)*
        - `traceData`: The data to store. It must be a JSON content.

    - *Security Token*: required

    - *Description*: Allows the client to store information about the test, the section or the item.

    - *Response*: The action sends back to the client a JSON object that only contains the status.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`move`**
    - *Parameters*:
        - `ref`: The identifier of the target position to reach. *(optional)*
        - `direction`: The direction of the move, could be `'next'` or `'previous'`
        - `scope`: The scope of the move, could be `'item'`, `'section'`, `'part'`

    - *Security Token*: required

    - *Description*: Moves the current position to the provided scoped reference: item, section, part

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testContext`: The context data that refers to the new item to display

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`skip`**
    - *Parameters*:
        - `ref`: The identifier of the target position to reach. *(optional)*
        - `scope`: The scope of the move, could be `'item'`, `'section'`, `'part'`
        - `itemDuration`: The time elapsed on the item at the client side

    - *Security Token*: required

    - *Description*: Skip the current position to the provided scope: item, section, part

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testContext`: The context data that refers to the new item to display

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`timeout`**
    - *Parameters*:
        - `ref`: The identifier of the target position from which the timeout occurred.
        - `scope`: The scope of the timeout, could be `'item'`, `'section'`, `'part'`

    - *Security Token*: required

    - *Description*: Handles a test timeout. May request a test end.

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testContext`: The context data that refers to the new item to display

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`exitTest`**
    - *Parameters*: none

    - *Security Token*: required

    - *Description*: Exits the test before its end.

    - *Response*: The action sends back to the client a JSON object that only contains the status.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`finish`**
    - *Parameters*: none

    - *Security Token*: required

    - *Description*: Finishes the test. It should not be possible to interact with this test later.
    The next action will be to go back to the index page.

    - *Response*: The action sends back to the client a JSON object that only contains the status.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`pause`**
    - *Parameters*: none

    - *Security Token*: required

    - *Description*: Sets the test in paused state. It should not be possible to interact with this test unless it is explicitly resumed.
    The next action will be to go back to the index page.

    - *Response*: The action sends back to the client a JSON object that only contains the status.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`resume`**
    - *Parameters*: none

    - *Security Token*: required

    - *Description*: Resumes the test from a paused state.

    - *Response*: The action sends back to the client a JSON object that contains:
        - `testContext`: The context data that refers to the new item to display

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`flagItem`**
    - *Parameters*:
        - `position`: The position of the item to flag. By default the current item is flagged. *(optional)*
        - `flag`: The flag state. By default the flag is set. *(optional)*

    - *Security Token*: required

    - *Description*: Flag an item for later review.

    - *Response*: The action sends back to the client a JSON object that only contains the status.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.

- **`comment`**
    - *Parameters*:
        - `comment`: The text of the comment to store

    - *Security Token*: required

    - *Description*: Stores a comment about the test

    - *Response*: The action sends back to the client a JSON object that only contains the status.

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.


- **`messages`**
    - *Parameters*: payload

    - *Security Token*: not needed

    - *Description*: Manage the bidirectional communication through a polling. This action is called every period of time.

    - *Response*: The action sends back to the client a JSON object that contains:
        - `responses`: A list of responses for the received requests
        - `messages`: A list of messages the server has sent to the client

    - *Possible error*: An error may be triggered if the test session is already finished, or if the test does not exist.


## Layout{#layout}

The new Test Runner does not use iframes anymore, it relies instead on a HTML5 layout, and delegate the access handling to an [AreaBroker](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner#area-broker).

Basically, this AreaBroker gives access to:

 - a main container for the whole runner
 - a header bar, that contains for instance the title
 - a control bar, that contains for instance the progress bar and the timer
 - a navigation bar, that contains the navigation controls
 - a toolbox, that contains the tools buttons
 - a side panel, which is a multi-purpose display area
 - a content panel, which obviously contains the current item

The layout is built and injected to the page by the [provider](#provider) when the Test Runner is rendered.


### Access to the layout{#access-to-the-layout}

Each component of the Test Runner must rely on the AreaBroker to get access to the layout.
To do so, the Test Runner provides an API to get the AreaBroker instance:

```javascript
    runner.getAreaBroker();
```

Then you can request access to the wanted area.
Either by relying on the standard areas, which must always be implemented by each provider:

```javascript
    runner.getAreaBroker().getHeaderArea();
    runner.getAreaBroker().getControlArea();
    runner.getAreaBroker().getContentArea();
    runner.getAreaBroker().getPanelArea();
    runner.getAreaBroker().getToolboxArea();
    runner.getAreaBroker().getNavigationArea();
```

Or by requesting an extra area, which may be implemented by a particular provider.
For instance, the QTI provider bring also access to the actionBar, which contains both toolbox and navigation:

```javascript
    runner.getAreaBroker().getArea('actionsBar');
```

**Note:** The brought AreaBroker always returns jQuery selections.

To get more info on the area broker implementation, please refer to the [taoTests extension](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner#area-broker).


## Helpers{#helpers}

Some helpers are provided to centralize the common features.


### Map{#map}

The Map Helper brings several API to manipulate the Map of the test assessment.
Each of these API need the map to manipulate as their first parameter.

Methods | Returns Type | Description
------- | ------------ | -----------
`getJumps(map)` | `Array` | Gets the list of jumps
`getParts(map)` | `Array` | Gets the list of test parts
`getJump(map, position)` | `Object` | Gets the descriptor of a jump stored at a particular position
`getPart(map, partName)` | `Object` | Gets the descriptor of a test part by its identifier
`getSection(map, sectionName)` | `Object` | Gets the descriptor of a test section by its identifier
`getItem(map, itemName)` | `Object` | Gets the descriptor of a test item by its identifier
`getTestStats(map)` | `Object` | Gets the global stats of the assessment test
`getPartStats(map, partName)` | `Object` | Gets the stats of the test part containing a particular position
`getSectionStats(map, sectionName)` | `Object` | Gets the stats of the test section containing a particular position
`getScopeStats(map, position, scope)` | `Object` | Gets the stats related to a particular scope
`getScopeMap(map, position, scope)` | `Object` | Gets the map of a particular scope from a particular position
`getItemPart(map, position)` | `Object` | Gets the descriptor of the test part containing a particular position
`getItemSection(map, position)` | `Object` | Gets the descriptor of the test section containing a particular position
`getItemAt(map, position)` | `Object` | Gets the descriptor of the item located at a particular position
`each(map, callback)` | `Object` | Applies a callback on each item of the provided map
`updateItemStats(map, position)` | `Object` | Update the map stats from a particular item
`computeItemStats(items)` | `Object` | Computes the stats for a list of items
`computeStats(collection)` | `Object` | Computes the global stats of a collection of stats

**Note:** Each time a component needs to manipulate the map, it should use this helper.


### Messages{#messages}

The Messages Helper is intended to complete the message displayed when trying to leave the test.

```javascript
    var exitMessage = getExitMessage(message, scope, runner);
```

For a particular `scope` the helper will complete the provided `message`, if needed.
The runner's instance must also be provided.

An [option](#option) allows to prevent this completion: `test-taker-unanswered-items-message`.

Each time the runner must display a message related to an exit, it must use this helper to complete the message.


## Plugins{#plugins}

[A chapter](Test-Runner-Plugins) is dedicated to the standard available plugins.

To get more info on the plugin implementation, please refer to the [taoTests extension](https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner#plugins).


## Options{#options}

[A chapter](Test-Runner-Config) is dedicated to the available options and how to manage them.