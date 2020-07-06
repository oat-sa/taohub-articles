<!--
authors:
    - "Jean-Sébastien Conan"
tags:
    Frontend Architecture:
        - "Best practices"
-->

# Code writing

> This document describes the best practices regarding frontend code writing.

**Description** -
In order to prevent trivial issues due to bad design, this article will propose
a list of best practices to apply. For each presented situation an example will
be provided for both bad and good solutions, with some explanation around them.

**Disclaimer** -
Regarding the provided examples, in order to make them more readable, only the
addressed topic will be represented, and the best practices unrelated with it might
not be always presented in the code. Please also keep in mind that the provided
examples are not final solutions, only illustrations.

<!-- TOC depthFrom:1 depthTo:6 withLinks:1 updateOnSave:1 orderedList:0 -->

- [Code writing](#code-writing)
    - [Always document your code](#always-document-your-code)
        - [Bad example: Undocumented code](#bad-example-undocumented-code)
        - [Good example: documented code](#good-example-documented-code)
        - [Resources](#resources)
    - [Choose short and self explaining names](#choose-short-and-self-explaining-names)
        - [Bad example: misnamed identifiers](#bad-example-misnamed-identifiers)
        - [Good example: properly named identifiers](#good-example-properly-named-identifiers)
        - [Resources](#resources)
    - [Use verbs to name events](#use-verbs-to-name-events)
        - [Bad example: verbose event name](#bad-example-verbose-event-name)
        - [Good example: accurate event naming](#good-example-accurate-event-naming)
        - [Resources](#resources)
    - [Use properly the event namespaces](#use-properly-the-event-namespaces)
        - [Bad example: namespaced event emitted](#bad-example-namespaced-event-emitted)
        - [Good example: correct event triggering](#good-example-correct-event-triggering)
        - [Resources](#resources)

<!-- /TOC -->

## Always document your code
Always document you code, using [JSDoc](https://jsdoc.app/). If too many
comments could lead to unreadable code, too few or missing comments will surely
reduce the readability as well, at least because of the cognitive impact due
to the additional effort needed to understand the intents.

Code might be self explanatory, if well written. But exposed code must at
least precise the intents and must describe the income and the outcome.

As best practice it is strongly recommended to apply the following:
- Add a file header to mention the release license, the author, and the copyright.
- All modules's public API must be documented, with a proper JSDoc block
explaining the role, declaring the expected parameter and the possible return
values.
- Emitted events and thrown errors must be described.
- For complex dataset, a type definition should describe them.
- A code snippet could be presented as well to show how to use the exposed code.

### Bad example: Undocumented code
The following code snippet is hard to follow as it doesn't express the intents.

```javascript
function doItAllFactory(config = {}) {
    let pollingTimer;
    const doItAll = eventifier({
        run() {
            this.trigger('action');
            return this;
        },
        start() {
            this.trigger('start');
            return this;
        },
        stop() {
            this.trigger('stop');
            return this;
        }
    });
    const doIt = () => doItAll.run();
    const stopIt = () => {
        if (pollingTimer) {
            window.setInterval(pollingTimer);
        }
        pollingTimer = null;
    };
    doItAll.on('start', () => {
        stopIt();
        if (config.polling) {
            pollingTimer = window.setInterval(doIt, config.polling);
        } else {
            doIt();
        }
    });
    doItAll.on('stop', () => stopIt());
    if (config.autoStart) {
        doItAll.start();
    }
    return doItAll;
}
```

### Good example: documented code
The JSDoc annotations help to quickly have some insights on what the code is
intended for. On the example below such annotations have been added, and you
can see how they can improve the readability, especially on the way to use the
exposed code.

```javascript
/**
 * The doItAll factory let's you process an action through a simple API.
 *
 * @author John Smith <js@taotesting.com>
 */

/**
 * @typedef {Object} doItAllConfig
 * @property {Number} polling - Allow to run the action at a regular interval,
 *                              given in milliseconds. O will disable the feature.
 * @property {Boolean} autoStart - Start the action upon creating the instance.
 */

/**
 * Implement an action manager that will do an action immediately
 * or on a regular interval.
 *
 * @example
 *  // do a single action
 *  doItAll()
 *      .on('action', () => {
 *          // do something
 *      })
 *      .start();
 *
 *  // do an action every 30 seconds
 *  doItAll({polling: 30000})
 *      .on('action', () => {
 *          // do something
 *      })
 *      .start();
 *
 *  // do an action every 30 seconds and auto start it
 *  doItAll({polling: 30000, autoStart: true})
 *      .on('action', () => {
 *          // do something
 *      });
 *
 * @param {doItAllConfig} [config] - Some config to adapt the behavior of the instance.
 * @param {Number} [config.polling=0] - Allow to run the action at a regular interval,
 *                                      given in milliseconds. O will disable the feature.
 * @param {Boolean} [config.autoStart=false] - Start the action upon creating the instance.
 * @returns {doItAll}
 * @fires action each time the action is processed
 * @fires start when the action manager has been started
 * @fires stop when the action manager has been stopped
 */
function doItAllFactory(config = {}) {
    // keep track of the interval timer
    let pollingTimer;

    /**
     * @typedef {Object} doItAll
     */
    const doItAll = eventifier({
        /**
         * Process the action.
         * @returns {doItAll} chain
         * @fires action to trigger the action
         */
        run() {
            /**
             * @event action
             */
            this.trigger('action');
            return this;
        },

        /**
         * Starts the process.
         * If the polling is enabled, the action will be triggered every period
         * of time. Otherwise the action will be executed once.
         * @returns {doItAll} chain
         * @fires start to start the process
         */
        start() {
            /**
             * @event start
             */
            this.trigger('start');
            return this;
        },

        /**
         * Stops the process if the polling is enabled. Otherwise do nothing.
         * @returns {doItAll} chain
         * @fires stop to stop the process
         */
        stop() {
            /**
             * @event stop
             */
            this.trigger('stop');
            return this;
        }
    });

    const doIt = () => doItAll.run();
    const stopIt = () => {
        if (pollingTimer) {
            window.setInterval(pollingTimer);
        }
        pollingTimer = null;
    };

    // reflect the starting state of the action manager
    doItAll.on('start', () => {
        stopIt();
        if (config.polling) {
            pollingTimer = window.setInterval(doIt, config.polling);
        } else {
            doIt();
        }
    });

    // reflect the stopped state of the action manager
    doItAll.on('stop', () => stopIt());

    // if the option has been set, auto start the manager
    if (config.autoStart) {
        doItAll.start();
    }
    return doItAll;
}
```

### Resources
- [Coding guide: Documentation](coding-guide.md#documentation)
- [Coding guide: JavaScript rules](coding-guide.md#javascript)
- [jsdoc.app - The JSDoc website](https://jsdoc.app/)

## Choose short and self explaining names
Code might be self explanatory, if well written. Good code is easy to
understand, with respect to the related complexity it might have. A part of the
code readability is linked to the way the identifiers are named. As mentioned in
the [coding guide](coding-guide.md#general-rules),  the names must express the
intent in a clear way. Too long names make reading difficult, as well as too
generic names are hard to follow.

### Bad example: misnamed identifiers
In the snippet below some silly names are in use. You can see how horrible it
is when wrong names are in use, as well as too long names.

```javascript
function bobTheBobby(i) {
    const myUselessAndTooLongLengthyLength = i.length;
    for (let bob = 0; bob < myUselessAndTooLongLengthyLength; bob ++) {
        const bobby = i[bob];
        console.log(`Line #${bob} is: ${bobby}`);
    }
}
const myTreeObjectIsSoCool = {
    firstLevelOfTheTree: {
        identifierOfTheNode: 'firstLevelOfTheTree',
        labelOfTheNode: 'This is the first level',
        actionOfTheNode() { },
        childrenOfTheNode: {
            secondLevelOfTheTreeNode1: {
                identifierOfTheNode: 'secondLevelOfTheTreeNode1',
                labelOfTheNode: 'This is the second level, Node1',
                actionOfTheNode() { },
                childrenOfTheNode: {
                }
            },
            secondLevelOfTheTreeNode2: {
                identifierOfTheNode: 'secondLevelOfTheTreeNode2',
                labelOfTheNode: 'This is the second level, Node2',
                actionOfTheNode() { },
                childrenOfTheNode: {
                }
            }
        }
    }
}
myTreeObjectIsSoCool.firstLevelOfTheTree.childrenOfTheNode.secondLevelOfTheTreeNode2.actionOfTheNode();
```

### Good example: properly named identifiers
Since the silly example was trivial, the equivalent respecting the best practices
is trivial as well. Variables got a proper name, and long names are removed
for the benefit of clearer versions.

```javascript
function showList(list) {
    const length = list && list.length;
    for (let index = 0; index < length; index ++) {
        const line = list[index];
        console.log(`Line #${index} is: ${line}`);
    }
}
const myTree = {
    root: {
        id: 'root',
        label: 'This is the first level',
        action() {},
        children: {
            node1: {
                identifier: 'node1',
                label: 'This is the second level, Node1',
                action() {},
                children: {
                }
            },
            node2: {
                identifier: 'node2',
                label: 'This is the second level, Node2',
                action() {},
                children: {
                }
            }
        }
    }
}
myTree.root.children.node2.action();
```

### Resources
- [Coding guide: General rules](coding-guide.md#general-rules)

## Use verbs to name events
Event names must express the action they are referring to. And verbs are a good
way to express an action. They are short, concise and clear. As examples:
`change`, `update`, `render`, `init`.

To distinguish too generic names, and give some context to the event, you may
add nouns to complete the name: `setvalue`, `clearname`, `valuechange`.

The main rule is to be directive.

By convention event names must also be lowercase.

### Bad example: verbose event name
In the snippet below, a too verbose name is used as event.

```javascript
function valueObserverFactory(value) {
    return eventifier({
        getValue() {
            return value;
        },
        setValue(newValue) {
            value = newValue;
            this.trigger('theValueHasBeenChanged', value);
            return this;
        }
    });
}
```

### Good example: accurate event naming
In the snippet below, a more accurate name is applied. Since there is only
one event, and the scope is clear enough, a single verb is used.

```javascript
function valueObserverFactory(value) {
    return eventifier({
        getValue() {
            return value;
        },
        setValue(newValue) {
            value = newValue;
            this.trigger('change', value);
            return this;
        }
    });
}
```

### Resources
- [Coding guide: General rules](coding-guide.md#general-rules)
- [Events model](events-model.md)

## Use properly the event namespaces
The events model allows to add namespaces for purposes of scoping events.
However, each events system have its own specificities. Usually namespaces are
applied by the event listeners, in order to group events under a same context,
making it easier to manage them. For instance this gives the ability to remove
all events listened for a specific context, without altering other listeners.

Where this become a little more complex is when the namespace is applied upon
emitting the event. In the TAO implementation, so called the [eventifier](events-model.md),
when a namespace is applied upon emitting the event, only the listeners
registered under the same namespace will be triggered. And therefore, since
namespace cannot be chained, it is impossible to enforce the scope for those
particular events.

### Bad example: namespaced event emitted
Consider the following snippet:

```javascript
const emitter = eventifier({
    setValue(value) {
        // the event is emitted with a namespace, therefore only listeners
        // that match the full qualified name will be actioned.
        this.trigger('set.value', value);
    }
});

// listen to the `set` event, under the namespace `value`
emitter.on('set.value', () => console.log('set.value'));

// listen to the `set` event, all namespaces
emitter.on('set', () => console.log('set'));

// listen to the `set` event, under the namespace `value.foo`
emitter.on('set.value.foo', () => console.log('set.value.foo'));

// will trigger the event
emitter.setValue('foo');
```

Only the listener bound to the exact namespaced event will be actioned. The non
namespaced event will never get actioned. And the over namespaced listener as
well.

Sometimes, however, for some edge case this pattern might be useful. But this
has to be motivated by a strong reason. For instance internal purpose events.

### Good example: correct event triggering
A better implementation of the previous example might be:

```javascript
const emitter = eventifier({
    setValue(value) {
        this.trigger('setvalue', value);
    }
});

// listen to the `setvalue` event, under the namespace `foo`
emitter.on('setvalue.foo', () => console.log('setvalue.foo'));

// listen to the `setvalue` event, all namespaces
emitter.on('setvalue', () => console.log('setvalue'));

// listen to the `setvalue` event, under the namespace `foo.bar`
emitter.on('setvalue.foo.bar', () => console.log('setvalue.foo.bar'));

// will trigger the event
emitter.setValue('foo');
```

Each listener applying to the `setvalue` event will get actioned.

### Resources
- [Events model](events-model.md)
