<!--
created_at: '2013-05-30 13:49:01'
updated_at: '2013-06-03 08:11:49'
authors:
    - 'Joel Bout'
tags:
    - Tutorials
-->



Accessing the generis persistence layer
=======================================

Requirements
------------

In order to follow this How-to you will need to be proficient in PHP and [[RDF]].

Accessing the TAO API
---------------------

### Web access

-   If you have already completed the How-To [[Make\_a\_new\_extension|Make a New Extension]] tutorial, you know how to add your own Module (Controller) to a TAO Extension. In this case It would probably be most comfortable to define a new module and include every of these code snippets in its own actions. These can then be called easily via your browser.

<!-- -->

-   Further down in the example we’re accessing constants of the extension `TaoItems`. For these please add the extension `TaoItems` to your dependencies.

### Command-line access

-   If you are planning to run your script in command-line PHP, you will need to initialise the TAO Framework in order to access to it’s functionalities. For this all you need to do is include **FILESYSTEM\_TAO\_FOLDER/tao/includes/raw\_start.php** at the beginning of your file. This will not only make use of the TAO autoloader, but will also load the required constants and use the credentials of your current installation to access the persistence layer.

<!-- -->

-   Further down in the example we’re accessing constants of the extension `TaoItems`. For these please include **FILESYSTEM\_TAO\_FOLDER/taoItems/includes/raw\_start.php** instead.

Read
----

### Literals

During the installation, a new user (the admin account) is added to TAO. If we to wanted view the label of this user we would call:

    $user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
    $propertyLabel = new core_kernel_classes_Property(RDFS_LABEL); // http://www.w3.org/2000/01/rdf-schema#label

    $literals = $user->getPropertyValues($propertyLabel);

In this example `$literals` will be an array with a single string.

### Resources

If we wanted to know which roles a user has, we would call:

    $user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
    $propertyRoles = new core_kernel_classes_Property(PROPERTY_USER_ROLES); // http://www.tao.lu/Ontologies/generis.rdf#userRoles
    $uris = $user->getPropertyValues($propertyRoles);

Since the values are references to existing roles and not literals as in our last example, the elements of `$resources` are the URIs of these resources. In order to visualise them we can create a resource of type `core_kernel_classes_Resource` an use the same `$resource->getPropertyValues($propertyLabel)` we used earlier. But there is an even simpler way since generis offers a shortcut: `getLabel()`

    foreach ($uris as $uri) {
       $resource = new core_kernel_classes_Resource($uri);
       echo 'The admin has the role: '.$resource->getLabel()."\n";
    }

Update
------

If we want to add a statement to the database the Syntax is very similar, instead of `getPropertyValues` we call **setPropertyValue**:

    $user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
    $propertyComment = new core_kernel_classes_Property(RDFS_COMMENT); // http://www.w3.org/2000/01/rdf-schema#comment

    $success = $user->setPropertyValue($propertyComment, 'a nice guy');

Note however that this will not replace the comment, but merely add another comment.

If we want to replace the current comment with our own we would use **editPropertyValues**:

    $success = $user->editPropertyValues($propertyComment, 'an ok guy');

To remove a specific value we use **removePropertyValue**:

    $success = $user->removePropertyValue($propertyComment, 'an ok guy');

Finally **removePropertyValues** allows us to remove all values at once:

    $success = $user->removePropertyValues($propertyComment);

All these methods work identically for adding/removing Resources from the database.

Create
------

In order to add a new instance to the system we call **createInstance** on the class we want to create an instance of:

    $itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS); //http://www.tao.lu/Ontologies/TAOItem.rdf#Item

    $newItem = $itemClass->createInstance('optionalItemLabel');

The newly created instance will be of type TAO\_ITEM\_CLASS and have the label ‘optionalItemLabel’ which is, as the name indicates, an optional parameter.

In order to create a new class, you can either subClass an existing class using **createSubClass**:

    $subClass = $itemClass->createSubClass('optionalSubclassLabel');

or since classes are only instances of the master class, instantiate it:

    $classClass = new core_kernel_classes_Class('http://www.w3.org/2000/01/rdf-schema#Class');
    $newClass = $classClass->createInstance('optionalLabel'); 

Delete
------

In order to delete a resource a simple call to **delete** of this resource suffices:

    $resource = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#instance1');
    $success = $resource->delete();

This will delete all statements having as subject this resource.

If you want to delete all the statements referencing the instance accross the database as well, set the parameter `$deleteReference` to true:

    $success = $resource->delete(true);

This will delete all statements having the resource as either subject or object.

Search
------

Sometimes we require the reverse operation of getPropertyValues() and we want to find all the resources that have a specific value for a property.

If for example we want to find all the users that have the role ‘Global Manager Role’ we can use **searchInstances**:

    $userClass = new core_kernel_classes_Class(CLASS_GENERIS_USER);
    $globalManagerRole = new core_kernel_classes_Resource(INSTANCE_ROLE_GLOBALMANAGER); // http://www.tao.lu/Ontologies/TAO.rdf#GlobalManagerRole

    $resources = $userClass->searchInstances(array(
        PROPERTY_USER_ROLES => $globalManagerRole
    ));

This returns a list of resources, that are instances of the class `$userClass`, and that have the object `$globalManagerRole` for the predicate `PROPERTY_USER_ROLES`.

Several conditions can be combined in order to narrow down the search:

    $itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS);

    $resources = $itemClass->searchInstances(array(
        TAO_ITEM_MODEL_PROPERTY => TAO_ITEM_MODEL_QTI,
        RDFS_LABEL => 'Periods of History'
    ));

However this only returns items that are direct instances of the TAO item class. In order to search the subclasses as well we need to add the option ‘recursive’:

    $resources = $itemClass->searchInstances(array(
        TAO_ITEM_MODEL_PROPERTY => TAO_ITEM_MODEL_QTI,
        RDFS_LABEL => 'Periods of History'
    ), array(
        'recursive' => true
    ));

These are the currently supported options, please note that they are subject to change:

  name        type           default   comment
  ----------- -------------- --------- ------------------------
  like        bool           true      
  chaining    ‘or’/’and’     ‘and’     
  recursive   bool           true      
  lang        string         none      applied all properties
  limit       int            none      
  offset      int            0         
  order       property       none      property to order by
  orderdir    ‘ASC’/’DESC’   ’ASC’     

Comments
--------

### Literals

Sometimes functions (such as getUniquePropertyValue(), getOnePropertyValue, …) return an instance of type `core_kernel_classes_Literal`, if the value of the property is a literal. To get the string representation we simply call the `__toString()` explicitly or we cast it to the string PHP datatype which will trigger the conversion implicitly.

    echo 'Label: '.(string)current($literals);


Accessing the generis persistence layer
=======================================

Requirements
------------

In order to follow this How-to you will need to be proficient in PHP and [[RDF]].

Accessing the TAO API
---------------------

### Web access

-   If you have already completed the How-To [[Make\_a\_new\_extension|Make a New Extension]] tutorial, you know how to add your own Module (Controller) to a TAO Extension. In this case It would probably be most comfortable to define a new module and include every of these code snippets in its own actions. These can then be called easily via your browser.

<!-- -->

-   Further down in the example we’re accessing constants of the extension `TaoItems`. For these please add the extension `TaoItems` to your dependencies.

### Command-line access

-   If you are planning to run your script in command-line PHP, you will need to initialise the TAO Framework in order to access to it’s functionalities. For this all you need to do is include **FILESYSTEM\_TAO\_FOLDER/tao/includes/raw\_start.php** at the beginning of your file. This will not only make use of the TAO autoloader, but will also load the required constants and use the credentials of your current installation to access the persistence layer.

<!-- -->

-   Further down in the example we’re accessing constants of the extension `TaoItems`. For these please include **FILESYSTEM\_TAO\_FOLDER/taoItems/includes/raw\_start.php** instead.

Read
----

### Literals

During the installation, a new user (the admin account) is added to TAO. If we to wanted view the label of this user we would call:

    $user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
    $propertyLabel = new core_kernel_classes_Property(RDFS_LABEL); // http://www.w3.org/2000/01/rdf-schema#label

    $literals = $user->getPropertyValues($propertyLabel);

In this example `$literals` will be an array with a single string.

### Resources

If we wanted to know which roles a user has, we would call:

    $user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
    $propertyRoles = new core_kernel_classes_Property(PROPERTY_USER_ROLES); // http://www.tao.lu/Ontologies/generis.rdf#userRoles
    $uris = $user->getPropertyValues($propertyRoles);

Since the values are references to existing roles and not literals as in our last example, the elements of `$resources` are the URIs of these resources. In order to visualise them we can create a resource of type `core_kernel_classes_Resource` an use the same `$resource->getPropertyValues($propertyLabel)` we used earlier. But there is an even simpler way since generis offers a shortcut: `getLabel()`

    foreach ($uris as $uri) {
       $resource = new core_kernel_classes_Resource($uri);
       echo 'The admin has the role: '.$resource->getLabel()."\n";
    }

Update
------

If we want to add a statement to the database the Syntax is very similar, instead of `getPropertyValues` we call **setPropertyValue**:

    $user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
    $propertyComment = new core_kernel_classes_Property(RDFS_COMMENT); // http://www.w3.org/2000/01/rdf-schema#comment

    $success = $user->setPropertyValue($propertyComment, 'a nice guy');

Note however that this will not replace the comment, but merely add another comment.

If we want to replace the current comment with our own we would use **editPropertyValues**:

    $success = $user->editPropertyValues($propertyComment, 'an ok guy');

To remove a specific value we use **removePropertyValue**:

    $success = $user->removePropertyValue($propertyComment, 'an ok guy');

Finally **removePropertyValues** allows us to remove all values at once:

    $success = $user->removePropertyValues($propertyComment);

All these methods work identically for adding/removing Resources from the database.

Create
------

In order to add a new instance to the system we call **createInstance** on the class we want to create an instance of:

    $itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS); //http://www.tao.lu/Ontologies/TAOItem.rdf#Item

    $newItem = $itemClass->createInstance('optionalItemLabel');

The newly created instance will be of type TAO\_ITEM\_CLASS and have the label ‘optionalItemLabel’ which is, as the name indicates, an optional parameter.

In order to create a new class, you can either subClass an existing class using **createSubClass**:

    $subClass = $itemClass->createSubClass('optionalSubclassLabel');

or since classes are only instances of the master class, instantiate it:

    $classClass = new core_kernel_classes_Class('http://www.w3.org/2000/01/rdf-schema#Class');
    $newClass = $classClass->createInstance('optionalLabel');

Delete
------

In order to delete a resource a simple call to **delete** of this resource suffices:

    $resource = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#instance1');
    $success = $resource->delete();

This will delete all statements having as subject this resource.

If you want to delete all the statements referencing the instance accross the database as well, set the parameter `$deleteReference` to true:

    $success = $resource->delete(true);

This will delete all statements having the resource as either subject or object.

Search
------

Sometimes we require the reverse operation of getPropertyValues() and we want to find all the resources that have a specific value for a property.

If for example we want to find all the users that have the role ‘Global Manager Role’ we can use **searchInstances**:

    $userClass = new core_kernel_classes_Class(CLASS_GENERIS_USER);
    $globalManagerRole = new core_kernel_classes_Resource(INSTANCE_ROLE_GLOBALMANAGER); // http://www.tao.lu/Ontologies/TAO.rdf#GlobalManagerRole

    $resources = $userClass->searchInstances(array(
        PROPERTY_USER_ROLES => $globalManagerRole
    ));

This returns a list of resources, that are instances of the class `$userClass`, and that have the object `$globalManagerRole` for the predicate `PROPERTY_USER_ROLES`.

Several conditions can be combined in order to narrow down the search:

    $itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS);

    $resources = $itemClass->searchInstances(array(
        TAO_ITEM_MODEL_PROPERTY => TAO_ITEM_MODEL_QTI,
        RDFS_LABEL => 'Periods of History'
    ));

However this only returns items that are direct instances of the TAO item class. In order to search the subclasses as well we need to add the option ‘recursive’:

    $resources = $itemClass->searchInstances(array(
        TAO_ITEM_MODEL_PROPERTY => TAO_ITEM_MODEL_QTI,
        RDFS_LABEL => 'Periods of History'
    ), array(
        'recursive' => true
    ));

These are the currently supported options, please note that they are subject to change:

  name        type           default   comment
  ----------- -------------- --------- ------------------------
  like        bool           true
  chaining    ‘or’/’and’     ‘and’
  recursive   bool           true
  lang        string         none      applied all properties
  limit       int            none
  offset      int            0
  order       property       none      property to order by
  orderdir    ‘ASC’/’DESC’   ’ASC’

Comments
--------

### Literals

Sometimes functions (such as getUniquePropertyValue(), getOnePropertyValue, …) return an instance of type `core_kernel_classes_Literal`, if the value of the property is a literal. To get the string representation we simply call the `__toString()` explicitly or we cast it to the string PHP datatype which will trigger the conversion implicitly.

    echo 'Label: '.(string)current($literals);

