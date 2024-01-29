<!--
created_at: '2016-03-21 10:13:00'
authors:
    - 'Christophe Noël'
tags:
    - JavaScript
    - 'Unit test'
-->

JavaScript unit tests
=====================

Setup
-----

    cd tao/views
    npm install

Running tests
-------------

### All tests:

    grunt testall

### Specific extension:

    cd tao/views
    grunt connect:test [extname+test]
    grunt connect:test taoqtiitemtest
    grunt connect:test taotest
    ...

### Specific test:

You can either open the test.html in a browser or adapt the following command line:

    cd tao/views
    grunt connect:test qunit:single --test=[/path/to/test.html]
    grunt connect:test qunit:single --test=/taoQtiItem/views/js/qtiCreator/test/MathEditor/test.html
    ...

Failing tests
-------------

In case you have failing tests:

-   make sure that you have the latest version of all TAO extensions
-   make sure that you have the latest npm dependencies (like PhantomJS) with npm update (or remove node_modules directory, then run npm install again)

In case of an obscure error message (`PhantomJS timed out` for example), you may get more detailed information using the the `--debug` or `--verbose` flags

    grunt connect:test qunit:single --test=/taoQtiTest/views/js/test/runner/helpers/map/test.html --debug
    grunt connect:test qunit:single --test=/taoQtiTest/views/js/test/runner/helpers/map/test.html --verbose

To help debugging unit tests that only fail when run with grunt, you can launch the test webserver…

    grunt connect:test:keepalive

    Running "connect:test:keepalive" (connect) task
    Waiting forever...
    Started connect web server on http://127.0.0.1:8082

… then open the test in your browser

    http://127.0.0.1:8082/taoQtiItem/views/js/qtiCreator/test/MathEditor/test.html

tadam …. !

Optionally, you can set the test url and port like:

    grunt connect:test:keepalive --testUrl=0.0.0.0 --testPort=1234

    Running "connect:test:keepalive" (connect) task
    Waiting forever...
    Started connect web server on http://localhost:1234

Live reloading
--------------

Enable livereload on test server, triggered by watch:

1.  grunt connect:dev watch:taosass
2.  Then open a test, for example http://127.0.0.1:8082/tao/views/js/test/ui/tooltip/test.html
3.  Modify a SCSS file
4.  The test will reload automatically once the CSS compilation is done

You can also change the livereload port by using the option —livereloadPort=35729 in the cli.

Writing tests
-------------

Store your tests in the following directory, so they are run by the CI engine:

    extension/views/js/test/

Create with a subdirectory containing the two following files:

### test.html

Use the following template:
```html
    <!DOCTYPE html>
    <html>
       <head>
           <meta charset="utf-8">
           <title>XXX TEST TITLE XXX</title>
           <link rel="stylesheet" type="text/css" href="/tao/views/js/lib/qunit/qunit.css">
           <script type="text/javascript" src="/tao/views/js/lib/qunit/qunit.js"></script>
           <script type="text/javascript" src="/tao/views/js/lib/require.js"></script>
           <script type="text/javascript" src="/tao/views/js/lib/qunit/qunit-parameterize.js"></script>
           <script type="text/javascript" src="/tao/views/js/lib/blanket/blanket.min.js" data-cover-flag="branchTracking" data-cover-only="editor/MathEditor.js"></script>
           <script  type="text/javascript">
               QUnit.config.autostart = false;
               require(['/tao/ClientConfig/config'], function(){
                   require(['taoQtiItem/qtiCreator/test/MathEditor/test'], function(){
                       QUnit.start();
                   });
               });
           </script>
       </head>
       <body>
           <div id="qunit"></div>
           <div id="qunit-fixture"></div>
       </body>
    </html>
```


Customise:

-   the test title
-   the path to the test file, starting with the extension folder and omitting the `view/js` subdirectories
-   you can put all you want in the `#qunit-fixture` div, this will be cleaned after each test so you will not have side effect.

Optionnal dependencies:

-   blanket adds code coverage. Specify the file to cover with the `data-cover-only` attribute.
-   parameterize is a QUnit plugin useful for parameterized tests https://github.com/AStepaniuk/qunit-parameterize

### test.js
```javascript
    define([
        'jquery',
        'your/plugin'
    ], function($, plugin){
        'use strict';

        QUnit.module('plugin');

        QUnit.test('module', function(assert){
            assert.expect(1);

            assert.ok(typeof plugin === 'function', 'The module expose a function');
        });

    });
```

-   we need all tests cases to be wrapped under a QUnit.module (for reporting)
-   for an example of parameterized test, see https://github.com/oat-sa/tao-core/blob/develop/views/js/test/core/encoder/str2array/test.js

More details you can find in official documentation for QUnit unit test framework - https://api.qunitjs.com/


