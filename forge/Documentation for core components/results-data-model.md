<!--
parent: 'Documentation for core components'
created_at: '2013-10-15 13:23:01'
updated_at: '2013-10-15 13:31:32'
authors:
    - 'Patrick Plichart'
tags:
    - 'Documentation for core components'
-->

Results Data Model TAO 2.5
==========================

This is the data model used for storing and exploiting the results in the taoResults extension part of TAO.<br/>

This storage is inspired by the QTI results standardisation but supports results arising from non QTI tests (including an object).<br/>

http://www.imsglobal.org/question/qtiv2p1/imsqti_resultv2p1.html

Elements of understanding

An itemResult is identified by the instantiation of the item, in other words if the user revisits the exact same item by going backwards to it, any other data collected during that second visit will be modelled as variables stacked into the same itemresult. Two distinct itemResults will be created if the same item is embedded twice in the same delivery.

Internally into TAO, the identifier of the item results is arising from the callId of the item delivery service.

A variable may be related to an itemresult or may directly refer to a test, which means a test variable rather than an item variable.


