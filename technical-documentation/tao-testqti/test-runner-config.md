# Test Runner Config

- [Runner Options](#runner-options)
    - [Platform Options](#platform-options)
    - [Implementation Options](#implementation-options)
    - [Test Options](#test-options)
    - [Item Usage](#item-usage)


# Runner Options

Most of the features of the Test Runner are configurable. Some are enabled by default, some are not.
Thanks to the modular architecture of the new Test Runner, most of the features are provided through plugins.
[A chapter](Test-Runner-Plugins) is dedicated to this aspect.

A subset of the Test Runner options are managed per tests, while others are platform wide.

Apart the features options, there is also a config dedicated to the version of the Test Runner.
[A chapter](Qti-Client-Test-Runner) is dedicated to this aspect.


## Platform Options

Most of the Test Runner options are platform wide and are managed through a config file.
They target both versions of the Test Runner.

Those options are located into the config file: `config/taoQtiTest/testRunner.conf.php`.

Here is a description of each platform options.


### `timerWarning`

>- *Default: None*
>- *since v2.6.1*

Defines the criteria to display the timer related warning messages. Those criteria are related to a particular scope.
A timer can be assigned either on: the whole test, a test part, a test section or a single item.
Here is the list of available scopes:

Scope | Description
----- | -----------
`assessmentItemRef` | Concern the single item timers
`assessmentSection` | Concern the test sections timers
`testPart` | Concern the test parts timers
`assessmentTest` | Concern the whole tests timers

For each scope it is possible to set several timer warnings, with different intensity level:

Level | Description
----- | -----------
`info` | Will display an info like message, with blue background
`warning` | Will display a warning like message, with yellow background
`danger` | Will display a danger like message, with orange background
`error` | Will display an error like message, with red background

To setup the timer warning, you must follow this syntax and replace accordingly the terms `scope` and `level` by their wanted equivalent, the number is a threshold in seconds below which the warning message will be displayed.

```php
    'timerWarning' => array(
        'scope' => array(
            999 => 'level'
        ),
    ),
```

### `timer`

>- *Default: `['target' => 'server']`*
>- *since v2.23.0*

Configure the runner's timer. This config is provided through a subset.

- `target` : The target from which computes the durations. Could be either `'client'` or `'server'`.
This config tells on which TimeLine to rely to compute the assessment test durations.
Caution, if the server TimeLine is always filled, the client TimeLine must be explicitly
provided by the implementation. If the client TimeLine is missing, the durations will be zeroed.
For more info please refer to the [Test Runner documentation](Test-Runner#timeline).

```php
    'timer' => array(
        'target' => 'server'
    ),
```

### `progress-indicator`

>- *Default: `percentage`*
>- *since v2.7.0*

Tells what type of progress bar to use. Can be:

- `percentage` : Classic progress bar displaying the percentage of answered items
- `position` : Progress bar displaying the position of the current item within the test session

```php
    'progress-indicator' => 'percentage',
```

### `progress-indicator-scope`

>- *Default: `testSection`*
>- *since v2.7.0*

When the `progress-indicator` option is set to `position`, define the scope of progress (i. e.: the number of items on which the ratio is computed). Can be:

- `testSection` : The progression within the current test section
- `testPart` : The progression within the current test part
- `test` : The progression within the whole test

```php
    'progress-indicator-scope' => 'testSection',
```

### `progress-indicator-forced`

>- *Default: `false`*
>- *since v2.12.0*

Force the progress indicator to be always displayed

```php
    'progress-indicator-forced' => false,
```

### `test-taker-review`

>- *Default: `true`*
>- *since v2.7.0*

Enables the test taker review screen, which is a side panel bringing the possibility to navigate through the test items and flag them for later review.
Then the test option `x-tao-option-reviewScreen` must be assigned to each item that needs this review panel.
Please see the chapter [Test Options](#test-options) for more information.

```php
    'test-taker-review' => true,
```

### `test-taker-review-region`

>- *Default: `left`*
>- *since v2.7.0*

When the test taker review screen is enabled, set the position of the side panel. Can be:

- `left`
- `right`

```php
    'test-taker-review-region' => 'left',
```

### `test-taker-review-force-title`

>- *Default: `false`*
>- *since v2.11.0*

Forces a unique title for all test items. When enabled even if each item has its own label a default label is displayed instead.

```php
    'test-taker-review-force-title' => false,
```

### `test-taker-review-item-title`

>- *Default: `Item %d`*
>- *since v2.11.0*

A unique title for all test items, when the option `test-taker-review-force-title` is enabled.
This title will be processed through a `sprintf()` call, with the item sequence number as argument, so you can easily insert the sequence number inside the title.
**Note:** Since this is brought by a config entry it is not possible to manage translation of the default title.

```php
    'test-taker-review-item-title' => 'Item %d',
```

### `test-taker-review-scope`

>- *Default: `test`*
>- *since v2.9.0*

Limits the test taker review screen to a particular scope. Can be:

- `test` : the whole test
- `testPart` : the current test part
- `testSection` : the current test section

```php
    'test-taker-review-scope' => 'test',
```

### `test-taker-review-prevents-unseen`

>- *Default: `true`*
>- *since v2.7.0*

Prevents the test taker to access unseen items.

```php
    'test-taker-review-prevents-unseen' => true,
```

### `test-taker-review-can-collapse`

>- *Default: `false`*
>- *since v2.10.0*

Allows the test taker to collapse the review screen: when collapsed the component is reduced to one tiny column.

```php
    'test-taker-review-can-collapse' => false,
```

### `test-taker-unanswered-items-message`

>- *Default: `true`*
>- *since v5.26.0*

Enable/Disable the warning message about unanswered items at the end of the test.

```php
    'test-taker-unanswered-items-message' => true,
```

### `exitButton`

>- *Default: `false`*
>- *since v2.7.0*

Replace the logout button by an exit button...

```php
    'exitButton' => false,
```

### `next-section`

>- *Default: `false`*
>- *since v2.14.0*

Allows the next section button...

```php
    'next-section' => false,
```

### `keep-timer-up-to-timeout`

>- *Default: `false`*
>- *since v5.28.0*

By default when the test taker leaves a timed section all the items within this section are closed, making impossible to go back to this section.
This option allows to just freeze the timer when the section is left, and allows to resume it when the test taker goes back to the section.

```php
    'keep-timer-up-to-timeout' => false,
```

### `extraContextBuilder`

>- *Default: `null`*
>- *since v2.19.0*

Sets an extra AssessmentTestContext builder class.
This class have to implements `\oat\taoQtiTest\models\TestContextBuilder`

```php
    'extraContextBuilder' => null,
```

### `plugins`

>- *Default: please see the [plugins chapter](Test-Runner-Plugins)*
>- *since v2.20.0*

A collection of plugins related config sets. Each particular plugin config is indexed by the plugin identifier.

```php
    'plugins' => [],
```

### `csrf-token`

>- *Default: `true`*
>- *since v2.22.0*

Enable the cross site request forgery token. For more info please refer to the [Test Runner documentation](Test-Runner#token).

```php
    'csrf-token' => true,
```

### `enable-allow-skipping`

>- *Default: `false`*
>- *since v3.1.0*

Enable Allow/Disallow Skipping feature. When enabled (true), the test taker will have to provide a response to each item having the `allow skipping` option disabled.

```php
    'enable-allow-skipping' => false,
```

### `force-branchrules`

>- *Default: `false`*
>- *since v5.6.0*

Force branch rules to be executed even if the current navigation mode is non-linear.

```php
    'force-branchrules' => false,
```

### `force-preconditions`

>- *Default: `false`*
>- *since v5.6.0*

Force preconditions to be executed even if the current navigation mode is non-linear.

```php
    'force-preconditions' => false,
```

### `path-tracking`

>- *Default: `false`*
>- *since v5.6.0*

Enable path tracking (consider taken route items, rather than default route item flow for navigation).

```php
    'path-tracking' => false,
```

### `always-allow-jumps`

>- *Default: `false`*
>- *since v5.7.0*

Always allow jumps, even if the current navigation mode is linear.

```php
    'always-allow-jumps' => false,
```

### `check-informational`

>- *Default: `true`*
>- *since v5.11.0*

Checks if items are informational. This will change the behavior of the review panel:
the informational items are not taken into account in the answered/flagged counters.

```php
    'check-informational' => true,
```

### `allow-shortcuts`

>- *Default: `true`*
>- *since v5.31.0*

Allows to use keyboard shortcuts to interact with the test runner.

```php
    'allow-shortcuts' => true,
```

### `shortcuts `

>- *Default: `array()`*
>- *since v5.31.0*

Shortcuts scheme applied to the test runner.

```php
    'shortcuts' => [
        '<target>' => [
            '<command' => '<shortcut>',
        ],
    ],
```

### `allow-browse-next-item`

>- *Default: `false`*
>- *since v5.61.0*

Allows to pre-load the next items and put them in a local cache. This option will change the frontend proxy that manages the connection to the server.

```php
    'allow-browse-next-item' => true,
```

### `item-cache-size`

>- *Default: 3*
>- *since v10.1.0*

Defines the number of items to cache, when the feature is allowed (allow-browse-next-item). This is required for caching scenarios.

```php
    'item-cache-size' => 3,
```

## Implementation Options

Some platform options located in the config file `config/taoQtiTest/testRunner.conf.php` are dedicated to the version of the Test Runner.

Here is a description of those implementation options.

### `reset-timer-after-resume`

>- *Default: `false`*
>- *since v2.13.1*

For the old Test Runner only, after resuming test session timers will be reset to the time when the last item has been submitted.

```php
    'reset-timer-after-resume' => false,
```

### `test-session`

>- *Default: `\taoQtiTest_helpers_TestSession`*
>- *since v2.25.0*

Set the FQCN of the TestSession class. This class will be used to manage server side of the Test Runner sessions.


### `test-session-storage`

>- *Default: `\taoQtiTest_helpers_TestSessionStorage`*
>- *since v6.11.0*

Set the FQCN of the TestSessionStorage class. This class will be used to manage server side storage of the Test Runner sessions.

```php
    'test-session' => '\taoQtiTest_helpers_TestSession',
```

### `bootstrap`

>- *Default: see sample below*
>- *since v2.28.0*

For the new Test Runner only, defines the config set that will be provided though the bootstrap.

- `serviceExtension` : The name of the extension containing the controller used as test runner service
- `serviceController` : The name of the controller used as test runner service
- `timeout` : The network timeout, in seconds. @since v2.30.0
- `communication` : Config for the communication channel, which allows a bidirectional dialog with the server.
    - `enabled` : Enables the communication channel
    - `type` : The type of communication channel to use. For now the only available type is `poll`.
    - `extension` : The extension containing the remote service to connect
    - `controller` : The controller containing the remote service to connect
    - `action` : The action corresponding to the remote service to connect
    - `service` : The address of the remote service to connect. When this address is provided it is used instead of url building from extension/controller/action.
    - `params` : Some additional parameters to setup the communication channel

```php
    'bootstrap' => [
        'serviceExtension' => 'taoQtiTest',
        'serviceController' => 'Runner',
        'timeout' => 0,
        'communication' => [
            'enabled' => false,
            'type' => 'poll',
            'extension' => null,
            'controller' => null,
            'action' => 'messages',
            'service' => null,
            'params' => []
        ],
    ],
```


## Test Options

It is possible to activate or configure certain features per test. This is achieved by the use of item categories:
at the item definition level it is possible to assign one or more category, which are like tags.

TAO brings the possibility to use the categories in a particular manner.
By convention, the categories representing Test Runner options start with this prefix: `x-tao-option-`.
Each category, as option, enable a feature for the related item only.
When the item is changed, the features related to the categories are reset.

To assign a category to an item, you must login to the TAO back-office, and enter in a test authoring.
Then, for each item of the test it is possible to assign categories. A helper allows to assign or remove a same category to/from each items of section.

For the standard categories an auto completion facilitate the input of such options.
However, some options are related to particular customers, and are not available as a standard, so no auto completion is provided for them.
Obviously, there are not covered by this documentation.

Here is a description of the currently available options.


### `x-tao-option-reviewScreen`

>- *since v2.15.0*

Displays the review/navigation panel. The platform option `test-taker-review` must be enabled in order to make this working.
Please see the chapter [Platform Options](#platform-options) for more information.

### `x-tao-option-markReview`

>- *since v2.14.0*

Displays the mark for review button when the [review/navigation panel](#x-tao-option-reviewscreen) is enabled.

### `x-tao-option-exit`

>- *since v2.14.0*

Displays an exit button that allow to finish and exit the test before its conventional end.

### `x-tao-option-nextSection`

>- *since v2.15.0*

Displays the next section button

### `x-tao-option-nextSectionWarning`

>- *since v2.15.0*

Displays a next section button, that warns, when clicked, the user that they will not be able to return to the section.

### `x-tao-option-endTestWarning`

>- *since v5.20.0*

Displays a warning before the user finishes the test

### `x-tao-option-unansweredWarning`

>- *since v5.53.0*

displays a warning before the user finishes the test, but only if there are unanswered/marked for review items

### `x-tao-option-noExitTimedSectionWarning`

>- *since v5.22.0*

Disables the warning automatically displayed upon exiting a timed section

### `x-tao-option-calculator`

>- *since v2.28.0*

Displays the calculator button, that bring a basic four function calculator


## Item Usage

>- *since v5.11.0*

The item categories are not only managed to be used as Test Runner options in TAO. Some of them are also dedicated to the item purpose.

Here is a description of the currently available item usages.


### `x-tao-itemusage-default`

When this category is assigned to an item, that is always the case if no other item usage is set, the item is processed as a standard item.


### `x-tao-itemusage-informational`

When this category is assigned to an item, the contained interactions are considered as informational only, the possible responses are not taken into account for the stats.
This means the review panel won't take care of those items. However the score is still processed server side if any.


### `x-tao-itemusage-seeding`

Consider the assigned item is for seeding purpose. At the moment of the writing of this chapter, there is no implementation of this feature yet.