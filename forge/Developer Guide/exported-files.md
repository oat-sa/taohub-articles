<!--
parent: 'Developer Guide'
created_at: '2016-03-30 15:37:11'
updated_at: '2016-03-31 09:41:49'
authors:
    - 'Antoine Robin'
tags:
    - 'Developer Guide'
-->



Exported Files
==============

This article will show and explain exported files that you can get from TAO.

These files are CSV files so they will be displayed as a table when opened with a spreadsheet software, in reality, every column is separated by commas and the text is in quotes. There are samples of each exported files at the end of this page.

Results Files
=============

This part will be about the possible files you can get from TAO concerning the results part

Complete export
---------------

First, you can have a complete export of the results. This will gather all results to all items of every delivery executions. This file should look like the following example:

  item           identifier             value                                                                                                                                                                                                                                                                                                              test_taker
  -------------- ---------------------- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ --------------
  Item 1 Label   numAttempts            O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";s:0:\"\";s:17:\"candidateResponse\";s:4:\"MQ==\";s:10:\"identifier\";s:11:\"numAttempts\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.74728000) 1459336098\\";}          Test taker 1
  Item 1 Label   RESPONSE_identifier   O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";b:0;s:17:\"candidateResponse\";s:4:\"MA==\";s:10:\"identifier\";s:19:\"RESPONSE_identifier\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.36770800) 1459336118\\";}       Test taker 1
  Item 1 Label   SCORE                  O:46:\\[taoResultServer_models_classes_OutcomeVariable\\](../resources/7:{s:13:\"normalMaximum\";s:0:\"\";s:13:\"normalMinimum\";s:0:\"\";s:5:\"value\";s:4:\"MA==\";s:10:\"identifier\";s:5:\"SCORE\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:5:\"float\";s:5:\"epoch\";s:21:\"0.76872100) 1459336098\\";}   Test taker 1
  Item 2 Label   numAttempts            O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";s:0:\"\";s:17:\"candidateResponse\";s:4:\"MQ==\";s:10:\"identifier\";s:11:\"numAttempts\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.74728000) 1459336098\\";}          Test taker 1
  Item 2 Label   RESPONSE_identifier   O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";b:0;s:17:\"candidateResponse\";s:4:\"MA==\";s:10:\"identifier\";s:19:\"RESPONSE_identifier\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.36770800) 1459336118\\";}       Test taker 1
  Item 2 Label   SCORE                  O:46:\\[taoResultServer_models_classes_OutcomeVariable\\](../resources/7:{s:13:\"normalMaximum\";s:0:\"\";s:13:\"normalMinimum\";s:0:\"\";s:5:\"value\";s:4:\"MA==\";s:10:\"identifier\";s:5:\"SCORE\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:5:\"float\";s:5:\"epoch\";s:21:\"0.76872100) 1459336098\\";}   Test taker 1
  Item 1 Label   numAttempts            O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";s:0:\"\";s:17:\"candidateResponse\";s:4:\"MQ==\";s:10:\"identifier\";s:11:\"numAttempts\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.74728000) 1459336098\\";}          Test taker 2
  Item 1 Label   RESPONSE_identifier   O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";b:0;s:17:\"candidateResponse\";s:4:\"MA==\";s:10:\"identifier\";s:19:\"RESPONSE_identifier\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.36770800) 1459336118\\";}       Test taker 2
  Item 1 Label   SCORE                  O:46:\\[taoResultServer_models_classes_OutcomeVariable\\](../resources/7:{s:13:\"normalMaximum\";s:0:\"\";s:13:\"normalMinimum\";s:0:\"\";s:5:\"value\";s:4:\"MA==\";s:10:\"identifier\";s:5:\"SCORE\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:5:\"float\";s:5:\"epoch\";s:21:\"0.76872100) 1459336098\\";}   Test taker 2
  Item 2 Label   numAttempts            O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";s:0:\"\";s:17:\"candidateResponse\";s:4:\"MQ==\";s:10:\"identifier\";s:11:\"numAttempts\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.74728000) 1459336098\\";}          Test taker 2
  Item 2 Label   RESPONSE_identifier   O:47:\\[taoResultServer_models_classes_ResponseVariable\\](../resources/6:{s:15:\"correctResponse\";b:0;s:17:\"candidateResponse\";s:4:\"MA==\";s:10:\"identifier\";s:19:\"RESPONSE_identifier\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:7:\"integer\";s:5:\"epoch\";s:21:\"0.36770800) 1459336118\\";}       Test taker 2
  Item 2 Label   SCORE                  O:46:\\[taoResultServer_models_classes_OutcomeVariable\\](../resources/7:{s:13:\"normalMaximum\";s:0:\"\";s:13:\"normalMinimum\";s:0:\"\";s:5:\"value\";s:4:\"MA==\";s:10:\"identifier\";s:5:\"SCORE\";s:11:\"cardinality\";s:6:\"single\";s:8:\"baseType\";s:5:\"float\";s:5:\"epoch\";s:21:\"0.76872100) 1459336098\\";}   Test taker 2

Here you can see that the file is divided into 4 parts:

-   The first column will show you the item label so you will know to which item the test-taker was answering.
-   The second part is the identifier of the variable. For instance, this part will make your search clearer and simpler if you want only score variable

\* The third column is the most tricky one. It contains the php serialized variable, it can be a response, an outcome or a trace variable. Letters followed by colons and numbers correspond to the type of the following variable (O= Object, s = string, i = integer …) the number corresponds to the length of the variable. For each variable you will have first the variable class (taoResultServer_models_classes_ResponseVariable, taoResultServer_models_classes_OutcomeVariable or taoResultServer_models_classes_TraceVariable) then between curly braces you will have multiple couples of property name and value. For example :

    s:17:\"candidateResponse\";s:4:\"MQ==\";

says that the property candidateResponse (which is a string of length 17) has for value MQ== (a string of length 4). This leads us to the last point, some of the values are base64 encoded. This is true for the candidateResponse of a ResponseVariable and the value of an OutcomeVariable. So you will have to decode them in order to get a human readable value.

-   The last one is the login of the test-taker that gives these answers.

Filtered export
---------------

From the export result file we can generate a filtered file that contains only the response for each item. This file is simpler than the previous one and is formatted like that :

  item           identifier              correct   response   timestamp               taker
  -------------- ----------------------- --------- ---------- ----------------------- --------------
  item 1 Label   Response_identifier    0         MA==       0.36770800 1459336118   Test taker 1
  item 1 Label   Response_identifier2   0         W10=       0.36770800 1459336118   Test taker 1
  item 2 Label   Response_identifier    1         MA==       0.36770800 1459336181   Test taker 1
  item 2Label    Response_identifier2   0         PD4=       0.36770800 1459336181   Test taker 1

This file is simple, you have 6 columns.

-   Item label
-   Response identifier
-   Correctness of the answer. This column is a boolean to say if the response is true or false
-   Candidate response (base 64 encoded)
-   The time when the test-taker respond to the item
-   Test-taker login

Monitoring Files
================

Delivery execution monitoring
-----------------------------

This file allows you to have an overview of the delivery executions of your instance. This file is divided into 4 column.

  test_taker   nb_item   nb_executions   nb_finished
  ------------- ---------- ---------------- --------------
  test          18         2                2
  taker1        20         3                2

The first column is the test-taker login, the second one is the number of items answered by this test-taker. Then we have the number of executions started by this test-taker. Finally, we have the number of tests the test-taker has finished.


