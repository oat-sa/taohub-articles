<!--
parent:
    title: Open_web_item
author:
    - 'Joel Bout'
created_at: '2013-10-18 11:12:24'
updated_at: '2014-09-11 14:49:21'
tags:
    - 'Open web item'
-->

{{\>toc}}

Item API
========

**This API is available since *TAO 2.5*. Previous versions are still supported but deprecated.**\
**This API is intended to evolve in a further release.**

Getting Started
---------------

Download either a full [HTML5 stub](http://forge.taotesting.com/attachments/download/2633/owi-stub.zip) or only the [Item API stub](http://forge.taotesting.com/attachments/download/2637/taoItemApi-stub.js) .

The stub or the injected API will look for a global function (in the `window` scope) named `onItemApiReady`. This function will gives you an instance of the `ItemApi` implementation you can use to connect your item with TAO:

    window.onItemApiReady = function(itemApi){
        //itemApi.saveScores({'SCORE' : 200});
    }

API Documentation
-----------------

### SaveResponses

    /**
     * Save test taker's responses
     * @param {Object} responses - key/value plain object
     */
    void : ItemApi.saveResponses(responses)

Example:

    window.onItemApiReady = function(itemApi){
        itemApi.saveResponses({
            'QUESTION_1' : false,
            'QUESTION_2' : 'foo'
        });

        //later
        itemApi.saveResponses({'QUESTION_3': 'bar'});
    }

### SaveScores

    /**
     * Save test taker's scores
     * @param {Object} scores - key/value plain object
     */
    void : ItemApi.saveScores(scores)

Example:

    window.onItemApiReady = function(itemApi){
        itemApi.saveScores({
            'SCORE_1' : 0,
            'SCORE_2' : 10
        });

        //later
        itemApi.saveScores({'FINAL': 6.25});
    }

### BeforeFinish

    /**
     * Add a callback to be executed in stack before the finish
     * @param {Function} callback - with no parameter
     */
    void : ItemApi.beforeFinish(callback)

Example:

    window.onItemApiReady = function(itemApi){

        itemApi.beforeFinish(function(){
            alert('3');
        });

        itemApi.beforeFinish(function(){
            alert('2');
        });

        itemApi.beforeFinish(function(){
            alert('1');
        });

        itemApi.beforeFinish(function(){
            alert('Finished);
        });
    }

### Finish

    /**
     * Flag the item as finish 
     */
    void : ItemApi.finish()

Example:

    window.onItemApiReady = function(itemApi){
        itemApi.finish();
        //nothing after
    }

### SetVariable

    /**
     * Store variable (not persistant)
     * @param {string} key
     * @param {string|number|Object|Array} value
     */
    void : ItemApi.setVariable(key, value)

Example:

    window.onItemApiReady = function(itemApi){
        itemApi.setVariable('answer1-time', 15);

        //...

        itemApi.setVariable('answer2-time', 58);
    }

### GetVariable

    /**
     * Get a stored variable
     * @param {string} key
     * @param {function} callback - as callback(value)
     */
    void : ItemApi.getVariable (key, callback)

Example:

    window.onItemApiReady = function(itemApi){
        itemApi.getVariable('answer1-time', function(value){
            alert('You have spend ' + value + ' seconds in question 1');
        });
    }

### TraceEvents

    /**
     * Log events
     * @param {Object} events
     */
    void : ItemApi.traceEvents(events)

Example:

    window.onItemApiReady = function(itemApi){
        itemApi.traceEvents({
            'AREA_hover_1': {x: 25, y: 43},
            'AREA_hover_2' : {x: 26, y: 40},
            'AREA_hover_3' : {x: 27, y: 38}
        });
    }
