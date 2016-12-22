<!--
created_at: '2013-11-20 10:51:43'
updated_at: '2013-11-20 10:51:43'
authors:
    - 'Joel Bout'
tags:
    - 'Tao 25 Delivery model'
-->

Service call
============

May also be referred to as “Call of Service”.

Service calls are used within the [[Tao 2.5 Delivery model]] and the [[Workflow Engine]]. They represent the actual activity that we want to launch and contain the information what service should be called and with which parameters.

Service
-------

Services within Tao are a simplified form of web services (http://en.wikipedia.org/wiki/Web\_service), insofar as they assume that the called service either resides within Tao and shares its user session or assumes that is a REST service that does not require authentication.

The service consists of:

-   the **URL** to be called
-   the definition of the **In Parameters**
-   the definition of the **Out Parameters**

Call Parameters
---------------

The **values** that should be associated to the In-Parameters of the service for a particular service call.

In addition to the specified parameters, the caller must also provide a **serviceCallId** at runtime. This identifier allows the caller to associate responses of the service to the corresponding service call and it allows the called service to identify service calls that have already been initialized (for example a test-taker returning to an item he has already responded to).

Service call
============

May also be referred to as “Call of Service”.

Service calls are used within the [[Tao 2.5 Delivery model]] and the [[Workflow Engine]]. They represent the actual activity that we want to launch and contain the information what service should be called and with which parameters.

Service
-------

Services within Tao are a simplified form of web services (http://en.wikipedia.org/wiki/Web\_service), insofar as they assume that the called service either resides within Tao and shares its user session or assumes that is a REST service that does not require authentication.

The service consists of:

-   the **URL** to be called
-   the definition of the **In Parameters**
-   the definition of the **Out Parameters**

Call Parameters
---------------

The **values** that should be associated to the In-Parameters of the service for a particular service call.

In addition to the specified parameters, the caller must also provide a **serviceCallId** at runtime. This identifier allows the caller to associate responses of the service to the corresponding service call and it allows the called service to identify service calls that have already been initialized (for example a test-taker returning to an item he has already responded to).


