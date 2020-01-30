<!--
authors:
    - "Jean-Sébastien Conan"
tags:
    Frontend Architecture:
        - "Good practices"
-->

## Testing

> This document describes good practices regarding frontend testing.

*Description* -
In order to prevent trivial issues due to bad design, this article will propose
a list of good practices to apply. For each presented situation an example will
be provided for both bad and good solutions, with some explanation around them.

*Disclaimer* -
Regarding the provided examples, in order to make them more readable, only the
addressed topic will be represented, and good practices unrelated with it might
not be always presented in the code. Please also keep in mind that the provided
examples are not final solutions, only illustrations.

### Prefer design by coding
When writing code, a developer must check the works is going the right way.
Usually, some manual checks are made aside. But it may become more and more
time consuming as long as the progress is made. So it is better to automate
somehow those manual checks. And a convenient way to do so is to write unit 
tests.

In order to ease the process and improve the quality of the tests, it is 
recommended to apply [Test Driven Development](https://en.wikipedia.org/wiki/Test-driven_development).
The principle is to write tests before you implement the feature.

It might seem tricky to start writing unit tests while you have no idea how
you will implement the feature. However, some patterns might help you.

For instance, if you intent to write a component, since this is a well know
pattern you might start by bootstrapping a common test pattern applied to 
components: check the format of the component factory, check the common API, 
prepare the check of the life cycle, and add a visual test. Then you may 
start implementing the component, adding more unit tests each time you 
augment the component implementation.

Another way of doing TDD might be to design by coding. If you know what you
intent to implement, start by drafting the client, the code that will consume
the feature. This way you will draft out the implementation. Take a look at the
video shared in the resources section below.  

#### Resources
- [Design by Coding - YouTube video](https://www.youtube.com/watch?v=d5Y1B1cmaGQ)

### Properly scope test fixtures
Unit tests must be unique, predictable, and reproducible. They must not be
dependant to other tests, and must not conflict as well. Moreover, they must 
not introduce flaws. If the test fails, this should be because there is an 
error in the tested feature, not an error inside the test.

This is a good habit to reserve one unique markup for each different test, 
in order to be able to setup a proper and dedicated test context.

#### Example: one dedicated fixture per test
Look at the `qunit-fixture` markup. It contains various entries, each one for 
a particular test.
 
```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Ui Test - Button Component</title>
        <script type="text/javascript" src="/environment/require.js"></script>
        <script type="text/javascript">
            require(['/environment/config.js'], function() {
                require(['qunitEnv'], function() {
                    require(['test/ui/button/test'], function() {
                        QUnit.start();
                    });
                });
            });
        </script>
    </head>
    <body>
        <div id="qunit"></div>
        <div id="qunit-fixture">
            <div id="fixture-render"></div>
            <div id="fixture-show"></div>
        </div>
    </body>
</html>
``` 

```javascript
    QUnit.test('render', function(assert) {
        const done = assert.async();
        const config = {label: 'FOO'};
        const container = document.getElementById('fixture-render', config);
        assert.equal(container.children.length, 0, 'The container is empty');

        buttonFactory('#fixture-render')
            .on('ready', function onReady() {
                const element = container.querySelector('.button');
                assert.equal(container.children.length, 1, 'The container now have a child');
                assert.equal(container.querySelectorAll('.button').length, 1, 'The button is rendered');
                assert.equal(this.getElement(), element, 'The expected element is rendered');
                assert.equal(element.innerHTML.trim(), config.label, 'The label has been properly set');
                assert.equal(element.classList.contains('small'), true, 'The button has the proper style');
                this.destroy();
            })
            .on('destroy', done);
    });
    QUnit.test('show/hide', function(assert) {
        const done = assert.async();
        const container = document.getElementById('fixture-show');
        assert.equal(container.children.length, 0, 'The container is empty');

        buttonFactory('#fixture-show')
            .on('ready', function onReady() {
                const element = container.querySelector('.button');
                assert.equal(container.children.length, 1, 'The container now have a child');
                assert.equal(container.querySelectorAll('.button').length, 1, 'The button is rendered');
                assert.equal(this.getElement(), element, 'The expected element is rendered');

                assert.equal(this.is('hidden'), false, 'The button instance is visible');
                assert.equal(element.classList.contains('hidden'), false, 'The button instance does not have the hidden class');
                
                this.hide();
                assert.equal(this.is('hidden'), true, 'The button instance is hidden');
                assert.equal(element.classList.contains('hidden'), true, 'The button instance has the hidden class');
                
                this.show();
                assert.equal(this.is('hidden'), false, 'The button instance is visible');
                assert.equal(element.classList.contains('hidden'), false, 'The button instance does not have the hidden class');

                this.destroy();
            })
            .on('destroy', done);
    });
```

#### Resources
- [Definition](https://en.wikipedia.org/wiki/Unit_testing)
- [Unit Testing](http://softwaretestingfundamentals.com/unit-testing/)

### Add visual playground for UI parts
When building a UI component, it is useful to also provide a visual playground
with the unit tests. This allows to demo the behavior of the component. This
is useful to quickly get an idea of what the component looks like. This is also
a good helper to quickly see what is the current state of the development during
the build process, aside the writing of unit tests. This will also avoid to have
to setup an environment to see the component in situation at an earlier stage.

In other words, this will save time at several stages. 

#### Example: add a visual playground
The following example gives a simple example of how a visual test could be 
added to a test suite.

```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Ui Test - Button Component</title>
        <script type="text/javascript" src="/environment/require.js"></script>
        <script type="text/javascript">
            require(['/environment/config.js'], function() {
                require(['qunitEnv'], function() {
                    require(['test/ui/button/test'], function() {
                        QUnit.start();
                    });
                });
            });
        </script>
        <style>
            #visual-test {
                background: #EEE;
                position: relative;
                margin: 10px;
                padding: 10px;
            }
            #visual-test button {
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <div id="qunit"></div>
        <div id="qunit-fixture">
            <div id="fixture-render"></div>
        </div>
        <div id="visual-test"></div>
    </body>
</html>
```

```javascript
QUnit.module('Button Visual Test');

    QUnit.test('simple button', function(assert) {
        assert.expect(1);
        button('#visual-test', {label: 'Button'})
            .on('render', function() {
                assert.ok(true, 'Button "' + id + '" is rendered');
            });
    });
```
