Create and Author a delivery
============================

The delivery content is a [[Process definition model|process definition]].

However two different properties in the delivery class contain the process definition of a delivery: *delivery content* and *delivery process*. The *delivery content* saves the delivery process for authoring purpose, with references to the tests, whereas the *delivery process* contains the compiled and generated process that is used for the actual delivery.

During delivery authoring, users select the tests to build their deliveries and they save the resulting process in the *delivery content*. During the [[Compile a delivery|compilation]], the system checks the definition of each test process to generate a final one. (The [[Compile a delivery|compilation]] will be presented in the next section)\
The differences between *delivery content* and *delivery process* are illustrated on the diagram below:\
![](compilation_generate_process.png)

Authoring a delivery basically means authoring a process definition. You can create a delivery with the delivery authoring service, which extends the [[Create a process definition with the authoring service|process authoring service]].\
The implementation of the delivery authoring tool is the same as the [[An implementation of process authoring tool|process authoring tool]]

However, most deliveries do not need a complex connections between tests. Therefore a simpler method is created in the *deliveryService* to create a sequential process from an ordered tests array: see *taoDelivery\_models\_classes\_DeliveryService::setDeliveryTests()* (see:phpdoc)

