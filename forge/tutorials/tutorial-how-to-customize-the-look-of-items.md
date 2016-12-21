<!--
parent:
    title: Tutorials
author:
    - 'Dieter Raber'
created_at: '2014-06-30 11:50:17'
updated_at: '2014-07-21 11:46:45'
tags:
    - Tutorials
-->

Tutorial - How to customize the look of items
=============================================

This article is for you when you want to change the way an item looks. Read through the sections that seem closest to your level of experience.

I just want to tweak a few things
---------------------------------

The easiest way to change the appearance of an item is to use the *Style Editor* built into TAO. You find it in the right sidebar when you click on the *Appearance* button on the top right corner of the *Item Creator*.

It allows you to change colors and fonts as well as the width of an item. While most of these tools should be pretty much self-explanatory the item width is a bit more tricky. By default the item has a width of 100% of the current screen to a maximum of 1024 pixels to ensure proper rendering on larger screens. Best practice is to leave this as default.

I want to do more
-----------------

The *Style Sheet Manager* allows to add your own CSS files to an item. If you want to learn more about CSS we recommend [the tutorials on HTML Dog](http://www.htmldog.com/guides/css/)

Style sheets are stored along with the item in `/tao/generis/data/taoItems/itemData/ITEM_ID/itemContent/en-US`. To find the Item Id you need to inspect the source code of the item in the console of your browsers, search for `data-identifier`:

![](../resources/find-item-serial.png).<br/>

Screen shot taken in Firefox, this item has the identifier `i14048063114861116` and is hence located at `/tao/generis/data/taoItems/itemData/i14048063114861116/itemContent/en-US`

As a basis for this tutorial we create a very simple CSS file and upload it through the *Style Sheet Manager*. It is important that all your styles start with `body div.qti-item.tao-scope` to be sure you don’t make any unwanted modifications!

        body div.qti-item.tao-scope {
            background-color: #eeeeff;
            color: #333366; 
            font-family: 'Segoe UI',Candara,'Bitstream Vera Sans',sans-serif;
        }

As you might spot this changes the font, the background color and the text color. In the next step we will add a company logo. All external resources such as pictures need to be `base64` encoded before they can be added to the style sheet. There are tools on the web that can help you with that, we found [this one](http://webcodertools.com/imagetobase64converter) particularly good. If we add the code from the field *CSS background* to the CSS and add positioning to our style sheet it will look something like this:

        body div.qti-item.tao-scope {
            background-color: #eeeeff;
            color: #333366; 
            font-family: 'Segoe UI',Candara,'Bitstream Vera Sans',sans-serif;
            background-image: url(data:image/png;base64,iVBORw[...]ErkJggg==);
            background-position: 20px 30px;
            background-repeat: no-repeat;
            padding-top: 80px;
        }

If you want to go further and change the appearance of the interactions you will need to use the developer tools in your browser. The easiest way to find them is to right-click on the edge of an interaction and to select *Inspect Element* (we assume that are using a recent browser). This will display the source of the interaction and should highlight a line like this:

        

If your line doesn’t contain the class `qti-interaction` you will need to scroll a bit - it must be somewhere very close. Interactions are normally tagged with two or more class names. In the example above we have \`qti-interaction\` which is a class name shared by all qti interactions; `qti-blockInteraction` which is shared by interactions that have a similar format; and `qti-choiceInteraction` which is specific to this one type of interaction. So if you want all *Choice Interactions* to have a gray background, you could do this:

    body div.qti-item.tao-scope .qti-choiceInteraction {
        background-color: #ddd;
    }

As another example, a question we had recently was how to remove the little check box in front of the *Hot Text Interaction*. Upon inspection of the element you will see that it has at least the class names `qti-choice`, `qti-hottext` and `hottext`. The check box itself has the HTML code

        
            
            
        

So now we can hide the check box with

        body div.qti-item.tao-scope .hottext-checkmark {
            display: none;
        }

I am super advanced
-------------------

If you have been working with any CSS pre-processor such as LESS or SASS you will probably have seen by now that most of TAO CSS is written in SCSS. If you want to that too you should familiarize with - `/tao/views/scss/inc` and `/taoQtiItem/views/scss/qti`. The first one contains files that concern the TAO platform as a whole. Notably `bootstrap.scss` and the files included in here might be very helpful for you work. The files in the second directory describe how to render interactions at run time. They are included in `/taoQtiItem/views/scss/qti.scss`. You may consider to start your work with a copy of this file, probably using a `bootstrap.scss` of your own.

We have a tutorial [[Front\_styling|on this wiki]] that explains in more detail how you need to setup the SASS compiler. We are considering to overhaul this setup in the future to make writing your own CSS easier.

Never override the `*.scss` files delivered with TAO - always create a custom style sheet and add it through the *Style Sheet Manager*!

Further reading
---------------

-   [[Tutorial - Using a custom font on items]]

