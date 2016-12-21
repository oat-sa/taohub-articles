<!--
author:
    - 'Somsack Sipasseuth'
created_at: '2013-12-05 15:12:58'
updated_at: '2013-12-11 16:26:01'
-->

QTI in TAO
==========

QTI 2.1 provides a standard way to define and share item contents and test structures.<br/>

The current version of TAO (v 2.5.3) uses standard QTI 2.1 as the main item model.<br/>

In TAO, you can :

-   import QTI items, as [QTI xml](http://www.imsglobal.org/question/qtiv2p1/imsqti_bindv2p1.html) or [QTI packages](http://www.imsglobal.org/content/packaging/index.html)
-   export QTI items, to [QTI xml](http://www.imsglobal.org/question/qtiv2p1/imsqti_bindv2p1.html) or [QTI packages](http://www.imsglobal.org/content/packaging/index.html)
-   create, author and deliver QTI items

Subset of QTI 2.1 features available in TAO 2.5
-----------------------------------------------

### Interactions

An interaction represents a question.<br/>

TAO supports composite items (item with more than one interaction) as well as single-interaction item.<br/>

In a composite item, when every interaction uses one of the [3 standard response templates](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html#section10084), the final score is calculated by adding the score of each individual interaction. For more information on response processing, see the Response processing section below.

Available interaction types:

-   choice interaction
-   associate interaction
-   order interaction
-   match interaction
-   inline choice interaction
-   text entry interaction
-   extended text interaction
-   hottext interaction
-   gap match interaction
-   slider interaction
-   media interaction
-   hotspot interaction
-   graphic associate interaction
-   graphic order interaction
-   graphic gap match interaction
-   select point interaction

Planned for TAO 2.6:

-   upload interaction

### Feedback

Only modal feebacks are available for now. It enables you to define a message to be displayed to the test taker after the item completion. You can select simple rules based on the score value or the correct response.<br/>

No adaptative item feature as defined by QTI is planned so far.

### RubricBlock

Planned for TAO 2.6.

### Rich content

The item body support images, audio and video. Images are inserted as simple *html image* while audio and video files are store as an *html objects*.<br/>

The supported video formats are mpeg4 (H.264+AAC) and *youtube*. We suggest using mp3 audio format to ensure cross-browser compatibility.

Math expressions are also available. It however requires the [installation of a free third-party library MathJax](http://forge.taotesting.com/projects/tao/wiki/Enable_math).

As to PDF files, the issue is the same as math expressions and multimedia. There is no way to ensure cross-browser compatibility natively. Currently, pdf files are therefore not fully supported in TAO QTI items. For more information, please see the open issue \#2503.

### Item appearance

Standard QTI 2.1 allows a subset of xhtml that can help you define the structure of text contents within your item. For example, you can create paragraph, align left, align right or justify your texts. You have also some other common format options like blod, italic etc.<br/>

Finally, you can upload your own css to customize the appearance of your item.

### Response processing

TAO uses the [3 standard response templates](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html#section10084) in non-composite items (item with one single interaction).<br/>

Composite items created with the item authoring tool - the QTI Creator - generate [generalized response processing](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html#section10085) rules based on the standard templates. Basically, generalized response processing rules are all response rules applied to response processing that are not the 3 standard response templates. A generalized response processing rule is made of response conditions (if, then, else) and [expressions](http://www.imsglobal.org/question/qtiv2p1/imsqti_infov2p1.html#element10569).<br/>

Although the QTI Creator does not currently allow generalized response rule definition, the QTI Player can process any response processing rule and expression. This means that you can import QTI 2.1 items with any qti valid response rules you want into TAO and run them in TAO.


