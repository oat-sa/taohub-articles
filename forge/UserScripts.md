<!--
author:
    - 'Christophe Noel'
created_at: '2016-07-11 17:27:04'
updated_at: '2016-07-11 17:27:37'
-->

User modules & user scripts
===========================

What are they?
--------------

User modules are pieces of Javascript that are loaded and executed at runtime by the item runner.<br/>

They should expose an object with an exec() method that will be called by the loader. They are available in both the new and old item runner.

User scripts are a different - and older - implementation of the same concept. They are only implemented in the old item runner. Thus, you most probably want to create a user module rather than a user script.

They are 2 ways of registering user modules. Pick up one or another depending on the test runner used but do not mix them. If you have user modules registered for the old test runner and want them in the new one, please unregister them first with

    $registry->remove('taoQtiItem/runtime/qtiBootstrap');
    $registry->remove('taoQtiItem/runtime/qtiBootstrap.min');

Register a userModule in the new test/item runner
-------------------------------------------------

This will activate the user modules in both the item preview and the new test/item runner.

    use oat\tao\model\ClientLibConfigRegistry;

    $registry = ClientLibConfigRegistry::getRegistry();
    $registry->register('taoQtiItem/runner/provider/manager/userModules', array(
        'userModules' => array(
            'taoExtension/userScripts/myModule1',
            'taoExtension/userScripts/myModule2'
        )
    ));

Register a userModule in the old test/item runner
-------------------------------------------------

This will activate the user modules in both the item preview and the old test/item runner.

    use oat\tao\model\ClientLibConfigRegistry;

    $registry = ClientLibConfigRegistry::getRegistry();
    $registry->register(''taoQtiItem/runtime/qtiBootstrap', array(
        'userModules' => array(
            'taoExtension/userScripts/myModule1',
            'taoExtension/userScripts/myModule2'
        )
    ));
    $registry->register(''taoQtiItem/runtime/qtiBootstrap.min', array(
        'userModules' => array(
            'taoExtension/userScripts/myModule1',
            'taoExtension/userScripts/myModule2'
        )
    ));

