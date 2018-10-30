<!--
contributors:
    - 'Aleh Hutnikau'
    - 'Alexander Zagovorichev'
    - 'Bertrand Chevrier'
    - 'Christophe Noël'
    - 'Dieter Raber'
    - 'Ivan Klimchuk'
    - 'Jean-Sébastien Conan'
    - 'Sam Sipasseuth'
tags:
    - Changelog
    - 'Front End'
-->

# Changelog Front-end

## Sprint 46

We are now able to show the loading bar without blocking the GUI:
<http://recordit.co/aPP8LcUxUv>

To do this pass `false` to the `start()` method:

```
    loadingBar.start(false);
```
---

`ui/dialog` has now flat buttons and benefits from key navigation functionality in the new test runner

`keyNavigation/navigator` now integrates `util/shortcut/registry` to manage the key press mapping. It no longer autofocus but exposes now a focus() method.

---

`ui/stacker`can be used to manage z-index of a group of DOM elements
`ui/component/stackable` binds the stacker to a component

---

`core/middleware`: manage a list of middlewares to apply on a request response. It acts mainly as the `connect` module from the Express framework, but with promises and on AJAX requests basis.

`controller/app`: a single page application controller. It is an entry point controller that works with the `historyRouter`. It offer API to catch all relevant links in the page that need to be routed through the `historyRouter`. A PHP controller has also been implemented.

`core/historyRouter`: some improvements has been added, especially to provide actions: `forward`, `replace`, `redirect`. The component also works now with promises.

`core/proxy`: a CRUD proxy API, based on the same behavior as the new TR proxy. Some base actions are provided through the API, like `create`, `read`, `write`, `remove`, other actions are possible through a dedicated API (`action`). Security token may also be used. Each proxy can be extended with middlewares.

`core/proxy/ajax`: an AJAX implementation of the CRUD proxy API.

`tao_actions_SinglePageModule` (PHP): an abstract controller that is intended to be a basis for single page apps. It provides a mechanism to build pages.

`tao_actions_Breadcrumbs` (PHP): a controller that is intended to serve breadcrumbs for a particular route, based on services (you must implement services that will provide the list of breadcrumbs for each controller/actions). These services should implement the `oat\tao\model\mvc\Breadcrumbs` interface.

---

## Sprint 45

This is a little bit in between Front end and Back end - there is now a more convenient way to register Item Themes using `taoQtiItem/model/themes/ItemThemeInstaller.php`. The class has a pretty complete set of examples.

---

`ui/keyNavigation/navigator` creates a navigator based on compatible navigable elements. Currently two types of navigable elements have been implemented : `ui/keyNavigation/navigableDomElement` represents a dom element and `ui/keyNavigation/navigableGroupElement` represents an navigator itself to allow key navigating between group of elements (these key navigation features are currently only used in a test runner plugin to implement complex key navigation rules requested by a customer)

---

`core/areaBroker`offer now the possibility to attach an arbitrary `ui/component` to an area. This is used by the Qti Test provider, which registers a custom component to handle the toolbox rendering : `taoQtiTest/runner/ui/toolbox` 
This has an impact on how plugin register their button in the toolbox area (and only the toolbox area for now). See any plugin for how to register a button (for example `taoQtiTest/runner/plugins/tools/magnifier`), and `taoQtiTest/runner/plugins/tools/itemThemeSwitcher` for how to register a menu and its entries into the toolbox.

The default rendering of the toolbox component can be overloaded by any client plugin, see `taoAct/runner/plugins/layout/toolbox` for an example

---

## Sprint 44

`core/statifier`: makes an object a states handler. Provides API to set and get states. A state is a named boolean flag, the `statifier` handles a list of states.

---

`core/logger` : front end has now a proper logger : 
```
var logger = loggerFactory('component');
 <http://logger.info|logger.info>('Message');
 logger.debug('Formated %s', 'message');
 logger.trace({ anotherField : true}, 'hello');
 logger.error(new Error('Something went wrong');

var childLogger = logger.child({ type : 'sub-component'});
childLogger.warn('oops');
```

Only the `console` provider is implemented, but we can easily add and load other providers (websockets, ajax, newrelic, etc.)

`taoQtiTest/runner/proxy/loader` lets you change the implementation of the test runner proxy (the module that serves the data).

`taoQtiTest/runner/proxy/cache/proxy` is a proxy provider that cache items and preload their assets

---

`ui/report` a component to display the exact same report generated everywhere in the Back Office
Task queue related :
`core/taskQueue` the client side task queue API to manage tasks, currently only actions get/poll/remove are available
`ui/taskQueue/status` the component to poll and display the current status and report for one task 
`ui/taskQueue/table` the component to display and manage a list of tasks, defined by a task queue context which is used as a filter

---

## Sprint 43

QTI Test Authoring:
`taoQtiTest/controller/creator/helpers/outcomeValidator`: helper that validates outcomes (identifier and type)
`taoQtiTest/controller/creator/helpers/qtiElement`: helper that creates QTI elements, and provides API to browse by path (ex: `“setOutcomeValue.gte.baseValue”`)

---

## Sprint 42

All related to QTI test authoring:
`taoQtiTest/controller/creator/helpers/outcome`: manage test outcomes
`taoQtiTest/controller/creator/helpers/processingRule`: create test outcome processing rules
`taoQtiTest/controller/creator/helpers/scoring`: manage the score processing in a test model 
`taoQtiTest/controller/creator/helpers/category`: helper that provide access to all categories defined in a test
`taoQtiTest/controller/creator/helpers/baseType`: port in JavaScript of QTISM BaseType Enumeration
`taoQtiTest/controller/creator/helpers/cardinality`: port in JavaScript of QTISM Cardinality Enumeration

Core functionalities
`util/shortcut/registry`: added support to enable/disable the shortcuts registry (prevent all shortcuts to be triggered while disabled)

---

## Sprint 41

`ui/feedback` is now a proper component. This means you can override the default config and use the component lifecycle (init/render/destroy). This is a first step in the ability to stack the feedbacks and even to keep errors in a notification area, etc.

---

## Sprint 40

The resource manager is now using `flex` and has some CSS tweaks to improve its responsiveness

Choice interactions now support the elimination of one or more choices

---

`ui/movableComponent`: an interact.js component that provides a movable and resizable simple panel.

---

`ui/calculator` font scales proportionally to the component's size

## Sprint 38

- `datatable` component has a new feature: _options.model.type = 'action'_, which means that there will be a new column with actions.

Usage example:
```
$elt.datatable({
    url: ...
    model: [...,{
        id: 'newActionsColumn',
        label: 'Actions',
        type: 'actions',
        actions: [{
            id: 'pause',
            icon: 'pause',
            label: 'Pause me',
            title: 'Press to pause process',
            action: function(id) {
                alert('in the pause action');
            }
        },{
            id: 'run',
            icon: 'play',
            label: 'Run me',
            title: 'Press to run process',
            action: function(id) {
                alert('in the run action');
            }
        }]
    }]
});
```
Also, datatable has new methods:
- `$list.datatable('highlightRow', rowId);` - add class `highlight` to the row
- `$list.datatable('addRowClass', rowId, className);` - add class to the row
- `$list.datatable('removeRowClass', rowId, className);` - remove class from the row

---

`core/dynamicComponent` contains new options for resizing : min/max width and height. new control to reset the size and an option to keep the aspect ratio. Also some minor refactoring to improve moving and resizing restrictions and perfs.

---

- `datatable` has a new parameter `options.filterSelector`, that allows redefine selector for custom columns filters

usage: 
```
$studentsList.datatable({
    ...
    filterStrategy: 'multiple',
    filterSelector: 'select, input:not(.select2-input)',
    ...
});
```

This is useful when custom filters generate internal inputs (like select2) but we need get the value only from only one of them for add to filter query

---

`core/highlighter` wraps the text nodes found within a selection range with a configurable class. Also provide helpers to save and restore the highlights on an content-identical, but different, DOM tree (useful if the markup is destroyed then re-created)
`taoQtiTest/runner/plugins/tools/highlighter`make use of the highlighter component to provide the test-taker with a highlighter tool

## Sprint 37

>

`documentViewer/pdfViewer`: is now able to search inside the PDF, when the PDF.js lib is installed.
`documentViewer`: new options added
- `allowSearch`: allows to search within the document, each provider must implement the feature if relevant. (default to false)
- `caseSensitiveSearch`: Use a case sensitive search when the search feature is available (default to false)
- `highlightAllMatches`: Highlight all matches to see all of them at a glance (default to false)

`PDF.js`: since a license conflict does not allow to provide this library with the core extension, an install script is available here: <http://forge.taotesting.com/projects/tao/wiki/Install_PDFjs_viewer>

QTI Test Runner: a documentation has been added in the taoQtiTest extension wiki: <https://github.com/oat-sa/extension-tao-testqti/wiki/>

`ui/hider`: the `toggle()` method now accept a second parameter to force the action (show or hide), like the jQuery method does.

`util/namespace`: a helper that provides basic API to manipulate namespaced names (like event names)
`util/shortcut/registry`: refactoring of `util/shortcut`. Provide a factory that maps a shortcuts listener on a particular DOM node. Allow to register several listeners for the same shortcut. Each shortcut can be also namespaced the same way that `core/eventifier` does.
Available options:
- `prevent`: prevent the default behavior of the shortcut
- `propagate`: allow the underlying event to be propagated
- `avoidInput`: prevent the shortcut to be caught inside an input field
- `allowIn`: always allows the shortcut if the event source is in the scope of the provided CSS class, even if the shortcut is triggered from an input field.
`util/shortcut`: refactored to use `util/shortcut/registry`, applied on `window`.

---

`ui/pagination`: component that provides pagination
Usages:

- _default_ pagination with buttons Next/Prev
```
pagination = paginationComponent({activePage: 3, totalPages: 7});
```

- _pages_ mode
```
pagination = paginationComponent({mode: 'pages', activePage: 4, totalPages: 7});
```

Events:
`next` - go to the next page
`prev` - go to the previous page
`change` - active page was changed
`error` - with error message in param

Component can be set to `disable` (all buttons will be disabled) or `enable`

## Sprint 36

>

`documentViewer/pdfViewer`: add option `fitToWidth` to display the PDF using the full available width instead of fitting only the available height.

---

`core/mimetype `: added the function `getMimeType(file)` to return the mimetype of a File object. If the type property of the file is of a generic type, it will use the file extension and the mapping table to find the mimetype.

---

I've updated the build instructions for our fork of CKEditor to be able to rebuild it: <https://github.com/oat-sa/ckeditor-dev#tao-fork-considerations>

On PR, but the `helpers` module is now fully deprecated. Instead of `helpers._url` use the method `route` from `util/url`. The method signature is backward compatible: 

`helpers._url('action', 'Controller', 'taoExtension', { foo : true, bar : 12 })`
becomes
`url.route('action', 'Controller', 'taoExtension', { foo : true, bar : 12 })`

I've also added a module `core/dataProvider/request`: make an ajax request on a TAO endpoint based on payload contract.

- Restful endpoint
    - contentType : application/json
    - the responseBody:
       `{ success : true, data : [the results]}`
       `{ success : false, errorCode: 412, errorMsg : 'Something went wrong' }`
    - 204 for empty content

So your server call looks like

```
var url = urlUtil.route('getOneById', 'Users', 'tao');
request(url, { id : '1234'})
.then(function(user){
     
})
.catch(function (err) { });
```

## Sprint 34

`core/eventifier`:
- the `before` async queue now support promises instead of the `event.done()` syntax, which is deprecated
- the events can now use a general namespace to target all namespaced events (see samples below)
- the `event` object provided to the `before` async queue now contains the name of the event and its namespace
- a new method allows to clears all the registered listeners: `removeAllListeners()`
- examples:
```
	emitter.before('foo', function(e) {
	    // name of event
	    console.log(e.name);

	    // namespace of event
	    console.log(e.namespace);

	    // async mode using promise
	    return new Promise(resolve, reject) {
		if (ok) {
		    resolve();
		} else {
		    reject();
		}
	    });
	});

	// listen to "foo" only
	emitter.on('foo');

	// listen to "foo" and "foo.bar"
	emitter.on('foo.bar');

	// listen to all "foo" events
	emitter.on('foo.*');

	// notify all "foo" listeners
	emitter.trigger('foo');

	// notify only "foo.bar" and "foo.*"
	emitter.trigger('foo.bar’);

	// remove all listeners
	emitter.removeAllListeners();
```

`taoQtiTest/runner/helpers/map`:
- now handles informational items
- new method `getScopeMap(map, position, scope)` that returns a subset of the map scoped to a part or section around a particular position
- new method `each(map, callback)`: loop over each item in the map

`taoQtiTest/runner/plugins/content/dialog`:
- now support targeted alerts/confirms thanks to the changes made into the `core/eventifier`
- can close alerts/confirms through the event `closedialog`. Can use namespace to target a particular kind of alerts/confirms
- Note: all the existing alerts/confirms have been namespaced. You must do the same for all new alerts/confirms

## Sprint 33

>


`core/requireIfExists`: deferred load of module, with fallback if not exists, useful to load optional libs like PDF.js
`core/lib/gamp`: a small lib that provide four functions calculator API with round-off correction
`taoTests/proxy`: the init() method can now accept params to send to the server.
`taoQtiTest/runner`: a new event `resumeitem` is handled to take care of item resuming (by example when the item has been halted in order to move, but the move has been prevented by the server)

`core/lib/decimal`: a complete math library with arbitrary precision

---

`core/eventifier` (to not forget)

<https://github.com/oat-sa/tao-test-taker-generator>

## Sprint 32

>

- `ui/documentViewer`: a general purpose document viewer. For now there only one implementation, targeting PDF.
- `ui/viewerFactory`: the implementation manager of the document viewers
- `ui/documentViewer/providers/pdfViewer`: the PDF viewer implementation

It should be integrated in place of the current `if/else` block, inside the `ui/previewer`, not replace the entire component

## Sprint 31

JSHint to ESLint

`core/pluginLoader` : supports plugin bundles

---

`core/store` : each storage backend as now a new method `removeAll` to remove all the stores and a method `getStoreIdentifier() ` to get a unique id linked to the store.

---

`ui/dateRange` - component that allows to create a selector of the date range

How it works:
```
	# Create new dateRange container
	dateRangeFactory({
	   pickerType: 'datetimepicker',
	   renderTo: $dateRange,
	   pickerConfig: {
	       // configurations from lib/jquery.timePicker.js
	       dateFormat: 'yy-mm-dd',
	       timeFormat: 'HH:mm:ss'
	   }
	});

	# attach to exists form
	&lt;div class="container"&gt;
	  &lt;input type="text" name="from"&gt;
	  &lt;input type="text" name="to"&gt;
	&lt;/div&gt;

	dateRange({
	    startInput: $inputFrom,
	    endInput: $inputTo
	}).render($container)
```

## Sprint 30

Technical documentation of the test runner is now available on the taoTests' wiki : <https://github.com/oat-sa/extension-tao-test/wiki/Test-Runner>

`loader/bootstrap` is the central bootstrap for all AMD entry points.
All entry bundles should be located under loader/

`ui/feedback` : has a new `popup` option if the feedback should be shown as a popup or inline with the content (popup is true by default)

---

`taoQtiItem/runner/provider/manager/userModules`: allow to load and execute modules at runtime in the item runner. See <http://forge.taotesting.com/projects/tao/wiki/UserScripts>

## Sprint 29

Sprint 29 changes

---

- `lib/d3js`, is a JavaScript library for producing dynamic, interactive data visualizations in web browsers. "D3 helps you bring data to life using HTML, SVG, and CSS."
<https://d3js.org/>

- lib/c3js, based on d3js, allows to create charts
<http://c3js.org/>
<http://c3js.org/examples.html>

---

`taoQtiTest/runner/plugins/tools/itemThemeSwitcher`: allows switching between registered item themes
`taoQtiTest/runner/plugins/controls/disableRightClick`: as the name says

## Sprint 28

>

build : update to grunt and contrib plugins to 1.0.0 (improve compilation time - you should run `npm install` also)

---

bundle time taoQtiItem: 3'57 -&gt; 1'05 ! :+1:

---

- remove `Modernizr`

- adding minimal requirement checks

---

- added `ui/tristateCheckboxGroup`, a component that provides tristate checkboxes management, useful to set properties of elements within a tree structure

---

- `taoTests/probeOverseer`: the capture listeners also receive the name of the event that activated the probe and its optional parameters. The callback signature is now `capture`: `function(testRunner, eventName, param…)`

- `taoQtiTest`: freeze the timer when the item is disabled (event `disableitem` triggered), and resume it when the item is enabled (event `enableitem` triggered)

## Sprint 27

>

`core/delegator` : Add a `wrapper` option

---

`core/cachedStore`: a store that buffers the data in memory to offer faster access, and synchronises each change with the browser storage.

---

`core/ui/feedback`: added new type of messages - `danger`, that should be used for notices, that more stronger than warnings. Also it not triggers any error events (in error processing stack)

---

in `core/plugin`: the `install` method is now a part of the life cycle and is not automatically called when the plugin is bound to its host. You need to call it explicitly.

In the new test runner, you can now provide extra parameters to the `init` request, by calling the proxy's method `addCallActionParams(params)`

---

- `ui/interactUtils`: helper for interact library. Contains functions that are commonly bound to _dragstart_ and _dragend_ events and a trigger for the tap event
- associate &amp; order interactions: platform option to enable drag &amp; drop behaviour on top of current Point &amp; Click behaviour

---

A new life cycle step has been added to the new test runner: `flush`. This step is reached before the runner is destroyed in order to flush the test context, by example by sending the test variables. If the test is terminated, the flush step occurs before the runner requests the server to close the test, so the server can handle the storage without worrying about test session access.

The new test runner now handles persistent states through two new methods:
`getPersistentState(state)` and `setPersistentState(state, active)`.
Note: `setPersistentState` returns a promise as the storage may be asynchronous.

The new test runner now can react to disconnection through two new events: `disconnect` and `reconnect`. It also manages a new runner state: `disconnected`.

---

As tooltip library now is used qtip2

You may find comprehensive documentation here:
<http://qtip2.com/options> 

Tooltip module name is `ui/tooltip`. Make sure you require this module before using.


Tooltips can be created in two ways:

1 - Direct call of `qtip()` on element:

```
	$('.selector').qtip({
	    content: {
		text: 'I will be added to elements with .selector class'
	    }
	});
```

2 - Use function which returns module 'ui/tooltip':

```
	define(['ui/tooltip'], function(tooltip) {
	    ...
	    tooltip($('.container-selector'));
	    ...
	});
```

`tooltip()` function will find all elements inside a container passed as first parameter which has `data-tooltip` attribute and initialize tooltip on them (in the same way it works before with old tooltip library).

```
	&lt;div class='container-selector'&gt;
		&lt;span data-tooltip="~ .tooltip-content:first" data-tooltip-theme="info"&gt;I'm tooltipstered element&lt;/span&gt;
		&lt;div class="tooltip-content"&gt;
		    &lt;b&gt;Strong text&lt;/b&gt;
		    &lt;i&gt;Html elemets can be used inside tooltip.&lt;/i&gt;
		&lt;/div&gt;
	&lt;/div&gt;
```




To simplify tooltip themes I have created aliases. They can be specified using the `theme` option:

```
$elt.qtip({
    theme : 'danger',
    content: {
        text: "I'm a danger tooltip !"
    }
});
```

Possible theme values:
'dark', 'default', 'info', 'warning', 'error', 'success', 'danger'

## Sprint 26

>

In `core/plugin`: each plugin can implement a `install` method that will be called when the plugin will be bound to its host

In the new TestRunner, the proxy API exposes:
- `channel()` to register a listener on a particular communication channel (the listener will be called only if the communicator is enabled). The method returns the instance to chain.
- `send()` to send a message to the server using the communication channel, if enabled. The method returns a promise, that will be rejected if the send failed or the communicator is not enabled, and will be resolved when the message has been received and responded.
- `getCommunicator()` to access to the communication channel. The method returns a promise that will be resolved with the communicator instance if enabled (note: this method is provided only for special cases and is not intended to be use for normal communication)

The new Test Runner implements a bidirectional communication, that can be enabled through the config. For now, this implementation is based on a server polling behavior, and is not recommended to be used unless there is a strong need.

---

`core/plugin` has also 2 new methods `getContent` and `setContent` in order to share it's content state (to be able to restore it)

---

- `core/mouseEvents` triggers mouse events with PhantomJS compatibility
- _gapMatch_ &amp; _graphicGapMatch_ interactions: platform option to enable drag &amp; drop behaviour on top of current Point &amp; Click behaviour

---

- `testRunner` now use new warning config, with configurable time points and types of warnings (warning, error, info)

## Sprint 25

>

_Gap Match interaction_:  platform option to enable Drag &amp; drop on top of the current point &amp; click behaviour

---

Some components have been moved from the extension taoTests to taoCore:
`core/tokenHandler`: handles a security token in memory.
`core/providerRegistry`: manage a list of named providers. Each providers must implement at least the `init()` method.

New components added:
`core/delegator`: a helper that provide a way to apply « delegate » and « forward » patterns between an API and a provider
`core/communicator`: an API that wrap the logic around a bidirectional communication channel. It allows several implementations, like polling or websocket.

Note: a « provider » is the implementation of a particular API. The API offers several methods, each one is delegating to an implementation brought by a provider.

---

## Sprint 24

>

`core/areaBroker` is a kind of hub to select areas from a user interface. It's now used in the new test runner and the coming version of the item creator

`core/plugins` and `core/pluginLoader` have been challenged with the test runner and are now part of the core. It provides you a plugin system, suitable for dynamic additions to user interface. Plugins works by hooking an _host_ lifecycle.

`ui/autoScroll`

---

`ui/autoscroll`: ensure that an element is visible inside its container. If the element is outside the viewport, scroll the container to make this element visible. The scroll is done using `animate`. The helper returns a promise that will always be resolved.

---

CSS SDK: all projects that are using theming for either the platform or the items are now on gitlab.

Platform themes now also include tabs

_Assets and Examples_ are now in a separate repo

---

Some components were here to bring the FileReader API using a Flash object. Since the supported browsers now have a good support of this API, these components are useless.
These obsolete components have been removed:
- `AsyncFileUpload`
- `polyfill/filereader`
- `polyfill/swfobject`
- `jquery.uploadify`

## Sprint 23

>

`core/store` unified browser storage

---

The CSS SDK is now mature enough to be used by anybody

---

SCSS mixin `@disableSelect()`: inject CSS rules so that the user can no longer select text in the page

## Sprint 22

>

`core/asyncProcess`: manage asynchronous process carrying deferred async steps. Only one process can run at a time per instance.

---

`eventifier` now supports multiple events: 
```
emitter.on('foo bar', handler);
```

adding `transform: translateZ(0);` on the loading bar to move the animation processing to the GPU when available, because the loading bar was eating up more and more CPU over the time.

## Sprint 21

Sprint 21 / tech changes are opened

`ui/hider` : *hide/show/toggle* using a css class to prevent issues on display when using jQuery's `show/hide`

## Sprint 19

>

new test runner:
- added event in the QTI provider: `endsession`, called each time the client session is ended, either for server interruption (pause/terminate) or normal ending (timeout, end of test)
- added option in the delivery server to choose the extension/controller for the test runner service (default to taoQtiTest/Runner): `serviceExtension`, `serviceController` (config: `taoDelivery/testRunner`)

old test runner:
- added a way to extend the test context by loading a hook class (config: `taoQtiTest/testRunner`, option: `extraContextBuilder `, the class must be an instance of `\oat\taoQtiTest\models\TestContextBuilder`)

---

`ui/actionbar`: display a toolbar, with support for conditional buttons (standalone component extracted from the `datatable/datalist` components).

`taoClientDiagnostic/diagnostic`: the diagnostic tool is now standalone and can be integrated easily as a widget inside another view

## Sprint 18

`core/timer`

`performance.now` polyfill

`localForage` (offline storage)

Core :

 - `core/logger` provides now a logging API with different possible backends
 - You can use `performance.now()` as it is polyfilled (it also polyfills `Date.now()`)
 - `lib/localforage` is also there so you use it for your offline storages
 - `core/polling` let's you run actions periodically with a control on the flow
 - `core/timer` creates an accurate timer/countdown
 - `core/eventifier` supports now namespaces
 - `core/collections` gives you an access to ES6 collections (`Set`, `Map`, `WeakSet`, `WeakMap`)
 - `core/mimeType#getResourceType` will HEAD a resource to retrieve it's mime-type`

Components:

 - `ui/datalist` let's you create list of entries from a data source
 - `ui/dialog`, `ui/alert` and `ui/confirm` should always be used instead of window.alert, etc. _(reminder)_

`moment` updated and `moment-timezone` added

## Sprint 17

`core/logger` is merged now

## Sprint 16

>

`core/mimetype#getResourceType` : HEAD the a resource to retrieve it's mime type. See <https://github.com/oat-sa/tao-core/pull/661>

---

Working on a way to use svg instead of icon fonts. This works to some extend but is still unstable and limited in scope.

---

`core/logger`

---

`ui/datalist`: display a list of selectable labels. Use the same style as ui/datatable. Toolbars and per-line actions are also supported.

## Sprint 14

>

- BrowserAppender
 - new tooltip

---

- modal dialog component:
  + `ui/dialog`: display a modal dialog with a message and a list of buttons (each buttons trigger an event)
  + `ui/dialog/alert`: display a simple alert message, with a unique OK button
  + `ui/dialog/confirm`: display a simple confirm message, with a couple of buttons: ok, cancel

- polling component: executes an action every period of time, each scheduling is made once the previous one is completely done (uses promises). The polling can be paused/resumed, or the next scheduling forced to be ran immediately.

- datatable: the transform callbacks assigned to model definitions can now access to the dataset since the current row is provided as argument

---

- ui/bulkActionPopup: display a popup to let the user verify the list of resources that are going to be affected by a bulk action and optionally define a reason for that action. It contains also a cascading combobox to enable selecting categories/subcategories of reasons. 
Side note : the cascading combobox may be isolated in the future if need be.

## Sprint 13

- `ui/datatable` got a lifting 
- `ui/component` to help you define new components the right way. 
- `ui/listbox` is a new component and uses the component interface above
- `ui/breadcrumb` is a new component and uses the component interface above
- `core/eventifier` is now in develop so you can wrap behavior around events (before and after)
- `core/historyRouter` a client side router that works with the browser history 
- The preview has now also an action bar that uses the same interface than the test runner

---

- preview now supports custom buttons similar to the test environment
