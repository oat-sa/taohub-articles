<!--
created_at: '2013-05-31 09:53:44'
updated_at: '2013-05-31 12:11:48'
authors:
    - 'Jérôme Bogaerts'
tags: {  }
-->

RDF by example
==============



Example 1: how to store the **name**, **birthday** and **class** of the pupils of a school.
-------------------------------------------------------------------------------------------

In a traditional database, we would probably create a simple table to achieve this:

  PupilID   Name             Birthday   Class
  --------- ---------------- ---------- -------
  1         Abraham Antler   1.1.1980   101
  2         Bart Bond        2.2.1981   102

Using the RDF model we would store the same information using only 3 fields:

-   Subject (what are we talking about: pupil1, pupil2…)
-   Predicate (what property aspect of the specified subject are we talking about: name, birthday,class)
-   Object (what is the value for this subject, predicate: “Abraham Antler”, “1.1.1980”, Class 1)

So to represent the information we know about “Abraham Antler” we would store:

  Subject                       Predicate                           Object
  ----------------------------- ----------------------------------- -------------------------------
  http://www.example.org/\#p1   http://www.example.org/\#name       Abraham Antler
  http://www.example.org/\#p1   http://www.example.org/\#birthday   1.1.1980
  http://www.example.org/\#p1   http://www.example.org/\#class      http://www.example.org/\#c101

Plus one information which was implicit in our traditional database, the information that he is a pupil:

  Subject                       Predicate                                          Object
  ----------------------------- -------------------------------------------------- --------------------------------
  http://www.example.org/\#p1   http://www.w3.org/1999/02/22-rdf-syntax-ns\#type   http://www.example.org/\#pupil

A single line, in this model would be called a ‘statement’

### Namespace prefix

So if we took all the information in our traditional table we would receive:

  Subject                       Predicate                                          Object
  ----------------------------- -------------------------------------------------- --------------------------------
  http://www.example.org/\#p1   http://www.example.org/\#name                      Abraham Antler
  http://www.example.org/\#p1   http://www.example.org/\#birthday                  1.1.1980
  http://www.example.org/\#p1   http://www.example.org/\#class                     http://www.example.org/\#c101
  http://www.example.org/\#p1   http://www.w3.org/1999/02/22-rdf-syntax-ns\#type   http://www.example.org/\#pupil
  http://www.example.org/\#p2   http://www.example.org/\#name                      Bart Bond
  http://www.example.org/\#p2   http://www.example.org/\#birthday                  2.2.1981
  http://www.example.org/\#p2   http://www.example.org/\#class                     http://www.example.org/\#c102
  http://www.example.org/\#p2   http://www.w3.org/1999/02/22-rdf-syntax-ns\#type   http://www.example.org/\#pupil

In order to make this a little easier to read we can substitute the namespaces with a prefix

-   xmlns:ex=“http://www.example.org/
#”
-   xmlns:rdf=“http://www.w3.org/1999/02/22-rdf-syntax-ns\#type”

which allows us to represent the list as following

  Subject   Predicate     Object
  --------- ------------- ----------------
  ex:p1     ex:name       Abraham Antler
  ex:p1     ex:birthday   1.1.1980
  ex:p1     ex:class      ex:c101
  ex:p1     rdf:type      ex:pupil
  ex:p2     ex:name       Bart Bond
  ex:p2     ex:birthday   2.2.1981
  ex:p2     ex:class      ex:c102
  ex:p2     rdf:type      ex:pupil

Example 2: how to store friend information
-------------------------------------------

In a traditional database model friendship between pupils would be modelled via an auxiliary table:

  --------------- -------------- ----------------
  .FriendshipId   _.PupilLeft   _.Pupilrigtht
  1               1              2
  2               1              7
  3               1              3
  --------------- -------------- ----------------

Since RDF does not define cardinalities, we can simple add a property ‘friendOf’ which will result in multiple lines, that share the same subject and predicate:

  Subject   Predicate     Object
  --------- ------------- ----------------
  ex:p1     rdf:type      ex:pupil
  ex:p1     ex:name       Abraham Antler
  ex:p1     ex:birthday   1.1.1980
  ex:p1     ex:class      ex:c101
  ex:p1     ex:friendOf   ex:p2
  ex:p1     ex:friendOf   ex:p7
  ex:p1     ex:friendOf   ex:p3

Please note however that in RDF no two statements may be identical i.e. be composed of the same subject, predicate and object.

Class definitions:
------------------

This generic approach to data modelling allows us to define in a single model not only store several different types of entities, such as pupil, class and teacher, but information on the data model as well.

Property definitions:
---------------------

RDF features:
-------------

-   multiple inheritance
-   multi-type


