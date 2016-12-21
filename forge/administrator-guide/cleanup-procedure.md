<!--
parent:
    title: Administrator_Guide
author:
    - 'Cyril Hazotte'
created_at: '2015-09-15 10:17:28'
updated_at: '2015-12-10 10:11:39'
tags:
    - 'Administrator Guide'
-->

Cleanup Procedure for TAO 3.x
=============================

This part will explain you how to clean you TAO instance. At a certain point you may will to remove all data linked to deliveries.

You can download [here](http://forge.taotesting.com/attachments/download/3868/tabula_rasa.php) a script that will do this cleanup for you. This script will remove all compilations, executions, states and results related to every delivery of you instance. It will keep all others data such as items, tests, test-takers …

This script will work for key-value and ontology storage for each of the data to remove.

You just have to put the script in you taoDelivery/script directory and then go to this directory and execute

    php tabula_rasa.php yes

This will launch the script and tell you what has been removed and if some failure has been encountered

**Note:** The first attached script is compatible with TAO 3.1+ only, while the second works with TAO 3.0 version.

