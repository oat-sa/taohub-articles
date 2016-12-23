<!--
created_at: '2011-03-10 11:45:09'
updated_at: '2013-03-13 13:11:26'
authors:
    - 'Jérôme Bogaerts'
tags:
    - 'Event Based Scoring'
-->



Event Based Scoring Model
=========================

Here is the event model that is used to trace activities of test takers:

-   *Trace* = seq{ *E1\*,E2…En* }
-   *Event* E: set { _VV1,VV2…VVm_}
-   *VV* : (Variable , Value)
    -   Fixed variables, TAO variables (source, time,…)
    -   Embedded score variables ( score variables calculated by the item)
    -   DataType of variable
    -   Possible values of a variable. ( events name, true, false, string…)

Example :




            stimulus
            RADIO_BTN
            1830
            choice1


            stimulus
            BUTTON
            1962
            btn_next


