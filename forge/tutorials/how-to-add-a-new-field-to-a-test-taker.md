<!--
created_at: '2015-10-08 12:04:15'
updated_at: '2016-01-31 07:07:46'
authors:
    - 'Rex Wallen Tan'
tags:
    - Tutorials
-->

How to add a new field to a test taker
======================================

Models

You will need to edit the core ontology to be able to add a new field to a test taker. Begin by opening the ontology located at /generis/core/ontology/generis.rdf

We can see a sample such as the field userMail.



        
        
        User Mail
        Mail
        
        
        
      

Step 1 - add the following code under \#userMail and note that is is a duplicate (with only the about attribute changed)
========================================================================================================================



        
        
        Company
        Company
        
        
        
      

Step 2 - Update the ontologies by running the script taoRDFImport.php, you can use the following command:
=========================================================================================================

php tao/scripts/taoRDFImport.php -u <TAO username> -p <TAO password> -i generis/core/ontology/generis.rdf

NOTE: Please use the your TAO username and Password (not the MySQL ones)

Optional TAO integrations
=========================

Option 1: Add a constant to refer to the property URI in generis/common/constants.php
-------------------------------------------------------------------------------------


    define('PROPERTY_USER_COMPANY' ,                GENERIS_NS . '#company' , true);

Option 2: Get all the users that meet the new company parameter
---------------------------------------------------------------

### Option 2a: Add a get method in tao/models/classes/class.UserService.php


    /**
         * Short description of method getAllUsersWithCompany
         *
         * @access public
         * @author Jerome Bogaerts, 
         * @param  array options
         * @return array
         */
        public function getAllUsersWithCompany($company, $options = array())
        {
            $returnValue = array();

            $userClass = new core_kernel_classes_Class(CLASS_TAO_USER);
            $options = array_merge(array('recursive' => true, 'like' => true), $options);
            $filters = array(PROPERTY_USER_COMPANY => $company);
            $returnValue = $userClass->searchInstances($filters, $options);

            return (array) $returnValue;
        }

### Option 2b: Call the function from your controller (if you create your own extension)


    use tao_models_classes_UserService;


    $userService = tao_models_classes_UserService::singleton();
            $users = $userService->getAllUsersWithCompany($company); 
            echo ("Users at ".current($company));
            foreach ($users as $currentUser) {
                echo ("".$currentUser);
            }

How to add a new field to a test taker
======================================

Models

You will need to edit the core ontology to be able to add a new field to a test taker. Begin by opening the ontology located at /generis/core/ontology/generis.rdf

We can see a sample such as the field userMail.





        User Mail
        Mail





Step 1 - add the following code under \#userMail and note that is is a duplicate (with only the about attribute changed)
========================================================================================================================





        Company
        Company





Step 2 - Update the ontologies by running the script taoRDFImport.php, you can use the following command:
=========================================================================================================

php tao/scripts/taoRDFImport.php -u <TAO username> -p <TAO password> -i generis/core/ontology/generis.rdf

NOTE: Please use the your TAO username and Password (not the MySQL ones)

Optional TAO integrations
=========================

Option 1: Add a constant to refer to the property URI in generis/common/constants.php
-------------------------------------------------------------------------------------


    define('PROPERTY_USER_COMPANY' ,                GENERIS_NS . '#company' , true);

Option 2: Get all the users that meet the new company parameter
---------------------------------------------------------------

### Option 2a: Add a get method in tao/models/classes/class.UserService.php


    /**
         * Short description of method getAllUsersWithCompany
         *
         * @access public
         * @author Jerome Bogaerts,
         * @param  array options
         * @return array
         */
        public function getAllUsersWithCompany($company, $options = array())
        {
            $returnValue = array();

            $userClass = new core_kernel_classes_Class(CLASS_TAO_USER);
            $options = array_merge(array('recursive' => true, 'like' => true), $options);
            $filters = array(PROPERTY_USER_COMPANY => $company);
            $returnValue = $userClass->searchInstances($filters, $options);

            return (array) $returnValue;
        }

### Option 2b: Call the function from your controller (if you create your own extension)


    use tao_models_classes_UserService;


    $userService = tao_models_classes_UserService::singleton();
            $users = $userService->getAllUsersWithCompany($company);
            echo ("Users at ".current($company));
            foreach ($users as $currentUser) {
                echo ("".$currentUser);
            }


