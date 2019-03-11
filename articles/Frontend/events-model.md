# Events model
The events model is a powerful and straightforward way to communicate between
and inside components. This article will describe how the events model works on
our frontend application level implementation.

An event is a channel through what messages can be dispatched to several
endpoints at once. Components can use events to notify or to be notified, hence
they can be a good support for an extensive API, asynchronous by design.

Each event can be seen as a channel, being processed as a pipeline, containing
three steps: **before**, **main**, **after**. By design, the `main` step is the
one that is targeted by the default event listener API, the two others allowing
to prepend or append actions on the same event. In each step, as many as needed
listeners can be added, they will be called in serie. From each step, a listener
may interrupt the pipeline and prevents the remaining steps to be processed.
However, inside a step nothing ensures a particular listener can be prevented
nor a particular listener can be called before another particular one. Only the
remaining steps can be prevented, and the steps are the only way to ensure a
listener is called before or after another one. 

![events model](resources/events-model.png)

Events does not have to be registered prior being able to use them: an
*eventified* object can trigger any events, even if no *listener* is bound to
it, and a client can listen to any events, even if the listened to event is
never triggered. This way it is possible to extend the API without having to
change the signatures nor the implementation, as there is no fixed pool of
available events.

## eventifier API
The events manager engine is provided by a core module, called `eventifier`.
This is a mixin that will augment any target object with a set of API bringing
the ability to manage events.

To use the `eventifier`, simply import the module `core/eventifier`: 

```javascript
define(['core/eventifier'], function (eventifier) {

    // ...

});
```

To turn a given object into an event manager, simply apply the `eventifier`
factory on it:

```javascript
// apply the mixin on the "emitter" object
eventifier(emitter);
```

**Note**: the emitter object is returned by the factory, so it is possible to
create a new *eventified* object on the fly:

```javascript
// create an "emitter" object and apply the mixin on it
var emitter = eventifier({
    doSomething: function doSomething() {
        // ...
    } 
});
```

Then the events manager API is available on this object:

```javascript
// do something before the "message" event is processed
emitter.before('message', function(e, msg) {
    console.log('message to be processed:', msg);
    
    setTimeout(function() {
        console.log('This will be processed after the event...');
    }, 250);
    
    // remaining steps can be prevented synchronously
    if (someCondition) {
        return false;
    }
});
// listen to the "message" event
emitter.on('message', function(msg) {
    console.log('received message:', msg);
    
    // remaining steps can be prevented synchronously
    if (someCondition) {
        return false;
    }
});
// do something after the "message" event has been processed
emitter.after('message', function(msg) {
    console.log('processed message:', msg);
    
    // does nothing specifically, there is no step after this one
    return false;
});

// emit the "message" event
emitter.trigger('message', 'hello');
```

The event steps are ran linearly: firstly the `before` step, then the `main` and
finally the `after`. By default, the steps are synchronous, that means each step
much be completed before moving to the next, but if a listener needs to delay
some stuff, remaining listeners might be processed before this stuff is
completely processed. For this reason, asynchronous event listeners are also
supported: a listener can return a `Promise` to put the next event step on hold.

```javascript
// listen to the "message" event, but delay the "main" listener by 250ms
emitter.before('message', function(e, msg) {
    console.log('hold on received message:', msg);
    return new Promise(function(resolve, reject) {
        setTimeout(function() {
            // remaining steps can be prevented
            if (someCondition) {
                reject();
            } else {
                resolve();
            }
        }, 250);
    });
});

// listen to the "message" event, but delay the "after" listener by 100ms
// this listener should be delayed 250ms from the "before"
emitter.on('message', function(msg) {
    console.log('received message:', msg);
    return new Promise(function(resolve) {
        setTimeout(function() {
            // remaining steps can be prevented
            if (someCondition) {
                reject();
            } else {
                resolve();
            }
        }, 100);
    });
});

// listen to the "message" event, once all main listeners have been processed 
// this listener should be delayed 100ms from the "main" and at least 350ms from
// the "before"
emitter.after('message', function(msg) {
    console.log('processed message:', msg);
    
    // does nothing more than simply delay an action.
    // there is no step after this one, so it won't put the event on hold
    return new Promise(function(resolve, reject) {
        setTimeout(function() {
            // remaining steps can be prevented
            if (someCondition) {
                reject();
            } else {
                resolve();
            }
        }, 50);
    });
});

// emit the "message" event
emitter.trigger('message', 'hello');
```

The available API is described here.

### `trigger(event)`
Emits an event. All listeners registered for this event will be called. However,
if a namespace is used, only the listeners registered with this particular
namespace will be called. Several events can be emitted at the same time, 
simply separate each name with a space.

**Note**: the lexical scope of the listener will be bound to the emitter object.

```javascript
// emit click event, all listeners will be triggered
emitter.trigger('click');

// emit namespaced click event, only listeners registered under this particular
// namespace will be triggered
emitter.trigger('click.foo');

// emit several events at once, with or without namespace
emitter.trigger('show enable foo.bar');

// emit event with parameters
emitter.trigger('foo', param1, param2);
```

### `on(event, listener)`
Attaches a listener to an event. Calling `on` with the same event's name
multiple times add callbacks: they will all be executed. The event's name may be
namespaced, to ease the later management. It could also be a list of events,
separated by spaces, so the listener will called if any of the listed event is
emitted. A `Promise` can be returned, and then the listeners registered on the
`after` step will be delayed until the promise is resolved.

**Note**: the lexical scope of the listener will be bound to the emitter object.

```javascript
// listen to click event
emitter.on('click', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// listen to event with parameters
emitter.on('click', function(param1, param2) {
    // The lexical scope is bound to the emitter
    if (param1) {
        this.doSomething(param2);
    }
});

// listen to click event, scope the listener to a namespace
emitter.on('click.foo', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// listen to several events, with or without namespace
emitter.on('show enable foo.bar', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// synchronously break the events chain
emitter.on('click', function() {
    return false;
});

// hold the event chain (async mode)
emitter.on('click', function() {
    return new Promise(function(resolve, reject) {
        // continue to next step
        resolve();
        
        // break the events chain, prevent the remaining steps
        reject();
    });
});
```

### `off(event)`
Removes **all** listeners for an event. To reduce the scope of the removal, a
namespace can be used. If only the name is given, **all** listeners registered
under this namespace will be deleted.

```javascript
// remove all listeners bound to the click event
emitter.off('click');

// remove all listeners bound to the namespaced click event
emitter.off('click.foo');

// remove all listeners bound to any events with the .foo namespace
emitter.off('.foo');

// remove listeners for several events at once, with or without namespace
emitter.off('click show foo.bar');
```

### `removeAllListeners()`
Removes **all** registered listeners.

### `before(event, listener)`
Registers a callback that is executed before the given event name. That provides
the opportunity to cancel the execution of the event if one of the returned
value is false. A particular parameter is provided to each listener, on the
first position, to give the ability to enter in async mode. However, this is a
legacy feature, and returning a `Promise` should be preferred instead.

**Note**: the lexical scope of the listener will be set on the emitter object.
The `before` step has a particularity other steps don't have: an `event`
parameter is prepended to the arguments list. 

```javascript
// listen to click event
emitter.before('click', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// listen to event with parameters
emitter.before('click', function(e, param1, param2) {
    // The lexical scope is bound to the emitter
    if (param1) {
        this.doSomething(param2);
    }
});

// listen to click event, scope the listener to a namespace
emitter.before('click.foo', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// listen to several events, with or without namespace
emitter.before('show enable foo.bar', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// synchronously break the events chain
emitter.before('click', function() {
    return false;
});

// hold the event chain (async mode)
emitter.before('click', function() {
    return new Promise(function(resolve, reject) {
        // continue to next step
        resolve();
        
        // break the events chain, prevent the remaining steps
        reject();
    });
});
```

### `after(event, listener)`
Registers a callback that is executed after the given event name. All listeners
should be executed at this stage, as long as the previous steps were not
cancelled.

**Note**: the lexical scope of the listener will be set on the emitter object.

```javascript
// listen to click event
emitter.after('click', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// listen to event with parameters
emitter.after('click', function(param1, param2) {
    // The lexical scope is bound to the emitter
    if (param1) {
        this.doSomething(param2);
    }
});

// listen to click event, scope the listener to a namespace
emitter.after('click.foo', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// listen to several events, with or without namespace
emitter.after('show enable foo.bar', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});
```

### `stopEvent(name)`
If triggered into a sync listener, this immediately cancels the execution of all
following listeners regardless of their category. If triggered asynchronously,
this will only cancel the next category of listeners, in an async context, you 
can also reject a `Promise` with the same results:
- `.on()` and `.after()` if triggered during a `.before()` listener
- `.after()` if triggered during a `.on()` listener
- nothing if triggered during a `.after()` listener

```javascript
emitter.before('click', function(e) {
    // will prevent the next steps to be ran: "on" and "after"
    this.stopEvent(e.name);
});

emitter.on('click', function() {
    // will prevent the next steps to be ran: "after"
    this.stopEvent('click');
});

emitter.after('click', function() {
    // will do nothing
    this.stopEvent('click');
});
```

### `spread(destination, event)`
Spreads events to another `eventifier` object. So when an event is triggered on
the current target, it gets triggered on the destination too. Be careful, the
forward will be triggered only if the event reaches the `on` step (it can be 
canceled by a `before`).

```javascript
// listen to regular click event on targetEmitter
targetEmitter.on('click', function() {
    // The lexical scope is bound to the targetEmitter
    this.doSomething();
});

// listen to regular click event on emitter
emitter.on('click', function() {
    // The lexical scope is bound to the emitter
    this.doSomething();
});

// forward all click events to the targetEmitter
emitter.spread(targetEmitter, 'click');

// emit click event on both emitter and targetEmitter
emitter.trigger('click');

// emit click event only on targetEmitter
targetEmitter.trigger('click');
```
