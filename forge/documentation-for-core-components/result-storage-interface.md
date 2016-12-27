<!--
parent: 'Documentation for core components'
created_at: '2013-10-16 15:26:05'
updated_at: '2013-10-16 15:51:14'
authors:
    - 'Patrick Plichart'
tags:
    - 'Documentation for core components'
-->

Result Storage Interface
========================

Location
--------

The results storage interface is made available in taoResultServer extension of TAO

Implementing the interface.
---------------------------

Implementing a new results storage consists at minimum in creating a new extension\
- with class(es) implementing taoResultServer_models_classes_ResultStorage\
- with the rdf declaration of a new results storage model available to result server.

``` {code="xml"}

    File
    This implementation stores the data in a single append mode file per session
    mystorageextension_models_classes_mydatastorage


```

Concepts
--------

*deliveryResultIdentifier*

Used to identify the set of information collected for the instanciation of a test delivery by a test taker. This identifier is used for further calls to the implementation in order to stack extra information as the data gets collected by the driver. The implementation should rely strictly on this to store the data adequately. The implementation can’t rely on any other “state” information like a session(the test session may be interrupted, etc.)<br/>

The spawn function to be implemented should return a valid unique new identifier (string).

For every single execution of the same test delivery by the same test taker a specific deliveryResultIdentifier will be used.

*callId*

CallIDs are sent to the implementation in order to distinguish ambiguous cases.

Typically, the implementation could receive the same item identifier with the same type of variable (same identifier member) collected but with a different callID. This means that the same item was used several times during the test but are different instances of the same item. The implementation shall record this differently from the case where the same callID has been sent. For the later, this will happen if the test takers came back on the same item, changed his mind and for taht case the implementation is expected then to **stack** another observation of the variable .

*Variables*

Variable object are php object container sent to the implementation for storage

interface taoResultServer_models_classes_ResultStorage
---------------------------------------------------------

        /**
         * @param deliveryResultIdentifier (example : lis_result_sourcedid)
         * @param string testTakerIdentifier (uri recommended)
         */
        public function storeRelatedTestTaker($deliveryResultIdentifier, $testTakerIdentifier);

        /**
         * @param string deliveryIdentifier (uri recommended)
         */
        public function storeRelatedDelivery($deliveryResultIdentifier, $deliveryIdentifier);

        /**
         * Submit a specific Item Variable, (ResponseVariable and OutcomeVariable shall be used respectively for collected data and score/interpretation computation)
         * @param string test (uri recommended)
         * @param string item (uri recommended)
         * @param taoResultServer_models_classes_ItemVariable itemVariable
         * @param string callId contextual call id for the variable, ex. :  to distinguish the same variable output by the same item and that is presented several times in the same test
         *
         */
        public function storeItemVariable($deliveryResultIdentifier, $test, $item, taoResultServer_models_classes_Variable $itemVariable, $callIdItem );

        /**
         *  CreateResultValue(sourcedId,ResultValueRecord)
         *  CreateLineItem(sourcedId,lineItemRecord:LineItemRecord)
         */
        public function storeTestVariable($deliveryResultIdentifier, $test, taoResultServer_models_classes_Variable $testVariable, $callIdTest);

        /**
         * The storage may configure itselfs based on the resultServer definition
         */
        public function configure(core_kernel_classes_Resource $resultServer, $callOptions = array());

         /**
         * @return string deliveryResultIdentifier
         */
        public function spawnResult();

