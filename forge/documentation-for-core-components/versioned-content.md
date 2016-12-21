<!--
parent:
    title: Documentation_for_core_components
author:
    - 'Jérôme Bogaerts'
created_at: '2011-10-31 17:20:57'
updated_at: '2013-03-13 12:59:17'
tags:
    - 'Documentation for core components'
-->

{{\>toc}}

Versioned content
=================

*It is important to notice that we are talking about versioned content. Versioned resources is an other feature and this feature will be designed later*

So why we need to manage versioned content, mostly to manage the versioning of files. By instance the files which describe items, the files which describe items’ translation, and so on.

Enable the versioning
---------------------

By default the versioning is not enabled (See [[Enable versioning]]).

Features
--------

The TAO platform supports almost all the features of the subversion system through two main objects. A *Repository* object to manage repositories and a *File* object to manage files inside repositories. Of course the system has been developped to be extended in the future with other kind of versioning system (GIT, Mercurial …)

The RDF model
-------------

The versioning is represented by two resources :

-   http://www.tao.lu/Ontologies/generis.rdf\#VersionedRepository ( [see rdf](http://forge.taotesting.com/projects/tao/repository/entry/trunk/generis/trunk/core/ontology/generis.rdf#L171) ) describes versioned repository resources
-   http://www.tao.lu/Ontologies/generis.rdf\#VersionedFile( [see rdf](http://forge.taotesting.com/projects/tao/repository/entry/trunk/generis/trunk/core/ontology/generis.rdf#L223) ) describes versioned file resources

The model
---------

As you can see on the schema the proxy pattern has been used to implement the versioning layer, in this way it is easy to bind a new versioning system to TAO.

![](http://forge.taotesting.com/attachments/1255/versioning.png)

Version your content
--------------------

### Version a file

In order to create a new versioned content the object *core\_kernel\_versioning\_File* provides a factory, its static function *create*.

The factory will create all triples which describe the new versioned content in the ontology. It is important to notice that the factory **will not create the file in the file system**, to avoid any Exception, create the file manually before using the factory or set the content of the file before using any other functions from the versioning layer (such as add or commit).

    $myFile = core_kernel_versioning_File::create('myFile.txt', '/', $myRepository);
    // Set the content of your file. Usefull if the file does not exist yet
    $myFile->setContent('my content');
    // Add the file to the resources to version
    $myFile->add();
    // Commit the file to the remote server
    $myFile->commit();
