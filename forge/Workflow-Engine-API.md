<!--
author:
    - 'Lionel Lecaque'
created_at: '2011-09-30 17:42:06'
updated_at: '2011-11-04 15:49:31'
-->

Workflow Engine API
===================

This API allow any services embedded within the Workflow Engine to receive and transmit data via JavaScript to the Engine.

WfApi

-   authenticate(user)

User

-   getRoles

ProcessesManager

-   getAllDefinitions
-   getAssignedActivities
-   getCompletedActivities

ProcessDefinition

-   getName
-   getAllActivities
-   initExecution

ProcessExecution

-   getPath
-   getCurrent
-   getDuration
-   searchInstance(properties)
-   pause
-   cancel
-   resume
-   delete

ActivityDefinition

-   getName
-   getNextConnector
-   getPreviousConnector

ActivityExecution

-   getDefinition
-   getACLMode
-   getDuration
-   getUser
-   assign(User) ??
-   parallalize ??
-   takeOver ??

Connector

-   getNextActivities
-   getPreviousActivities


