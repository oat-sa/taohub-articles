Rest Client Libraries Focus Group
=================================

The goal of this focus group is to coordinate the development of TAO’s consumer libraries for other languages/platforms.\
These libraries should help others to integrate with TAO, using high level functions calls.

Useful informations
-------------------

-   Coordinator: [Bertrand Chevrier](bertrand@taotesting.com)
-   Mailing list : rest@taotesting.com (alias: rest-connectors-list@taotesting.com)
-   Repository (to be set up - we can host your source code if needed)

Targeted platform
-----------------

-   PHP
-   Java
-   Python
-   JavaScript (client - TAO needs to implement [CORS](http://enable-cors.org/) )
-   JavaScript (server/node.js)
-   C\#/.NET
-   …

Related documentation
---------------------

http://forge.taotesting.com/projects/tao/wiki/Rest

Advised architecture
--------------------

The connectors architecture is the responsibility to it’s developer, but here some idea of the way it could be achieved (any suggestion/critic is welcomed).

The diagram below represents a simplified view of a connector architecture:

![](http://forge.taotesting.com/attachments/download/2622/rest-arch.png)

-   The `RestClient` helps you to call HTTP requests. There is libraries in most languages to perform this operations (Jersey for Java, jQuery for JavaScript, etc.)
-   The `Service` components :

\* Provides to the user an API of the implemented methods (the interface)\
 \* Uses the configured `RestClient` to call TAO’s REST services\
 \* The services can be split by TAO’s extension: `TestTakerService`, `ItemService`, etc.

-   The `FactoryService` is the entry point :

\* It reads the configuration (TAO URL, authentication details, format, additional headers, etc.)\
 \* Instantiate the `RestClient` (usually a good practice is to keep the same instance of the `RestClient` across all calls, even though between services)\
 \* Instantiate the requested `Service`

Java (using Generic for the factory):

    TestTakerService testTakerService = FactoryService.getService(TestTakerRestService.class);
    List testTakers = testTakerService.getAll();

PHP

    $testTakerService = FactoryService.getService("TestTakerRestService");
    $testTakers = $testTakerService->.getAll();
