<!--
created_at: '2015-12-09 15:54:05'
updated_at: '2015-12-15 17:42:13'
authors:
    - 'Joel Bout'
tags:
    - 'Legacy Versions:TAO 3.0'
    - 'Version Changes:TAO 3.0 to 3.1'
-->



Code Changes from 3.0 to 3.1
============================

taoDelivery
-----------

taoDelivery has been split into two extensions:

-   **taoDelivery** for the test-taker experience
-   **taoDeliveryRdf** for the delivery management

### Controllers

The old taoDelivery controllers *taoDelivery_actions*

*_ have been moved from taoDelivery/action to controller of their respective extension:

-   *taoDelivery_actions_DeliveryServer* to *oat\taoDelivery\controller\DeliveryServer*
-   all others to *oat\taoDeliveryRdf\controller\\*

### Delivery execution state identifiers

These states were in the past stored as either global constants or using *oat\taoFrontOffice\model\interfaces\DeliveryExecution*, 
but will in the future be part of the **oat\taoDelivery\model\execution\DeliveryExecution** interface.

### Services

Almost all services (with the exception of *taoDelivery_models_classes_DeliveryServerService* and *taoDelivery_models_classes_execution*) were part of the delivery management and have therefore been moved to taoDeliveryRdf:

-   *taoDelivery_models_classes_TrackedStorage* -> *oat\taoDeliveryRdf\model\TrackedStorage*
-   *taoDelivery_models_classes_SimpleDeliveryFactory* -> *oat\taoDeliveryRdf\model\SimpleDeliveryFactory*
-   *taoDelivery_models_classes_DeliveryAssemblyService* -> *oat\taoDeliveryRdf\model\DeliveryAssemblyService*
-   *taoDelivery_models_classes_GuestTestUser* -> *oat\taoDeliveryRdf\model\guest\GuestTestUser*
-   *taoDelivery_models_classes_GuestTestTakerSession* -> *oat\taoDeliveryRdf\model\guest\GuestTestTakerSession*



-   *taoDelivery_models_classes_AssignmentService* has been split into the interface 
*oat\taoDelivery\model\AssignmentService* and the basic implementation 
*oat\taoDeliveryRdf\model\GroupAssignment* that allows you to assign test-takers to deliveries 
using the groups.


-   *taoDelivery_models_classes_DeliveryRdf* has been deprecated in favor of 
*oat\taoDelivery\model\Assignment* that represents the link between the test-taker and the delivery.

### Assets

Templates and JavaScripts have been split between the two extensions according to split of the controllers.

Update scripts
--------------

In order to ensure partially completed updates get resumed properly, the abstract update script *common_ext_ExtensionUpdater* has been enhanced with the functions:

-   isVersion($nr)
-   setVersion($nr)

So instead of:

````

if ($currentVersion == ‘2.7.9’) {

 // magic happens here
$currentVersion = ‘2.7.10’;

}

````

please use

````

if ($this->isVersion(‘2.7.9’)) {

 // magic happens here
$this->setVersion(‘2.7.10’);

}
````

and add a **$this->setVersion($currentVersion)** in between the old update scripts and the new ones.
