<!--
parent:
    title: How_TAO_development_works
author:
    - 'Jérôme Bogaerts'
created_at: '2010-10-05 15:05:55'
updated_at: '2013-03-13 15:20:02'
tags:
    - 'How TAO development works'
-->

{{\>toc}}

Issues
======

Issues include bugs, features, support or documentation matters.

A reporter creates an issue in the default status **New**.\
If it’s a bug, the issue revision where the error appears has to be specified.

Then, the manager has 4 alternatives:

1.  He needs more information to understand the issue: he sets the issue to the **Feedback** status
2.  He assigns the issue to someone: he sets the issue to the **Assigned** status
3.  He does not want to treat the issue : set the issue in **Rejected** status
4.  No one is available to handle the issue but the issue is relevant : set the issue in **Confirmed** Status

Once the assigned person begins to work on the issue, he defines the percentage he has achieved and sets the issue status to **In progress**.

Once the issue seems to be resolved, the assigned person sets it to **To be tested** status.\
The solution will be clearly defined :

-   if it concerns a development version, the revision number shall be specified in the comment.
-   if it is developed on a released version, a patch have to be attached to the issue and the modalities to apply it have to be explained in comment.

The reporter has to test if the solution is OK.\
He has two possibilities:

1.  if the solution is satisfactory: he sets the issue to a **Resolved** status
2.  if the solution is not satisfactory: he sets the issue to a **Reopened** status and he specifies why it is reopened.

Finally, at the next release, all fixed issues are released and transferred into **Closed** status.\
When a release is under process, no issue should be closed.

Tracker
-------

The field *Tracker* is the issue’s type.

\>**Bug**\
\>\
\> You choose **Bug** if you want to report an error in a TAO version.\
\> You have to\
\> \* summarize the error\
\> \* explain everything that can be useful to reproduce it\
\> \* specify the TAO version if you are in test mode

\> **Feature**\
\>\
\> You choose **Feature** if you want to add a new feature.\
\> If you want to add it in the roadmap of a version, you have to specify the Target version.

\> **Support**\
\>\
\> You choose **Support** if you want to add some requirements for documentation, or formation, or other things that are not directly connected to the code of TAO tool.

Status
------

\>**New**\
\> Default status for new issue.\
\>\
\>**Feedback**\
\> The manager needs more information from the reporter to understand the issue.\
\>\
\>**Assigned**\
\> The issue has been allocated to someone.\
\>\
\>**In progress**\
\> The assigned developer is working on the issue.\
\>\
\>**To be tested**\
\> The issue has been resolved but need to be tested by the reporter\
\>\
\>**Resolved**\
\> The issue is resolved.\
\>\
\>**Reopened**\
\> The solution is not good. The issue is reopened.\
\>\
\>**Rejected**\
\> The issue won’t be / doesn’t need to be solved.\
\>\
\>**Closed**\
\> The solution to this issue is released.

Target Version
--------------

The Field **Target Version** is used to build the versions’ roadmap.\
The **Target Version** has to be set if the issue’s solution has to be integrated in the target version’s roadmap.

If you want to add a new **Target version** or to manage existing versions, you have to play the role of a *Manager* for the project.\
You go to *Settings* tab, then to the *Versions* tab.\
You can add new version (to create new roadmap) or edit an existing version to change its parameters.

Tested Version
--------------

The **Tested Version** field appears only if the **Tracker** is a **Bug**.\
The idea is to put the TAO version for each encountered problem.

