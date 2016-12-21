<!--
parent:
    title: Tutorials
author:
    - 'Joel Bout'
created_at: '2013-05-24 07:53:53'
updated_at: '2016-05-25 10:48:54'
tags:
    - Tutorials
-->

How to deliver a test using LTI
===============================



Preparation
-----------

1.  Install TAO 2.4+
2.  Install a LTI Consumer (This tutorial uses Moodle 2.4 https://moodle.org/)
3.  in TAO: Create a delivery ([[Steps\_to\_create\_an\_assessment]])
4.  in Moodle: Create a course (http://docs.moodle.org/24/en/Create\_your\_own\_course)

LTI Installation
----------------

-   to Install the required extensions in Tao:<br/>

    \*\# go to Settings (Upper right corner)<br/>
    \*\# open the tab **Extensions manager**<br/>
    \*\# select the extensions **ltiDeliveryProvider** and **ltiProvider**<br/>
    \*\# click on install and confirm<br/>
    \*\# once the extensions are installed, reload the page.

\> {{thumbnail(tao\_after\_lti\_install.png, size=500, title=TAO Extensions manager after install)}}

Exchange Credentials
--------------------

-   in TAO<br/>
    \*\# click on the new tab **LTI Consumers** on the settings page<br/>
    \*\# select the class LTI Consumer and click on **add Consumer**<br/>
    \*\# Name the new consumer and fill in any key and secret you like, callback URL can be left empty<br/>
    \*\# click on create (if the consumer does not immediately appear in the list, reload the page)

\>{{thumbnail(tao\_lti\_consumer.png, size=700, title=LTI Consumer configuration in TAO)}}

-   in Moodle as administrator<br/>
    \*\# Go to **Site administration** and open **Plugins** (under advanced features) ~~\> **Activity modules**~~\> **Manage activities**<br/>
    \*\# Open **Settings** of the **External Tools** and click on **Add external tool configuration**<br/>
    \*\# Name your configuration and enter the same Consumer Key and Shared Secret that you used in TAO<br/>
    **\# The Tool Base URL is TAO\_ROOT\_URL +**‘/ltiDeliveryProvider/DeliveryTool/launch’\*.<br/>

     (If you don’t know the url of your TAO instalation then return to the TAO back office home, look at your url and remove ‘tao/Main/index’.<br/>

     So if your TAO home is ‘http://localhost/tao24/tao/Main/index’ then your root url would be ‘http://localhost/tao24/’.)<br/>
    \*\# click on ‘save Changes’

\>{{thumbnail(moodle\_lti\_config.png, size=700, title=LTI Provider configuration in Moodle)}}

Add the Delivery to Moodle
--------------------------

-   in TAO<br/>
    \*\# Open the Deliveries and select the delivery you prepared earlier<br/>
    \*\# Please make sure the delivery has been compiled<br/>
    \*\# Now you should have an action without icon called **LTI export**. Please copy the link it generates.

\>{{thumbnail(tao\_lti\_export.png, size=700, title=TAO Delivery Link export)}}

-   in Moodle as a teacher<br/>
    \*\# Open your course in edit mode<br/>
    \*\# click on **Add an activity or resource**, select **External Tool** and click on **add**<br/>
    \*\# Name your activity and copy the url into the **Launch URL** field. Right of the URL a green check mark should appear<br/>
    \*\# Click on **Save and return to course** to finish adding your TAO delivery to a Moodle course

\>{{thumbnail(moodle\_link\_config.png, size=700, title=LTI Link configuration in Moodle)}}

Testing it
----------

\*\# Login as a student registered in your course<br/>
\*\# Select the course and click on the activity<br/>
\*\# ???<br/>

\*\# Profit
