<!--
parent: Tutorials
created_at: '2013-05-24 07:53:53'
updated_at: '2016-05-25 10:48:54'
authors:
    - 'Joel Bout'
tags:
    - Tutorials
-->

How to deliver a test using LTI
===============================



Preparation
-----------

1.  Install TAO 2.4+
2.  Install a LTI Consumer (This tutorial uses Moodle 2.4 https://moodle.org/)
3.  in TAO: Create a delivery ([Steps to create an assessment](../user-guide/steps-to-create-an-assessment.md))
4.  in Moodle: Create a course (http://docs.moodle.org/24/en/Create_your_own_course)

LTI Installation
----------------

-   to Install the required extensions in Tao:<br/>

    \*\# go to Settings (Upper right corner)
    \*\# open the tab **Extensions manager**
    \*\# select the extensions **ltiDeliveryProvider** and **ltiProvider**
    \*\# click on install and confirm
    \*\# once the extensions are installed, reload the page.

\> {{thumbnail(tao_after_lti_install.png, size=500, title=TAO Extensions manager after install)}}

Exchange Credentials
--------------------

-   in TAO\
    \*\# click on the new tab **LTI Consumers** on the settings page
    \*\# select the class LTI Consumer and click on **add Consumer**
    \*\# Name the new consumer and fill in any key and secret you like, callback URL can be left empty
    \*\# click on create (if the consumer does not immediately appear in the list, reload the page)

\>{{thumbnail(tao_lti_consumer.png, size=700, title=LTI Consumer configuration in TAO)}}

-   in Moodle as administrator\
    \*\# Go to **Site administration** and open **Plugins** (under advanced features) ~~\> **Activity modules**~~\> **Manage activities**
    \*\# Open **Settings** of the **External Tools** and click on **Add external tool configuration**
    \*\# Name your configuration and enter the same Consumer Key and Shared Secret that you used in TAO
    **\# The Tool Base URL is TAO_ROOT_URL +**‘/ltiDeliveryProvider/DeliveryTool/launch’\*.
     (If you don’t know the url of your TAO instalation then return to the TAO back office home, look at your url and remove ‘tao/Main/index’.
     So if your TAO home is ‘http://localhost/tao24/tao/Main/index’ then your root url would be ‘http://localhost/tao24/’.)
    \*\# click on ‘save Changes’

\>{{thumbnail(moodle_lti_config.png, size=700, title=LTI Provider configuration in Moodle)}}

Add the Delivery to Moodle
--------------------------

-   in TAO\
    \*\# Open the Deliveries and select the delivery you prepared earlier
    \*\# Please make sure the delivery has been compiled
    \*\# Now you should have an action without icon called **LTI export**. Please copy the link it generates.

\>{{thumbnail(tao_lti_export.png, size=700, title=TAO Delivery Link export)}}

-   in Moodle as a teacher\
    \*\# Open your course in edit mode
    \*\# click on **Add an activity or resource**, select **External Tool** and click on **add**
    \*\# Name your activity and copy the url into the **Launch URL** field. Right of the URL a green check mark should appear
    \*\# Click on **Save and return to course** to finish adding your TAO delivery to a Moodle course

\>{{thumbnail(moodle_link_config.png, size=700, title=LTI Link configuration in Moodle)}}

Testing it
----------

\*<br/>
# Login as a student registered in your course\
\*<br/>
# Select the course and click on the activity\
\*<br/>
# ???<br/>

\*<br/>
# Profit


