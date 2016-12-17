---
tags: Forge
---

{{\>toc}}

![](resources/http://forge.taotesting.com/attachments/download/760/attention.png)**This page is deprecated as of Tao 2.1 and needs to be rewritten**

Result Data Model
=================

1. Objective
------------

The Result Data Model (RDM) constitutes the data level of this module. RDM allows saving the result of tests according to a special structure in order to be used by the other levels of the module. Since we are in ontology context, the RDM have to follow this notion and it is considered as sub-ontology of TAO ontology with the appropriate relations to other ones.

2. Structure and Classes
------------------------

Initially three classes are proposed for the RDM, the RUSULT class, TAO\_ITEM\_RESULTS, TAO\_DELIVERY\_RESULTS. See Fig 1.\
![](resources/http://forge.taotesting.com/attachments/download/475/RM_RDM_Classes.jpg)

-   In **RDM** the **Rresult class** is just used to indicate that all other classes that heritage it is considered as a result class. So, Result class has a very restricted structure.
-   **TAO\_ITEM\_RESULTS**. Instance of this class correspond to a variable value of an item in a test passed by a test taker. Each item has a set of standards variables (SCORE, Endorsement…) or unknown variables that can be added by the designer of the item. For that the structure of this class has to manage this special case. The proposed structure is based on (Variable,Value) tuple. This efficient structure permits to save variable value that can be unknown before the creation of the model. The property TAO\_ITEM\_VARIABLE\_ID contains the ID of the variable, the property TAO\_ITEM\_VARIABLE\_VALUE contains its value. The other five properties are used as key to identify exactly the value of the variable for the item of the test passed by a test take. The following figure presents all properties of this class.

![](resources/http://forge.taotesting.com/attachments/download/314/RM_TAO_ITEM_RESULTS.jpg)

-   **TAO\_DELIVERY\_RESULTS**. All the results of tests and classify them according to each delivery. The idea behind that is to propose a correspondence between the model and the structure of a delivery and the model of t the result for this delivery. So, one finds the properties already exist in the delivery module (designation of the delivery, name of the test, name of the item) and the variables in each items. The variables can be the SCORE, the ENDORSEMENT and other variables that can be added by the designer of the item. For each delivery in the delivery module, one creates a Result Delivery and one put it in the hierarchy of the class TAO\_DELIVERY\_RESULTS. However, the creation of the delivery and its structure depends on the test really done. The model is built dynamically after each test. For each delivery in the TAO\_DELIVERY\_RESULTS on finds all variables related to the tests already passed. The variables of the test are the properties of the delivery class. The number and the type of variables change depending of the tests included in the delivery. However, some variables are available for all the items like SCORE and ENDORSEMENT. The property that corresponds to the score of a specific item of a specific test has usually this name “SCORE of ItemX\_testX” this label is proposed by the system but can be changed by the interface.

3. Initial Model builder
------------------------

In order to create the initial model, we use the service ModelBuilderQTI that has as parameter an XML file.\
![](resources/http://forge.taotesting.com/attachments/download/356/RM_ResultModelBuilderQTI.jpg)

The XML file that describes the model is :




        
            
            
            
            
            

            
            


        
        
            
            
            
        

     

