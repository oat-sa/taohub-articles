<!--
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

The taoOutcomeRds extension store results in a relational database, it uses 3 tables.<br/>

The first one stores the relation between test taker, delivery and delivery execution. This table is called results_storage.<br/>

|*.result_id |*.test_taker |_.delivery |<br/>

|primary key | | |<br/>

|delivery execution uri |test taker uri |delivery uri |

The second stores the variables (test and item) related to a delivery execution and a call id (the item or test that ask for storage). This table is called variables_storage\
|*.variable_id |*.results_result_id |*.call_id_test |*.call_id_item |*.test |*.item |*.identifier |*.class |<br/>

|primary key |foreign key | | | | | | |<br/>

|int |delivery execution uri | |delivery execution uri + item rank |test uri |item uri |variable identifier |variable class |

The last one stores values of each variable in a key value storage. This table is called results_kv_storage\
|*.variables_variable_id |*.result_key |_.result_value |<br/>

|primary and foreign key |primary key | |<br/>

|variable primari key |variable property key |variable property value |


