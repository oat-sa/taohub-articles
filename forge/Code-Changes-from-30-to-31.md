<!--
created_at: '2015-12-09 15:54:05'
updated_at: '2015-12-15 17:42:13'
authors:
    - 'Joel Bout'
tags:
    - 'Legacy Versions:TAO 3.0'
    - 'Version Upgrades:TAO 3.0'
    - 'Legacy Versions:TAO 3.1'
    - 'Version Upgrades:TAO 3.1'
-->



Code Changes from 3.0 to 3.1
============================

taoDelivery
-----------

taoDelivery has been split into two extensions:

-   **taoDelivery** for the test-taker experience
-   **taoDeliveryRdf** for the delivery management

### Controllers

The old taoDelivery controllers *taoDelivery_actions*<br/>
*_ have been moved from taoDelivery/action to controller of their respective extension:

-   *taoDelivery_actions_DeliveryServer* to *oat\<br/>
taoDelivery\<br/>
controller\<br/>
DeliveryServer*
-   all others to *oat\<br/>
taoDeliveryRdf\<br/>
controller\<br/>
\**

### Delivery execution state identifiers

These states were in the past stored as either global constants or using *oat\<br/>
taoFrontOffice\<br/>
model\<br/>
interfaces\<br/>
DeliveryExecution*, but will in the future be part of the **oat\<br/>
taoDelivery\<br/>
model\<br/>
execution\<br/>
DeliveryExecution** interface.

### Services

Almost all services (with the exception of *taoDelivery_models_classes_DeliveryServerService* and *taoDelivery_models_classes_execution*<br/>
*_) were part of the delivery management and have therefore been moved to taoDeliveryRdf:

-   *taoDelivery_models_classes_TrackedStorage* -<br/>
> *oat\<br/>
taoDeliveryRdf\<br/>
model\<br/>
TrackedStorage*
-   *taoDelivery_models_classes_SimpleDeliveryFactory* -<br/>
> *oat\<br/>
taoDeliveryRdf\<br/>
model\<br/>
SimpleDeliveryFactory*
-   *taoDelivery_models_classes_DeliveryAssemblyService* -<br/>
> *oat\<br/>
taoDeliveryRdf\<br/>
model\<br/>
DeliveryAssemblyService*
-   *taoDelivery_models_classes_GuestTestUser* -<br/>
> *oat\<br/>
taoDeliveryRdf\<br/>
model\<br/>
guest\<br/>
GuestTestUser*
-   *taoDelivery_models_classes_GuestTestTakerSession* -<br/>
> *oat\<br/>
taoDeliveryRdf\<br/>
model\<br/>
guest\<br/>
GuestTestTakerSession*



-   *taoDelivery_models_classes_AssignmentService* has been split into the interface *oat\<br/>
taoDelivery\<br/>
model\<br/>
AssignmentService* and the basic implementation *oat\<br/>
taoDeliveryRdf\<br/>
model\<br/>
GroupAssignment* that allows you to assign test-takers to deliveries using the groups



-   *taoDelivery_models_classes_DeliveryRdf* has been deprecated in favor of *oat\<br/>
taoDelivery\<br/>
model\<br/>
Assignment* that represents the link between the test-taker and the delivery

### Assets

Templates and JavaScripts have been split between the two extensions according to split of the controllers.

Update scripts
--------------

In order to ensure partially completed updates get resumed properly, the abstract update script *common_ext_ExtensionUpdater* has been enhanced with the functions:

-   isVersion(<br/>
$nr)
-   setVersion(<br/>
$nr)

So instead of:

<code style="php"><pre><br/>

if (<br/>
$currentVersion == ‘2.7.9’) {<br/>

 // magic happens here\
 <br/>
$currentVersion = ‘2.7.10’;<br/>

}

</pre>
</code>

please use

<code style="php"><pre><br/>

if (<br/>
$this-<br/>
>isVersion(‘2.7.9’)) {<br/>

 // magic happens here\
 <br/>
$this-<br/>
>setVersion(‘2.7.10’);<br/>

}

</pre>
</code>

and add a **<br/>
$this-<br/>
>setVersion(<br/>
$currentVersion)** in between the old update scripts and the new ones.


