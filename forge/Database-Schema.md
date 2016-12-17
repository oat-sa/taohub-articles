---
tags: Forge
---

Database Schema
===============

TAO and Generis need to use a storage engine even though it’s transparent. By default, the storage back-end is [Mysql](resources/http://www.mysql.com/), but it could be used over any relational database engine (eg. [Postgresql](resources/http://www.postgresql.org/))

As you can see in the schema below, there are few tables only.\
Only these three are important:

-   The *statements* table which contains the triples. This is the main table: it contains the RDF (Resource Description Format)/RDFS triples ontologies representing the data (and the data model as a data itself).
-   The *models* table references the ontologies namespaces (*models*.*modelID* = *statements*.*modelID*)
-   The *extension* table contains the list of TAO/Generis extensions.

![](resources/http://forge.taotesting.com/attachments/396/tao-database-schema.png)

