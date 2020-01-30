<!--
authors:
    - "Jean-Sébastien Conan"
tags:
    Frontend Architecture:
        - "Good practices"
-->

# TAO Frontend Good Practices

## Components

> This document describes good practices regarding frontend components on Current Gen.

*Description* -
In order to prevent trivial issues due to bad design, this article will propose
a list of good practices to apply. For each presented situation an example will
be provided for both bad and good solutions, with some explanation around them.

*Disclaimer* -
Regarding the provided examples, in order to make them more readable, only the
addressed topic will be represented, and good practices unrelated with it might
not be always presented in the code. Please also keep in mind that the provided
examples are not final solutions, only illustrations.

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

#### Bad example: component that alter the surrounding
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
        .on('loaded', () => loadingBar.stop())
        .init(config);
}

// fake controller that use the component
function controller() {
    // instanciate and perform the action
    toolFactory('.markup').load();
}
```

#### Good example: notify the consumer of a responsibility
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
        })
        .init(config);
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

#### Resources
- [Component abstraction](component-abstraction.md)
- [Events model](events-model.md)

### Prefer events to callbacks
When it comes to add a subscription mechanism to a system performing asynchronous 
tasks, like a UI component, it might be obvious to rely on a simple callback. The 
subscriber registers a callback function to get notified when a process has been 
done. However, simple callback means only one subscriber at a time. If a second
subscriber wants to enter the party, it will either replace the already registered
subscriber, or will be rejected. This is not very convenient.

In the context of a system call, that is not shareable, it is legit to only have
one possible subscriber, like in the Node.js FileSystem API. But in the context
of components, this is too restrictive.

Eventually, a callback queue might be implemented to take care of *1-to-N* 
relationship. However, fortunately the component abstraction is built on top of 
the [`eventifier`](events-model.md), and therefore it offers a good support for 
an extensive API. The events manager allows a *1-to-N* relationship, which is 
pretty convenient for a component.

Thanks to the [`eventifier`](events-model.md), every component can emit events.
It is strongly recommended to rely on this ability, and the use of simple 
callbacks should be avoided.

#### Bad example: using callbacks
In the following example callbacks are offered to react on click. And as expected
only one subscriber can be registered. An additional flaw is presented here as
the callback can only be set upon creating the component instance. 

```javascript
/**
 * @param {Element|String} container
 * @param {Object} config
 * @param {String} label
 * @param {Function} onClick
 */
function buttonFactory(container, config) {
    return component()
        .setTemplate(buttonTpl)
        .on('init', function onInit() {
            if (container) {
                this.render(container);
            }           
        })
        .on('render', function onRender() {
            this.getElement().on('click', () => {
                if (this.getConfig().onClick) {
                    this.getConfig().onClick.call(this);
                }               
            });                 
        })
        .init(config);
}

// create a button, and bind a click callback
const button = buttonFactory('.fixture', {
    label: 'Ok', 
    onClick: () => console.log('ok')
});

// eventually, the click callback can be changed
button.getConfig().onClick = () => console.log('changed callback');

// unfortunately, we cannot register more than one callback
// the following will replace the callback once again
button.getConfig().onClick = () => alert('click');
```

#### Good example: rely on events model
Using simple callbacks reduces the extensibility, as it prevents to share the API 
among several consumers. A callback queue might be implemented, but this would be
useless since the [component abstraction](component-abstraction.md) already offers 
such a mechanism, thanks to the [`eventifier`](events-model.md).

```javascript
/**
 * @param {Element|String} container
 * @param {Object} config
 * @param {String} label
 * @fires click when the button is clicked
 */
function buttonFactory(container, config) {
    return component()
        .setTemplate(buttonTpl)
        .on('init', function onInit() {
            if (container) {
                this.render(container);
            }           
        })
        .on('render', function onRender() {
            this.getElement().on('click', () => {
                /**
                 * @event click
                 */
                this.trigger('click');
            });                 
        })
        .init(config);
}

// create a button, and bind to the click event
const button = buttonFactory('.fixture', {label: 'Ok'})
    .on('click', () => console.log('ok'));

// eventually, the click listener can be changed
button.off('click').on('click', () => console.log('changed callback'));

// and, we can register more than one listener
button.on('click', () => alert('click'));
```

#### Resources
- [Component abstraction](component-abstraction.md)
- [Events model](events-model.md)

### Action events vs direct action
When building a component, it can be handy to create dedicated API to perform
an action. For instance `activateTab()` to actually change the current tab on
a tabs manager. And then the method will directly perform the action, 
eventually emitting an event at some point to notify it.

Thanks to the [events model](events-model.md) we can also apply 
[Aspect Oriented Programming](https://en.wikipedia.org/wiki/Aspect-oriented_programming).
So instead of directly performing the action upon calling the method, we might
only emit the related event, then internally listen to this event to perform 
the action.

The benefit of such a practice is to allow to easily hook the action. Either
by binding on it an additional behavior, or by preventing the action to occur
if a particular condition is met. The side effect will be that the action will
be somehow deferred, since it will be performed when the event will be received.

However, this might not apply for every situation. To decide when use the
action event instead of direct action, ask yourself the question: 
"Can the consumer prevent or change the behavior?". So if you want to keep the 
implementation closed, then let's use the method. But if it can be changed,
prevented or hooked, then let's implement it in the handler.

Please also note that if this patterns offers obvious benefit, it also comes
with a downside, decreasing the readability as the action is now spread in
several places. 

#### Standard example: execute action when invoked
In the following example, a button directly activates a tab. 
 
```javascript
/**
 * @param {Element|String} container
 * @param {Object} config
 * @param {Object[]} config.tabs
 * @fires activate when the tab is activated
 */
function tabsFactory(container, config) {
    return component({
            activate(id) {
                // activate the tab
                this.getElement()
                    .find('[data-id]')
                    .removeClass('active')
                    .filter(`[data-id=${id}]`)
                    .addClass('active');
                
                /**
                 * @event activate
                 */
                this.trigger('activate');
            }
        })
        .setTemplate(tabsTpl)
        .on('init', function onInit() {
            if (container) {
                this.render(container);
            }           
        })
        .on('render', function onRender() {
            this.getElement().on('click', '[data-id]', e => {
                this.activate(e.currentTarget.dataset.id);
            });                 
        })
        .init(config);
}
```

Then the use of this component is as usual:

```javascript
const tabs = tabsFactory('.fixture', {
    tabs: [
        {id: 'tab1', label: 'Tab 1'},
        {id: 'tab2', label: 'Tab 2'}
    ] 
});

tabs.on('activate', id => console.log('tab activated', id));

// the action will be immediately performed
tabs.activate('tab2');
```

#### Improved example: defer the action to event
The previous example can be improved using action event instead of immediate 
action. The benefit being you can now prevent the tab to be activated.

However, please keep in mind this is not an universal solution. Depending on
what you intend it might not be the best approach. Once again, ask yourself
if the action can be prevented by the consumer. In many cases this is not
needed.
 
```javascript
/**
 * @param {Element|String} container
 * @param {Object} config
 * @param {Object[]} config.tabs
 * @fires activate when the tab is activated
 * @fires activated once the tab has been activated
 */
function tabsFactory(container, config) {
    return component({
            /**
             * Triggers a click action
             * @params {String} id
             * @fires activate
             */            
            activate(id) {
                /**
                 * @event activate
                 * @params {String} id
                 */
                this.trigger('activate', id);
            }
        })
        .setTemplate(tabsTpl)
        .on('init', function onInit() {
            if (container) {
                this.render(container);
            }           
        })
        .on('render', function onRender() {
            // the physical click on the button is forwarded to the API
            this.getElement().on('click', '[data-id]', e => {
                this.activate(e.currentTarget.dataset.id);
            });                 
        })
        // listen to the click event in order to actually perform the action 
        .on('activate', id => {
            // activate the tab
            this.getElement()
                .find('[data-id]')
                .removeClass('active')
                .filter(`[data-id=${id}]`)
                .addClass('active');

            /**
             * @event activated
             * @params {String} id
             */
            this.trigger('activated', id);
        })
        .init(config);
}
```

Then we can hook the `activate` action, preventing it to happen by 
rejecting the event *before* it is applied. Worth to mention, an 
additional event `activated` is emitted once the action has been performed. 
However, this is not required since the [AOP](https://en.wikipedia.org/wiki/Aspect-oriented_programming)
also offers a way to execute something *after* an event.

```javascript
const tabs = tabsFactory('.fixture', {
    tabs: [
        {id: 'tab1', label: 'Tab 1'},
        {id: 'tab2', label: 'Tab 2'}
    ] 
});

tabs.on('activate', id => console.log('tab being activated', id));
tabs.on('activated', id => console.log('tab has been activated', id));

// the action will be performed very soon
tabs.activate();
// the action might not be performed yet, but it will

// prevent the activate event to happen, the tab2 won't be activated
tabs.before('activate', (e, id) => {
    if (id === 'tab2') {
        return Promise.reject();
    }
})
// execute something once the action has been applied
tabs.after('activate', id => console.log('tab has been activated', id));

// the action will never be performed, since the before event step is rejecting it
tabs.activate('tab2');
// the activated event will never be emitted

// the action will be performed since the tab1 is not prevented
tabs.activate('tab1');
```

#### Resources
- [Component abstraction](component-abstraction.md)
- [Events model](events-model.md)
- [AOP: Aspect Oriented Programming](https://en.wikipedia.org/wiki/Aspect-oriented_programming)

### Prefer simplicity
When designing an API it might be temptating to offer several ways to perform 
an action. For instance give the ability to register events both from the 
config and by using explicit setter methods.

However, this introduces several issues:
- It adds unnecessary complexity, as it requires more code paths to implement 
the "features". 
- It makes the code harder to maintain, because of the increased complexity 
and also because of different coding flavours it might introduce.
- It introduces discrepancies in the use cases, some developers will favor one 
way over the other, and then the less used form might persist in a small part, 
making more difficult to refactor the code.
- It might enforce bad practices, like code coupling or other anti-patterns.   

#### Bad example: redundant API 
In the following example, both callback and events are offered to react to a 
button click. Even if the result looks the same, they are behaving exactly
identically, the callback being called after the event.

The API is redundant, and does not add any value.

```javascript
/**
 * @param {Element|String} container
 * @param {Object} config
 * @param {String} label
 * @param {Function} [onClick]
 * @fires click when the button is clicked
 */
function buttonFactory(container, config) {
    return component({
            click() {
                // performs some action
                activateSomething();
                
                /**
                 * @event click
                 */
                this.trigger('click');
            }
        })
        .setTemplate(buttonTpl)
        .on('init', function onInit() {
            if (container) {
                this.render(container);
            }           
        })
        .on('render', function onRender() {
            this.getElement().on('click', () => this.click());                 
        })
        .on('click', () => {
            if (this.getConfig().onClick) {
                this.getConfig().onClick.call(this);
            }   
        })
        .init(config);
}

// we may add a callback to listen to click
button('.fixture', {label: 'Ok', onClick: () => { ... }});

// or we may listen to an event for the same result
button('.fixture', {label: 'Ok'})
    .on('click', () => { ... });
```

#### Good example: one purpose API
In the previous example the API was redundant, and did not add any value. The
following snippet fix that by removing the useless API.

```javascript
/**
 * @param {Element|String} container
 * @param {Object} config
 * @param {String} label
 * @fires click when the button is clicked
 */
function buttonFactory(container, config) {
    return component({
            click() {
                // performs some action
                activateSomething();
                
                /**
                 * @event click
                 */
                this.trigger('click');
            }
        })
        .setTemplate(buttonTpl)
        .on('init', function onInit() {
            if (container) {
                this.render(container);
            }           
        })
        .on('render', function onRender() {
            this.getElement().on('click', () => this.click());                 
        })
        .init(config);
}

// Only a single way of reacting to click actions
button('.fixture', {label: 'Ok'})
    .on('click', () => { ... });
```

#### Resources
- [Coding guide: General rules](coding-guide.md#general-rules)
