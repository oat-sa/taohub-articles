<!--
parent:
    title: Results_And_Events
author:
    - 'Jérôme Bogaerts'
created_at: '2011-03-10 11:41:48'
updated_at: '2013-03-13 13:10:12'
tags:
    - 'Results And Events'
-->

{{\>toc}}

Data Presentation
=================

1. Objective
------------

The presentation of results is accomplished by **UTR** component (**Ultimate Table of Results**). The main objective of **UTR** is to provide the facilities to create and to preview a table view of the result classes. Since the structure of classes is flexible and the classes are linked with relations, UTR aims to facilitate this creation according to new properties added by the user and to integrate other properties from other classes that are related to the selected result classes.

2. Description
--------------

Before explaining the functionalities of UTR, we propose brief theoretical information

### Theoretical Background

All information are stored following the RDF h model, this model allows a high flexibility to describe the structure of resources and relations between them. In our case, the main purpose resource is the instance of classes. Each class has a set of instances that represent a specific resource with a set of property values. So, in order to exploit these resources, on should get the structure of its class and get all the property values that are defined within the class description.

![]({width:100px}http://forge.taotesting.com/attachments/download/204/classdescription2.gif)

To do that the RDF model provides a specific type of relations (predicate) to ensure the correspondence between classes, properties, instances and property values of instances.

-   http://www.w3.org/2000/01/rdf-schema\#domain
-   http://www.w3.org/2000/01/rdf-schema\#label
-   http://www.w3.org/2000/01/rdf-schema\#range
-   …

In addition of the class structure, there is an important relation between class that is the *Range* http:www.w3.org/2000/01/rdf-schema\#range. With the range, on can establish a specific relation between class and use it as junction (as in SQL) to get the appropriate instance of class base on instance of other one.

![](http://forge.taotesting.com/attachments/download/205/rangeclass.gif)

As the RDF, and TAO by consequence, provides high degree of flexibility to describe classes, our task is more complicated that exploiting a rigid and static data model. We have two main objectives:

1.  Extract information on the fly and without any knowledge about the model structure.
2.  Provide an easy to use factory, to help developer to create their one result tables.

3. Architecture
---------------

In this section, we present the architecture of the UTR extension by providing the class diagram and the structure of the table

![](http://forge.taotesting.com/attachments/download/477/RM_UML_UTR.jpg):http://forge.taotesting.com/attachments/download/469/RM\_UML\_UTRFull.jpg

The extension contains 4 classes

1.  **RegCommon**: provides the main and the common methods to build the table of result.
    1.  Get clases according to instances
    2.  Filter the properties to provide to hide RDF ones.
    3.  Get the classes that are range of the selected classes.
    4.  Get the value of column according to the its description, specially the path value

2.  **TReg\_VirtualTable**: this class fosters on the creation and managing of the table according to UTR model. It provides some services as
    1.  Add columns
    2.  Delete columns
    3.  Delete rows
    4.  Create instant Table
    5.  Export to CSV and native excel

3.  **UtrStatistic** in this version, it gives a percentage of no null value for rows and column
4.  **UtrFilter**: addes filter feature to the table according to a complex filter criteria.

### Structure of the table

***T*** : an *UTR* table is 2-tuple :

***T*:= (*Instances, Columns* )**

-   *Instances*: list of instances, in the case of the *Result Module* instances are the results of tests passed by test takers.
-   *Columns*: set of column.

***Column*:= (*Label, Path* )**

-   *Label* : is the label of the column.
-   *Path* : is a complex structure.

***Path* := *PU*[{ *Sep* } *PU* ]**\*

*PU* : Property URI is the URI of a property of the ranged class.<br/>

*Sep* : is a separator. In the current version Sep = ‘**’

### The path

The path constitutes an important notion in the description of a column. The path permits to establish a relation with instances of other classes.

-   To get the accurate instances between classes, we use the concept of path query; each path query is a sequence of property URI, which will be used to do model exploitation. After that, for each instance, on uses the trGetBridgePropertyValues() to get exactly the appropriate set of instance corresponding to the initial instance and based on the path.
-   The path is created based on a other sub function : get the range of the class, get the description of the properties …See php Doc.<br/>

    On can put only the information related to the test it self, or on can also put other information from other class that are in relation with result classes. This is an interesting feature to use.

