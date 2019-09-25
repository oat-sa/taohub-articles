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
add nouns to complete the name: `setvalue`, `clearname`, `valuechange`.

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
The events model allows to add namespaces for purposes of scoping events.
However, each events system have its own specificities. Usually namespaces are 
applied by the event listeners, in order to group events under a same context, 
making it easier to manage them. For instance this give the ability to remove 
all events listened for a specific context, without altering other listeners.

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
has to be motivated by a strong reason. 

#### Good
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

#### References
- [Events model](https://github.com/oat-sa/taohub-articles/blob/article/frontend-good-practices/articles/Frontend/Architecture/events-model.md)

## Modules

### Be careful with module scope
Usually a module is loaded along with the page. Or later in case of lazy
loading. In all cases it will remain available till the page is closed. That 
means every code that is contained at the root of the module will be executed 
upon loading. For that reason code defined in the module must be static, and 
should not launch nor trigger any behavior, unless this is the bootstrap of the 
application, or unless this is a worker. Per definition, the purpose of a 
module is to define, scope, and provide features. But those features should not
be activated without need.  

Keep in mind that what is inside a module will be executed immediately, even if
it is not needed. And it will be executed only once for the whole application. 
Of course, the code inside the functions won't be executed without an explicit
call to them. But this will be the case if the function is invoked. And for 
instance this will occur if the function is immediately attached to an event.

Code executed in modules will slow down the loading process. And started 
processes will remain in memory till they are stopped and garbage collected.
Attaching an event listener upon loading, because it might serve a part of the 
application, is not a good habit as it will unnecessarily consume resources.
Especially if the launched process is only used by a component that might not
be enabled or activated. Or if the consumer will only be activated sparsely. 
In that case it is far better to start and stop the process when needed.  

That being said, we must generally consider the following:
- Avoid to directly execute code from a module, unless this is needed to build 
some structure and the code is fast enough to not have negative impact on the 
page bootstrap.
- Avoid to register events from the module, prefer to implement an API to start
and stop the event listening when needed.
- For workers or bootstrap modules, having auto executed code is legit.
- Registering adapters is also ok since the purpose is to load not to start a 
process.  

#### Example

##### Bad
In the following snippet, one is registering a listener on the resize event to 
take care of size concerned elements, and an API to add elements to resize is
offered. Beside the bad practice of registering a global event, the first issue 
is the event listener is not throttled, and therefore will have a huge impact 
on the performances since the `resize` event might be emitted thousands of 
times per minutes. The second issue is the event listener is registered even
if no consumer require it. And the third issue is the global event itself.
We must avoid to rely on global as must as possible, since they impact the
whole application. At least, when using them, the code must respect the life
cycle, and must offer way to activate/deactivate, especially when disposing
the consumer. 

```javascript
const elements = new Map();
window.addEventListener('resize', e => {
    elements.forEach(element => {
        // do something
    });
});
export function addResizeElement(element, id = null) {
    if (element instanceof Element) {
        elements.set(id || element.id, element);
    }
} 
```

##### Good
Having considered the need to rely on the `resize` event, a better approach
would be as exposed in the following snippet. Of course this is not the only
way to address the concern, especially as we did not motivate the need to
rely on the global event, and a better approach might be to not rely on it but
implement the feature using a proper pattern. The example is only there to 
illustrate the concept.

In this example one is exposing a factory to wrap the resize feature. Once
again, don't take it as a final solution, but as an illustration.

Beside the fact a factory is responsible to manage the access and the life 
cycle of the event listener, some high level API is also offered to work
directly with the default event context.

The important concept to pay attention to is the life cycle management. The 
global event listener is not immediately installed. The manager waits for an 
actual consumer to require the service before registering the event. And it 
will also free the resources if no more consumer is requiring the service.

Please also note the use of `lodash` to throttle the event, in order to
reduce the possible impact on performances. 

```javascript
export function resizeObserverFactory({context=window, throttle=50} = {}) {
    const elements = new Map();
    // throttle the callback, allowing only one call per period
    const observer = _.throttle(e => {
        elements.forEach(element => {
            // do something
        });
    }, throttle);
    let started = false;
    return {
        /**
         * Installs the event listener on the defined context
         */
        start() {
            if (!started) {
                context.addEventListener('resize', observer);
                started = true;   
            }
            return this;
        },
        /**
         * Removes the event listener from the defined context
         */
        stop() {
            if (started) {
                context.removeEventListener('resize', observer);
                started = stop;    
            }
            return this;
        },
        /**
         * Tells if the manager is observing the event.
         * @returns {Boolean}
         */
        running() {
            return started;
        },       
        /**
         * Checks if consumers are registered.
         * @returns {Boolean}
         */
        hasConsumers() {
            return !!elements.size;
        },
        /**
         * Registers an element to resize. The identifier might be overridden.
         * @param {Element} element
         * @param {String} id
         */ 
        register(element, id) {
            if (element instanceof Element) {
                elements.set(id || element.id, element);
    
                // make sure the listener is activated
                this.start();
            }
            return this;
        },
        /**
         * Unregisters an element to resize. The identifier might be overridden.
         * @param {String} id
         */
        unregister(id) {
            elements.delete(id);

            // dispose the event if no consumer is needing it
            if (!this.hasConsumers()) {
                this.stop();
            }
            return this;
        }
    };
}

// high level API, to illustrate the use case
let resizeObserver = null;
export function getResizeObserver() {
    if (!resizeObserver) {
        resizeObserver = resizeObserverFactory();
    }
    return resizeObserver;   
} 
export function addResizeElement(element, id = null) {
    getResizeObserver().register(element, id);
}
export function removeResizeElement(id) {
    const observer = getResizeObserver();
    observer.unregister(id);
    
    // free resources if no more consumer is registered
    if (!observer.hasConsumers()) {
        observer.stop();
        resizeObserver = null;
    }
}
```

#### References

### Module scope vs factory scope
A module is loaded along with the page, or later in case of lazy loading. 
In all cases it will remain available till the page is closed. And each
function within the module will have access to the module scope. To the same 
set of variables. They won't get duplicated. That means module variables will 
be shared across every module functions, and even if you create instances from
these functions, they will still access to the same unique dataset. If one is 
modifying the shared data, all others will benefit or suffer of that.

Modules must only contain static content, and the module scope variables must 
be immutable. Created instances must not alter the shared content. Some 
exceptions are allowed though, like for registry managers or system services,
but these cases are not frequent and must be considered as specific cases.

#### Example

##### Bad
If the following example a module variable is used to store a list of tabs. 
Then a factory is creating instances that will manage these tabs.

```javascript
import component from 'ui/component';
import tabsTpl from 'tpl/tabs';

// This variable will be shared for all instances
let tabs = [];

// This definition will also be shared across all instances. While this might 
// be ok as this looks like to be immutable, since this code is referring to 
// the module variable `tabs`, it will modify it.
const tabsApi = {
    setTabs(newTabs) {
        tabs = [...newTabs];
        return this;
    },
    getTabs() {
        return tabs;
    },
    activateTabByName(name) {
        const index = tabs.findIndex(t => t.name === name);
        return this.activateTabByIndex(index);
    },
    activateTabByIndex(index) {
        if (tabs[index]) {
            const name = tabs[index].name;
            tabs.forEach(tab => tab.active = false);
            tabs[index].active = true;
            this.getElement()
                .find('.active')
                .removeClass('active')
                .filter(`[data-id="${name}"]`)
                .addClass('active');
            this.trigger('tabactivate', index, name);
        }
        return this;
    }
};

// This factory will create different instances, all relying on the same API
// definition, but also relying on the exact same variable to store the data.
export function tabsFactory(container, config) {
    return component(tabsApi)
        .setTemplate(tabsTpl)
        .on('init', function() {
            if (container) {
                this.render(container);
            }
        })
        .on('render', function() {
            if (this.getConfig().tabs) {
                this.setTabs(this.getConfig().tabs);
            }
            this.trigger('ready');
        })
        .init(config);
}
```

Now please consider the following usages:
```javascript
import tabsFactory from 'ui/tabs';

const tabs1 = tabsFactory('.container1', {
    tabs: [
        {name: 't1', label: 'Tab1'}, 
        {name: 't2', label: 'Tab2'}
    ]
});

const tabs2 = tabsFactory('.container2', {
    tabs: [
        {name: 't3', label: 'Tab3'}, 
        {name: 't4', label: 'Tab4'}
    ]
});

// This will fail because the tab `t1` does not exist anymore,
// the shared tabs array has been overwritten by another dataset. 
tabs1.activateTabByName('t1');

// This might work, but the emitted name will be wrong: `t4` instead of `t2`. 
tabs1.activateTabByIndex(1);

// This will work however, since the list of tabs has been replaces by the set 
// of the second instance. But the select DOM element will have the id `t1`.
tabs1.activateTabByName('t3');

// And obviously the following line will work as expected since the instance is
// the most recent one and is working with the last dataset.
tabs2.activateTabByName('t3');
```

This kind of bad design should be prevented by proper unit tests, as different 
tests might conflict, or might work and fail in cycle. Unstable and inconsistent 
unit test executions are often the symptom of memory access conflict within 
factories.

##### Good
Respecting the concept of immutable module variables, the following 
implementation will offer a better solution.

The instances created by the factory will all get a dedicated context to store
the related data, without polluting possible other instances.

```javascript
import component from 'ui/component';
import tabsTpl from 'tpl/tabs';
export function tabsFactory(config) {
    // This variable is scoped and liked to the created instance. 
    // It won't be shared.
    let tabs = [];
    
    // Since this code is directly relying on the `tabs` variable, it cannot
    // be moved outside of the factory.
    const tabsApi = {
        setTabs(newTabs) {
            tabs = [...newTabs];
            return this;
        },
        getTabs() {
            return tabs;
        },
        activateTabByName(name) {
            const index = tabs.findIndex(t => t.name === name);
            return this.activateTabByIndex(index);
        },
        activateTabByIndex(index) {
            if (tabs[index]) {
                const name = tabs[index].name;
                tabs.forEach(tab => tab.active = false);
                tabs[index].active = true;
                this.getElement()
                    .find('.active')
                    .removeClass('active')
                    .filter(`[data-id="${name}"]`)
                    .addClass('active');
                this.trigger('tabactivate', index, name);
            }
            return this;
        }
    };
    return component(tabsApi)
        .setTemplate(tabsTpl)
        .on('init', function() {
            if (container) {
                this.render(container);
            }
        })
        .on('render', function() {
            if (this.getConfig().tabs) {
                this.setTabs(this.getConfig().tabs);
            }
            this.trigger('ready');
        })
        .init(config);
}
```

Then the following usages should be fine:
```javascript
import tabsFactory from 'ui/tabs';

const tabs1 = tabsFactory('.container1', {
    tabs: [
        {name: 't1', label: 'Tab1'}, 
        {name: 't2', label: 'Tab2'}
    ]
});

const tabs2 = tabsFactory('.container2', {
    tabs: [
        {name: 't3', label: 'Tab3'}, 
        {name: 't4', label: 'Tab4'}
    ]
});

// This will properly work without conflict, since the instances of the tabs
// component are correctly scoped. 
tabs1.activateTabByName('t1');

// Th tab `t2` will be activated, as expected. 
tabs1.activateTabByIndex(1);

// This won't work, the tab `t3` is not defined in the `tabs1` instance, and
// is not reachable.
tabs1.activateTabByName('t3');

// This will work as expected. The tab `t3` is part of the instance `tabs2`.
tabs2.activateTabByName('t3');
```

#### References

## Components

### Respect the separation of concerns and the atomicity principles
Component must follow the principle of separation of concerns. They must only
take care of the feature set they have to provide. They must also respect the
atomicity, and must not alter the surrounding nor alter the internals of 
embedded elements.

When a collaboration is required between components, a communication API must
be applied, without introducing any coupling. For instance, when a change is 
needed in the HTML markup of an associated component, no direct modification
must be applied, but instead a dedicated API must be invoked. If needed, such 
an API could be added and then utilized.

As other example, when an operation is required to be performed on higher level,
it is better to emit an event than relying on an hypothetical surrounding API or
adding arbitrarily other high level element. Then the responsibility will belong
to the container to take care of the notification or forward the information at 
higher level. This way the component is not introducing any coupling, and remain
able to work in any context. Components must be modular and pluggable.  

#### Example

##### Bad
In the following snippet the layout helper `loadingBar` is called from a component.
It might seem legit to apply such a practice, since the events `load` and `loaded`
are properly used to start and stop the loading bar. However, this introduces a
coupling with the layout. And therefore the component won't be able to work in a
context that does not provide a loading bar. A less evident flaw is this approach
will lead to concurrency issue if several components are calling the loading bar
at the same period, degrading the user experience as a process could still be
running.

```javascript
function toolFactory(container, config) {
    const api = {
        load() {
            this.trigger('load');
            dataProvider
                .getData()
                .then(data => this.trigger('loaded', data))
                .catch(err => this.trigger('error', err));
            return this;
        }
    };
    return component(api)
        .setTemplate(toolTpl)
        .on('init', function onInit() {
            if (container) {
                this.render('container');
            }
        })
        .on('render', function onRender() {
            // ...
        })
        // load and loaded events are used to action the layout helper 
        .on('load', () => loadingBar.start())
        .on('loaded', () => loadingBar.stop());
}

// fake controller that use the component
function controller() {
    // instanciate and perform the action
    toolFactory('.markup').load();
}
```

##### Good
The appropriate approach is to only provide the API from the component, then
transfer the responsibility to the controller that will manage the component
and pipe the events.

```javascript
function toolFactory(container, config) {
    const api = {
        load() {
            this.trigger('load');
            dataProvider
                .getData()
                .then(data => this.trigger('loaded', data))
                .catch(err => this.trigger('error', err));
            return this;
        }
    };
    return component(api)
        .setTemplate(toolTpl)
        .on('init', function onInit() {
            if (container) {
                this.render('container');
            }
        })
        .on('render', function onRender() {
            // ...
        });
}

// fake controller that use the component
function controller() {
    toolFactory('.markup')
        // the controller pipe the component API with the loading bar 
        .on('load', () => loadingBar.start())
        .on('loaded', () => loadingBar.stop())
        // still perform the action
        .load();
}
```

#### References

### Prefer events to callbacks

#### Example

##### Bad
```javascript

```

##### Good
```javascript

```

#### References

### Action events vs direct action

#### Example

##### Bad
```javascript

```

##### Good
```javascript

```

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
```javascript

```

##### Good
```javascript

```

#### References

## Testing

### Prefer design by coding: TDD / BDD

#### Example

##### Bad
```javascript

```

##### Good
```javascript

```

#### References
- [Design by Coding - YouTube video](https://www.youtube.com/watch?v=d5Y1B1cmaGQ)

### Properly scope test fixtures

#### Example

##### Bad
```javascript

```

##### Good
```javascript

```

#### References

### Add visual playground for UI parts

#### Example

##### Bad
```javascript

```

##### Good
```javascript

```

#### References

## Styling

### Use explicit class names
SASS and LESS are providing some useful shortcuts, but could also lead to 
unreadable and unmaintainable code. The parent selector (`&`) is a very useful 
tool, but it must be reserved to chain classes, not to build complex names.
Using the parent selector to build complex names prevents to retrieve easily 
the class names. This is hard to maintain as it introduces some mess in the 
code.  

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
to apply proper design later on. 

#### Example

##### Bad
This HTML markup makes use of redundant class name, in different context, 
making difficult to apply consistent rules. `dashboard-sidebar` should be the 
root class for the component, and in this context `container`, `root` and `list` 
are both useless and too generic as they could mean anything. Please also not 
the misuse of class names with `wide-margin`, `align-left`, and `align-right`,
that all are related to enforcing style. A better approach would have been to
rely on a single class name to apply the expected style. 

```html
<div class="dashboard-sidebar container wide-margin">
    <div class="dashboard-sidebar root align-left"></div>
    <div class="dashboard-sidebar list align-right"></div>
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