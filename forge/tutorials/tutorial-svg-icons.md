<!--
author:
    - 'Dieter Raber'
created_at: '2016-04-29 17:14:19'
updated_at: '2016-05-04 17:35:08'
tags:
    - Tutorials
-->

Tutorial - SVG Icons
====================

As of version 3.0 TAO uses custom icon fonts. With the 3.1 release there will also be support for SVG icons. They are especially interesting for extensions since they don’t require a change of the TAO icon font.

SVG format
----------

You need to use SVG that contains symbols which looks like this


        
            
                
            

If your SVG doesn’t use symbols an easy way to create them is to use https://icomoon.io/app/. Create a new collection, import one or more SVG files, click on **Generate SVG and more**. In the resulting zip file **symbol-defs.svg** is your converted SVG file containing all symbols.

Prerequisites in an extension context
-------------------------------------

Extension icons refers to all icons that are set in *structures.xml*. When using the TAO icon font icons in *structures.xml* look like this:

This is a bit different for svg icons. In this example we expect an SVG in */anotherOne/views/img/example.svg* that contains a symbol with the ID *icon-foo*. The *ext* attribute is optional, the default is the structure to which the structure belongs.

The rendered HTML
-----------------


        

On browsers that lack complete support for <code class="html"><use/></code> the content of the symbol will be used instead. This is done with a JavaScript polyfill.


        
            

The group with the class *.use* will be added to make CSS easier.

CSS for SVG icons
-----------------

SVG can be used several ways, for instance as source an <code><img /></code> element or as a background image. If you want to use CSS on an SVG you will need to put it in the HTML directly as demonstrated above. CSS is mostly straight forward. Changing the colors though can be a little bit tricky. Firstly color is called **fill** or **stroke** depending on the construction SVG. https://developer.mozilla.org/en-US/docs/Web/SVG/Tutorial/Fills\_and\_Strokes explains this in great detail.

    use, g.use {
        fill: currentColor !important;
    }
Tutorial - SVG Icons
====================

As of version 3.0 TAO uses custom icon fonts. With the 3.1 release there will also be support for SVG icons. They are especially interesting for extensions since they don’t require a change of the TAO icon font.

SVG format
----------

You need to use SVG that contains symbols which looks like this







If your SVG doesn’t use symbols an easy way to create them is to use https://icomoon.io/app/. Create a new collection, import one or more SVG files, click on **Generate SVG and more**. In the resulting zip file **symbol-defs.svg** is your converted SVG file containing all symbols.

Prerequisites in an extension context
-------------------------------------

Extension icons refers to all icons that are set in *structures.xml*. When using the TAO icon font icons in *structures.xml* look like this:

This is a bit different for svg icons. In this example we expect an SVG in */anotherOne/views/img/example.svg* that contains a symbol with the ID *icon-foo*. The *ext* attribute is optional, the default is the structure to which the structure belongs.

The rendered HTML
-----------------




On browsers that lack complete support for <code class="html"><use/></code> the content of the symbol will be used instead. This is done with a JavaScript polyfill.





The group with the class *.use* will be added to make CSS easier.

CSS for SVG icons
-----------------

SVG can be used several ways, for instance as source an <code><img /></code> element or as a background image. If you want to use CSS on an SVG you will need to put it in the HTML directly as demonstrated above. CSS is mostly straight forward. Changing the colors though can be a little bit tricky. Firstly color is called **fill** or **stroke** depending on the construction SVG. https://developer.mozilla.org/en-US/docs/Web/SVG/Tutorial/Fills\_and\_Strokes explains this in great detail.

    use, g.use {
        fill: currentColor !important;
    }

