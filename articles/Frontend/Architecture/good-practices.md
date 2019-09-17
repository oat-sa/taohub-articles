<!--
authors:
    - "Jean-Sébastien Conan"
tags:
    Frontend Architecture:
        - "Good practices"
-->

# TAO Frontend Good Practices

> This document describes frontend good practices.

In order to prevent trivial issues due to bad design, this article will propose a list of good practices to apply. For each presented situation an example will be provided for both bad and good solution, with some explanation around them.

## Code writing

### Please always document your code

Always document you code, using JSDoc. If too many comments could lead to unreadable code, too few or missing comments will surely reduce the readability as well.

Code might be self explanatory, if well written. But exposed code should at least precise the intent and should describe the income and the outcome.

Every function should have a proper JSDoc block, declaring the expected parameter and the possible return values. Emitted events and thrown errors should also be described. For complex datasets, a type definition should describe them. A code snippet could be presented as well.

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
The JSDoc annotations helps to quickly have some insights on what the code is intended for.

```javascript
/**
 * The doItAll factory let's you process an action through a simple API.
 *
 * @author John Smith <js@taotesting.com>
 */

/**
 * @typedef {Object} doItAllConfig
 * @property {Number} polling - Allow to run the action at a regular interval, given in milliseconds. O will disable the feature.
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
 * @param {doItAllConfig} config
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
         * Starts the process. If the polling is enabled, the action will be triggered every period of time.
         * Otherwise the action will be executed once.
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
https://jsdoc.app/


### Choose short and self explaining names
#### Example
##### Bad
##### Good

### Use verbs to name events
#### Example
##### Bad
##### Good

## Modules

### Be careful with module scope
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

### Prefer simplicity
#### Example
##### Bad
##### Good

## Testing

### Prefer design by coding: TDD / BDD
#### Example
##### Bad
##### Good

### Add visual playground for UI parts
#### Example
##### Bad
##### Good

## Styling

### Use explicit class names
#### Example
##### Bad
##### Good

### Use dedicated class names
#### Example
##### Bad
##### Good
