How to extend the Results Persistence Layer for more functionality
==================================================================

When we retrieve Delivery Results from TAOTesting - the ideal way to retrieve objects is to use ResultsService.php but we may go directly to the persistence layer which interacts with SQL namely RdsResultStorage.php

Step 1 - Add a new function
---------------------------

Add a new function to RdsResultStorage.php - this is a sample function that will retrieve all the Delivery Results for a group of Test Takers

    public function getAllDeliveryIdsByTesttaker($testTakersUri = array())
        {
            $returnValue = array();
            $sqlWhereInTable = implode("','", $testTakersUri); //Implode first to add commas + Single quotes
            $sqlWhereInTable = "('".$sqlWhereInTable."')"; //Add brackets and beginning/ending single quote
            $sql = 'SELECT ' . self::RESULTS_TABLE_ID . ', ' . self::DELIVERY_COLUMN . ' FROM ' . self::RESULTS_TABLENAME;
            $sql .= ' WHERE ' . self::TEST_TAKER_COLUMN .' IN' . $sqlWhereInTable;
            $results = $this->persistence->query($sql);
            foreach ($results as $value) {
                $returnValue[] = array(
                    "deliveryResultIdentifier" => $value[self::RESULTS_TABLE_ID],
                    "deliveryIdentifier" => $value[self::DELIVERY_COLUMN]
                );
            }
            return $returnValue;
        }

Step 2 - Import the correct file into your controller
-----------------------------------------------------

Import the correct file into your controller

    use oat\taoOutcomeRds\model\RdsResultStorage;

Step 3 - Call the function from your controller
-----------------------------------------------

Call the function from your controller

    $testTakers = array();
    //This is a hard coded URI of a test taker (just to test)
    array_push($testTakers, 'http://localhost/projects/taotesting/john.rdf#i1441541566133340');
    $rdsResultsStorage = new RdsResultStorage();
    $deliveryIDs = $rdsResultsStorage->getAllDeliveryIdsByTesttaker($testTakers);
    foreach ($deliveryIDs as $deliveryID) 
     {
      echo print_r($deliveryID);
      echo "";
     }
