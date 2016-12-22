<!--
created_at: '2014-07-17 15:32:30'
updated_at: '2014-09-25 12:38:56'
authors:
    - 'Lionel Lecaque'
tags:
    - 'Developer Guide'
-->

Build Client Side resource
==========================

This page describes how to build TAO in order to release it. Some of the actions may be relevant if you have modified the source code of TAO and want to deploy your modified version.

Compile client side resources
-----------------------------

The SASS files needs to be compiled to CSS as well as the JavaScript modules that needs to be bundled. This step is required when you install TAO in production mode and ensure you better performances than the development mode.

### Dependencies

Be sure node.js, npm, grunt and sass are available on your system. See [this section](http://forge.taotesting.com/projects/tao/wiki/Front_tools) for installation instructions.

#### Compilation

Go to the build folder (where `{tao_dist}` is your TAO installation directory):

    $> cd {tao_dist}/tao/views/build

Then run

    $> npm install

    $> npm run build

The first command `npm install` will install/update the node.js packages required to bundle the sources and initialize the build tasks.\
The 2nd command `npm run build` will create bundles, minimify the content, inline some assets and compile the SASS files to CSS.\
These commands may take some time according to your CPU power.

Build Client Side resource
==========================

This page describes how to build TAO in order to release it. Some of the actions may be relevant if you have modified the source code of TAO and want to deploy your modified version.

Compile client side resources
-----------------------------

The SASS files needs to be compiled to CSS as well as the JavaScript modules that needs to be bundled. This step is required when you install TAO in production mode and ensure you better performances than the development mode.

### Dependencies

Be sure node.js, npm, grunt and sass are available on your system. See [this section](http://forge.taotesting.com/projects/tao/wiki/Front_tools) for installation instructions.

#### Compilation

Go to the build folder (where `{tao_dist}` is your TAO installation directory):

    $> cd {tao_dist}/tao/views/build

Then run

    $> npm install

    $> npm run build

The first command `npm install` will install/update the node.js packages required to bundle the sources and initialize the build tasks.<br/>

The 2nd command `npm run build` will create bundles, minimify the content, inline some assets and compile the SASS files to CSS.<br/>

These commands may take some time according to your CPU power.


