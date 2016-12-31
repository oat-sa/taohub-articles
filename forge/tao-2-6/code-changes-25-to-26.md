<!--
parent: 'TAO 2 6'
created_at: '2013-12-03 10:24:57'
updated_at: '2014-05-27 10:11:23'
authors:
    - 'Joel Bout'
tags:
    - 'Legacy Versions:TAO 2.526'
    - 'Legacy Versions:TAO 2.5'
    - 'Legacy Versions:TAO 2.6'
-->

Code changes 25 to 26
=====================

### User Service

The functions *tao_models_classes_UserService::addUser()* and *core_kernel_users_Service::addUser()* now take the password in clear text instead of md5 encrypted

### Item Model

-   *taoItems_models_classes_ExportableItemModel* has been replaced by *tao_models_classes_export_ExportProvider*
-   *taoItems_models_classes_ImportableItemModel* has been replaced by *tao_models_classes_import_ImportProvider*

### User Session

The interface `common_session_Session` has changed:

-   added **getTimeZone()**, expects a php timezone identifier(http://php.net/manual/en/timezones.php). By default use the constant TIME_ZONE
-   changed **getUserRoles()**, now expects an array of strings(the URIs) instead of an array of resources.
-   added **getUserPropertyValues()**, only used in services (might be moved to separate interface)

### Access Control

The access control has been replaced by an abstraction that needs to implement the interface `tao_models_classes_accessControl_AccessControl`.<br/>

To test whenever the user has access to a functionality please use `tao_models_classes_accessControl_AclProxy::hasAccess($action, $controller, $extension, $parameters = array())`

### Extension Manifest

New properties **license**, **label**.

The property **dependencies** has been replaced with the property **requires** which is an associative array with the structure (extensionId =<br/>
> versionRequired). While the keyword dependencies is still supported it is deprecated will be removed in the future

### Constants

The following constants have been retired:

-   TAOVIEW_PATH
-   TAO_TPL_PATH
-   PROCESS_BASE_WWW
-   WFAUTHORING_CSS_URL
-   WFAUTHORING_SCRIPTS_URL
-   PROCESS_BASE_PATH
-   PROCESS_TPL_PATH

The following constants are deprecates:

-   TAOBASE_WWW

please use the helper `oat\tao\helpers\Template` instead.


