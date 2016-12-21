<!--
parent:
    title: Documentation_for_core_components
author:
    - 'Jérôme Bogaerts'
created_at: '2011-03-04 17:39:38'
updated_at: '2013-03-13 12:56:43'
tags:
    - 'Documentation for core components'
-->

Models
======



Service Oriented Models
-----------------------

In order to access the model data, we use services as a unique entry point. The services are designed to manage the data from the different data sources. The TAO meta-extension contains the main service structure, the service utilities and abstract class to enable the other extensions to extend.<br/>

The advantages of such an architecture are:

-   a shared public interface of management method. Even though it’s not implemented yet we can use it with only the methods prototype.
-   a unique entry point, either to use it in the modules, the unit tests or the scripts.
-   the use of a Factory to serve singleton instance of a service, that could be used from any part of the code sharing its internal resources.
-   easy to maintain and re-implement. For instance, in a web service.

![](http://forge.taotesting.com/attachments/393/service-model.png)

-   The *Service* class is an abstract class used as a type and for polymorphism. Any service must extend that class or the one of its children.
-   The *ServiceFactory* class enables you to get a service instance. It’s a central way to retrieve a service, so we can load services dynamically and manage single/multiple references of a service.
-   The *TaoService* manages the extension loading (using a bridge to the Extension Manager) and loads the extension and section structure into the actions/structure.xml file (XML and API data sources). It’s a high-level service regarding the TAO meta-extension management.
-   The *UserService* is a common service implementation to manage user from the API.
-   The *GenerisService* is an abstract service. It provides a set of methods shared between the extension’s services that are managing a RDF model.

![](http://forge.taotesting.com/attachments/download/215/returnTopArrow.JPG)[[Models|Return to Top]]

