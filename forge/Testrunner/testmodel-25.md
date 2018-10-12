<!--
parent: Testrunner
created_at: '2013-10-31 17:51:03'
updated_at: '2013-11-04 17:03:26'
authors:
    - 'Joel Bout'
tags:
    - Testrunner
-->

Testmodel TAO 2.5
=================

The test model in TAO 2.5 is defined by the interface *taoTests_models_classes_TestModel*

TestModel
---------

The test model must implement the following functions:

### __construct()

A public constructor in order to ensure that taoTests can instantiate it.

### onChangeTestLabel( core_kernel_classes_Resource <br/>
$test)

Called when the label of a test changes

### prepareContent( core_kernel_classes_Resource <br/>
$test, <br/>
$items = array())

Creates a test content specific to the test model. If possible this content should be based on <br/>
$items.<br/>

This function is called whenever a test model is assigned to an test.

### deleteContent( core_kernel_classes_Resource <br/>
$test)

This should delete the content of the test, however not the compiled content.<br/>

Usually called on deletion of test or change of test model.

### getItems( core_kernel_classes_Resource <br/>
$test)

Should return the items of the test if possible. Should the test model change these items will be used as basis for the new test model.

### getAuthoring( core_kernel_classes_Resource <br/>
$test)

Should return the html of the authoring widget for this test model

### cloneContent( core_kernel_classes_Resource <br/>
$source, core_kernel_classes_Resource <br/>
$destination)

Should clone the content of the test <br/>
$source and assign the cloned content as the content of the test <br/>
$destination.

### getCompiler( core_kernel_classes_Resource <br/>
$test)

Returns an instance of the abstract class *tao_models_classes_Compiler*, which has been initialised for <br/>
$test:

Test compiler
-------------

The test compiler needs to implement the abstract method:

### compile(core_kernel_file_File <br/>
$destinationDirectory)

This function will prepare a datastructure for the test that is exploitable by the test runner. The provided <br/>
$destinationDirectory can be used for storage. Typically this will involve compiling the items of the test as well, which will be compiled using a similar compiler:

    $itemCompiler = taoItems_models_classes_ItemsService::singleton()->getCompiler($item);
    $serviceCall = $compiler->compile($itemCompiler);

This method should return an instance of *tao_models_classes_service_ServiceCall* that points to the testrunner and provides the necessary parameters to run this test.


