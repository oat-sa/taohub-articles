<!--
author:
    - 'Jérôme Bogaerts'
created_at: '2011-03-02 17:20:18'
updated_at: '2013-03-13 13:02:49'
tags:
    - 'Workflow Engine'
-->



Process Creation with API “Process Authoring Service”
=====================================================

Starting creating a process programmatically can be fast and handy. For instance, we can loop over a list of tens of items to build a sequential test process.

1. Create a simple sequential process
-------------------------------------

First, make sure that the class is defined and that you are authenticated against the [[Generis API]].

Initialize the authoring service (call the get function of the service factory to get the singleton instance for better performance):


    $authoringService = tao_models_classes_ServiceFactory::get('wfEngine_models_classes_ProcessAuthoringService');

Create a new process:


    $processDefinition = $authoringService->createProcess('ProcessForUnitTest', 'Unit test');

Add an activity to the process called ‘activity 1’:


    $activity1 = $authoringService->createActivity($processDefinition, 'activity1');

Every process need one activity that is designated as the first one. Set it with the *setFirstActivity()* method as follows:


    $authoringService->setFirstActivity($processDefinition, $activity1);

Create a new connector for this activity and set the ‘sequence’ type by using the defined constant INSTANCE\_TYPEOFCONNECTORS\_SEQUENCE:


    $connector1 = $authoringService->createConnector($activity1);
    $authoringService->setConnectorType($connector1, new core_kernel_classes_Resource(INSTANCE_TYPEOFCONNECTORS_SEQUENCE));

Finish the process by connecting the sequential connector to a new activity called “activity2”:


    $activity2 = $authoringService->createSequenceActivity($connector1, null, 'activity2');

2. Create a simple conditional process
--------------------------------------

Init the process authoring service and create a process definition resource:


    $authoringService = tao_models_classes_ServiceFactory::get('wfEngine_models_classes_ProcessAuthoringService');
    $processDefinition = $authoringService->createProcess('ProcessForUnitTest', 'Unit test');

Create a first actvity and define it as the first one:


    $activity1 = $authoringService->createActivity($processDefinition, 'myActivity');
    $authoringService->setFirstActivity($processDefinition, $activity1);

Create a connector with the type to “conditional” INSTANCE\_TYPEOFCONNECTORS\_CONDITIONAL


    $connector1 = $authoringService->createConnector($activity1);
    $authoringService->setConnectorType($connector1, new core_kernel_classes_Resource(INSTANCE_TYPEOFCONNECTORS_CONDITIONAL));

    $then = $authoringService->createSplitActivity($connector1, 'then');//create "Activity_2"
    $else = $authoringService->createSplitActivity($connector1, 'else', null, '', true);//create another connector

Create a variable called *’myProcessVarCode1’*, and a transition rule \_‘\^myProcessVarCode1  1'\_. This transition rule means that the condition is fulfilled if the value of the process variable with the code \_myProcessVarCode1\_ is equal to '1'. For more information on transition rule syntaxe, see [[transition rule syntaxe]].
\<pre\>
\<code class="php"\>
\$myProcessVar1 = \$authoringService-\>getProcessVariable('myProcessVarCode1', true);
\$authoringService-\>createTransitionRule(\$connector1, '\^myProcessVarCode1  1’);<br/>

</code>

</pre>
Complete the process by connecting the connector ‘else’ to a new activity labeled ‘Activity 3’


    $activity3 = $authoringService->createSequenceActivity($else, null, 'Activity 3');

3. Other services to help building a process definition
-------------------------------------------------------

The wfEngine extension also provides other services and helpers to help building processes. Below is a short introduction to them. For more information, please refer to the [phpDoc](http://forge.tao.lu/docs/phpdoc/index.html) **package wfEngine**

### 3.1. ProcessUtil helper

This process helper provides convenient methods to check the type of a [[Generis Overview|Generis resource]], in particular if the resource is a connector or an activity. If it is an activity, is it an initial or a final one.

### 3.2. Process checker

Building a process could be a complex task.<br/>

Frequent mistakes are:

-   forgetting to define a process as the first one
-   leaving a connector without a following activity
-   creating a conditional connector without transition rules

It is therefore useful to use a tool to check the validity of a process definition. Hereafter, you’ll find the purpose of the process checker.

#### 3.2.1. Check a process

From a previously created process definition ‘\$processDefinition’, load it into the process checker:


    $processChecker = new wfEngine_models_classes_ProcessChecker($processDefinition);

You can perform individual check with an available method, for instance, checking whether the process has one or several isolated connectors, i.e., without a next activity:


    $hasNoIsolatedConnector = $processChecker->checkNoIsolatedConnector();

In case of a problem, you can print out the faulty connectors


    if($hasNoIsolatedConnector){
        echo 'process ok';
    }else{
        echo 'error: the process has isolated connector(s):';
        foreach($processChecker->getIsolatedConnectors() as $connector){
            echo "{$connector->getLabel()}";
        }
    }

You can also directly validate the connector with a list of available checking methods:


    if($processChecker->check()){
        echo 'process ok';
    }else{
        echo 'the process is not valid';
    }

#### 3.2.2. Add a new verification rule

You may also want to extend the functionalities of the basic *Process Checker*. The ProcessChecker class allows you to easily implement your own checking methods. To add a new check method, you only need to add a function, the name of which starts with “check” (like the *checkMyProcessHasTenActivities()* method below). The return value of the method must be of boolean type. You can use the class properties “process” to get the loaded process definition and “authoringService” as the singleton of the process authoring service.


    class myChecker extends wfEngine_models_classes_ProcessChecker{

        //check that your process has ten activities
        public function checkMyProcessHasTenActivities(){
            $process = $this->process;
            $activities = $this->authoringService->getActivitiesByProcess($process)
            return count($activities)==10?true:false;
        }
    }

    $myChecker = new myChecker($processDefinition);
    if($myChecker->check()){
        echo 'process ok';
    }else{
        echo 'the process is not valid';
    }

### 3.3. Process cloner

After building a valid process, a process definition resource can be cloned completely or cloned by segment. Currently, only sequential and conditional processes can be cloned.

Cloning completely a process gives process creators a way to create an entirely new independent process based on an original model. It could be a way to take time to build a complex process then use it as a template to create several others (e.g., keeping the process flow and changing the services only).

The purpose of cloning a process by segment is to allow merging several processes together, by selecting branches of a given process and to “paste” or “insert” it into another one. (Note: the current implementation enables only cloning section from the first to the last activities: further work is required to make the full functionality a reality).

4. More examples
----------------

The unit tests dedicated to the Workflow Engine provide other examples of process creation and execution by the workflow related services. They are located on the following path */wfEngine/test/*:

-   ProcessAuthoringServiceTestCase gives examples of the way to use most of the methods of the process authoring service.
-   ProcessClonerTestCase
-   ProcessCheckerTestCase
-   ProcessExecutionTestCase and TokenServiceTestCase offer complete examples of process creation-execution cycle

You can find more details about the workflow services presented in this page in the [phpDoc](http://forge.tao.lu/docs/phpdoc/index.html)


