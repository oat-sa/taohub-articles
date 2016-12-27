<!--
parent: Tutorials
created_at: '2016-01-01 02:40:35'
updated_at: '2016-01-01 02:41:13'
authors:
    - 'Rex Wallen Tan'
tags:
    - Tutorials
-->

How to add the Results persistence layer to your module
=======================================================

The Results persistence layer is called ResultsService.php but is fairly tricky to work with because it requires an instance of taoResultServer_models_classes_ReadableResultStorage to be passed to it as an implementation.

Step 1: Create a constants.php file and add it to your module
-------------------------------------------------------------

You need to create a constants.php file and make sure it is placed in the following location <YOUR MODULE><br/>
\includes\<br/>
constants.php

Add the following includes to your constants.php file

Step 2: Import the correct classes into your module
---------------------------------------------------

Add the following class imports at the top of your module

Step 3: Add class variables to your module
------------------------------------------

Add the following class variables to your module

    protected $resultsService;
    protected $rdsResultsStorage;

Step 4: Modify your construct() to initialize all the variables
---------------------------------------------------------------

Add the following code to your construct() function in your module, while this code creates a new RdsResultsStorage which **really** should be called as a singleton, it keeps the code simpler rather than extending the GenerisPersistence layer which may cause a lot of confusion.

    public function __construct() {
            parent::__construct();
        //Set variables to access the persistence layer
        $this->rdsResultsStorage = new RdsResultStorage();
        $this->resultsService = ResultsService::singleton();
        $this->resultsService->setImplementation($this->rdsResultsStorage);
        }

