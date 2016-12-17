---
tags: Forge
---

{{\>toc}}

Process storing Data
====================

1. Objective
------------

In order to save the results (variable value) after passing a test, the interception and storing service will be used. When the subject validates his response for an item, the Delivery module sends immediately a variable description to the Result module in order to save it. The latter, intercepts the description of the variable for this item and call the **Add\_Result\_Variable** method to save this value according to RDM.

2. Description
--------------

The variable description structure is a composed of two parts; DTIS and variable/ value. **DTIS** is a structure with four variables **Delivery, Test, Item and Subject**, this tuple is used as a key. The second part is the variable and its value.

![](resources/http://forge.taotesting.com/attachments/download/476/RM_interception_Result.jpg)

The delivery classes will be created dynamically, base on the **iMBR** (incremental Model Builder for Result) algorithm (see later). We can add instances in the TAO\_ITEM\_RESULTS and in the flexible Model of TAO\_DELIVERY\_RESULTS with incremental building feature. Result Delivery classes are created as well as their properties dynamically. Regarding to each new result, we create or not the class and the property. It is important to check the existence of the instance also to add the property name for the appropriate instance.

