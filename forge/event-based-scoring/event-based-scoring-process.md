<!--
created_at: '2011-03-10 11:45:34'
updated_at: '2013-03-13 13:11:44'
authors:
    - 'Jérôme Bogaerts'
tags:
    - 'Event Based Scoring'
-->



Event Based Scoring Process
===========================

Pattern matching process
------------------------

The following figure shows the process of pattern matching in EBS

![](http://forge.taotesting.com/attachments/download/372/RM_EBS_patternMatchingProcess.jpg)

First, the Window Filter provides a set of traces according to the defined interval.

Then, the Symbolization creates the Symbolic TAO Log according to the symbol declarations in the variable descriptions. At this stage, another activity consists in the creation of a new pattern\
based on the Sequence Strategy.

For the third step (Regular Expression Matching), one uses the powerful mechanism of pattern matching of the regular expression in order to extract the subset log. The second activity enables the conversion from the Symbolic TAO Events into its equivalent subset of the initial log. The final step will use this subset as a parameter of the chosen scoring function.


