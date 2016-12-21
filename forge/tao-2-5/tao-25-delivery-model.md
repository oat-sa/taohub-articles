<!--
parent:
    title: TAO_2_5
author:
    - 'Cyril Hazotte'
created_at: '2013-11-19 14:25:07'
updated_at: '2013-12-03 11:39:15'
tags:
    - 'TAO 2 5'
-->

Tao 2.5 Delivery model
======================

Design
------

In Tao 2.5 the delivery model has changed significantly. Neither tests nor deliveries have to be processes any more even though this is still a possible implementation.

Items, Tests and Deliveries are each split into two distinct parts:

-   The model which allows the user to import/design/export the definition of the item/test/delivery which contains the authoring and the data model.
-   The runner which during execution of a delivery (by the test-taker) renders the component and handles interactions with the user.

### Content model

There is no interface on the content level between items and tests or tests and deliveries. The interface that an implementation needs to implement can be found in models/classes of the extensions taoItems, taoTests and taoDeliveries respectively.

### Runner

In order to be able to execute a delivery that contains different implementations, the interfaces between the Tao Platform and the Delivery Runner, the Delivery Runner and the Test Runner and between the Test Runner and the Item Runner had to be clear. To keep these implementation as independent as possible we implemented this by a [[Service call]], which is very similar to an URL as it contains the service to be called and the parameters with which this service should be executed.

In order to obtain the service call that allows us to execute a specific item/test/delivery we need to compile it.

Compilation
-----------

Compiling an item/test/delivery means preparing the data in a shared storage and returning a service call to the associated runner with one of the parameters pointing toward the prepared data. The compiler and the runner are usually provided by the implementation of the model. The shared storage in Tao is a directory structure located in “taoDelivery/data/compiled”.

{{thumbnail(compilationGraph.png, size=500, title=Sample Compilation)}}

Step by Step explanation:

-   An user has launched the compilation of a specific delivery, taoDelivery initializes the delivery compiler associated with the deliveries implementation and launches the compilation
-   The delivery compiler determines the tests included in this delivery and launches the compilation of these tests. In taoTests the correct compiler is initialized and launched
-   The test compiler uses its knowledge of the contents structure to get a list of items included in the provided test and launches the appropriate items compilers
-   The item compiler prepares the item content in a way that allows the item runner to launch it at a later state and stores this information in the shared storage. It then prepares a service call that points toward the item runner and takes as parameter the prepared data
-   After all the items have been compiled the test compiler takes the returned service calls and stores them together with the data the test runner requires in order to decide which items should be run in the shared storage and returns a service call which takes this data structure as parameter.
-   After all the tests (in our example only one) have been compiled, the delivery compiler stores the returned test runner service calls and its own data in the shared storage and creates a service call pointing toward the delivery runner taking as parameter the compiled deliver data.
-   Finally taoDelivery stores this service call, together with some meta-data (compilation date…) as a compiled (or published) delivery.

Delivery Execution
------------------

To launch a compiled/published delivery, all we need to do is execute the service call stored in it, by pointing the user to the indicated action.

{{thumbnail(deliveryGraph.png, size=500, title=Delivery Graph)}}<br/>
Please note that in the diagram the calls to the delivery/test/item-runner have been simplified. For now all these calls are made by the web client.

Step by Step explanation:

-   After the login, the test-taker is shown a lost of available and started published deliveries (called “tests” in the interface).
-   The test-taker clicks on an available delivery
-   taoDelivery initializes the execution of this delivery and redirects the user to the delivery runner indicated in the associated service call.
-   The delivery runner opens the compiled data specified by the call parameter and uses this data to decide which test should be called. It then redirects the user to the test runner.
-   The test runner uses its compiled data in the same way to determine to which item runner the user should be redirected.
-   The item runner uses the compiled item data to render the item to the user and await an user interaction
-   After the user has completed the item the item runner will inform the test runner that it has completed
-   The test runner determines the next appropriate item and redirects the user to its runner
-   The item runner uses the compiled item data to render the item, this could either be the same item runner with other parameters if both items share the same model or a different item runner.
-   After the user has completed the item, completion will once more be reported to the test runner
-   The test runner finds out that it has no more items to show to the user and informs the delivery runner of it’s completion
-   The delivery runner seeing that it has no other test to run informs taoDelivery of the completion of the service call
-   taoDelivery marks the delivery execution as finished and redirects the user to the list of available deliveries

Open Issues
-----------

-   The way the abstraction is implemented still varies between item, test and delivery and needs to be homogenized.

