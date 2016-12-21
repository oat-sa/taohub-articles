<!--
parent:
    title: Testrunner
author:
    - 'Joel Bout'
created_at: '2013-10-31 17:51:03'
updated_at: '2013-11-04 17:03:26'
tags:
    - Testrunner
-->

Testmodel Tao 2.5
=================

The test model in Tao 2.5 is defined by the interface *taoTests\_models\_classes\_TestModel*

TestModel
---------

The test model must implement the following functions:

### \_\_construct()

A public constructor in order to ensure that taoTests can instantiate it.

### onChangeTestLabel( core\_kernel\_classes\_Resource \$test)

Called when the label of a test changes

### prepareContent( core\_kernel\_classes\_Resource \$test, \$items = array())

Creates a test content specific to the test model. If possible this content should be based on \$items.\
This function is called whenever a test model is assigned to an test.

### deleteContent( core\_kernel\_classes\_Resource \$test)

This should delete the content of the test, however not the compiled content.\
Usually called on deletion of test or change of test model.

### getItems( core\_kernel\_classes\_Resource \$test)

Should return the items of the test if possible. Should the test model change these items will be used as basis for the new test model.

### getAuthoring( core\_kernel\_classes\_Resource \$test)

Should return the html of the authoring widget for this test model

### cloneContent( core\_kernel\_classes\_Resource \$source, core\_kernel\_classes\_Resource \$destination)

Should clone the content of the test \$source and assign the cloned content as the content of the test \$destination.

### getCompiler( core\_kernel\_classes\_Resource \$test)

Returns an instance of the abstract class *tao\_models\_classes\_Compiler*, which has been initalised for \$test:

Test compiler
-------------

The test compiler needs to implement the abstract method:

### compile(core\_kernel\_file\_File \$destinationDirectory)

This function will prepare a datastructure for the test that is exploitable by the test runner. The provided \$destinationDirectory can be used for storage. Typically this will involve compiling the items of the test as well, which will be compiled using a similar compiler:

    $itemCompiler = taoItems_models_classes_ItemsService::singleton()->getCompiler($item);
    $serviceCall = $compiler->compile($itemCompiler);

This method should return an instance of *tao\_models\_classes\_service\_ServiceCall* that points to the testrunner and provides the nescessary parameters to run this test.

