<!--
parent:
    title: Contribution_Focus_Groups
author:
    - 'Patrick Plichart'
created_at: '2013-10-15 10:48:26'
updated_at: '2013-10-17 14:31:22'
tags:
    - 'Contribution Focus Groups'
-->

Alternative Results Storage Focus Group
=======================================

Objective
---------

The objective is to leverage the functionality provided by external systems in terms of data reporting by using the alternative results storage capability built in TAO 2.5.

Members
-------

-   Patrick Plichart
-   Doug Wilson
-   Lionel Lecaque
-   Mari-Paullina Vainikainen

Mailing List
------------

ers[@]taotesting.com

Coordinator
-----------

Patrick Plichart

Activities
----------

### Document the result storage interface and provide a “Hello world” extension of TAO implementing that interface.

Volunteer : Patrick<br/>
Status : done<br/>
If there is a need to extend the interface or for further documentation let me know, the materials are linked below.

### Identify the most relevant data repositorie(s)

Which data repository do we focus on ? What are JasperSoft connector possibilities ?

Volunteer :

### Document the data repository access protocol (HTTP-based REST? SOAP?, SQL?, credentials, security related aspects, etc.)

Volunteer :

### Implement an extension of TAO implementing the storage into the target data repository.

Volunteer :

### Test the extension

Volunteer : Patrick

### Integrate the extension in the official release of TAO

Volunteer : Lionel

Materials
---------

- [[Result Storage Interface| Result Storage Interface (TAO 2.5)]]<br/>
- [[Results Data Model| taoResults Storage Data Model (TAO 2.5)]]

- taoResultsUdp.zip, a simple new extension implementing a basic forward of the collected data over UDP.

- The existing results storage possibilities

1.  taoResults implementation : The tao results model documentation
2.  taoLtiBasicOutcome implementation

- JasperSoft data ware house connectors possibilities documentation<br/>
- Meeting Minutes

