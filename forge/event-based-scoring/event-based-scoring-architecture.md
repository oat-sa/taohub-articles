<!--
created_at: '2011-03-10 11:44:02'
updated_at: '2013-03-13 13:11:13'
authors:
    - 'Jérôme Bogaerts'
tags:
    - 'Event Based Scoring'
-->



Event Based Scoring Architecture
================================

The global architecture of the EBS component is:

![](http://forge.taotesting.com/attachments/download/379/RM_EBS_Global_architecture.jpg)

1. TAO Events Converter
-----------------------

The TEC component converts the received events from their initial models to the Tao Event Model. This operation guarantees the unification of the trace model and allows a unique computation mechanism by the other components of the scoring engine.

2. TAO Variable Parser
----------------------

This component parses the query formulated with the proposed language and invokes the appropriate score functions from the toolbox (i.e., a flexible and open set of functions dedicated to scoring). In some variable definitions, the source of event traces can be a log file from a specific location. In this case, the Logs Selector component downloads this log and sends it to the Parser. This log will be converted into TAO Event Model by the TEC component.

3. Toolbox of functions
-----------------------

The Toolbox contains all functions needed in the assessment. One can enumerate three kinds\
of functions:

-   Simple Matching and Scoring functions calculate the score according to a direct comparison between the value of an event element and the correct response.
-   Complex Pattern Matching and Scoring functions provide a complex mechanism of matching for some kinds of assessment, especially in problem solving tests. The score depends on the sequence of actions that the test maker accomplished as a response. One can express a complex sequence pattern using several strategies and options inspired from the existing approaches in the field of Complex Events Processing, e.g., the mechanism of pattern matching and finite automata.
-   External Scoring functions are not implemented in the system. They are used just for calling external scoring functions implemented in other systems. This bridge is important to allow a collaboration scoring in an open assessment approach.

4. Variable Generator
---------------------

The Variable Generator intercepts the variables’ values and creates a specific list of variables\
that can be used in two manners:

-   As output of the scoring engine;
-   As input for the Variable Persistence Component in order to set the variables’ values in the Result Ontology


