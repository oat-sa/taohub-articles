<!--
parent:
    title: Documentation_for_core_components
author:
    - 'Jérôme Bogaerts'
created_at: '2012-02-20 11:08:29'
updated_at: '2013-03-13 12:57:53'
tags:
    - 'Documentation for core components'
-->

Client/Server communication
===========================

{{\>toc}}

An unified mechanism
--------------------

In order to make the communication between the client & the server consistent TAO platform provides to the developer an unified mechanism. By centralizing and make the mechanism homogeneous, TAO :

-   Controls communication between the client and the server in a unique point ;
-   Make the management of errors by its clients more easily ;
-   Allow developers to adapt behavior of all exchanges ;

![](http://forge.taotesting.com/attachments/1233/Tao_client_server_communication.png)

*A unit test can be found in /tao/test/AjaxWrapperTestCase.php*

Client/Server communication components
--------------------------------------

The mechanism is composed by the following components :

-   An Ajax Wrapper (Client)
-   A common Ajax Response (Server)

### Ajax Wrapper

The ajax wrapper is located in the meta extension TAO (/tao/views/js/tao.ajaxWrapper.js).\
It is based on the *ajax* function of the library [jQuery](http://jquery.com)

**Methods**

|*.Method name|*.Parameters|\_.Description|\
|**ajax**|(array) **options** Array of options\
(function) **options.success** The success callback function\
(function) **options.error** The error callback function which is called if : the call failed; the server generate an exception; the server return a success=false|The ajax method is an overloading of the jQuery ajax function, this function get the same options than the original one. To get more information take a look to the following documentation http://api.jquery.com/jQuery.ajax\
This overloading makes homogeneous exchanges between the client and the server.\
The behavior of its parent function has been adapted to control every exchanges between the client and the server and so it allows :\
- to intercept server exceptions ;\
- to manage under control errors ;|\
|**addSuccessCallback**|(function) **fct** The default success callback to add\
(string) **position** The position to add the function in the queue of callback success functions (‘begin’, ‘end’, integer to represent the position)|Add a default success callback. This success callback will be called after each successfull ajax requests|\
|**removeSuccessCallback**|(string) **position** The position of the function to remove|Remove a default success callback function|\
|**addErrorCallback**|(function) **fct** The default error callback to add\
(string) **position** The position to add the function in the queue of callback error functions (‘begin’, ‘end’, integer to represent the position)|Add a default error callback. This success callback will be called after each ajax requests which encoutered a problem|\
|**removeErrorCallback**|(string) **position** The position of the function to remove|Remove a default error callback function|

### Common Ajax Response

The common ajax response is located in the class **common\_AjaxResponse**. It ensures the homogeneity of the communication from the server to the client.

**Methods**

|*.Method name|*.Parameters|\_.Description|\
|**\_\_construct**|(array) **options** Array of options\
(boolean) **options.success** The request has been a success (by default true)\
(string) **options.type** The type of return (‘json’, ‘exception’) (by default json)\
(mixed) **options.data** The return of the request (by default null)\
(string) **options.message** The message attached to the return (by default an empty string)|The constructor of the common\_AjaxResponse. It builds and it displays the output|

By default the common\_AjaxResponse object returns a message :

    {"success":true,"type":"json","message":"","data":null}

TAO Exceptions control mechanism
--------------------------------

With this tool, TAO is able to control its executed code. So when the server encounter a problem, the TAO platform is able to communicate with its client code with an unified mechanism.

*The control is done in the TAO bootstrap*

    try{
        //Execute the controler code
        $this->mvc();
    }
    //If an exception is released
    catch(Exception $e){
        //If the request is an ajax request, deliver a common_AjaxResponse to the client script
        if(tao_helpers_Request::isAjax()){
            new common_AjaxResponse(array(
                "success"   => false
                , "type"    => 'Exception'
                , "data"    => array('ExceptionType' => get_class($exception))
                , "message" => $exception->getMessage()
            ));
        }
        //Else log the not catched exception and continue the execution
        else{
            common_Logger::notCatchedException($exception);
            throw $exception;
        };
    }

Examples
--------

### Make a classic ajax request

**client**

    tao.ajaxWrapper.ajax({
        'url' : 'http://www.tao.lu/tao/Main/isReady'
        , type: 'GET'
        ,'success' : function(data, result){
            //the system is ready
        }
        ,'error' : function(result){
            //the system is not ready
        }
    });

**server return**\
if the server is ready it will return the following message

    {"success":true,"type":"json","message":"","data":null}
