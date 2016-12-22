<!--
created_at: '2014-05-26 16:41:50'
updated_at: '2014-05-27 12:11:15'
authors:
    - 'Joel Bout'
tags:
    - 'Developer Guide'
-->

The following document is work in progress



Hooks in Tao 2.6
================

Tao provides several ways to alter or extend its functionalities.

PHP session
-----------

Ontology
--------

To define a new persistence for the ontology you need to implement `oat\generis\model\data\model` and activate it using\
`oat\generis\model\data\modelManager::setModel()` migration and fallback need to be provided within the new model itself\
for the time being

Runtime data storage services
-----------------------------

More informations on how to configure them can be found on the [[Data abstractions]] page.

### Uri Provider

`common_uri_AbstractUriProvider`

### Delivery execution informations

`taoDelivery_models_classes_execution_Service`

Content models
--------------

On every model level there can be custom implementations.

Every content model can implement `tao_models_classes_import_ImportProvider` and `tao_models_classes_export_ExportProvider` to\
provide import and export capabilities.

### Item model

`taoItems_models_classes_itemModel`

### Test model

`taoTests_models_classes_TestModel`

### Delivery model

`taoDelivery_models_classes_ContentModel`

User & Session abstraction
--------------------------

Developers can provide a custom `common_user_auth_Adapter` that can return a custom `common_user_User`.

Based on this user a normal session can be initialized, or alternatively a custom session can be created that implements\
either `common_session_StatefulSession` or `common_session_StatelessSession`

For custom authentication adapters a custom entry point needs to be defined as the Tao login form will always\
use the default `core_kernel_users_AuthAdapter` and the default `common_session_DefaultSession`.

Access Control
--------------

A custom access control layer can be achieved by implementing `tao_models_classes_accessControl_AccessControl` and\
setting it as the current implementation using `tao_models_classes_accessControl_AclProxy::setImplementation()`

Result abstractions
-------------------

An alternative resultStorage can implement:

`taoResultServer_models_classes_WritableResultStorage` for data storage\
and/or\
`taoResultServer_models_classes_ReadableResultStorage` for data retrieval

User Interface
--------------

In the `structures.xml` file users can define:

-   add a new [[entrypoint]]
-   add a new menu entry to the backoffice (next to “Items”, “Tests”… on the top)
-   add tabs to an existing menu entry

The following document is work in progress



Hooks in Tao 2.6
================

Tao provides several ways to alter or extend its functionalities.

PHP session
-----------

Ontology
--------

To define a new persistence for the ontology you need to implement `oat\generis\model\data\model` and activate it using\
`oat\generis\model\data\modelManager::setModel()` migration and fallback need to be provided within the new model itself\
for the time being

Runtime data storage services
-----------------------------

More informations on how to configure them can be found on the [[Data abstractions]] page.

### Uri Provider

`common_uri_AbstractUriProvider`

### Delivery execution informations

`taoDelivery_models_classes_execution_Service`

Content models
--------------

On every model level there can be custom implementations.

Every content model can implement `tao_models_classes_import_ImportProvider` and `tao_models_classes_export_ExportProvider` to\
provide import and export capabilities.

### Item model

`taoItems_models_classes_itemModel`

### Test model

`taoTests_models_classes_TestModel`

### Delivery model

`taoDelivery_models_classes_ContentModel`

User & Session abstraction
--------------------------

Developers can provide a custom `common_user_auth_Adapter` that can return a custom `common_user_User`.

Based on this user a normal session can be initialized, or alternatively a custom session can be created that implements\
either `common_session_StatefulSession` or `common_session_StatelessSession`

For custom authentication adapters a custom entry point needs to be defined as the Tao login form will always\
use the default `core_kernel_users_AuthAdapter` and the default `common_session_DefaultSession`.

Access Control
--------------

A custom access control layer can be achieved by implementing `tao_models_classes_accessControl_AccessControl` and\
setting it as the current implementation using `tao_models_classes_accessControl_AclProxy::setImplementation()`

Result abstractions
-------------------

An alternative resultStorage can implement:

`taoResultServer_models_classes_WritableResultStorage` for data storage\
and/or\
`taoResultServer_models_classes_ReadableResultStorage` for data retrieval

User Interface
--------------

In the `structures.xml` file users can define:

-   add a new [[entrypoint]]
-   add a new menu entry to the backoffice (next to “Items”, “Tests”… on the top)
-   add tabs to an existing menu entry


