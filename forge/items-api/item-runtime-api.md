<!--
parent:
    title: 'Items''_API'
author:
    - 'Joel Bout'
created_at: '2011-03-04 11:30:38'
updated_at: '2014-03-07 13:51:48'
tags:
    - 'Items'' API'
-->

![](http://forge.taotesting.com/attachments/download/760/attention.png)**This page is deprecated since TAO 2.5 please visit [[Item API]]**

Item Runtime API
================

{{\>toc}}

Download
--------

You can either:

-   \*download the TAO API standalone package [here](http://forge.taotesting.com/attachments/507/itemRuntimeApi.zip*)
-   use the version included in the TAO distribution at */taoItems/views/js/taoApi*

Description
-----------

The **taoApi** provides the following services:

\* Set and get pre-defined variables. These variables are then used in the TAO platform, like the `setScore` , `getSubjectLogin` or `setAnsweredValues` functions.\
 \* Set and get your variables using the `set/getUserVar` function\
 \* Communicate with a server-side platform. You can retrieve data from a server-side platform and push the collected data. By default, the API is connected to TAO, using authentication by token.\
 \* Trace the events. Each action made by the user (clicks, mouse move, entered text, etc.) can be logged by the API and sent to the server-side platform.\
 \* Trigger custom events. You can define your own events that will be traced like a common event. The custom events can be related to the item content. For example, in a math item you can trigger a *resolve equation* event when the user resolve an equation.\
 \* Define what should be done when the item is finished.\
 \* Say that the item is finished.

Example
-------

The following example is provided with the API, under the *examples* folder. We are going to understand it.




        TAO Api: an example of a synchronized remote data source configuration
        
        
        
        

        initDataSource({type: 'sync'}, null);

        initPush(null, {'async' : true});

        $(document).ready(function(){

            $("#header").text("Hello " + getSubjectName());

            $("#next").click(function(){
                setAnsweredValues($('#answer').val());
                if($('#answer').val() == ''){
                    setEndorsment(false);
                    setScore(0);
                }
                else{
                    setEndorsment(true);
                    setScore(1);
                }
                return push();
            });
        }); 
        


        
        
            AN ITEM
            Please enter something : 
        
        

How it works?

1.  We include the JQuery because, the API and the example use it for the DOM manipulation.
2.  We include the API minimified file.
3.  There is to fields in the body of the page: a text field *answer* and a button *next*
4.  Inside the script tag:
    -   We initialize the connections to be synchronous: `initDataSource` will retrieve the data from the server. So we want to continue only once the data are there. Particularly to get the name of the test taker and to write it in the header: `getSubjectName()` , line 16. We initialize also the `push` to be synchronous, in order to know if the data has been pushed.
    -   With JQuery we bind a click listener on the next button. Once the button is clicked, we take the value of the field and save it as it is: `setAnsweredValues($('#answer').val());`
    -   Then if the value is empty, the test taker has wrong and it’s score is 0. If he has entered something, it’s score is 1: line 20 to 27.
    -   The last step, we send all the collected data to the server: the answered value, the score and the endorsement. By calling the `push()` method manually, and because it has be defined synchronously: once the data is sent or not it returns true or false to the button (if true the button could go to the next item).

Create your item in TAO with the Item Runtime API
-------------------------------------------------

To learn how you can create your own application/item with this item runtime API, then import and execute it in TAO, see [[Free Form Items\#TAO Item Runtime API integration|the Open Web Item wiki page]].

Further documentation on the Item Runtime API
---------------------------------------------

All the functions are described in the [Javascript documentation](http://forge.tao.lu/docs/jsdoc/taoApi/index.html). Check it out to know precisely what are the parameters and options to use.

The interface below outlines the available methods:

**Function to get or set the item related data:**

    /**
     * Get the endorsment of the item
     */
    function getEndorsment();

    /**
     * Set the endorsment of the item
     */
    function setEndorsment(endorsment);

    /**
     * Get the score of the item 
     */
    function getScore();

    /**
     * Set the final score of the item
     */
    function setScore(score);

    /**
     * get the score range if defined
     */
    function getScoreRange();

    /**
     * Set the score range. 
     * It will be used to calculate the endorsment from the score.
     */
    function setScoreRange(max, min);

    /**
     * Get the values answered by the subject 
     */
    function getAnsweredValues();

    /**
     * Set the values answered by the subject.
     * If the item contains a free text field, 
     * you can record here the complete response. 
     */

    function setAnsweredValues(values);
    /**
     * Get the data of the user currently doing the item  (the subject)
     */
    function getSubject();

    /**
     * Get the login of the subject
     */
    function getSubjectLogin();

    /**
     * Get the name of the subject (firstname and lastname)
     */
    function getSubjectName();

    /**
     * Get the current item's informations 
     */
    function getItem();


    /**
     * Get the informations of the currently running test 
     */
    function getTest();

    /**
     * Get the informations of the current delivery
     */
    function getDelivery();

**Functions to get or set custom variables:**

    /**
     * This function enables you to create and edit custom variables: the user's variables
     * The variable is identified by a key you have chosen.
     * This variable will be saved temporarly into the taoApi.
     * When you call the push() function, the user's variables are sent to the server.
     * It's a way to record some data other than the results and the events.
     */
    function setUserVar(key, value);

    /**
     * Get a previously defined user's variable.
     */
    function getUserVar(key);

**Functions to drive the item’s state:**


    /**
     * Define the item's state as finished.
     * This state can have some consequences.
     */
    function finish();

    /**
     * Add a callback that will be executed on finish state.
     */
    function onFinish(callback);

    /**
     * Add a callback that will be executed on finish but before the other callbacks  
     */
    function beforeFinish(callback);

    /**
     * Add a callback that will be executed on finish but after the other callbacks  
     */
    function afterFinish(callback);

**Communication functions:**


    /**
     * Get the communication token (this token is sent at each communication)
     * 
     * @function
     * @returns {String} the token
     */
    function getToken();

    /**
     * This function enables you to set up the data the item need.
     * You can retrieve this data from either a remote or a manual source.
     * If you don't need to change the default values, don't call this function.
     */
    function initDataSource(environment, settings);

    /**
     * This function is a convenience method to add directly the datasource 
     * by writing the data in the source object (JSON) .
     */
    function initManualDataSource(source);


    /**
     * Initialize the push communication.
     * If you don't need to change the default values, don't call this function.
     */
    function initPush(environment, settings);


    /**
     * This method enables you to push the data to the server.
     */
    function push();

**Event logging functions:**


    /**
    * Log the an eventType bound on elementName by sending the data
    */
    function logEvent(elementName, eventType, data);

    /**
    * Log the a eventName by sending the data
    */
    function logCustomEvent(eventName, data);

    /**
     * Initialize the interfaces communication for the events logging.
     * The source service defines where and how we retrieve the list of events to catch
     * The destination service defines where and how we send the catched events 
     */
    function initEventServices(source, destination);

![](http://forge.taotesting.com/attachments/download/215/returnTopArrow.JPG)[[Item\_Runtime\_API|Return to Top]]

