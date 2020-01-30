<!--
authors:
    - "Jean-Sébastien Conan"
tags:
    Frontend Architecture:
        - "Good practices"
-->

## Modules

> This document describes good practices regarding frontend modules.

*Description* -
In order to prevent trivial issues due to bad design, this article will propose
a list of good practices to apply. For each presented situation an example will
be provided for both bad and good solutions, with some explanation around them.

*Disclaimer* -
Regarding the provided examples, in order to make them more readable, only the
addressed topic will be represented, and good practices unrelated with it might
not be always presented in the code. Please also keep in mind that the provided
examples are not final solutions, only illustrations.

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

#### Bad example: immediate registration of heavy process
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

#### Good example: on demand heavy process
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

#### Bad example: unexpected sharing of variable across instances
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

#### Good example: proper wrapping of instance state
Respecting the concept of immutable module variables, the following 
implementation will offer a better solution.

The factory function scopes the variables managed by the created instance, and
each instance will have a dedicated and separated context. Only static content
is shared across instances, like the component factory and the layout template.

When an instance modifies the `tabs` variable, it doesn't interfere with `tabs`
variable attached to another instance. 

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

#### Resources
- [Component abstraction](component-abstraction.md)
