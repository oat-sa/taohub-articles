<!--
created_at: '2014-03-18 11:15:39'
updated_at: '2014-08-19 14:34:37'
authors:
    - 'Patrick Plichart'
-->

TAO 3.0
=======

Features
--------

### Portable Custom Interaction (PCI)

"The QTI™ (Question and Test Interoperability™) and APIP™ (Accessible Portable Item Protocol™) workgroups have defined a standard way for technology enhanced items (TEIs) or Custom Interaction types to be represented as part of the QTI specification.

This best practice document outlines a method that allows an author to define an almost unlimited variety of custom interaction types, while still keeping the item portable between different systems. This is achieved by making use of common web technologies combined with an agreement about how to communicate the results of a learner’s interaction to a QTI/APIP rendering engine. By following the best practice documented here, most TEIs and assessment components can increase their value by supporting interoperability."\
src: http://www.imsglobal.org/assessment/interactions.html

### General User Interface Review

TAO 2.6 exposed a brand new WYSIWYG editor with a modern flat design. TAO 3.0 enforces this new shift with the overall user interfaces being revisited for more consistency and according to this flat design and color schemes.

### Data Rights Access Management

{{collapse(Details …)\
Computer based assessment project involve several stakeholders, the resources, items, tests are designed and authored sometimes collaboratively. In addition to the authentication system, a fine grained control access should be added so that resources or informations access (read, write, delete, create) may be set considering specific groups of users or roles.

Two differents approaches could be considered :\
- Rights access at resource level, considering access control on an item globally for instance.\
- Rights access at knowledge level, considering access control on every knowledge defined (every meta-data)

Rights Management System Prevent users of the back office from accessing data they are not authorized. Design and implement a rights management layer on Generis. See [[Generis\_overview]]\
This will alow users to share and restrict access to any resource with other TAO users based on user identification and groups users belong to. This functionality is strongly needed since TAO could be distributed and allows sharing of resources across the web. triple(S,P,O). –\> utriple(S,P,O,U).\
}}

Migration Guidelines
--------------------

[[Code Changes from 2.6 to 3.0]]

[[Migrating Server from 2.6 to 3.0]]

[[Updating Extensions from 2.6 to 3.0]]

TAO 3.0
=======

Features
--------

### Portable Custom Interaction (PCI)

"The QTI™ (Question and Test Interoperability™) and APIP™ (Accessible Portable Item Protocol™) workgroups have defined a standard way for technology enhanced items (TEIs) or Custom Interaction types to be represented as part of the QTI specification.

This best practice document outlines a method that allows an author to define an almost unlimited variety of custom interaction types, while still keeping the item portable between different systems. This is achieved by making use of common web technologies combined with an agreement about how to communicate the results of a learner’s interaction to a QTI/APIP rendering engine. By following the best practice documented here, most TEIs and assessment components can increase their value by supporting interoperability."\
src: http://www.imsglobal.org/assessment/interactions.html

### General User Interface Review

TAO 2.6 exposed a brand new WYSIWYG editor with a modern flat design. TAO 3.0 enforces this new shift with the overall user interfaces being revisited for more consistency and according to this flat design and color schemes.

### Data Rights Access Management

{{collapse(Details …)\
Computer based assessment project involve several stakeholders, the resources, items, tests are designed and authored sometimes collaboratively. In addition to the authentication system, a fine grained control access should be added so that resources or informations access (read, write, delete, create) may be set considering specific groups of users or roles.

Two differents approaches could be considered :<br/>

- Rights access at resource level, considering access control on an item globally for instance.<br/>

- Rights access at knowledge level, considering access control on every knowledge defined (every meta-data)

Rights Management System Prevent users of the back office from accessing data they are not authorized. Design and implement a rights management layer on Generis. See [[Generis\_overview]]\
This will alow users to share and restrict access to any resource with other TAO users based on user identification and groups users belong to. This functionality is strongly needed since TAO could be distributed and allows sharing of resources across the web. triple(S,P,O). –\> utriple(S,P,O,U).<br/>

}}

Migration Guidelines
--------------------

[[Code Changes from 2.6 to 3.0]]

[[Migrating Server from 2.6 to 3.0]]

[[Updating Extensions from 2.6 to 3.0]]


