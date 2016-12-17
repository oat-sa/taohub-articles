---
tags: Forge
---

Styling
=======

Using the theme defined into the [[Style guide]]
------------------------------------------------

The theme defined into the style guide is included into the back office. It comes from tao/views/css/tao-main-style.css

To prevent conflicts with current style, the style applies only to elements of a container with the class `tao-scope`. For example, to use buttons, you need to wrap them into a container with this class:


       Info button

SASS
----

TAO uses [SASS](resources/http://sass-lang.com/) to create the TAO main theme.

### Structure

#### Main and bootstrap

The folder `tao/views/scss/` contains the main theme (`tao-main-style.scss`) as well as a bootstrap (`inc/bootstrap.scss`) that provides variables, functions and mixins you can reuse into your own SASS files.

#### Extension’s custom styles

You can create your own style sheets into a specific extension. You need to create a structure according to the hierarchy described into [[Front Structure]].\
In extension’s SCSS files, include the bootstrap.

    @import "inc/bootstrap";

    .my-style { ... }

Do not forget to add the path to the bootstrap into your compiler’s options (`--load-path=tao/views/scss`)

### Compiling

In order to compile (or watch) your SASS files to the target CSS, you can either use:\
 - The grunt task provided with TAO (see [[Front Tools]])\
 - The SASS CLI tool provided by SASS (requires ruby and the sass gem)\
 - Your favorite IDE SASS plugin

#### Build using Grunt

To compile the main theme, you need the [[Front Tools]] up and running. Then open a terminal into `tao/views/build`.

For example to compile CSS files for the tao extension :

    grunt taosass

(`grunt {nameOfTheExtension.toLowerCase()}sass`)

To compile files as you edit (watching):

    grunt watch:taosass

(`grunt watch:{nameOfTheExtension.toLowerCase()}sass`)

#### Your theme

To ensure your theme is compiled during the build phase, add new line into `{extension}/views/build/grunt/sass.js` (if the file does not exists, you can copy it from another extension)

By example, if you want `taoQtiTest/views/scss/creator.scss` to be compiled to `taoQtiTest/views/css/creator.css`, edit the file `taoQtiTest/views/build/grunt/sass.js` to add the line:

        sass.taoqtitest.files[root + 'css/creator.css'] = root + 'scss/creator.scss';
