<?php
use oat\generis\model\data\ModelManager;
use oat\taoOutcomeRds\model\RdsResultStorage;

require_once dirname(__FILE__) . '/../includes/raw_start.php';

$parms = $argv;
$script = array_shift($parms);

if (count($parms) != 1) {
    echo "Usage: " . $script . " CONFIRMATION" . PHP_EOL . PHP_EOL;
    echo "This script will delete all delivery results, delivery executions." . PHP_EOL;
    die(1);
}
$confirmation = array_shift($parms);
if ($confirmation != 'yes') {
    echo "Confirmation needs to be 'yes' to DELETE all" . PHP_EOL;
    die(1);
}

// file system
$config = common_ext_ExtensionsManager::singleton()->getExtensionById('tao')->getConfig(tao_models_classes_service_FileStorage::CONFIG_KEY);

foreach (array(new core_kernel_fileSystem_FileSystem($config['private']), new core_kernel_fileSystem_FileSystem($config['public'])) as $fs) {
    $path = $fs->getPath();
    tao_helpers_File::emptyDirectory($path);
    echo 'Emptied ' . $path . PHP_EOL;
}

// deliveryExecutions
$extension = common_ext_ExtensionsManager::singleton()->getExtensionById('taoDelivery');
$deliveryService = $extension->getConfig('execution_service');
if ($deliveryService instanceof taoDelivery_models_classes_execution_KeyValueService) {
    $persistenceOption = $deliveryService->getOption(taoDelivery_models_classes_execution_KeyValueService::OPTION_PERSISTENCE);
    $persistence = common_persistence_KeyValuePersistence::getPersistence($persistenceOption);
    $count = 0;
    foreach ($persistence->keys('kve_*') as $key) {
        if (substr($key, 0, 4) == 'kve_') {
            $persistence->del($key);
            $count++;
        }
    }
    echo 'Removed ' . $count . ' key-value delivery executions' . PHP_EOL;
} elseif ($deliveryService instanceof taoDelivery_models_classes_execution_OntologyService) {
    $count = 0;
    $deliveryExecutionClass = new core_kernel_classes_Class(CLASS_DELVIERYEXECUTION);
    $deliveryExecutions = $deliveryExecutionClass->getInstances();
    /** @var  core_kernel_classes_Class $deliveryExecution */
    foreach ($deliveryExecutions as $deliveryExecution) {
        $deliveryExecution->delete(true);
        $count++;
    }
    echo 'Removed ' . $count . ' ontology delivery executions' . PHP_EOL;

} else {
    echo 'Cannot cleanup delivery executions from ' . get_class($deliveryService) . PHP_EOL;
}

// service states
$persistence = common_persistence_KeyValuePersistence::getPersistence(tao_models_classes_service_StateStorage::PERSISTENCE_ID);
if ($persistence instanceof common_persistence_AdvKeyValuePersistence) {
    $count = 0;
    foreach ($persistence->keys('tao:state:*') as $key) {
        if (substr($key, 0, 10) == 'tao:state:') {
            $persistence->del($key);
            $count++;
        }
    }
    echo 'Removed ' . $count . ' states' . PHP_EOL;
} elseif ($persistence instanceof common_persistence_KeyValuePersistence) {
    try {
        if ($persistence->purge()) {
            echo 'States correctly removed' . PHP_EOL;
        }
    } catch (common_exception_NotImplemented $e) {
        echo $e->getMessage();
    }

} else {
    echo 'Cannot cleanup states from ' . get_class($persistence) . PHP_EOL;
}

// deliveries and references
$rootClass = taoDelivery_models_classes_DeliveryAssemblyService::singleton()->getRootClass();
$ids = array();
foreach ($rootClass->getInstances(true) as $delivery) {
    $ids[] = $delivery->getUri();
}

$rdf = ModelManager::getModel()->getRdfInterface();
foreach ($rdf as $triple) {
    if (in_array($triple->subject, $ids) || in_array($triple->object, $ids)) {
        $rdf->remove($triple);
    }
}
echo 'Deleted ' . count($ids) . ' deliveries' . PHP_EOL;


try {
    // results rds
    $rdsStorage = new RdsResultStorage();
    $deliveryIds = $rdsStorage->getAllDeliveryIds();
    $count = 0;
    foreach ($deliveryIds as $deliveryId) {
        if ($rdsStorage->deleteResult($deliveryId['deliveryResultIdentifier'])) {
            $count++;
        } else {
            echo 'Cannot cleanup results for ' . $deliveryId['deliveryResultIdentifier'] . PHP_EOL;
        }

    }
    echo 'Removed ' . $count . ' on ' . count($deliveryIds) . ' RDS results' . PHP_EOL;

    // results redis
    try{
        $keyValuePersistence = common_persistence_KeyValuePersistence::getPersistence('keyValueResult');
    }
    catch(common_Exception $e){
        $keyValuePersistence = null;
    }

    if(!is_null($keyValuePersistence)){
        $kvStorage = new taoAltResultStorage_models_classes_KeyValueResultStorage();
        $deliveryIds = $kvStorage->getAllDeliveryIds();
        $count = 0;
        foreach ($deliveryIds as $deliveryId) {
            if ($kvStorage->deleteResult($deliveryId['deliveryResultIdentifier'])) {
                $count++;
            } else {
                echo 'Cannot cleanup results for ' . $deliveryId['deliveryResultIdentifier'] . PHP_EOL;
            }

        }
        echo 'Removed ' . $count . ' on ' . count($deliveryIds) . ' Key Value results' . PHP_EOL;
    }
} catch (common_Exception $e) {
    echo 'Cannot cleanup Results: ' . $e->getMessage() . PHP_EOL;
}

echo 'done' . PHP_EOL;