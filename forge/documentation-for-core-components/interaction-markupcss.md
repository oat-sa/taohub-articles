<!--
parent:
    title: Documentation_for_core_components
author:
    - 'Dieter Raber'
created_at: '2015-10-14 14:53:58'
updated_at: '2015-11-17 10:40:44'
tags:
    - 'Documentation for core components'
-->

Writing HTML and CSS for new interaction types
==============================================

An item theme in TAO is nothing more than an alternative CSS implementation with selectors of higher specificity. The CSS SDK is a stripped down copy of the TAO item SCSS. It relies on the same class names and the same structures the TAO default theme does. This works very well as long as all interactions have similar structures but can become very messy if they don’t.

The look of a standard interaction is defined by several files:

1\. `taoQtiItem/views/js/qtiCommonRenderer/tpl/interactions/[interaction].tpl`\
2. `taoQtiItem/views/scss/qti/_[interaction].scss` which extends `taoQtiItem/views/scss/qti-runner.scss`\
3. `taoQtiItem/views/scss/qtiCreator/_[interaction].scss` which extends `taoQtiItem/views/scss/item-creator.scss`

HTML
----

The order interaction is a good example to explain the ideal structure of an interaction.

The HTML looks roughly like this:

<pre>
<code class="html">

<!-- Use these class names as a guide. Use either qti-vertical or qti-horizontal to indicate the direction -->
<div class="qti-interaction qti-blockInteraction qti-myInteraction qti-vertical|qti-horizontal">
<!-- Don't call or nest this part differently without a good reason -->
<div class="qti-prompt-container">
<p class="qti-prompt">
</p>
</div>
<div class="instruction-container">
</div>
<div class="my-interaction-area">
<!-- .choice-area and .result-area allow for different designs on both sides. 
                If you require only one block, call it .choice-area.
                .solid and .block-listing do most of the look and feel -->
<ul class="choice-area solid block-listing">
<!-- keep .qti-choice and .qti-block nested if possible -->
<li class="qti-choice">
<div class="qti-block">
\#1</div>{#1div}

</li>
</ul>
<!-- see above -->
<ul class="result-area solid block-listing">
<li class="qti-choice">
<div class="qti-block">
\#2</div>{#2div}

</li>
</ul>
</div>
</div>
</code>

</pre>
CSS
---

Don’t get tempted to write your CSS by hand - always generate it from SCSS. The preferred way is to keep base and editor specific code in separate files. Always look at the code of existing interactions to see if there is already a similar implementation. PCI interactions are meant to be standalone - whether or not your SCSS can extend existing TAO code is debatable and we haven’t decided yet what we consider being best practice.

The base SCSS file structure could look like this for instance:

<pre>
<code class="sass">

@import “path/to/bootstrap/if/any”;

// always start with the name of your extension\
 .qti-myInteraction {\
 .choice-area {\
 .qti-choice { }\
 }\
 .result-area {\
 .qti-choice { }\
 }

// Maybe your interaction supports two directions\
 </code>&<code class="sass">.qti-vertical {\
 .choice-area {\
 .qti-choice { }\
 }\
 .result-area {\
 .qti-choice { }\
 }\
 }

</code>&<code class="sass">.qti-horizontal {\
 .choice-area {\
 .qti-choice { }\
 }\
 .result-area {\
 .qti-choice { }\
 }\
 }\
 }\
</code>

</pre>
The editor specific file would then be responsible for specific toolbars and buttons in the editor if they aren’t covered in the existing code yet.

