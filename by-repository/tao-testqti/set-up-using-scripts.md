# Set up using scripts

>- *since v5.15.0*

Some scripts are provided to easily activate the TestRunner in a particular version.


### New Version{#new-version}

From the command line of your server, type and execute the following command:

```
php index.php '\oat\taoQtiTest\scripts\install\SetNewTestRunner'
```

The script should display this text when finished:

```
New test runner activated
```


### Old Version{#old-version}

From the command line of your server, type and execute the following command:

```
php index.php '\oat\taoQtiTest\scripts\install\SetOldTestRunner'
```

The script should display this text when finished:

```
Old test runner activated
```


### Check the Version{#check-the-version}

>- *since v5.30.0*

From the command line of your server, type and execute the following command:

```
php index.php '\oat\taoQtiTest\scripts\install\TestRunnerVersion'
```

Depending on the TestRunner version, the script should display this text when finished:

```
DeliveryServer: New TestRunner
Compiler Class: New TestRunner
Test Session: New TestRunner

The New Test Runner is activated

```

If something is wrong in your config, the script will alert you:

```
DeliveryServer: New TestRunner
Compiler Class: New TestRunner
Test Session: Unknown version / bad config

WARNING!
The Test Runner seems to be misconfigured!

```

## Set up manually{#set-up-manually}

In order to correctly set up the Test Runner in the wanted version you need to set up several config file.


### New Version{#new-version}

In order to use the new version of the Test Runner you need to set up the following configurations :

1. The item compiler, in `config/taoQtiItem/compilerClass.conf.php`
    ```php
    return 'oat\\taoQtiItem\\model\\QtiJsonItemCompiler';
    ```

2. The delivery container, in `config/taoDelivery/deliveryServer.conf.php`
    ```php
    'deliveryContainer' => 'oat\\taoDelivery\\helper\\container\\DeliveryClientContainer'
    ```

3. The test session, in `config/taoQtiTest/testRunner.conf.php`
    ```php
   'test-session' => 'oat\\taoQtiTest\\models\\runner\\session\\TestSession',
    ```

You may adapt the following script to set these values:

```php
class SetNewTestRunner extends \common_ext_action_InstallAction
{
    public function __invoke($params)
    {
        $deliveryExt = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoDelivery');
        $deliveryServerConfig = $deliveryExt->getConfig('deliveryServer');
        $deliveryServerConfig->setOption('deliveryContainer', 'oat\\taoDelivery\\helper\\container\\DeliveryClientContainer');
        $deliveryExt->setConfig('deliveryServer', $deliveryServerConfig);

        $itemQtiExt = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiItem');
        $compilerClassConfig = 'oat\\taoQtiItem\\model\\QtiJsonItemCompiler';
        $itemQtiExt->setConfig('compilerClass', $compilerClassConfig);

        $testQtiExt = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest');
        $testRunnerConfig = $testQtiExt->getConfig('testRunner');
        $testRunnerConfig['test-session'] = 'oat\\taoQtiTest\\models\\runner\\session\\TestSession';
        $testQtiExt->setConfig('testRunner', $testRunnerConfig);

        return new \common_report_Report(\common_report_Report::TYPE_SUCCESS, 'New test runner activated');
    }
}
```


### Old Version{#old-version}

In order to use the old version of the Test Runner you need to set up the following configurations :

1. The item compiler, in `config/taoQtiItem/compilerClass.conf.php`
    ```php
    return 'oat\\taoQtiItem\\model\\QtiItemCompiler';
    ```

2. The delivery container, in `config/taoDelivery/deliveryServer.conf.php`
    ```php
    'deliveryContainer' => 'oat\\taoDelivery\\helper\\container\\DeliveryServiceContainer'
    ```

3. The test session, in `config/taoQtiTest/testRunner.conf.php`
    ```php
   'test-session' => '\\taoQtiTest_helpers_TestSession',
    ```

You may adapt the following script to set these values:

```php
class SetOldTestRunner extends \common_ext_action_InstallAction
{
    public function __invoke($params)
    {
        $deliveryExt = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoDelivery');
        $deliveryServerConfig = $deliveryExt->getConfig('deliveryServer');
        $deliveryServerConfig->setOption('deliveryContainer', 'oat\\taoDelivery\\helper\\container\\DeliveryServiceContainer');
        $deliveryExt->setConfig('deliveryServer', $deliveryServerConfig);

        $itemQtiExt = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiItem');
        $compilerClassConfig = 'oat\\taoQtiItem\\model\\QtiItemCompiler';
        $itemQtiExt->setConfig('compilerClass', $compilerClassConfig);

        $testQtiExt = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest');
        $testRunnerConfig = $testQtiExt->getConfig('testRunner');
        $testRunnerConfig['test-session'] = '\\taoQtiTest_helpers_TestSession';
        $testQtiExt->setConfig('testRunner', $testRunnerConfig);

        return new \common_report_Report(\common_report_Report::TYPE_SUCCESS, 'Old test runner activated');
    }
}
```