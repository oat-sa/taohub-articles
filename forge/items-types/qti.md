<!--
parent:
    title: 'Items''_Types'
author:
    - 'Somsack Sipasseuth'
created_at: '2011-02-08 11:04:37'
updated_at: '2014-10-21 11:25:57'
tags:
    - 'Items'' Types'
-->

{{\>toc}}

QTI
===

A standard
----------

The QTI standard version 2.0 was first implemented as the main item type in TAO version 1.3.\
From version 2.5, TAO moves from QTI 2.0 to 2.1.\
The implemention of the QTI standard enables TAO to be more open and interoperable with other systems.\
The current available QTI features in TAO are:

\* Import QTI Item (XML files compatible with [QTI 2.0](http://www.imsglobal.org/question/qti_v2p0/imsqti_infov2p0.html) or [QTI 2.1](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html))\
 \* Import QTI Package (ZIP files compatible with [IMS Content Packaging v1.1.4](http://www.imsglobal.org/content/packaging/cpv1p1p4/imscp_infov1p1p4.html))\
 \* Save the item content in the QTI format (XML)\
 \* Create or edit a QTI Item ([QTI 2.1](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html))\
 \* Export item to XML file ([QTI 2.1](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html))\
 \* Export one or more items to zip package ([QTI 2.1](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html))\
 \* Render QTI item in XHTML, CSS, Javascript

For additional information regarding the QTI standard, please refer to the IMS Consortium web site:

-   [Specification documents version 2.1](http://www.imsglobal.org/question/index.html)
-   [Implementation guide](http://www.imsglobal.org/question/qtiv2p1/imsqti_implv2p1.html)
-   [Information model](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html)

PHP Modelling
-------------

We use a PHP Object oriented model to represent a QTI item and enable you to manage it.\
This model is the core of the development. The main idea is to import xml documents in the QTI format, in order to parse it and instantiate PHP objects.\
Then with the PHP object, you can update the item - add an interaction, change the properties, update the response model, etc.\
Once you are finished working on your model, you can save it, render it, etc :

\* QTI XML format to save and export your item\
 \* XHTML to preview and deliver the item\
 \* PHP Array for other format transformation, e.g. json

The QTI PHP model is outlined by the UML model below. Not all properties and methods are displayed, only the most significant ones.

![](http://forge.taotesting.com/attachments/2627/taoQTImodels.png)

-   Element is the superclass of all QTI objects and it provides all QTI objects with the behavior methods: attributes get/set, serialization xml/array, etc.
-   Container is another central class which represents a block of qti html (flow, block, inline elements; either static or not). A Container instance is characterized by its “body” (html + qti elements placeholders) and an array of Qti Elements. Each type of containers can contain only specific classes of QTI Elements.
-   Item represents the QTI Item document, composed of responses, outcomes, stylesheets, etc. The body of the item is defined by a ContainerInteractive, which can contain Interactions.
-   Interaction represents the QTI interaction of a particular type. Since multiple inheritance is not possible in PHP 5.3, the interaction classes hierarchy has been carefully thought to take advantage of class inheritance while remaining as close as possible to the Standard QTI 2.1.
-   Choice represents the choice of an interaction.
-   Attribute defines the attribute of one or more Qti Elements. It follow the exact definition of the standard.

You can find the complete source code documentation in the [PHP Doc](http://forge.tao.lu/docs/phpdoc/index.html) (Package: *taoQTI*, SubPackage: *models\_classes\_QTI*)

###Sample code usage{#sample-code-usage}

To create QTI item programatically, you can directly use the QTI model described in the previous section.\
Here is an example to create an Item with one single Interaction:

    //create an item:
    $myItem = new taoQTI_models_classes_QTI_Item();
    $myItem->setAttribute('title', 'My Coolest Item');
    $myItem->getBody()->edit('My Item body');

    //create an interaction
    $myInteraction = new taoQTI_models_classes_QTI_interaction_ChoiceInteraction();
    $myInteraction->attr('shuffle', true);//attr() is a shortcut method of setAttribute()
    $myInteraction->getPrompt()->edit('Select one choice.');

    //add some choices to the interaction:
    $myChoice1 = $myInteraction->createChoice(array('fixed' => true), 'This is correct');
    $myChoice2 = $myInteraction->createChoice(array(), 'This is not correct');
    $myChoice3 = $myInteraction->createChoice();

    //edit the choice content or attributes:
    $myChoice1->setContent('answer #1');{#1}

    $myChoice2->setContent('answer #2');{#2}

    $myChoice3->attr('fixed', true);

    //remove a choice from "myInteraction"
    $myInteraction->removeChoice($myChoice1);

    //add "myInteraction" to "myItem"
    $myItem->addInteraction($myInteraction, "Adding my interaction here {$myInteraction->getPlaceholder()}. And not there.");

    //add a response declaration to the item
    $myResponse = new taoQTI_models_classes_QTI_ResponseDeclaration();
    $myItem->addResponse($myResponse);

    //bind the response to "myInteraction":
    $myInteraction->setResponse(myResponse);

Javascript library
------------------

QTI Item are managed by 3 (+1) Javascript libraries on the client side:

-   QtiAuthoring
-   QtiItem
-   QtiRunner (+DefaultRenderer)

###QtiCreator{#qticreator}

It contains the codes to author a qti item. The complete documentation on Qti Creator can be found here : [[Qti Creator]]

###QtiItem{#qtiitem}

It represents a QTI item in Javascript. It is closely tighted to the PHP implementation.

###QtiRunner{#qtirunner}

It contains codes required to run a QTI item.

The QtiRunner.js is called to:

-   init a QTI item by calling the rendering engine.
-   collect and sent responses to the result server
-   display feedback

The QtiRunner lib also contains the programmatic interface of QTI renderers. The goal of a QTI renderer is to transform a QTI Item Javascript object into a user-friendly HTML, CSS and JS widgets.\
This interface is first introduced in TAO 2.5 and has currently only one implementation: the QTI DefaultRenderer (hence the +1).\
Though not mature yet, this interface is designed to welcome anyone to implement its own qti renderer in the future. This page will be updated in due time.

CSS template
------------

The layout of QTI items is driven by [CSS](http://en.wikipedia.org/wiki/Cascading_Style_Sheets) (Cascading Style Sheets). The default style sheet ([qti.css](http://forge.taotesting.com/projects/tao/repository/entry/trunk/tao/trunk/taoItems/trunk/views/js/QTI/css/qti.css)) TAO applies to each QTI items can be overrode following your needs.

If you are using the [QTI Authoring tool](http://forge.taotesting.com/projects/tao/wiki/The_Authoring_tab), you will be able to upload your style sheet to override the default one.

Portable Custom Interaction
---------------------------

Since TAO 3.0, TAO offers complete PCI and PCI hooks to enable developers to extend the functonalities offered by IMS QTI 2.1 standard.

Portable Custom Interaction Best Practice Change Proposal\
The Change proposal recommendation to implement TAO PCI can be found in [[TAO PCI]]

The base proposal from IMS is a draft version subimitted to IMS members for review. [IMS initial PCI proposal](http://www.imsglobal.org/assessment/pciv1p0cf/imsPCIv1p0cf.html)

The proposal form Passific Metrics attempts to solve some issues from the original proposal with the introduction of the concept of “shared libraries” and a better structured XML serialization of PCIs. [Proposal from Pacific Metrics](http://www.imsglobal.org/assessment/PCI_Change_Request_v1pd.html)

We use both of them to write our own proposal, which is backed by this currently working implementation. The proposal can be found here.[[TAO PCI]]

To implement PCI in TAO, the following wiki page provides a good starting point [[TAO PCI and PIC]].

