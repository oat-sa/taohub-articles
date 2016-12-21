<!--
author:
    - 'Patrick Plichart'
created_at: '2013-05-21 07:47:27'
updated_at: '2013-05-21 08:02:32'
-->

Past Roadmap Objectives
=======================

TAO 2.4 - Non functionnal : TAO code base Quality Improvements : Unit tests - Database abstraction - Performances (Spring 2013)
-------------------------------------------------------------------------------------------------------------------------------

### 1. PHP 5.4 support

To stay up to date according to PHP’s development, we plan to support PHP 5.4.

### 2. Tests Coverage

This release doens’t include new specific features for users but will improve the overall quality of tao and avoid future regressions and bugs.<br/>

The team will try to reach a unit tests coverage of 80% of all the source code of tao. Currently all unit tests are checked upon release and help to detect any regression, side-effects of new features on the platform.

The unit test framework used will be simpleTest(no change)

### 3. Database abstraction component replacement

Currently TAO uses AdoDB that is now deprecated. TAO would benefit in terms of maintenance and performances from using PDO native implementation now available in PHP.<br/>

In terms of effort, since TAO makes use of standard and simple SQL queries and since AdoDb works similarly, msot of the effort will eb concenntrated on the rewriting of the returned results handling (mixed objects instead of adoDBResult). Running the unit tests, should allow us to detect regressions during the migration. We target to replace AdoDB with [PDO (PHP Data Objects)](http://www.php.net/manual/en/intro.pdo.php). We anticipate to have some performances improvements with this migration.

The team will also check compliance of TAO 2.4 using mainstream SQL database servers for better compatibility and eventually review sql queries.

-   MariaDB (will be fully supported)
-   PostgreSQL (will be fully supported)

Support of proprietary DBMS such as Microsoft SQL Server and Oracle are also on their way for next versions.

### 4. Users And Roles assignment Models

A refactoring of our users amnagements is being performed with aim to improve the overall performances.

### 5. Performances

Several improvements are going to be added to TAO 2.4

1.  A refactoring our users management and roles assignment should result into performances improvements at the level of Users authentication or functionalities access restrictions check.
2.  ADODb replacement. OUr new abstraction Layer PDO brings strong improvements to our performances
3.  PHP 5.4 comes with a major performance gain of approximatively 40%.
4.  Default engine for Mysql tables are set to MyIsam, TAO has been checked successfully using INNODB engine that brings performances improvements

### 6. Extensions’ Mechanism

TAO extensions mechanism had been reviewed and is going to be refactored, the main goal is to provides developers and partners a better set of hooks and Delegation Interface to customize TAO. One result of this work is that some extensions will be split up into multiple parts and benefits from these new features available in the platform. We will keep investigating new features that extensions developers may required in order to continually add hooks and Delegation interface into TAO.

### 7. miscellaneous

1.  Our file widget that you may configure for any new property has been corrected. (This feature enable for example to upload documents along an item)
2.  The QTI authoring tool has been stabilized with more than 15 issues fixed.
3.  Installation procedure reviewed (requirements checks spread over all extensions)

TAO 2.3 - Ease of Install, Extension Management, third-party libraries dependencies rationalization (Aug 2012 TAO 2.3.1 Final Release)
--------------------------------------------------------------------------------------------------------------------------------------

### Easy to use installer<br/>
Reduce time and effort to install and setup TAO, facilitate TAO install for evaluation before final deployment, make install easily done by non-IT users

A new installer has been developped in TAO. It includes new user interfaces built as a wizard, contextual help for every setting asked to the users and feedback help.

### Extensions Management

-   Extension manager . Tao would benefit from an embedded service enabling user to browse and install easily extensions directory providing dedicated features or custom adaptations of the tao platform.<br/>

    The extension manager has been partly implemented in TAO 2.3, it is available under the settings pane of the backoffice. You amy easily install new extensions from there. The online directory exposing all available extensions hasn’t been set up yet.

<!-- -->

-   Upgrading the platform Automatic update of the platform on startup (patching mechanism) (Feature \#511)

### Third-party libraries dependencies

Multiple instances of the same third party component were included in the platform using different versions. It was resulting into a more complex maintainance and also some performances decrease on the client side. A complete refactoring and review of the code has been implemented. Redundant libraries have been removed.

An improvement to the way libraries are included and laoded will be investigated by 2013 Q1. Solutions like http://getcomposer.org/doc/00-intro.md will be evaluated

TAO 2.2 - Advanced Grading and Resources Versioning capabilities (July 2012 TAO 2.2 Final Release - Partly implemented)
-----------------------------------------------------------------------------------------------------------------------

### 1. Human-Based Scoring<br/>
*This work is achieved in close collaboration with the medical university: Karolinska Institute and is currently applied in the domain of Health-Care Education*

\> **Status**<br/>
The human based scoring has been partly implemented within the 2.2. Using TAO 2.2 version of TAO, you may first install the the human based grading extension quite easily by going to the settings menu, extensions manager then search for the grading extension and clikc on the install button.

This will enable the grading functionnality, includign the possibility to define scoring guidelines, a score scale (min, max, step) for every QTI item interaction. After data collection, independenant graders may score individuals for every essay, input against the scoring guidelines. The conflict reconciliation supporting features (if independant graders give different scores) is not yet available within the 2.2.

\> Improve the quality and reliability of multiple expert scoring through process based guidance and reconciliation features, monitor scoring process along user-defined scoring quality processes. Basically, this scoring process includes two main activities. The grading itself, which is achieved by one or many “graders”. The grader is presented with anonymous responses arising from test deliveries and who is expected to “grade” the responses according to a configurable scale and consulting the scoring guidelines. Secondly, the “conflicts solving” activity which purpose is to solve contradictory conflicts in scores given by the different graders and which could result from misinterpretation of scoring guidelines.

\> Other benefits included the possibility to use the anonymous statistics from conflicting scores and graders’ work to adapt the assignation of scoring tasks to scores thus improving the entire quality of the results management. These accomplishments and others like assessment from the test takers performance is thereby going to enhance on the overall course improvement and making amendments where needed.

\> Functionalities :<br/>

\> \* Specify a scale (min, max, and step) for the manual grading of items in item authoring tool<br/>
\> \* Provide a GUI, in the results extension, enabling graders to browse test takers (anonymously or not) and grade for each items and interactions of items according to the specified scale. Advanced browsing will make use of properties defined on items as criteria to grade by focusing exclusively on subsets of items.<br/>

\> \* Reconciliation user interface exposing all conflicting grades from graders and prompting for a reconciled score<br/>
\> \* Compute statistics from grades.

### 2. Resources (Item Bank) Versioning\*

\>Items, Tests but also other resources of TAO evolve over time. CBA brings some specific challenges in terms of management like the issue of collecting data from items which have evolved between the data collection and the data analysis, etc.<br/>

\>his new capability enable to manage the different versions of resources, check the history of modifications and perform “version restore” operations.

### 3. Bug fixes

\>The TAO 2.2 will bring many bug fixes not yet release since the last 2.1 version of tao.<br/>

\>[List of Solved issues in 2.2](http://forge.taotesting.com/projects/tao/issues?set_filter=1&f[]=status_id&op[status_id]=o&f[]=fixed_version_id&op[fixed_version_id]=%3D&v[fixed_version_id][]=71&f[]=&c[]=status&c[]=priority&c[]=subject&c[]=author&c[]=assigned_to&c[]=updated_on&c[]=fixed_version&group_by=)

TAO 2.1 Scalability (TAO version 2.1 released)
----------------------------------------------

High-scalability is a key feature for any CBA platform. The context of education introduces more challenging situations than classical web applications in terms of figures and the way work flows. The TAO platform and the team learned from interesting national feedback : In the luxembourgish monitoring project, TAO had to face 6,000 students clicking on the “start the test” button almost at the same time since the project schedule was the same for all classes. Most teachers decided to write the URL of the TAO platform on board and tell the students to click at a specific time. This involved peaks on the use of the server farm.

In addition to the specificity of the educational context, scalability is a key feature since you have high stakes assessments where service denial are not an option and it is also important in terms of psychometric validity.

In order to improve the scalability of the platform,

\* Systematic benchmarks tests should be planned for every contribution. This can be achieved with JMeter software (pure large scale benchmark), Selenium (user-experience benchmark)

\* Experimentations on different backend should be achieved:

1.  TAO could benefit from a replacement of MySQL to a clustered database management system like postgreSQL
2.  TAO could benefit from a replacement of the current MySQL storage to a prolog based storage. Prolog being dedicated to the problematic of large knowledge base management. This improvement takes place into Generis.
3.  TAO could benefit from a complete replacement of the RDF repository used for other existing systems like Virtuoso.
4.  TAO could benefit from a different storage schema of Generis, we could change the way the data is stored into Generis and have several tables like classes, instances and properties and/or a global resources table instead of a unique fine-grained statements table.
5.  TAO could benefit from a different behavior of the API, the knowledge base could be “compiled” and generate specific db schema based on classes, properties and instance, every services from the API would be re-routed to this specific database. The system could also reverse this back to the statements tables for any design related operation.

-   another lead consists in correctly informing CBA managers of this problematic. Very often and since this is a hidden issue when handling the system, CBA managers are not aware of this problematic and don’t address it. Improve communication on this issue, provide tools and methodology to evaluate and address the risk.

Edit : Scalability features have been adressed within tao 2.1. The changes includes : PostgresSql compatibility and enabling database clustering, compilation of data into a classical relationnal database, algorithmics improvements. There are some significant improvements in terms of performances based on Jmeter benchamrks (available in the Files section). We still need to provide CBA managers with information/guidelines on IT infrastructure required based on relevant attributes like the number of test takers, the distribution of load, the number of items, the weight of every items, etc. A large contribution into this was achieved by Tudor.

TAO 2.0 Governing CBA Organisational processes with TAO Advanced workflow features (TAO 2.0 released)
-----------------------------------------------------------------------------------------------------

CBA operations can be achieved by the TAO platform, this includes, Items authoring, Subjects import, tests definition, Items translation, etc. For larger stakes, needs or scale, there is often a need to conduct organisational processes and the way the cba operations are performed by every stakeholders having a role into this process.<br/>

According to tools provided and described above there is a need for advanced features of the workflow engine so that CBA managers may design their own specific CBA process for translation, item authoring, item review, test takers free response coding etc. This means to define activites of the process, roles and CBA operations with their related tool/feature from tao expected to be used.

The TAO workflow engine is now available and enable you to design such organisationnal processes involving parts of tao, specific features at the righ time for the right user. There are still some functionnal requirments here :

Being able to assign an activity to a specific user at run time by opposition to the design of a fixed role at process design time (a translation process could include an activity where a manager decide who is able to translate this item for the next activity.<br/>

In addition, it should be possible to add set/bag activities with general selection algorithms, like a random selector (which would be useful especially at the level of the test delivery for adaptive testing).

-   A detailed email reporting system warning stakeholders on the progress of the processes or warning them that they are expected to take and perform some specific activity. A specific time engine could also improve time management in processes including time limitations or expiration timeouts.
-   A process Monitoring Board dedicated to administrators will enable to re-assign activities, cancel processes, view elapsed time for activity/process, view last visited time for activty/process.
-   The possibility to design navigation policies (going backwards/forward) inside the process.
-   The possibility to design how variables will evolve when going backwards (revert ?, keep up to date?, user-defined ?)
-   In addition to those new features an API would allow to pilot running processes and perform basic administrative tasks, like reassignment of activities, processes removal or reinitialization.

There are other features required for the workflow engine induced by the advanced tests section of this page.

### Specific tools for specific tasks of CBA processes (TAO 2.0 released)

The computer based assessment platform and authoring facilities are crucial but CBA usecases also require companion/extra tools for the different stakeholders to perform their usual tasks like an item translation tool with a translation memory, an item review/feedback tool, a test-taker free response coding tool with instructions, advanced statistical tool for results. Those tools are intended for non technical persons and are part of the whole CBA process. Thankfully, the TAO platform comes with a workflow engine. There is a need to identify classic processes used in CBA projects, and provide tools involved in those projects together with the TAO platform.

Related tasks
-------------

-   \#792 Governing CBA Organisational processes with TAO Advanced workflow features
-   \#799 Specific tools for specific tasks of CBA processes
-   \#804 Advanced Tests - User Friendly Authoring tool, I18N, Sub-processes, …
-   \#814 Advanced Results
-   \#820 Ease of Installation
-   \#825 Ease of Use
-   \#828 Delivery Media
-   \#833 Test Delivery Security
-   \#839 General Security Review
-   \#842 Standards & Softwares

