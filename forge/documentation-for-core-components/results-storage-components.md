<!--
parent:
    title: Documentation_for_core_components
author:
    - 'Antoine Robin'
created_at: '2015-07-24 14:41:27'
updated_at: '2015-07-27 09:29:43'
tags:
    - 'Documentation for core components'
-->

Results Storage components
==========================

Relational Database Storage (taoOutcomeRds)
-------------------------------------------

The taoOutcomeRds extension store results in a relational database, it uses 3 tables.<br/>

The first one stores the relation between test taker, delivery and delivery execution. This table is called results\_storage.<br/>

|*.result\_id |*.test\_taker |\_.delivery |\
|primary key | | |\
|delivery execution uri |test taker uri |delivery uri |

The second stores the variables (test and item) related to a delivery execution and a call id (the item or test that ask for storage). This table is called variables\_storage\
|*.variable\_id |*.results\_result\_id |*.call\_id\_test |*.call\_id\_item |*.test |*.item |*.identifier |*.class |\
|primary key |foreign key | | | | | | |\
|int |delivery execution uri | |delivery execution uri + item rank |test uri |item uri |variable identifier |variable class |

The last one stores values of each variable in a key value storage. This table is called results\_kv\_storage\
|*.variables\_variable\_id |*.result\_key |\_.result\_value |\
|primary and foreign key |primary key | |\
|variable primari key |variable property key |variable property value |

