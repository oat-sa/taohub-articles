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

