<!--
parent: 'Documentation for core components'
created_at: '2011-03-04 10:57:53'
updated_at: '2013-03-13 12:58:29'
authors:
    - 'Jérôme Bogaerts'
tags:
    - 'Documentation for core components'
-->



![](http://forge.taotesting.com/attachments/download/760/attention.png)**This page is deprecated and needs to be rewritten**

Generis Overview
================

In order to understand TAO world, it’s necessary to get introduced to the underlying concepts of the system, i.e., generis4 and ontologies.

An ontology is an organization of the knowledge domain, describing entities and their relations within this specific domain (part of the world). An entity can be described as:

-   a Class (concept, type of object, or set of entities), a set of homogeneous instances sharing the same properties.
-   a Property (attribute, parameter of a class), a characteristic pertaining to specific classes, it may also be a descriptive relation to another class. Ex.: students have a property that is the classroom they belong to. All classrooms being defined using a class, the classroom membership is a relation from students to classrooms
-   an Instance (type of class, individual)

License
-------

Generis4 is released under GPL v2.

Generis4 - an ontology engine
-----------------------------

Generis is an ontology management tool which enables collaborative annotation of any kind of resources in a distribute way. Generis enables the management of an ontology in the form of a web resource (according to RDF and RDFS standards). RDFS being fully implemented, Generis enables one to manage (create, edit, remove) any kind of resource on all abstraction levels of resources modeling. According to the model or meta-model, user interfaces are dynamically generated to enable the user to manage lower level of resources. Generis also provides facilities to perform full text queries or structured queries (queries expressed according to the model) on the knowledge base. Generis may be accessed using an Application Programming Interface (API). Furthermore, Generis provides you with features for general administration like the management of users and settings.

For the description of an ontology generis4 uses the formal language RDF (S), a mark-up language that allows data publishing and sharing on the internet. RDF (S) – the Resource Description Framework (Schema) – is a recommendation of the World Wide Web Consortium (W3C).

RDF (S) uses statements in the form of triples (subject – predicate – object) to make assertions about the objects of a certain domain and thus formalize ontologies.

The user won’t get in touch with the formal language. Generis4 offers a graphical interface to model intuitively an ontology. All constructive entities (Resource, Class, Property, etc.) are pre-described in generis4 and provide you with the basis to model your own ontologies.

The pre-defined entities of generis4 are:

***Classes***

  ------------------------ -------------------------------------------------------------------------------------------------------
  **Predefined classes**   **Description**
  Resource                 All entities described by RDF (‘Resource’ is the only class without a subClassOf value)
  Class                    Category to describe a resource – the property ‘type’ of these resources has as value ‘Class’
  Property                 Attribute or relation to describe a resource
  Statement                Specific resource (subject) with a named property (predicate) and the value of this property (object)
  Container                Lists of resources or literals
  List                     Concatenated list of resources or literal
  Bag                      unordered list of resources or literals
  Seq                      ordered list of resources or literals
  Alt                      list of resources or literals that represent alternatives for the (single) value of a property
  Literal                  The class of literal values, e.g. textual strings and integers.
  XMLLiteral               Text containing XML tags
  Generis_Resource        Set of resources created with generis, building up on the pre-defined RDF resources of W3C
  ------------------------ -------------------------------------------------------------------------------------------------------

***Properties***

  --------------------------- ---------------------------------------------------------------------------------------------------
  **Predefined properties**   **Description**
  subClassOf                  Relation between two entities
  subPropertyOf               Relation between two properties
  comment                     Human-readable description of the entity
  label                       Human-readable name of entity (used to display and identify the entity within the user interface)
  type                        Type of the resource (‘Class’, ‘Property’, …)
  domain                      Relation between class and property
  range                       Relation between class and property
  value                       Idiomatic property used for structured values
  seeAlso                     Link to another resource with additional information
  isDefined                   Subproperty of ‘seeAlso’, defining the entity
  member                      A member of the subject resource.
  --------------------------- ---------------------------------------------------------------------------------------------------

The functions to work on the given entities are:

-   add/delete subclass (‘add class’ is not possible, because each added class will be a subclass of an already existing class)
-   add/delete property
-   add/delete instance

These functions allow the users to model any knowledge of a specific domain. There are no restrictions.

TAO and Generis
---------------

The resource management varies according to the context. In the educational system, for instance, learners management will involve the definition of the classrooms the students are in, their teachers, or their training options. From the human resources perspective, past positions, skills, experiences might be of interest. This model variability also applies to other resources in a TBA system like test items, tests, or the management of the test results. From an IT perspective this model variability is challenging since it prevents to define a priori the data model and the design of a classical database. To tackle this variability, we used the semantic web-related technologies RDF and RDFS. Both are languages standardized by the W3C that enable us to express knowledge about resources at any abstraction level. They allow the system users to define the data model (i.e., the definition of classes of resources and the description of their properties) as well as the data itself (e.g., values of properties that describe a particular student).

Using RDF repositories instead of a classical database design solves the model variability issue. The TAO platform makes use of the generis4 RDF/RDFS repository. This implies that, from the point of view of the application layer, the source code need to be independent from the model and all the user interfaces for the resources management needs to be generated by first inspecting the model that was defined by the user.

Future of Generis
-----------------

The Generis roadmap and the TAO roadmap are defined and prioritized together since TAO is the biggest Generis use case.

New versions of Generis will include:

-   a fine-grained rights access management
-   a peer to peer network enabling to perform a semantic on the network for resources
-   the management of methods associated to class, extending RDFS model to a pure oo model. This will enable to add the description of behaviors.
-   Associate to model entities pictograms.
-   Scalability : we will experiment new backends replacing the current MYSQL database with Prolog knowledge base and other RDFrepositories.


