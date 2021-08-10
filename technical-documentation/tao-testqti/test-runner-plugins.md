# Test Runner Plugins

- [Plugins](#plugins)
    - [Content Plugins](#content-plugins)
        - [Dialog](#dialog)
        - [Exit Messages](#exit-messages)
        - [Feedback Modal Message](#feedback-modal-message)
        - [Feedback Inline Message](#feedback-inline-message)
        - [Modal Feedback](#modal-feedback)
        - [Feedback](#feedback)
        - [Loading Bar](#loading-bar)
        - [Overlay](#overlay)
        - [Collapser](#collapser)
        - [Rubric Block](#rubric-block)
    - [Control Plugins](#control-plugins)
        - [Connectivity Check](#connectivity-check)
        - [Duration Record](#duration-record)
        - [Progress Indicator](#progress-indicator)
        - [Test State](#test-state)
        - [Timer Indicator](#timer-indicator)
        - [Title Indicator](#title-indicator)
    - [Navigation Plugins](#navigation-plugins)
        - [Navigation and review panel](#navigation-and-review-panel)
        - [Next button](#next-button)
        - [Previous button](#previous-button)
        - [Skip button](#skip-button)
        - [Next section button](#next-section-button)
    - [Security Plugins](#security-plugins)
        - [Disable right click](#disable-right-click)
    - [Tools Plugins](#tools-plugins)
        - [Comment tool](#comment-tool)
        - [Document Viewer](#document-viewer)
        - [Item themes switcher](#item-themes-switcher)
        - [Calculator](#calculator)
        - [Zoom](#zoom)
        - [Highlighter](#highlighter)
- [Registry](#registry)
    - [Registry API](#registry-api)
- [Features](#features)


# Plugins

Thanks to the modular architecture of the new Test Runner, most of the features are provided through plugins.

Plugins are gathered by categories, in order to facilitate their management. There is also a system of tags to complete the categories.
Here is a list of the standard categories:

- `content`: plugins that deal with the test content
- `controls`: plugins that control the test
- `navigation`: plugins that provide tha navigation within the test
- `security`: plugins related to the test security
- `tools`: general purpose tools the test may offer

Some plugins can be configured through the platform options, as described in the [dedicated chapter](Test-Runner-Config#plugins).
The options related to each plugins are detailed with the documentation of the concerned plugin.

Plugins must be registered into a config file, that is managed by a [TAO registry](#registry).
Through the registry, plugins can be enabled or disabled for the whole platform.

A system of [features](#features) also allows to enable/disable plugins per deliveries.


## Content Plugins

Those plugins are intended to be related to the test content.


### Dialog

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | No | - | - | -

Displays popups that requires user interactions.
This plugin is required since it is responsible of the messages display.

>- **Since:** v2.18.0
>- **Identifier:** `dialog`
>- **Namespace:** `taoQtiTest/views/js/runner/plugins/content/dialog/dialog`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `alert.*` | `message`, `callback` | Displays an alert message, the provided callback will be invoked once the test taker will acknowledge
listen | `confirm.*` | `message`, `accept`, `reject` | Displays a confirm message, the provided callbacks will be invoked with respect to the test taker response
listen | `closedialog.*` | `accept` | Close all dialogs. The namespace of the event allows to restrict the target. By default all dialogs will be closed with reject. The `accept` parameter allows to close with accept.


### Exit Messages

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | No | - | - | -

Displays messages when a test taker leaves the test.

>- **Since:** v2.30.0
>- **Identifier:** `exitMessages`
>- **Namespace:** `taoQtiTest/runner/plugins/content/dialog/exitMessages`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `leave` | `data` | When the `leave` event comes with a message, displays it and wait before allowing to end the session
emit | 'alert.leave' | `data.message` | Displays an alert message to bring the exit reason to the test taker


### Feedback Modal Message

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | Yes | - | - | Yes

Sub-plugin used by the QTI Feedback feature. Displays the feedback using a modal alert.

>- **Since:** v5.10.0
>- **Identifier:** `itemAlertMessage`
>- **Namespace:** `taoQtiTest/views/js/runner/plugins/content/dialog/itemAlertMessage`

- **Config:** Set the TAO registry entry `['taoQtiItem/qtiRunner/core/QtiRunner']['inlineModalFeedback']` to `false`
- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
emit | `plugin-resume.itemAlertMessage` | | The test taker has acknowledged the feedback


### Feedback Inline Message

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | Yes | - | - | Yes

Sub-plugin used by the QTI Feedback feature. Displays the feedback by injecting inline messages inside the item.

>- **Since:** v5.10.0
>- **Identifier:** `itemInlineMessage`
>- **Namespace:** `taoQtiTest/views/js/runner/plugins/content/dialog/itemInlineMessage`

- **Config:** Set the TAO registry entry `['taoQtiItem/qtiRunner/core/QtiRunner']['inlineModalFeedback']` to `true`
- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
emit | `plugin-resume.itemInlineMessage` | | The test taker has acknowledged the feedback


### Modal Feedback

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | Yes | - | - | Yes

Displays QTI feedback

>- **Since:** v5.10.0
>- **Identifier:** `modalFeedback`
>- **Namespace:** `taoQtiTest/runner/plugins/content/modalFeedback/modalFeedback`

- **Config:** 
    - Set the TAO registry entry `['taoQtiItem/qtiRunner/core/QtiRunner']['inlineModalFeedback']` either to `true` or `false` (for item authoring)
    - Set the TAO registry entry `['taoQtiTest/runner/plugins/content/modalFeedback/modalFeedback']['inlineModalFeedback']` either to `true` or `false` (for test runner)
- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `modalFeedbacks` | `renderingQueue`,`done`,`inline` | Displays the feedback as requested
listen | `plugin-resume.itemAlertMessage` | | Closes the feedback as the test taker acknowledge it
listen | `plugin-resume.itemInlineMessage` | | Closes the feedback as the test taker acknowledge it


### Feedback

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | No | - | - | -

Displays notifications into feedback popups.

>- **Since:** v2.18.0
>- **Identifier:** `feedback`
>- **Namespace:** `taoQtiTest/views/js/runner/plugins/content/feedback/feedback`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `error` | `err` | Displays message when an error occurs
listen | `danger` | `message` | Warns the user about something, with a danger level
listen | `warning` | `message` | Warns the user about something
listen | `info` | `message` | Displays an info message
listen | `alert.*` | | Closes existing feedback
listen | `confirm.*` | | Closes existing feedback
listen | `unloaditem` | | Closes existing feedback


### Loading Bar

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | No | - | - | -

Shows a loading bar when the test is loading

>- **Since:** v2.32.0
>- **Identifier:** `loading`
>- **Namespace:** `taoQtiTest/views/js/runner/plugins/content/loading/loading`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `unloaditem` | | Displays the loading bar
listen | `renderitem` | | Hide the loading bar


### Overlay

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | Yes | Yes | - | -

Add an overlay over items when disabled

>- **Since:** v2.18.0
>- **Identifier:** `overlay`
>- **Namespace:** `taoQtiTest/runner/plugins/content/overlay/overlay`

- **Config:**
    - `plugins`:
        - `overlay`: @since 2.26.0
            - `full`: When set to `true`, completely obfuscate the current item when displayed (default: `false`)

    ```php
        'plugins' => [
            'overlay' => [
                'full' => false
            ],
        ],
    ```

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `disableitem` | | Displays the overlay
listen | `enableitem` | | Hides the overlay
listen | `unloaditem` | | Hides the overlay


### Collapser

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | No | Yes | Yes | - | -

Reduce the size of the tools when the available space is not enough

>- **Since:** v5.5.0
>- **Identifier:** `collapser`
>- **Namespace:** `taoQtiTest/runner/plugins/content/responsiveness/collapser`

- **Config:**
    - `plugins`:
        - `collapser`:
            - `collapseTools`: When set to `true`, manage the size of the tools bar (default: `true`)
            - `collapseNavigation`: When set to `true`, manage the size of the navigation bar (default: `false`)
            - `hover`: When the buttons are reduced, allow an expand when the mouse is over a button (default: `false`)

    ```php
        'plugins' => [
            'collapser' => [
                'collapseTools' => true,
                'collapseNavigation' => false,
                'hover' => false
            ]
        ],
    ```

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `renderitem` | | Update the size of the bar
listen | `loaditem` | | Update the size of the bar


### Rubric Block

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | No | - | - | -

Displays the test rubric blocks

>- **Since:** v2.18.0
>- **Identifier:** `rubricBlock`
>- **Namespace:** `taoQtiTest/runner/plugins/content/rubricBlock/rubricBlock`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `ready` | | Hides the rubric blocks if any
listen | `loadrubricblock` | | Inject and displays the rubric blocks if any
listen | `renderitem` | | Shows the rubric blocks if any
listen | `unloaditem` | | Hides and removes the rubric blocks if any


## Control Plugins

Those plugins are intended to provide a control on the test


### Connectivity Check

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | No | - | - | -

Pauses the test when the network looses the connection

>- **Since:** v2.32.0
>- **Identifier:** `connectivity`
>- **Namespace:** `taoQtiTest/runner/plugins/controls/connectivity/connectivity`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `window`.`offline` | | The browser looses the connection
listen | `window`.`online` | | The browser retrieves the connection
listen | `error` | | Detect connection error
listen | `proxy`.`receive` | | Detect reconnection through the proxy
listen | `disconnect` | | Set the runner state to `disconnected`
listen | `reconnect` | | Remove the `disconnected` state from the runner
emit | `disconnect` | | Emit this event when the browser has loss the connection
emit | `reconnect` | | Emit this event when the browser has retrieved the connection


### Duration Record

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | No | - | - | -

Record accurately time spent by the test taker

>- **Since:** v2.24.0
>- **Identifier:** `duration`
>- **Namespace:** `taoQtiTest/runner/plugins/controls/duration/duration`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `renderitem` | | Enables the plugin
listen | `enableitem` | | Enables the plugin
listen | `disableitem` | | Disables the plugin
listen | `move` | | Disables the plugin
listen | `skip` | | Disables the plugin
listen | `error` | | Disables the plugin
listen | `plugin-get.duration` | | Loads the duration from store
listen | `finish` | | Removes the duration store


### Progress Indicator

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | Yes | Yes | - | -

Displays the current progression within the test by using a progress bar.

>- **Since:** v2.17.0
>- **Identifier:** `progressbar`
>- **Namespace:** `taoQtiTest/runner/plugins/controls/progressbar/progressbar`

- **Config:** Please refer to [the Test Runner Options chapter](Test-Runner-Config#platform-options)
- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `ready`| | Updates the progress bar
listen | `loaditem`| | Updates the progress bar


### Test State

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | No | - | - | -

Manage the test state. Detects if the test has been paused or finished, and then leave it.
Also detects state inconsistency, then leave immediately the test.

>- **Since:** v2.29.0
>- **Identifier:** `testState`
>- **Namespace:** `taoQtiTest/runner/plugins/controls/testState/testState`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
emit | `destroy` | | Force to leave the test if the state is inconsistent
emit | `leave` | `data` | Force to leave the test it has been paused or finished, provide a message to display


### Timer Indicator

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | Yes | Yes | Yes | -

Manage the timers, triggers timeout
Add countdown when remaining time

>- **Since:** v2.18.0
>- **Identifier:** `timer`
>- **Namespace:** `taoQtiTest/runner/plugins/controls/timer/timer`

- **Config:** Please refer to [the Test Runner Options chapter](Test-Runner-Config#platform-options)
- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `storechange` | | Clear the storage when changing store
listen | `loaditem` | | Updates the timers
listen | `resumeitem` | | Updates the timers
listen | `renderitem` | | Enables the timers
listen | `enableitem` | | Enables the timers
listen | `disableitem` | | Disables the timers
listen | `disconnect` | | Disables the timers
listen | `move` | | Detects if the test taker leaves a timed section. Update, remove or add the timers.
listen | `finish` | | Clear the storage when the test is finished
emit | `confirm.exittimed`| `message`, `accept`, `reject` | Prompts the test taker that he/she is leaving a timed section
emit | `enableitem` | | Restore the item if the test taker refuse to leave the timed section
emit | `enablenav` | | Restore the item if the test taker refuse to leave the timed section
emit | `info` | `message` | Displays a message about the remaining time with info layout
emit | `warning` | `message` | Displays a message about the remaining time with warning layout
emit | `danger` | `message` | Displays a message about the remaining time with danger layout
emit | `error` | `message` | Displays a message about the remaining time with error layout


### Title Indicator

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | No | - | - | -

Display the title of current test element

>- **Since:** v2.17.0
>- **Identifier:** `title`
>- **Namespace:** `taoQtiTest/runner/plugins/controls/title/title`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | --- | ---
listen | `renderitem` | | Updates the displayed title


## Navigation Plugins

Those plugins are intended to manage the navigation inside the test


### Navigation and review panel

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | Yes | Yes | Yes | -

Displays and manage the navigation and review panel.
It allows to jump to any reachable item, shows info and statistics about a particular scope.
See the [dedicated chapter](Test-Runner-Config#platform-options) about the options.
It also allows to mark an item for later reviews.

>- **Since:** v2.18.0
>- **Identifier:** `review`
>- **Namespace:** `taoQtiTest/runner/plugins/navigation/review/review`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `render` | | Displays the panel, enable/disable the "Mark for review" button
listen | `loaditem` | | Updates the panel, enable/disable the "Mark for review" button
listen | `enabletools` | | Enables the plugin
listen | `disabletools` | | Disables the plugin
emit | `move` | `jump`, `scope`, `position` | Move to a particular item (through the `jump` API)
emit | `jump` | `position`, `scope` | Jump to a particular item (through the `jump` API)

- **API:**

Name | Action | Parameters | Description
--- | --- | --- | ---
`jump` | | `position`, `scope` | Jump to a particular item
`callTestAction` | `flagItem` | `position`, `flag` | Mark/unmark an item for later review


### Next button

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | No | - | - | -

Moves to the next available item or finishes the test

>- **Since:** v2.17.0
>- **Identifier:** `next`
>- **Namespace:** `taoQtiTest/runner/plugins/navigation/next`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | |  Shows/hides the button
listen | `enablenav` | |  Enables the button
listen | `disablenav` | |  Disables the button
emit | `move` | `next`, `scope` | Moves to the next item (through the `next` API)
emit | `end` | | This is the last item

- **API:**

Name | Action | Parameters | Description
--- | --- | --- | ---
`next` | | | Moves to the next available item


### Previous button

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
Yes | Yes | No | - | - | -

Moves to the previously available item

>- **Since:** v2.17.0
>- **Identifier:** `previous`
>- **Namespace:** `taoQtiTest/runner/plugins/navigation/previous`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | |  Shows/hides the button
listen | `enablenav` | |  Enables the button
listen | `disablenav` | |  Disables the button
emit | `move` | `previous`, `scope` | Moves to the previous item (through the `previous` API)

- **API:**

Name | Action | Parameters | Description
--- | --- | --- | ---
`previous` | | | Moves to the previously available item


### Skip button

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | Yes | - | Yes | Yes

Skips the current item, and move to the next available item or finishes the test.
The button is displayed only if the current item does allow to skip (Authoring config).

>- **Since:** v2.17.0
>- **Identifier:** `skip`
>- **Namespace:** `taoQtiTest/runner/plugins/navigation/skip`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | |  Shows/hides the button
listen | `enablenav` | |  Enables the button
listen | `disablenav` | |  Disables the button
emit | `skip` | `scope` | Skips the current item (through the `skip` API)

- **API:**

Name | Action | Parameters | Description
--- | --- | --- | ---
`skip` | | | Skips the current item


### Next section button

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | Yes | Yes | Yes | -

Moves to the next available section or finishes the test.
This plugin is configurable through [platform](Test-Runner-Config#platform-options) and [test](Test-Runner-Config#test-options) options.

>- **Since:** v2.17.0
>- **Identifier:** `nextSection`
>- **Namespace:** `taoQtiTest/runner/plugins/navigation/nextSection`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | |  Shows/hides the button
listen | `enablenav` | |  Enables the button
listen | `disablenav` | |  Disables the button
emit | `move` | `next`, `section` | Moves to the next section (through the `next` API)

- **API:**

Name | Action | Parameters | Description
--- | --- | --- | ---
`next` | | `section` | Moves to the next available section


## Security Plugins

Those plugins are intended to enforce the security of the assessment test


### Disable right click

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | No | No | - | - | -

Disables the right click and the context menu on items.

>- **Since:** v3.1.0
>- **Identifier:** `disableRightClick`
>- **Namespace:** `taoQtiTest/runner/plugins/security/disableRightClick`


## Tools Plugins

Those plugins are intended to provide a better user experience


### Comment tool

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | Yes | - | - | Yes

Allows the test taker to comment an item.
The button is displayed only if the current item does allow to comment (Authoring config).

>- **Since:** v2.18.0
>- **Identifier:** `comment`
>- **Namespace:** `taoQtiTest/runner/plugins/tools/comment/comment`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | |  Shows/hides the button
listen | `enabletools` | |  Enables the button
listen | `disabletools` | |  Disables the button

- **API:**

Name | Action | Parameters | Description
--- | --- | --- | ---
`callTestAction` | `comment` | `comment` | Sends the comment to the server


### Document Viewer

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | No | - | - | -

Displays a document as requested by an event.

>- **Since:** v5.29.0
>- **Identifier:** `documentViewer`
>- **Namespace:** `taoQtiTest/runner/plugins/tools/documentViewer/documentViewer`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | DOM.`viewDocument` | `document` | Displays a panel to show the requested document
listen | `renderitem` | | Enables the plugin, listen to DOM event `viewDocument`
listen | `enabletools` | | Enables the plugin
listen | `disabletools` | | Hides the panel and disables the plugin
listen | `unloaditem` | | Hides the panel and disables the plugin
listen | `move` | | Hides the panel
listen | `skip` | | Hides the panel


### Item themes switcher

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | No | Yes | - | - | Yes

Allows to switch between themes through a menu listing the available themes.
The list of available themes is configured on the platform.

>- **Since:** v3.1.0
>- **Identifier:** `itemThemeSwitcher`
>- **Namespace:** `taoQtiTest/runner/plugins/tools/itemThemeSwitcher/itemThemeSwitcher`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | |  Shows/hides the button
listen | `renderitem` | |  Enables the button, ensures the selected theme is applied
listen | `enabletools` | |  Enables the button
listen | `disabletools` | |  Disables the button
listen | `unloaditem` | |  Disables the button


### Calculator

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | Yes | Yes | - | Yes | -

Gives the student access to a basic calculator.
The enabling of the calculator is done through a [test option](Test-Runner-Config#test-options).

>- **Since:** v2.28.0
>- **Identifier:** `calculator`
>- **Namespace:** `taoQtiTest/runner/plugins/tools/calculator`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | | Shows/hides the plugin
listen | `renderitem` | | Enables the plugin
listen | `enabletools` | | Enables the plugin
listen | `disabletools` | | Hides the calculator and disables the plugin
listen | `unoaditem` | | Hides the calculator and disables the plugin
emit | `plugin-calculator.open` | | Notify the plugin is opened
emit | `plugin-calculator.close` | | Notify the plugin is closed


### Zoom

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | No | No | - | - | -

Zoom in and out the item content

>- **Since:** v3.1.0
>- **Identifier:** `zoom`
>- **Namespace:** `taoQtiTest/runner/plugins/tools/zoom`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | | Enables the plugin and shows the buttons
listen | `renderitem` | | Enables the plugin and targets the item content
listen | `enabletools` | | Enables the plugin
listen | `disabletools` | | Disables the plugin

### Highlighter

Required | Default | Configurable | Platform Option | Test Option | Other Option
--- | --- | --- | --- | --- | ---
No | No | Yes | - | - | Yes

Allows a Test-Taker to mark passages of text in an Item.

>- **Since:** v5.37.0
>- **Identifier:** `highlighter`
>- **Namespace:** `taoQtiTest/runner/plugins/tools/highlighter`

- **Events:**

Mode | Event | Parameters | Description
--- | --- | --- | ---
listen | `loaditem` | | Enables the plugin and shows the buttons
listen | `renderitem` | | Enables the plugin and targets the item content
listen | `enabletools` | | Enables the plugin
listen | `disabletools` | | Disables the plugin
emit | `start` | | Highlighting mode started
emit | `end` | | Highlighting mode stopped

# Registry

>- **Since:** v5.0.0

The plugins are now managed through a platform registry.
This allows to manage the plugins platform wide and provide different plugins set per customer.

To register a plugin, through an install/update script (replace the content by yours):

```php
use oat\taoTests\models\runner\plugins\PluginRegistry;
...
$registry = PluginRegistry::getRegistry();
$registry->register(TestPlugin::fromArray([
    'id' => 'pluginID',
    'name' => 'pluginName',
    'module' => 'path/to/the/plugin',
    'description' => 'The description of the plugin',
    'category' => 'aMainCategory',
    'active' => true|false,
    'tags' => [ 'some', 'tags' ]
]));
...
```

To gets the list of available and enabled plugins, you can now rely on the plugins service:

```php
use oat\oatbox\service\ServiceManager;
use oat\taoTests\models\runner\plugins\TestPluginService;
...
$serviceManager = ServiceManager::getServiceManager();
$pluginService = $serviceManager->get(TestPluginService::CONFIG_ID);
...
$allPlugins = $pluginService->getAllPlugins();
...
```

## Registry API

## TestPluginService->getAllPlugins()
Retrieve the list of all available plugins (from the registry).

**Returns:** an array of `TestPlugin` instances


### TestPluginService->getPlugin(string $id)

Retrieve a plugin by its identifier from the registry

**Returns:** The `TestPlugin` or `null`


### TestPluginService->loadPlugin(array $data)

Load a test plugin from the given data.

**Returns:** The `TestPlugin` or `null`


### TestPluginService->activatePlugin(TestPlugin $plugin)

Change the state of a plugin to active.

**Returns:** `true` if the process succeed, or `false`


### TestPluginService->deactivatePlugin(TestPlugin $plugin)

Change the state of a plugin to inactive.

**Returns:** `true` if the process succeed, or `false`


# Features

>- **Since:** v5.28.O

In addition to the platform registry, it is possible to assign a set of plugins per deliveries through a features management.
The features are also managed through a platform registry.

A the delivery level, the list of available features allow to enable/disable them.
When a feature is disabled, the related plugins are removed for this delivery.

A feature is represented by a PHP class that lists the plugins targeted by the feature.

To create a feature you must inherit the class from `\oat\taoTests\models\runner\features\TestRunnerFeature`.

```php
use oat\oatbox\service\ServiceManager;
use oat\taoTests\models\runner\features\TestRunnerFeature;
use oat\taoTests\models\runner\plugins\TestPluginService;

class MyFeature extends TestRunnerFeature
{
    public function __construct() {
        $serviceManager = ServiceManager::getServiceManager();
        $pluginService = $serviceManager->get(TestPluginService::CONFIG_ID);

        parent::__construct(
            'myFeature',                    // the inner name of the feature
            ['myPlugin'],                   // the list of plugins the feature contains
            true,                           // enabled by default
            $pluginService->getAllPlugins() // the list of available plugins provided by the plugins registry
        );
    }

    public function getLabel()
    {
        return __('MyFeature');
    }

    public function getDescription()
    {
        return __('A simple feature that rocks!');
    }
}
```

Then to publish your new feature, you still need to register it:

```php
use oat\taoTests\models\runner\features\TestRunnerFeatureService;

class RegisterTestRunnerFeatures extends \common_ext_action_InstallAction
{
    public function __invoke($params)
    {
        $serviceManager = $this->getServiceManager();

        $testRunnerFeatureService = $serviceManager->get(TestRunnerFeatureService::SERVICE_ID);
        $testRunnerFeatureService->register(new MyFeature());

        $serviceManager->register(TestRunnerFeatureService::SERVICE_ID, $testRunnerFeatureService);

        return new \common_report_Report(\common_report_Report::TYPE_SUCCESS, 'Test runner features registered');
    }
}
```