<!--
parent:
    title: How_TAO_development_works
author:
    - 'Cyril Hazotte'
created_at: '2011-04-22 12:00:52'
updated_at: '2013-10-28 15:33:45'
tags:
    - 'How TAO development works'
-->

{{\>toc}}

How TAO development works
=========================

1. Overview
-----------

As an open source project, TAO is open to any contributor who demonstrates commitment to the project.

###1.1 What can you do?{#11-what-can-you-do}

If you are interested in contributing to TAO, you have various options:

-   Anyone can express new requirements they are interested in. The more detailed your requirement is, the higher chance this functionality is to be included in the roadmap, and part of the next version. Use the menu **New Issue** and choose the tracker **new feature**
-   Developers can develop new extensions as TAO was built to be completely modular. See Howto [[Make a new extension]]
-   Developers can help us fixing issues/enhancing feature/adding UnitTest. See Howto [[Change core code|Change code]]
-   Anyone can translate TAO in another language. See Howto [[Translate TAO into other languages]]
-   Anyone can help us improve TAO Documentation. See Howto [[Help document TAO]]
-   Anyone can join the testing effort. See Howto [[Join the testing effort]]

###1.2 How can you do it?{#12-how-can-you-do-it}

In order to contribute to the testing effort or to post new features, you need to use the appropriate tracker for **New Issue**. You will get the opportunity to discuss it with the team into more details and then, we’ll decide on which future version it could be made available (roadmap).

For contributions in developments and translations, send us a patch. Patches have to be uploaded on the forge with a description of the improvement. Our TAO Master will evaluate the integration of the patch.

For documentation contributions, you can do this through the use of the wiki.

2. Releases Cycles.
-------------------

TAO is periodically released according to an announced schedule: we usually target one major release and two minor releases every year. We usually spend 3-6 months working on a release ([[Past release history]]).

At the beginning of a new release phase, we first put efforts working on refactoring existing features, fixing bugs and cleaning old issues, update documentation, update build script. We then focus on developing the set of Features according to the [[Plans\_for\_the\_future|roadmap]].

Occasionally some alpha versions may be released without warranty on the stability. Such versions shouldn’t be used for production mode.

We then focus on building a Beta version that usually comes out 3-4 weeks before the announced release day.

The Beta release is nearly complete and free of major bugs like installation problems, it will work on different Operating Systems (Windows, Linux), users will edit/run items and tests. It is recommended for a larger (but still technically inclined) audience.

When releasing the beta version, all features (model and database, installation procedures, config files) that may impact externals extensions will be frozen in order to let community work on updating their extension according to the next release. An updating extension procedure will also be published during the following days of the Beta version.

One week before the scheduled release, we publish Release Candidate versions. As the final release approaches, our focus narrows to fixing “showstopper” bugs and performing very thorough validation of key features of the TAO product.

![](http://forge.taotesting.com/attachments/789/devCylce.png)

3. Patch Policy
---------------

During the development phase, we keep updating TAO from major issue. SVN-Patches are created and are directly provided to the community in the *comment* section of the related issue. Patch receives an incremental number and in the following days of the patch creation, the version available on TAO website will be updated and renamed according to the patch number. Patch’s Numbers are managed by the target version’s Head Developer.

For instance, if the version of TAO available on the TAO website is *TAO 2.1.01*, *2.1* indicates the version number and *.01* indicates that the patch *01* had been applied.\
All available patches for a version may also be found in the [SVN](http://forge.taotesting.com/projects/tao/repository/show/patchs)

4. Contribution
---------------

TAO is the result of the work of many developers. Here is a [list of TAO’s contributors](https://www.tao.lu/html/index.php?option=com_content&view=article&id=115&Itemid=161). If your name is missing, please let us know.

In order to improve the efficiency of the team’s work, we set up some tools within the TAO Forge.

###4.1. TAO Forge{#41-tao-forge}

TAO source code is available on the [Subversion repository](http://vcs.taotesting.com/svn/tao/). There is an update every day made by our team.

All feedbacks from the community are also gathered in the [TAO Forge](http://forge.taotesting.com/projects/tao/issues), you can find more detailed information about **[[Issues|issues]]**.

By default, people enroled in the TAO Forge have a *reporter* status/role.

The *reporter* can

-   create issues
-   add comments on his/her own issues
-   participate to a forum
-   be assigned to an issue
-   send patches to be tested by *developers*
-   participate to issues by commenting them

TAO Team members are *developers*. A *developer* can

-   do everything a reporter does
-   modify issues
-   commit developments in subversion

If you want larger access rights, please let us know !

###4.2. Validation{#42-validation}

Over time, TAO is getting more and more complex (see [[TAO Architecture]]), meanwhile here is a list of TAO team members that can help you for different sections listed below and who will be in charge of validating contributions and assure the overall TAO Product Quality. Please be also sure to follow [[guidelines]] and common conventions used by the TAO team.

**TAO Product** [Patrick Plichart](http://forge.taotesting.com/users/339), [Raynald Jadoul](http://forge.taotesting.com/users/630)\
**Generis Core** [Lionel Lecaque](http://forge.taotesting.com/users/305), [Patrick Plichart](http://forge.taotesting.com/users/339)\
**TAO Core** [Lionel Lecaque](http://forge.taotesting.com/users/305), [Raynald Jadoul](http://forge.taotesting.com/users/630)\
**TAO Delivery** [Somsack Sipasseuth](http://forge.taotesting.com/users/361)\
**TAO Groups** [Lionel Lecaque](http://forge.taotesting.com/users/305), [Raynald Jadoul](http://forge.taotesting.com/users/630)\
**TAO Items** [Raynald Jadoul](http://forge.taotesting.com/users/630), [Cedric Alfonsi](http://forge.taotesting.com/users/352), [Jérôme Bogaerts](http://forge.taotesting.com/users/306), [Somsack Sipasseuth](http://forge.taotesting.com/users/361)\
**TAO Results** [Younes Djaghloul](http://forge.taotesting.com/users/347)\
**TAO Subjects** [Raynald Jadoul](http://forge.taotesting.com/users/630)\
**WfEngine** [Lionel Lecaque](http://forge.taotesting.com/users/305), [Somsack Sipasseuth](http://forge.taotesting.com/users/361), [Jérôme Bogaerts](http://forge.taotesting.com/users/306)\
**TAO Documentation** [Jérôme Bogaerts](http://forge.taotesting.com/users/306), [Laure Conde](http://forge.taotesting.com/users/503)

Please feel free to discuss about your input in the [Forum](http://forge.taotesting.com/projects/tao/boards)

