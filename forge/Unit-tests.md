---
tags: Forge
---

Javascript unit tests
=====================

Setup
-----

    cd tao/views/build
    npm install

Running tests
-------------

### All tests:

    grunt testall

### Specific extension:

    cd tao/views/build
    grunt connect [extname+test]
    grunt connect taoqtiitemtest
    grunt connect taotest
    ...

### Specific test:

You can either open the test.html in a browser or adapt the following command line:

    cd tao/views/build
    grunt connect qunit:single --test=[/path/to/test.html]
    grunt connect qunit:single --test=/taoQtiItem/views/js/qtiCreator/test/MathEditor/test.html
    ...

Failing tests
-------------

In case you have failing tests:

-   make sure that you have the latest version of all tao extensions
-   make sure that you have the latest npm dependencies (like PhantomJS) with npm update (or remove node\_modules directory, then run npm install again)

To help debugging unit tests that only fail when run with grunt, you can launch the test webserver…

    grunt connect::keepalive

    Running "connect:test:keepalive" (connect) task
    Waiting forever...
    Started connect web server on http://127.0.0.1:8082

… then open the test in your browser

    http://127.0.0.1:8082/taoQtiItem/views/js/qtiCreator/test/MathEditor/test.html

tadam …. !

Writing tests
-------------

Store your tests in the following directory, so they are run by the CI engine:

    extension/views/js/test/

Create with a subdirectory containing the two following files:

### test.html

Use the following template:



       
           
           XXX TEST TITLE XXX
           
           
           
           
           
           
               QUnit.config.autostart = false;
               require(['/tao/ClientConfig/config'], function(){
                   require(['taoQtiItem/qtiCreator/test/MathEditor/test'], function(){
                       QUnit.start();
                   });
               });
           
       
       
           
           
       

Customise:

-   the test title
-   the path to the test file, starting with the extension folder and omitting the view/js subdirectories
-   you can put all you want in the \#qunit-fixture div, this will be cleaned after each test so you will not have side effect.

Optionnal dependencies:

-   blanket adds code coverage. Specify the file to cover with the *data-cover-only* attribute.
-   parameterize is a QUnit plugin useful for parameterized tests https://github.com/AStepaniuk/qunit-parameterize

### test.js

    define([
        'jquery',
        'your/plugin'
    ], function($, plugin){
        'use strict';

        QUnit.module('plugin');

        QUnit.test('module', function(assert){
            QUnit.expect(1);

            assert.ok(typeof plugin === 'function', 'The module expose a function');
        });

    });

-   we need all tests cases to be wrapped under a QUnit.module (for reporting)
-   for an example of parameterized test, see https://github.com/oat-sa/tao-core/blob/develop/views/js/test/core/encoder/str2array/test.js

