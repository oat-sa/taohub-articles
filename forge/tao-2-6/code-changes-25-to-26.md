<!--
created_at: '2013-12-03 10:24:57'
updated_at: '2014-05-27 10:11:23'
authors:
    - 'Joel Bout'
tags:
    - 'TAO 2 6'
-->

Code changes 25 to 26
=====================

### User Service

The functions *tao\_models\_classes\_UserService::addUser()* and *core\_kernel\_users\_Service::addUser()* now take the password in clear text instead of md5 encrypted

### Item Model

-   *taoItems\_models\_classes\_ExportableItemModel* has been replaced by *tao\_models\_classes\_export\_ExportProvider*
-   *taoItems\_models\_classes\_ImportableItemModel* has been replaced by *tao\_models\_classes\_import\_ImportProvider*

### User Session

The interface `common_session_Session` has changed:

-   added **getTimeZone()**, expects a php timezone identifier(http://php.net/manual/en/timezones.php). By default use the constant TIME\_ZONE
-   changed **getUserRoles()**, now expects an array of strings(the URIs) instead of an array of resources.
-   added **getUserPropertyValues()**, only used in services (might be moved to separate interface)

### Access Control

The access control has been replaced by an abstraction that needs to implement the interface `tao_models_classes_accessControl_AccessControl`.\
To test whenever the user has access to a functionality please use `tao_models_classes_accessControl_AclProxy::hasAccess($action, $controller, $extension, $parameters = array())`

### Extension Manifest

New properties **license**, **label**.

The property **dependencies** has been replaced with the property **requires** which is an associative array with the structure (extensionId =\> versionRequired). While the keyword dependencies is still supported it is deprecated will be removed in the future

### Constants

The following constants have been retired:

-   TAOVIEW\_PATH
-   TAO\_TPL\_PATH
-   PROCESS\_BASE\_WWW
-   WFAUTHORING\_CSS\_URL
-   WFAUTHORING\_SCRIPTS\_URL
-   PROCESS\_BASE\_PATH
-   PROCESS\_TPL\_PATH

The following constants are deprecates:

-   TAOBASE\_WWW

please use the helper `oat\tao\helpers\Template` instead.

Code changes 25 to 26
=====================

### User Service

The functions *tao\_models\_classes\_UserService::addUser()* and *core\_kernel\_users\_Service::addUser()* now take the password in clear text instead of md5 encrypted

### Item Model

-   *taoItems\_models\_classes\_ExportableItemModel* has been replaced by *tao\_models\_classes\_export\_ExportProvider*
-   *taoItems\_models\_classes\_ImportableItemModel* has been replaced by *tao\_models\_classes\_import\_ImportProvider*

### User Session

The interface `common_session_Session` has changed:

-   added **getTimeZone()**, expects a php timezone identifier(http://php.net/manual/en/timezones.php). By default use the constant TIME\_ZONE
-   changed **getUserRoles()**, now expects an array of strings(the URIs) instead of an array of resources.
-   added **getUserPropertyValues()**, only used in services (might be moved to separate interface)

### Access Control

The access control has been replaced by an abstraction that needs to implement the interface `tao_models_classes_accessControl_AccessControl`.<br/>

To test whenever the user has access to a functionality please use `tao_models_classes_accessControl_AclProxy::hasAccess($action, $controller, $extension, $parameters = array())`

### Extension Manifest

New properties **license**, **label**.

The property **dependencies** has been replaced with the property **requires** which is an associative array with the structure (extensionId =\> versionRequired). While the keyword dependencies is still supported it is deprecated will be removed in the future

### Constants

The following constants have been retired:

-   TAOVIEW\_PATH
-   TAO\_TPL\_PATH
-   PROCESS\_BASE\_WWW
-   WFAUTHORING\_CSS\_URL
-   WFAUTHORING\_SCRIPTS\_URL
-   PROCESS\_BASE\_PATH
-   PROCESS\_TPL\_PATH

The following constants are deprecates:

-   TAOBASE\_WWW

please use the helper `oat\tao\helpers\Template` instead.


