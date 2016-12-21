<!--
parent:
    title: Hawai
author:
    - 'Jérôme Bogaerts'
created_at: '2011-03-09 10:54:43'
updated_at: '2013-03-13 13:05:30'
tags:
    - Hawai
-->

DEPRECATED
==========

Hawai item format
=================

{{\>toc}}

**Notice: This page is just a draft. Work on Hawaï standard is still in progress : Important changes may still occurs on it. If you are interested about work on it, please free to contact us in the** [forums](http://forge.taotesting.com/projects/tao/boards)

TODO
----

- HAWAI or Hawaï ???<br/>

- `==` in sources instead of `=`

Document
--------

### What does HAWAI mean ?

HAWAI is the abbreviation for \*H\*yper \*A\*daptive \*W\*ork \*A\*rea \*I\*tem. The HAWAI Item as a very powerful item type enabling the creation of complex item types providing the whole palette of up-to-date graphical user interface design possibilities.

### Why a HAWAI format ?

In the TAO platform the HAWAI format fills the gap between the QTI items and the free form items. QTI items allows items’ creators to create items easily with our powerful QTI items but the format could be limited if the requirements are too specific. In the other hand free form items allows items’ creators to create powerful items but this format is intended to IT experts. Our format associated with our authoring tool allows items’ creator to create powerful items (in a defined scope) without any expert knowledge in IT.

### What is the Hawaï standard ?

The Hawaï standard is not just a document format it is a package of standard developed and used around the process of items’ creation :

-   [document format \#Hawaï\_format]
-   widget standard
-   template standard

These standards will contribute by themselves to the building of a community. By sharing a model of widgets and templates the software could accept contribution from any creators.

### Hawaï format

The hawaï format is actually a free form item which use the **briques de base** such as widgets and events model for its runtime … bla bla bla

Widgets
-------

The widgets are a way to explain needs of items’ creator. They allow items’ creator to create item with high valued components such as : google map, video clips, spreadsheet, mail client … etc …

We provide with our platform a format of xml document based on BLACK (an xml n-tiers model) to create widgets. The following documentation will present you this format

### manifest

*Attribute* : xmlns:{namespace\_name} [\*] : string

*Contains* : [[Hawaï\_standard\#business|business]] [0-1]\
*Contains* : [[Hawaï\_standard\#layout|layout]] [0-1]\
*Contains* : [[Hawaï\_standard\#action|action]] [0-1]\
*Contains* : [[Hawaï\_standard\#content|content]] [0-1]\
*Contains* : [[Hawaï\_standard\#knowledge|knowledge]] [0-1]

### business

Widget Setting is the area where the business model of the widget will be defined.

*Contains* : [[Hawaï\_standard\#widgetsetting|widgetSetting]] [1]

### layout

see documentation about the black format [TODO Missing reference]

### action

*Contains* : [[Hawaï\_standard\#authoringaction|authoringaction]] [0-1]

*Contains* : [[Hawaï\_standard\#runtimeaction|runtimeaction]] [0-1]

### authoring action

Authoring action allows widgets’ creator to associate an authoring behavior to his widget. All the behavior defined here will be available only during the authoring of the item.

### content (a)

see documentation about the black format\
*content title is misunderstood by redmine. Redmine create a big white box…*

*Contains* : [[Hawaï\_standard\#templates|templates]] [\*]

### init

Init represents the initialization process and can be use either in the authoring context or in the runtime context.

*Contains* : [[Hawaï\_standard\#expressions|expression]] [\*]

### (abstract) expression

Derived elements :<br/>

[[Hawaï\_standard\#lock|lock]], [[Hawaï\_standard\#unlock|unlock]]

### knowledge

see documentation about the black format

### lock

The lock expression allows widgets’ creator to lock a variable of his widget’s data model during the authoring of his widget.

*Attribute* : variableIdentifier [1] : string Identifier of the variable

### unlock

The lock expression allows widgets’ creator to unlock a variable of his widget’s data model during the authoring of his widget.

*Attribute* : variableIdentifier [1] : string Identifier of the variable

### variabledeclaration

Variable declaration allows widgets’ creator to associate a variable to a widget. The instance of the variable could be used by the business of the widget by instance :

-   to create a specific view (templated view);
-   to be used by other variables (variable dependancy …);
-   to be used as parameter of the widget’s functions;

*Attribute* : name [1] : string Identifier of the variable. This identifier has to be unique.

*Attribute* : type [1] : string Type of the variable. A variable has to be a scalar for now (see [[Hawaï\_standard\#variables\_opening|opening]]) :

-   boolean;
-   id;
-   integer;
-   list;
-   positive\_integer;
-   string;
-   url;
-   …

*Attribute* : wpLock [0-1] : boolean Lock the attribute during edition. The default value is false.

*Attribute* : wpVisible [0-1] : boolean Show the attribute during edition. The default value is true.

*Contains* : [[Hawaï\_standard\#variabledependancy|variabledependancy]] [0-1]

*Contains* : [[Hawaï\_standard\#defaultvalue|defaultvalue]] [0-1]

#### Example

*1. A simple string variable*


*2. A widget identifier variable*

By instance if we want to associate a “widget identifier” variable to our widget. A widget that we could identify with “myWidgetIndentifier”. A variable we do not want to make editable during edition of the widget.


*3. An enumeration variable*

If we want to provide a range of available values to a variable. By instance during the creation of a button widget the widget’s creator need to explain a choice - the button could be an image or a textual button.


        image
        text

### variabledependancy

Variable dependancy allows widget’s creator to associate a data model to the widget. With this element widget’s creator could associate together variables following some rules.

*Attribute* : variableidentifier [1] : string The identifier of the variable.

*Contains* : [[Hawaï\_standard\#variabledeclaration|defaultvalue]] [0-1]

#### Example

*1. lock a variable functions of the value of another*

Here we want to lock the variable *buttonLabel* if the value of the variable *buttonType* is not equal to *text*.


        

### widgetsetting

*Contains* : [[Hawaï\_standard\#template|template]] [\*]

*Contains* : [[Hawaï\_standard\#variabledeclaration|variabledeclaration]] [\*]

Templates
---------

Template are the fastest way to create easy to create reusable items. These kind of components allow items’ creator to create complete item in few time by following a wizard.

opening
-------

### defaultvalue opening

It will be used if the following [[Hawaï\_standard\#variables\_dependancies\_opening|opening]] is validated

### expressions opening

The set of expressions which are provided to the widgets’ creator are not enough. Think about usefull expressions, an example of grammar and management of this one could be the tao matching API.

### variables opening

Right now the black manages scalar variables but we are thinking about more complex variables such as object, array, tuple … and so on.

-   Are these variables needed ?
-   How to explain the needs ?

### variables dependancies opening

-   The regexp should be placed between the characters “/” and “/”
-   variablelock is an expression which does not require a value. variableunlock will be its opposite.

