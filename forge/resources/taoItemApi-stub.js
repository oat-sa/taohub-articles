/*  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2009-2012 (original work) Public Research Centre Henri Tudor (under the project TAO-SUSTAIN & TAO-DEV);
 *               2009-2012 (update and modification) Public Research Centre Henri Tudor (under the project TAO-SUSTAIN & TAO-DEV);
 * 
 */

/**
 * The ConsoleItemApi is a basic implementation of the Item API you can use during your development
 * @author Bertrand Chevrier <bertrand@taotesting.com>
 */

/**
 * @constructor
 * @augments ItemApi
 * @returns {ConsoleItemApi}
 */
function ConsoleItemApi() {
    this.responses = {};
    this.scores = {};
    this.store = {};
    this.before = [];
};

/**
 * Connect the API to the onItemApiReady function
 */
ConsoleItemApi.prototype.connect = function(){
    var ready = window.onItemApiReady;
    if (typeof(ready) === "function") {
        ready(this);
    }
};

/**
 * Save test taker's responses
 * @param {Object} responses
 */
ConsoleItemApi.prototype.saveResponses = function(responses){
    for(var key in responses){
        this.responses[key] = responses[key];
    }
};

/**
 * Log events
 * @param {Object} events
 */
ConsoleItemApi.prototype.traceEvents = function(events){
    for(var key in events){
        console.log("Event [%s] : %s", key, events[key]);
    }
};

/**
 * Add a callback to be executed in stack before the finish
 * @param {function} callback
 */
ConsoleItemApi.prototype.beforeFinish = function(callback){
    if(typeof callback === 'function'){
	this.before.push(callback);
    }
};

/**
 * Save test taker's scores
 * @param {Object} scores
 */
ConsoleItemApi.prototype.saveScores = function(scores){
    for (var key in scores) {
        this.scores[key] = scores[key];
    }
};

/**
 * Store variable (not persistant)
 * @param {string} key
 * @param {string|number|Object|Array} value
 */
ConsoleItemApi.prototype.setVariable = function(key, value){
    this.store[key] = value;
};

/**
 * Get a stored variable
 * @param {string} key
 * @param {function} callback - as callback(value)
 */
ConsoleItemApi.prototype.getVariable = function(key, callback){
     if(typeof callback === 'function'){
        return callback(this.store[key]);
     }
     return this.store[key];
};

/**
 * Flag the item as finish 
 */
ConsoleItemApi.prototype.finish = function(){
    this.before.forEach(function(callback){
        if (typeof callback === 'function') {
            return callback();
        }
    });
    console.log("Responses : %s",  JSON.stringify(this.responses));
    console.log("Scores : %s",  JSON.stringify(this.scores));
};

/*
 * Stub added
 */
if(window.ItemServiceImpl === undefined && window.ItemApi === undefined){
	var consoleApi = new ConsoleItemApi()
	consoleApi.connect();
}

