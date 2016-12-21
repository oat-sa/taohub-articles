<!--
author:
    - 'Joel Bout'
created_at: '2015-12-09 15:54:05'
updated_at: '2015-12-15 17:42:13'
-->



Code Changes from 3.0 to 3.1
============================

taoDelivery
-----------

taoDelivery has been split into two extensions:

-   **taoDelivery** for the test-taker experience
-   **taoDeliveryRdf** for the delivery management

### Controllers

The old taoDelivery controllers *taoDelivery\_actions*\*\_ have been moved from taoDelivery/action to controller of their respective extension:

-   *taoDelivery\_actions\_DeliveryServer* to *oat\\taoDelivery\\controller\\DeliveryServer*
-   all others to *oat\\taoDeliveryRdf\\controller\\\**

### Delivery execution state identifiers

These states were in the past stored as either global constants or using *oat\\taoFrontOffice\\model\\interfaces\\DeliveryExecution*, but will in the future be part of the **oat\\taoDelivery\\model\\execution\\DeliveryExecution** interface.

### Services

Almost all services (with the exception of *taoDelivery\_models\_classes\_DeliveryServerService* and *taoDelivery\_models\_classes\_execution*\*\_) were part of the delivery management and have therefore been moved to taoDeliveryRdf:

-   *taoDelivery\_models\_classes\_TrackedStorage* -\> *oat\\taoDeliveryRdf\\model\\TrackedStorage*
-   *taoDelivery\_models\_classes\_SimpleDeliveryFactory* -\> *oat\\taoDeliveryRdf\\model\\SimpleDeliveryFactory*
-   *taoDelivery\_models\_classes\_DeliveryAssemblyService* -\> *oat\\taoDeliveryRdf\\model\\DeliveryAssemblyService*
-   *taoDelivery\_models\_classes\_GuestTestUser* -\> *oat\\taoDeliveryRdf\\model\\guest\\GuestTestUser*
-   *taoDelivery\_models\_classes\_GuestTestTakerSession* -\> *oat\\taoDeliveryRdf\\model\\guest\\GuestTestTakerSession*

<!-- -->

-   *taoDelivery\_models\_classes\_AssignmentService* has been split into the interface *oat\\taoDelivery\\model\\AssignmentService* and the basic implementation *oat\\taoDeliveryRdf\\model\\GroupAssignment* that allows you to assign test-takers to deliveries using the groups

<!-- -->

-   *taoDelivery\_models\_classes\_DeliveryRdf* has been deprecated in favor of *oat\\taoDelivery\\model\\Assignment* that represents the link between the test-taker and the delivery

### Assets

Templates and JavaScripts have been split between the two extensions according to split of the controllers.

Update scripts
--------------

In order to ensure partially completed updates get resumed properly, the abstract update script *common\_ext\_ExtensionUpdater* has been enhanced with the functions:

-   isVersion(\$nr)
-   setVersion(\$nr)

So instead of:

<code style="php"><pre><br/>
if (\$currentVersion == ‘2.7.9’) {<br/>
 // magic happens here<br/>
 \$currentVersion = ‘2.7.10’;<br/>

}

</pre>
</code>

please use

<code style="php"><pre><br/>
if (\$this-\>isVersion(‘2.7.9’)) {<br/>
 // magic happens here<br/>
 \$this-\>setVersion(‘2.7.10’);<br/>

}

</pre>
</code>

and add a **\$this-\>setVersion(\$currentVersion)** in between the old update scripts and the new ones.

