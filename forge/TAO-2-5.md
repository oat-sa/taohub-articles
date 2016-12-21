<!--
author:
    - 'Jérôme Bogaerts'
created_at: '2013-05-21 09:18:55'
updated_at: '2014-01-14 16:26:14'
-->

TAO 2.5 - Education related Tools Ecosystem interoperability & Standards - Mobile Devices (Fall 2013)
-----------------------------------------------------------------------------------------------------

{{toc}}

Features
--------

### 1. [QTI](http://www.imsglobal.org/question/) 2.1 compliance. Improve the current QTI compliance of TAO by enabling the importation of test definitions.

{{collapse(Details…)

Currently TAO implements QTI 2.0 for items, It covers the different item interactions from the 2.0, composite items, responseProcessing (including customResponseProcessing), stylesheets, external objects and basic content packaging . It doesn’t support Meta-data and usage data, on items: feedbacks and adaptive items, item templates

The plan is to support :\
- Math ML\
- Assesment Test, section and information item model\
From the execution perspective, this is going to be implemented by a new QTI State Machine (allowing for branching and general rules evaluation), but for test banking, the QTI format will be used for storing and authoring. (similarly to the way we proceed for QTI (the rendering html is only used at delivery preparation time).\
This includes Time limitations, Test structure, navigation submission, Pre-conditions and branching and Test Level FeedBack.\
- Meta-data and Usage data

Detailed planned QTI coverage :

|*.Feature |*.TAO 2.4 |\_.TAO 2.5 | Unplanned|\
|Item session | support of interacting and closed state | Fully implement other states : modal feedback, suspended, solution, review\
Support of item session control options whatsoever (this will be made available with the implementation of QTI test, see later slides)||\
|Item variables |Items Variables and Outcome Variables are solely implemented to output the item score for an item | Outcome variable support||\
|Content Model |implemented, except the following entities|Rubric block;FeedbackElement (see 9. Feedback);|Printed variable (see 10. Item emplates); InfoControl ; Number formatting rules|\
|MathML|Currently, no support of MathML at all| Planning to add support of MathML both in authoring and runtime; Combination of Template Variables and MathML||\
|Supported Interactions|\
Choice\
Inline Choice\
Associate\
Order\
Match\
Gap Match\
Hottext\
Text Entry\
Extended text\
Hotspot\
Graphic Order\
Graphic Associate\
Graphic Gap Match\
Select Point\
Slider|\
Media Interaction (music, video: a must)\
End Attempt Interaction (required to trigger feedbacks)|\
Position object interaction (not planned, quite similar to graphic gap)\
Upload Interaction\
Drawing Interaction|\
|Response Processing| The three standard templates are implemented: match correct, map response and map response point.|Allows for custom response processing rule (XML)|Provide commodity to ease the writing of custom response processing rule (limitation to the list of currently implemented operators listed in section 15. Expressions)|\
|Feedback |/|Support for QTI adaptive items;Feedback rule definition;Feedback block and feedback inline;Feedback modal||\
|Item templates|/|/|Support of template declaration and printed variable in authoring;Template processing rule definition;Support of template processing and printed variable on runtime;Enable generation of many versions of an item dynamically on runtime;Enable the cloning engine : batch item creation from an item template|\
|Assessment Test|/|Navigation mode (linear, non-linear);\
Submission mode (individual, simultaneous);\
Time limits (min, max);\
Rubric block (shared stimulus);\
Test-level feedback;\
Random selection of items and item sections;\
Outcome Processing;\
Precondition and branch rules;\
QTI test package validation, import and export;||

The authoring tool of test will be reviewed to build compliant QTI 2.1 test descriptions\
}}

### 2. [Learning Platform Interoperability - LTI](http://www.imsglobal.org/toolsinteroperability2.cfm)

{{collapse(Details…)

This objective has been partly anticipated within TAO 2.4

IMS Learning Tools Interoperability (LTI) provides a single framework or standard way of integrating rich learning applications — in LTI called Tools — with platforms like learning management systems, portals, or other systems from which applications can be launched”called Tool Consumers.\
Enable easy and seamless integration of TAO with Learning Management Systems, access the full learning and assessment functional chain from a single location, easily integrate TAO into your learning legacy systems to create a comprehensive learning and assessment environment.

exposes a tool/content in a secured way available for embedding into an LMS or any other education tool. LTI is actually specifying how to “link” using a secured url a tool consumer and a tool producer as well as returning some standardized information (lti:grade) back or calling back LIS services.

Depending on the configuration, it would allow to link from moodle 2.2 Learning Management System (tool consumer), a test provided by the TAO platform (tool producer) having the required data exchanged automatically and preventing users from encoding general information twice like in this example the learner data. In another configuration, this would allow the tao platform (tool consumer) to link test produce by a third party CBA platform (tool producer) like Concerto for example.

LTI is about linking the services and from that perspective different from a content interoperability standard, the content provided by a tool producer is also serviced by this tool.

LTI 1.1.1 will be implemented in TAO 2.5 according to this implementation guide http://www.imsglobal.org/LTI/v1p1p1/ltiIMGv1p1p1.html\
From the point of view of the standard, the whole specification is planned to be implemented and from a tool perspective :\
- The test delivery service of tao will be exposed as a tool available (TP) from LTI compliant TC.\
- A delivery in TAO (TC) will allow users to embed a test serviced by a third party LTI compliant tool producer.

Documentation of TAO will be updated from an administrative perspective (configure/declare external TP) and from a user perspective (How to embed a test produced by Concerto ? , How to link your tao test from Moodle 2.2)

}}

### 3. Moodle/Sakaï integration

{{collapse(Details…)\
As a consequence on our work on LTI, TAO tests will be embeddable within Moodle and Sakaï courses. The required student/learner information for identification will be exchanged automatically.\
}}

### 4. Software engineering process review

{{collapse(Details…)

Objective anticipated within TAO 2.4

The purpose of this working area is to improve access to extenral contributions into the tao code base. One of the barrier to entry being our SE process including formal code generation from argoUML.

#### Generate the models from the source code instead of the other way round while keeping the consistency.

So far, we were generating the source code from our architecture models.

The advantages were the following :\
- Continuous consistency between the architecture and the source code\
- High quality models as they start from an abstract design.

The drawbacks were the following :\
- PHP5 generation in OS were restricted to argouml tool\
- Access to external contributions may be limited\
- the software engineering is not “common”

So, here is the suggestion on the table :\
What if, instead of looking another tool, we generate the models from the source code ?

Advantages :\
- Consistency would be preserved.\
- No tool dependency, use what the hell you want just yet another uml editor\
- common software dev./ access toe external development.\
- benefit from the community and the partners more easily\
- Changing the Sw dev process would be simple.

Criticisms :\
- This implies more strong check rules on code Architecturing as the coding could not start from conceptual models. Integration process will have to be updated.

#### ArgoUML replacement

As a consequence of the Software engineering review process, a survey of CASE tool will be conducted but it will be up tot he community tto choose their own solution according tot he new process

#### Integration process

From the point of view of the process and ongoing developments over time, the core team will work similarly to the way we work for external contributions, any new development candidate for integration into the tao core will go through the Quality Manager (QM) who is Lionel Lecaque. The QM checks the contribution conformance with coding guidelines, architecture consistency, manifest in the case of extensions, documentation (wiki), checks the coverage of unit tests and run all unit tests to see any side effects of the contribution on the core. The QM, then drives the required issues fixing with the support of the dev team or the external contributor. If the contribution doesn’t match the architecture consistency or if the tool used to document the architecture of the contribution is different, the LA will decide if we will rework the architecture and the source code of the contribution on our own.\
}}

### 5. Assessment delivery on mobile devices

{{collapse(Details…)\
Address today’s test takers technological environments and nomadic access\
Mobile device compatibility (smart phones, tablets…). Ipad IOS, Android, google OS\
Focus will be set on :

-   IOS
-   Android

The target within TAO 2.5 scope consists in making our QTI items to render and support user interactions on mobile devices.\
The TAO platform will remain delivered on mobile devices through the web browser/webkit.

}}

### 6. (Unplanned) [APIP](http://www.imsglobal.org/apip/APIP_PublicDraftv1_20110404.zip) holds potential to improve the validity of test-based inferences for students with disabilities and is best accomplished by applying principles of Universal Design t hroughout the assessment development process.

### 7. (Unplanned) “SIF”

### 8. (Unplanned) SCORM/ Elearning platforms\
Manage test and items from tao as Scorm compliant elearning objects.

### 9. (Unplanned) Provide connectors to legacy systems. Ex. : The tests takers database would reflect what is available from enterprise/school/system databases.

### 10. (Unplanned) Align TAO with SC36 working item draft. To be determined along draft progress.

Migration
---------

Please see [[Migration 2.4 to 2.5]] for instructions on adoptions that might be required in your extensions

