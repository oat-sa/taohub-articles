<!--
parent: QTI
created_at: '2014-10-21 10:52:09'
updated_at: '2015-03-04 09:51:25'
authors:
    - 'Somsack Sipasseuth'
tags:
    - QTI
-->

TAO PCI and PIC
===============



﻿h1. PCI and PIC specifications

Since TAO 3.0, TAO offers complete PCI and PIC hooks to enable developers to extend the functonalities offered by IMS QTI 2.1 standard.

PCI stands for Portable Custom Interaction. QTI offers about 20 types of interactions (questions types). Among them, the special custom interaction gives tool vendors opportunities to implement any type of interaction. This however breaks the interoperability which is supposed to be the strongest benefit adopting the QTI standard. IMS is therefore working on a new specification that enable tool vendors to structure their custom interaction in an interoperable way. Portable Custom Interaction is the result of this effort. Currently a few vendors are experimenting with this PCI specification and are making new proposal to improve it. OAT, publisher of TAO is very active in defining this PCI specification. As a illustration of the benefit and power of PCI, TAO 3.0 comes up with a full working implementation of PCI.

PIC stands for portable info control. Info control (add ref.) offers opportunity for tool vendor to add their own custom content to the item body. Implementing completely vendor specific Info Controls leads to the same interoperability issue as basic custom interactions. IMS has so far not publish any recommendation on the way Info Control should be implemented. OAT took the initiative to propose the PIC specification which is strongly influenced by its cousin PCI.

This wiki page will present how you may implement PCI and PIC into TAO.

Two Hooks to rule them all : Delivery/Runtime Hook versus Authoring/Creator Hook :
==================================================================================

Before going further, it is worth noting that there are two distinct aspects when implementing a PCI or PIC : authoring on the one hand, and delivery on the other hand. The former requires the later. The IMS PCI only deals with the delivery, that is how the PCI should be implemented to be executable in any PCI-compliant vendor. This hook is standardized by IMS.

TAO offers an additional hook in its item creator, which enable every item author to create and configure such PCIs via the GUI. This authoring hook is therefore specific to TAO. As stated in the previous paragraph, the runtime code is required because the item creator is based on a WYSWYG experience : although it is not required, we encourage PCI implementor to follow this principle to offer an optimal user experience.

Since PIC is highly inspired by PCI, the following sections will successively introduce how to create PCI for TAO then present the difference for PIC.

The base proposal from IMS is a draft version submitted to IMS members for review. [IMS initial PCI proposal](http://www.imsglobal.org/assessment/pciv1p0cf/imsPCIv1p0cf.html#_Toc353965343)

The proposal form Passific Metrics attempts to solve some issues from the original proposal with the introduction of the concept of “shared libraries” and a better structured XML serialization of PCIs. [Pacific Metrics proposal](http://www.imsglobal.org/assessment/PCI_Change_Request_v1pd.html)

We use both of them to write our own proposal, which is backed by this currently working implementation. The proposal can be found here.

Delivery/Runtime Hook
=====================

To implement a PCI for delivery execution : you only have to follow the PCI specification.

The PCI specification (add ref.) explain how a PCI should be implemented. PIC follows the same principle. The main concept being :

The XML present the interoperable format for a PCI and PIC.

The shared libraries define the resource.

The hook is the entry point.

**Important note 1 :**

Any Javascript code in PCI and PIC must be wrapped as proper AMD. No code such as window.myGlobalScope = {…} is allowed.

This requirement includes all embedded libraries. Indeed there is no way to know in advance which libraries and which version would be used in PCI. Failure to comply with the AMD pattern would break interoperability and perhaps the delivery or creator engine itself.

**Important note 2 :**

Because we don’t know which libs and files will be used, all PCI-runtime AMD files are loaded in a separate requirejs context. That is of a particular importance when using JQuery. **Two instances of JQuery cannot communicate with each other**. The consequence is :

1.  custom events fired in one context, cannot be listened in the other
2.  data attribute bound with method *
$element.data(’my-data’, someValue)* cannot be retrieved in another (passing through the dom works though : *
$element.attr(’data-my-data’, someValue)*, here *someValue* must be a string obviously)

Authoring/Creator Hook
======================

If you want to implement a PCI completely in TAO (runtime+authoring), please follow the guideline in this section. It will enable item author to create such PCI from the Itme Creator GUI.

Overview
--------

The goal of this section is to give an overview of the way a PCI Creator Hook is structured. Every concept will be detailed in a later section.

First, let’s have a look at a sample implementation available at [qtiItemPci/views/js/pciCreator/dev/likertScaleInteraction](https://github.com/oat-sa/extension-tao-itemqti-pci/tree/develop/views/js/pciCreator/dev/likertScaleInteraction).

File structure :

The root folder must contains two files : pciCreator.js and pciCreator.json\
The file pciCreator.json is the manifest file that contains all the data required by the server and the client to describe the pciCreator (name, label, required js, css etc).

The file pciCreator.js is an AMD module that will be the hook for the Item Creator upon initialization.

The remaining files are the source or media used in pciCreator.js and pciCreator.json. The pci creator implementor is free to organize those files as will but we would recommend clearly separating code of the delivery from the authoring (e.g. runtime folder / creator folder).

manifest file : pciCreator.json
-------------------------------

Unless stated otherwise, all fields are required.

-   typeIdentifier : the unique type identifier of the PCI
-   label : a human readable name for the PCI
-   short : a short human readable name for the PCI (used when the label is too long to fit in the GUI, in e.g. interaction sidebar)
-   description : a longer description of what the PCI is supposed to to
-   version : semantic versioning
-   author : the author of the PCI creator package
-   email : the email of the author of the PCI creator package
-   libraries : array of required libraries on runtime. They are referenced by their globally unique ids (see section on “shared libraries” of the PCI proposal) or relative to the root of the package
-   css : array of css required on runtime (relative to the root of the package)
-   entryPoint : the file defined (relative to the root of the package)
-   tags : array of key words that can be used to organize it.
-   icon : the picture that will be used in the interaction sidebar when integrated into the creator GUI,
-   response : a json object representing the default response attributes of the interaction




    {
        "typeIdentifier": "likertScaleInteraction",
        "label": "Likert Scale",
        "description": "A simple implementation of likert scale.",
        "version": "0.1",
        "author": "Sam Sipasseuth",
        "email": "sam@taotesting.com",
        "libraries": [
            "IMSGlobal/jquery_2_1_1"
        ],
        "css": [
            "runtime/css/likertScaleInteraction.css"
        ],
        "entryPoint": "runtime/likertScaleInteraction.amd.js",
        "tags": [
            "mcq",
            "likert"
        ],
        "icon": "creator/img/icon.svg",
        "short": "Likert",
        "response": {
            "baseType": "integer",
            "cardinality": "single"
        }
    }

### For PIC :

The previous statements apply to PIC with the following notable exceptions :

The two required files are respectively called picCreator.json and pciCreator.js (instead of pciCreator.json and picCreator.js)

icon : this is not currently used but is still required for consistency with the PCI package and keeping for future usage (e.g. a more visual PIC selection toolbar)

response : this is not useful for PIC since no response is expected from an info control so should not appear in picCreator.json

the entry point : pciCreator.js
-------------------------------

It is an AMD module that returns an object that exposes the following functions :

-   getTypeIdentifier : Get the typeIdentifier of the custom interaction
-   getWidget : Get the creator widget. A creator widget is the central component of the qti item creator. Every qti element is represented by a client-side js model. Every qti element has a creator widget that exposes GUI to allow item author to edit this model. Please see the wiki page on how to write a creator widget (link)
-   getDefaultProperties (optional) : assign default properties (key/value) to the PCI upon creation in the item creator
-   afterCreate (optional) : do some data manipulation on the newly created PCI instance
-   getMarkupTemplate : returns the compiled handlebars template for the PCI markup
-   getMarkupData (optional) : enable passing additional data to the PCI markup




    define([
        'lodash',
        'taoQtiItem/qtiCreator/editor/customInteractionRegistry',
        'likertScaleInteraction/creator/widget/Widget',
        'tpl!likertScaleInteraction/creator/tpl/markup'
    ], function(_, ciRegistry, Widget, markupTpl){

        var _typeIdentifier = 'likertScaleInteraction';

        var likertScaleInteractionCreator = {
            /**
             * (required) Get the typeIdentifier of the custom interaction
             *
             * @returns {String}
             */
            getTypeIdentifier : function(){
                return _typeIdentifier;
            },
            /**
             * (required) Get the widget prototype
             * Used in the renderer
             *
             * @returns {Object} Widget
             */
            getWidget : function(){
                return Widget;
            },
            /**
             * (optional) Get the default properties values of the pci.
             * Used on new pci instance creation
             *
             * @returns {Object}
             */
            getDefaultProperties : function(pci){
                return {
                    level : 5,
                    'label-min' : 'min',
                    'label-max' : 'max'
                };
            },
            /**
             * (optional) Callback to execute on the
             * Used on new pci instance creation
             *
             * @returns {Object}
             */
            afterCreate : function(pci){
                //do some stuff
            },
            /**
             * (required) Gives the qti pci xml template
             *
             * @returns {function} handlebar template
             */
            getMarkupTemplate : function(){
                return markupTpl;
            },
            /**
             * (optional) Allows passing additional data to xml template
             *
             * @returns {function} handlebar template
             */
            getMarkupData : function(pci, defaultData){
                defaultData.prompt = pci.data('prompt');
                return defaultData;
            }
        };

        //since we assume we are in a TAO context, there is no use to expose the a global object for lib registration
        //all libs should be declared here
        return likertScaleInteractionCreator;
    });

### For PIC :

All previous statements apply to PIC except for the name of file that should be picCreator.js

Implementing pciCreator.js
--------------------------

### Dependencies and libraries inclusion

pciCreator.js can have dependencies to any libraries available in TAO. They may be:

-   common libs (jquery, lodash)
-   ui libs (ui/modal, ui/form. ui/feedback etc.)
-   extension specific ones, especially those of taoQtiItem (taoQtiItem/qtiCreator/editor/customInteractionRegistry)

You can use available requiresjs extension such as tpl[, css](../resources/, css), json! to include template, css or json data files.

You can also reference any file relative to your directory in the namespace of your PCI. The namespace is the unique typeIdentifier of your PCI : e.g. when the typeIdentifier of the PCI is likertScaleInteraction, likertScaleInteraction/creator/widget/Widget refer to the file that is located at ./creator/widget/Widget.js

When adding a PCI into your item, all required files declared in the manifest json will be copied into the item content folder :

For example, a file defined as ./creator/media/icon.svg will be copied to {{itemContentDir}}/{{typeIdentifier}}/creator/media/icon.svg (where itemContentDir is the absolute path to the item content directory and typeIdentifier is the PCI typeIdentifier).

Multiple instance of a single PCI implementation will therefore share the same files and multiple implementations of PCIs will not overwrite the files of each other. For example two PCIs (myGreatPCI and myAwesomePci) may have a file named ./js/lib/common.js but they will end up in two different folders when added to the item, respectively {{myGreatPCI}}/js/lib/common.js and {{myAwesomePci}}/js/lib/common.js.

As a consequence, if you want to attach a media file to your PCI markup, please do not forget to add its namespace. Instead of <img src="img/icon.svg" />, write <img src="myAwesomePci/img/icon.svg" /> since img/icon.svg declared in the manifest will be copied to myAwesomePci/img/icon.svg.

### Custom Interaction Registry

It is an especially useful helper located at [taoQtiItem/qtiCreator/editor/customInteractionRegistry](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/editor/customInteractionRegistry.js)

It enables you to retrieve any data related to your PCI such as the content of the manifest or baseUrl.

Since you are not supposed to know the location of the package is the file system, using customInteractionRegistry.getBaseUrl() is the only way you can get the link to a picture you want to use in your creator widget.

### For PIC :

The same rules of thumb apply.

The Portable Info Control registry is located at [taoQtiItem/qtiCreator/editor/infoControlRegistry.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/editor/infoControlRegistry.js)

Under the hood
--------------

The previous sections described every needed components to create a PCI creator package. The sequence diagram below gives an overview of what is happening during execution of this code. This shall give PCI implementors better understand of PCI implementation in TAO.

The members involved in this process are :

portableCustomInteraction : [qtiCreator/model/interactions/PortableCustomInteraction.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/model/interactions/PortableCustomInteraction.js)

containerHelper : [qtiCreator/model/helper/container.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/model/helper/container.js)

registry : [qtiCreator/editor/customInteractionRegistry.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/editor/customInteractionRegistry.js)

creatorRenderer : [qtiCreator/renderers/interactions/PortableCustomInteraction.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/renderers/interactions/PortableCustomInteraction.js)

creator Widget : the one returned by pciCreator.getWidget(), e.g. [a sample implementation](https://github.com/oat-sa/extension-tao-itemqti-pci/blob/master/views/js/pciCreator/dev/likertScaleInteraction/widget/Widget.js)

commonRender : [qtiCommonRenderer/renderers/interactions/PortableCustomInteraction.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCommonRenderer/renderers/interactions/PortableCustomInteraction.js)

The commonRenderer will basically call the the runtime code, which is initialized by the call to the method initialize() of the object registered in manifest.entryPoint.

![](http://forge.taotesting.com/attachments/download/3430/pciCreatorSequence.png)

### For PIC :

The same principle applies.

The members and locations are :

portableInfoControl : [qtiCreator/model/PortableInfoControl.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/model/PortableInfoControl.js)

containerHelper : [qtiCreator/model/helper/container.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/model/helper/container.js)

registry : [qtiCreator/editor/infoControlRegistry.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/editor/infoControlRegistry.js)

creatorRenderer : [qtiCreator/renderers/PortableInfoControl.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCreator/renderers/PortableInfoControl.js)

creator Widget : the one returned by picCreator.getWidget(), e.g. [a sample implementation](https://github.com/oat-sa/extension-tao-itemqti-pic/blob/develop/views/js/picCreator/dev/studentToolSample/creator/widget/Widget.js)

commonRender : [qtiCommonRenderer/renderers/PortableInfoControl.js](https://github.com/oat-sa/extension-tao-itemqti/blob/develop/views/js/qtiCommonRenderer/renderers/PortableInfoControl.js)

Implementing Creator Widget
---------------------------

A PCI or PIC creator widget follow strictly the same rules as any standard qti creator widget in TAO (e.g. Item, ChoiceInteraction, SimpleChoice, Img, Math etc.). For more information please go to the dedicated wiki page (link)

Tips :

The standard QTI creator widget works directly on the DOM to reflect changes and new config set by the item author. This is the basis of the WYSIWYG experience associated with the new item creator. The sequence diagram in the previous section shows that the creator widget is built on top of the DOM generated by the runtime code\
Quick recap, the DOM first comes from the runtime code execution. The creator widget is creates ui components on top of the runtime code. There are two strategies to implement a wysiwyg experience:

1 : update the dom to reflect every changes\
2 : refresh the whole interaction to reflect it\
3 : a mix of them\
See an example of call to widget refresh() in [qtiItemPci/views/js/pciCreator/dev/likertScaleInteraction/creator/widget/states/Question.js](https://github.com/oat-sa/extension-tao-itemqti-pci/blob/develop/views/js/pciCreator/dev/likertScaleInteraction/creator/widget/states/Question.js)


            //init data change callbacks
            formElement.setChangeCallbacks($form, interaction, {
                level : function(interaction, value){

                    //update the pci property value:
                    interaction.prop('level', value);

                    //update rendering
                    _widget.refresh();
                },
                identifier : function(i, value){
                    response.id(value);
                    interaction.attr('responseIdentifier', value);
                }
            });


