<!--
authors:
    - "Jean-Sébastien Conan"
tags:
    Frontend Architecture:
        - "Good practices"
-->

# TAO Frontend Good Practices

> This document describes frontend good practices.

In order to prevent trivial issues due to bad design, this article will propose 
a list of good practices to apply. For each presented situation an example will 
be provided for both bad and good solutions, with some explanation around them.
Regarding the provided examples, in order to make them more readable, only the 
addressed topic will be represented, and good practices unrelated with it might 
not be always presented in the code. 

## Code writing

### Please always document your code
Always document you code, using [JSDoc](https://jsdoc.app/). If too many 
comments could lead to unreadable code, too few or missing comments will surely 
reduce the readability as well, at least because of the cognitive impact due
to the additional effort needed to understand the intents.

Code might be self explanatory, if well written. But exposed code must at 
least precise the intents and must describe the income and the outcome.

Every function must have a proper JSDoc block, declaring the expected 
parameter and the possible return values. Emitted events and thrown errors 
must also be described. For complex datasets, a type definition should 
describe them. A code snippet could be presented as well to show how to use
the exposed code.

#### Example

##### Bad
This code snippet is hard to follow as it doesn't express the intend.

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

##### Good
The JSDoc annotations helps to quickly have some insights on what the code is 
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
 * Do an action immediately or on a regular interval.
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

#### References
- [jsdoc.app - The JSDoc website](https://jsdoc.app/)

### Choose short and self explaining names
Code might be self explanatory, if well written. Good code is easy to 
understand, with respect to the related complexity it might have. A part of the 
code readability is linked to the way the identifiers are named. As mentioned in 
the [coding guide](https://github.com/oat-sa/taohub-articles/blob/article/frontend-good-practices/articles/Frontend/Architecture/coding-guide.md#general-rules), 
the names must express the intent in a clear way. Too long names make reading 
difficult, as well as too generic names are hard to follow.

#### Example

##### Bad
In the snippet below some silly names are in use. You can how horrible it is 
when too long names are in place. The same for badly named variables.

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

##### Good
Since the silly example was trivial, the equivalent respecting good practices 
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

#### References
- [Coding guide: General rules](https://github.com/oat-sa/taohub-articles/blob/article/frontend-good-practices/articles/Frontend/Architecture/coding-guide.md#general-rules)

### Use verbs to name events
Event names must express the action they are referring to. And verbs are a good 
way to express an action. They are short, concise and clear. As examples:
`change`, `update`, `render`, `init`.

To distinguish too generic names, and give some context to the event, you may 
add nouns to complete the name: `setvalue`, `clearname`.

The main rule is to be directive.

By convention event names must also be lowercase.
#### Example

##### Bad
In the snippet below, a too verbose name is used as event. 

```javascript
function valueObserverFactory(value) {
    return eventifier({
        getValue() {
            return value;
        },
        setValue(newValue) {
            value = newValue;
            this.trigger('valueHasBeenChanged', value);
            return this;
        }
    });
}
```

##### Good
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

#### References
- [Coding guide: General rules](https://github.com/oat-sa/taohub-articles/blob/article/frontend-good-practices/articles/Frontend/Architecture/coding-guide.md#general-rules)
- [Events model](https://github.com/oat-sa/taohub-articles/blob/article/frontend-good-practices/articles/Frontend/Architecture/events-model.md)

### Use properly the event namespaces
The events model allows to add namespaces to scope events. However, there are
specificities for each events system. Usually namespaces are applied by the
event listeners, in order to group events under a same context, making it
easier to manage them, for instance to remove all events listen by a specific
component, and not the ones that are listen by the others.

Where this become a little more complex is when the namespace is applied upon
emitting the event. In the TAO implementation, so called the [eventifier](https://github.com/oat-sa/taohub-articles/blob/article/frontend-good-practices/articles/Frontend/Architecture/events-model.md),
when a namespace is applied upon emitting the event, only the listeners
registered under the same namespace will be triggered. And therefore, since
namespace cannot be chained, it is impossible to enforce the scope for those
particular events.

#### Bad
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
emitter.on('set.value', () => {});

// listen to the `set` event, all namespaces
emitter.on('set', () => {});

// listen to the `set` event, under the namespace `value.foo`
emitter.on('set.value.foo', () => {});
```

Only the listener bound to the exact namespaced event will be actioned. The non 
namespaced event will never get actioned. And the over namespaced listener as
well, but even with properly emitted event this listener will never be actioned.

Sometimes, however, for some edge case this pattern might be useful. But this
has to be motivated by a strong reason. 

#### Good
A better implemenation of the previous example might be:

```javascript
const emitter = eventifier({
    setValue(value) {
        this.trigger('setvalue', value);
    }
});

// listen to the `setvalue` event, under the namespace `foo`
emitter.on('setvalue.foo', () => {});

// listen to the `setvalue` event, all namespaces
emitter.on('setvalue', () => {});

// listen to the `setvalue` event, under the namespace `foo.bar`
emitter.on('setvalue.foo.bar', () => {});
```

Each listener applying to the `setvalue` event will get actioned. Except the
one that is over namespaced, as it will never match the namespace, by design.

#### References
- [Events model](https://github.com/oat-sa/taohub-articles/blob/article/frontend-good-practices/articles/Frontend/Architecture/events-model.md)

## Modules

### Be careful with module scope
Usually a module is loaded along with the page. And it will remain available till the page is closed.
That means every code that is contained at the root of the module will be executed upon loading.
For that reason code defined in the module must be static, and should not launch nor trigger any behavior, 
unless this is the bootstrap of the application.

Keep in mind that what is inside a module will be executed immediately, even if it is not needed.
And it will be executed only once for the whole application. Of course, the code inside the functions won't be
executed if the function is not invoked, but it will if the function is invoked from the root of the module.

That being said, we should consider the following:
- never trigger a process from the root of a module, since this process will start immediately, and will 

#### Example
##### Bad
##### Good

### Module scope vs factory scope
#### Example
##### Bad
##### Good

## Components

### Prefer events to callbacks
#### Example
##### Bad
##### Good

### Action events vs direct action
#### Example
##### Bad
##### Good
#### References
- [AOP: Aspect Oriented Programming](https://en.wikipedia.org/wiki/Aspect-oriented_programming)

### Prefer simplicity
When designing an API it might be temptating to offer several ways to perform an action. For instance give the ability to register events both from the config and by using explicit setter methods.
However, this introduces several issues:
- It adds unnecessary complexity, as it requires more code paths to implement the "features". 
- It makes the code harder to maintain, because of the increased complexity and also because of different coding flavours it might introduce.
- It introduces discrepancies in the use cases, some developers will favor one way over the other, and then the less used form might persist in a small part, making more difficult to refactor the code.
- It might enforce bad practices, like code coupling or other anti-patterns.   

#### Example
##### Bad
##### Good

## Testing

### Prefer design by coding: TDD / BDD
#### Example
##### Bad
##### Good
#### References
- [Design by Coding - YouTube video](https://www.youtube.com/watch?v=d5Y1B1cmaGQ)

### Add visual playground for UI parts
#### Example
##### Bad
##### Good

## Styling

### Use explicit class names
SASS and LESS are providing some useful shortcuts, but could also lead to 
unreadable and unmaintainable code. The parent selector (`&`) is a very useful 
tool, but it must be reserved to chain classes, not to build complex names.
Using the parent selector to build complex names prevents to retrieve easily 
the class names, and is hard to maintain as it introduces some mess in the code.  

#### Example

##### Bad
The following snippet shows how messy the code could be with a misuse of the 
parent selector. Can you quickly see what will be the outcome of that?

```scss
.sidebar {
    &-list {
        .node {
        }
    }
}
.dashboard-sidebar {
    &-collapse {
    }
    &.sidebar {
        &-open {
        }
    }
    &-open {
    }
    .filter-school {    
        &-container {
        }
        &-border {
        }
        
        &__error-message {
        }
    }
}
```

##### Good
A proper implementation, keeping the same class names, will be:

```scss
.sidebar-list {
    .node {
    }
}
.dashboard-sidebar-collapse {
}
.dashboard-sidebar-open {
}
.dashboard-sidebar {
    &.sidebar-open {
    }
    .filter-school-container {
    }
    .filter-school-border {
    }
    .filter-school-error-message {
    }
}
```

### Use dedicated class names
Always prefer specific and well defined class name to match a component part.
Using generic name could lead to conflicts as they could be broadly used for 
different purposes. Unless, of course, the intent is to have a generic behavior, 
like `disabled` or `hidden`. But when we talk about scope class, it is better
to rely on unique and self-explaining names. Please avoid also verbose styling, 
like Bootstrap use to do. This has the same downside as hardcoding the style 
within the markup. It couples hard meaning to the design, and this is not easy 
to to apply proper design later on. 

#### Example

##### Bad
This HTML markup makes use of redundant class name, in different context, 
making difficult to apply consistent rules. `dashboard-sidebar` should be the 
root class for the component, and in this context `container`, `root` and 
`list` are both useless and too generic as they could mean anything.

```html
<div class="dashboard-sidebar container">
    <div class="dashboard-sidebar root"></div>
    <div class="dashboard-sidebar list"></div>
</div>
```

##### Good
Here is a better solution, even if not the only one. `dashboard-sidebar` is the
root class that will define the main component style. `dashboard-sidebar-root` 
should define the style of the related part in the component, the same for 
`dashboard-sidebar-list`.
   
```html
<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-root"></div>
    <div class="dashboard-sidebar-list"></div>
</div>
```