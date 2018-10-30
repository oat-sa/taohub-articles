<!--
parent: 'Documentation for core components'
created_at: '2015-07-24 14:41:27'
updated_at: '2015-07-27 09:29:43'
authors:
    - 'Antoine Robin'
tags:
    - 'Documentation for core components'
-->

Results Storage components
==========================

Relational Database Storage (taoOutcomeRds)
-------------------------------------------

The taoOutcomeRds extension store results in a relational database, it uses 2 tables.

>The first one stores the relation between test-taker, delivery and delivery execution. This table is called results_storage.

|       result_id       |   test_taker  |   delivery  |
|:---------------------:|:-------------:|:-----------:|
|      primary_key      |               |             |
|delivery execution uri |test taker uri |delivery uri |

This table is used to get all delivery executions linked to a specific delivery.
We can also use it to retrieve information about test-taker or delivery execution in conjunction with the statements table 

>The second stores the variables (test and item) related to a delivery execution and a call ids. This table is called variables_storage

| variable_id |    results_result_id   |          call_id_test          |                                 call_id_item                                 |                  test                  |       item       |        value        |      identifier     |
|:-----------:|:----------------------:|:------------------------------:|:----------------------------------------------------------------------------:|:--------------------------------------:|:----------------:|:-------------------:|:-------------------:|
| primary_key |       foreign_key      |                                |                                                                              |                                        |                  |                     |                     |      
|    int      | delivery execution uri | delivery execution uri or null | delivery execution uri, item identifier and attempt glued with a '.' or null | test uri or item compilation directory | item uri or null | serialized variable | variable identifier |


This table allows to retrieve all variables stored during the delivery execution.
Once you have all rows with the correct delivery execution uri (results_result_id) you will be able to get test variable or item variable.
Test variables have a call_id_test value, a null call_id_item and a null item. 
Item variables have a call_id_item value and a null call_id_test. The item column contains the item uri so you can then retrieve items information from the statements table. The test columns contains the item compiled directory.

The value column contains the php serialized variable. So you will retrieve some information about the item like the number of attempt, the response given by the test-taker and the score.
These value are base64 encoded in the php serialised variable.