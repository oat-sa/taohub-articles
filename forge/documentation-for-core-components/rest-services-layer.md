<!--
parent:
    title: Documentation_for_core_components
author:
    - 'Patrick Plichart'
created_at: '2013-08-29 09:35:35'
updated_at: '2014-07-31 13:09:49'
tags:
    - 'Documentation for core components'
-->

Rest Services Layer (\>= TAO 2.5)
=================================

A tutorial demonstrating a few examples is available here: (Test takers) [[Rest]] and (Results) [[RestResults]]

List of available rest controllers
----------------------------------

-   http://foo/taoSubjects/RestSubjects
-   http://foo/taoGroups/RestGroups
-   http://foo/taoTests/RestTests
-   http://foo/taoItems/RestItems
-   http://foo/taoItems/RestResults
-   http://foo/taoResultServer/RestResultServer

Authentification methods
------------------------

-   HTTP/Basic

Digest and Oauth authentification methods support is planned

Supported HTTP methods
----------------------

-   GET
-   POST
-   PUT
-   DELETE

Supported Accept encodings
--------------------------

-   Accept: application/json
-   Accept: application/xml

Supported default headers
-------------------------

Generic headers aliases:

-   uri
-   label
-   comment
-   type

Generic headers<br/>
By default you may refer to any attribute of the target resource type using header with the uri reference :<br/>

“http://tao-dev/taodev.rdf\#i1372429454323825” : “35”

Specific header aliases<br/>
Specific header aliases may be supported on extension basis, example :

-   “login”
-   “password”
-   “guiLg”
-   “dataLg”
-   “firstName”
-   “mail”

<!-- -->

-   “member”
-   “model”

…

Header parameters requirements
------------------------------

Depending on the type of operation and the type of target resource types, some requirements may apply. In this case , a message is returned according to the requested encoding (JSON/XML) with a message information

Returned types and exception handling
-------------------------------------

Depending on the type of operation and the type of target resource types,<br/>

a message is always returned using the requested encoding with a status information and a message :<br/>

example in XML :



     
    true
     
    http://tao-dev/taodev.rdf#i13777687654193852


    core_kernel_persistence_smoothsql_Class::createInstanceWithProperties
     
    2.5-alpha
      

example in JSON:


    {
    success: false
    errorCode: 0
    errorMsg: "One of the precondition for this type of request was not satisfied"
    version: "2.5-alpha"
    }

HTTP error codes are used along the returned message

-   400
-   401
-   412
-   406
-   404
-   403
-   200
-   204

Building your own controller for your own extension
---------------------------------------------------

You may extend the tao\_actions\_CommonRestModule and override

-   getParametersAliases()<br/>
    example : return array\_merge(parent::getParametersAliases(), array(<br/>
     “login”=\> PROPERTY\_USER\_LOGIN,<br/>

     “password” =\> PROPERTY\_USER\_PASSWORD,<br/>

     “guiLg” =\> PROPERTY\_USER\_UILG,<br/>

     “dataLg” =\> PROPERTY\_USER\_DEFLG,<br/>

     “firstName”=\> PROPERTY\_USER\_LASTNAME,<br/>

     “mail”=\> PROPERTY\_USER\_MAIL,<br/>

     “type”=\> RDF\_TYPE<br/>
     ));
-   getParametersRequirements()

example :<br/>

return array(<br/>
 /\*\* you may use either the alias or the uri, if the parameter identifier<br/>
 \* is set it will become mandatory for the operation in \$key<br/>
 \* Default Parameters Requirents are applied<br/>
 \* type by default is not required and the root class type is applied<br/>
 \*/<br/>
 “post”=\> array(“login”, “password”)<br/>
 );<br/>

This abstract controller will handle for you

-   the http request and trigger the correct service from your implementation of service set up in<br/>
    \$this-\>service = taoSubjects\_models\_classes\_CrudSubjectsService::singleton();
-   Authentification
-   parameters check, ACL controls
-   Encoding of the returned Data
-   exception handling

Examples
--------