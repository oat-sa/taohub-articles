<!--
author:
    - 'Joel Bout'
created_at: '2012-05-25 15:42:03'
updated_at: '2012-06-15 10:12:36'
-->

Functionality access control
============================

This pages describes the implementation of the funcACL in [[TAO\_2\_2|TAO 2.2]]. Changes can be found in [[FuncACL 2.3]].



Goal
----

The goal is to limit the module/action access by roles.

Preparation
-----------

It begin by the preparation of the models/ontology/funcacl.rdf by extension, describing each public method (action) accessible by class (module).

The script to generate the files for all extensions is tao/scripts/taoPreparePublicActions.php calling class.TaoPreparePublicActions.php.

It must be called each time a class/method is created or deleted.

The manifest of each extension introduce the funacl.rdf file and install it. It’s followed by other rdf file like aclrole.rdf giving basic access for this extension.

Control
-------

Once installed, it’s start in tao/include/class.AccessControlFC.php called by the bootstrap checking your access to the uri targeted. Extension, module and action is checked.

The control is made by the helper tao/helpers/funcacl/class.funcACL.php :: hasAccess method. It retrieves the roles of the current user and add, even if not logged in, a base access controle role (CLASS\_ROLE\_BASEACCESS) giving the access for logging and basic access like that. This is valid for all 3 kind of loggin

![](http://forge.taotesting.com/attachments/1669/taofuncacl.png)

Optimisation
------------

For optimizing the access to the database (processing \~+5000 records), it create a file (tao/data/cache/RolesByActions) structured for giving a fast answer to the “hasAccess” request.

Managing
--------

An interface exist to give access for entire module or specific action in the user management. It’s more for developper than user by the way it shows methods and classes (actions/modules).

![](http://forge.taotesting.com/attachments/1680/manager_roles_rights.png)

It’s hidded ! To activate it, in the structures.xml of tao add this line

<section id="manage_rolesrights" name="Manages Roles Rights" url="/tao/Roles/index" />
The interface show the roles, select one to display modules by extension, showing directly what’s selected, partialy selected or not selected. Click on a module to display the actions, showing what’s selected or not and at the bottome of this list, a way to select all (access by module) even if the module is modified (new action or less).

Edit a user to attach role.

![](http://forge.taotesting.com/attachments/1681/edit_user_roles.png)

