<!--
created_at: '2016-08-18 14:06:04'
updated_at: '2016-08-22 15:49:22'
authors:
    - 'Christophe Garcia'
tags: {  }
-->

TAO Service injector
====================

About
-----

TAO Service Injector is th way to integrate any dependencies container.<br/>

It must implement Container interop interface.<br/>

TAO provide configuration for generis Service Manager and Zend Framework Service Locator.<br/>

As well it’s possible to integrate others libraries.

Usage :
-------

Service injector is accessible form controller using getServiceInjector since tao-core 7.5.0 and generis 3.0.0.

Service injector implement [container interop interface](https://github.com/container-interop/container-interop).

**example : in your controller action**

    if($this->getServiceInjector()->has('myService')) {
        $myService = $this->getServiceInjector()->get('myService');
    }

### get service injector in your objects :

you must implement <br/>
\oat\<br/>
oatbox\<br/>
service\<br/>
ServiceInjectorAwareInterface and use <br/>
\oat\<br/>
oatbox\<br/>
service\<br/>
ServiceInjectorAwareTrait (or implement interface methods) AND instanciate by the service injector.

Add your own dependencies using Zend ServiceLocator :
-----------------------------------------------------

### for a new extension :

An helper is available to overload tao configuration :

**1 . Create your install script :**

put it in scripts/install.

    namespace myVendor\myExtension\scripts\install;

    class ServiceInjectorInstaller extends \common_ext_action_InstallAction {
        /**
        * set up a new service injector configuration
        */
        public function __invoke($params) {
            $this->setServiceInjectorConfig(
                    [
                            \oat\oatbox\service\factory\ZendServiceManager::class =>
                                [
                                    //my Zf2 config
                                ],
                        ]
            );
        }
    }

see [Service Locator Usage](https://framework.zend.com/manual/2.4/en/modules/zend.service-manager.quick-start.html)

**2 . Add your script in your manifest :** open manifest.php on your extension root directory

*example :*

    return [
        'name' => 'MyTAOExtension',
        'label' => 'my extension',
        'description' => 'my extension description',
        'license' => 'GPL-2.0',
        'version' => '1.0.0',
        'author' => 'my company',
        'requires' => [],
        'install' => [
            'php' =>
            [
                \oat\myExtension\scripts\install\ServiceInjectorInstaller::class,
            ]
        ]
    ]

### Add your favorite container :

**1 . Create a service factory :**


    namespace myVendor\myExtension\model;

    class MyContainerFactory implements FactoryInterface
    {
        public function __invoke(array $config) {
            return new \myVendor\myExtension\model\MyContainer($config);
        }
    }

**2 . add it to your configuration in your install script :**


    $this->setServiceInjectorConfig(
                    [
                            \myVendor\myExtension\model\MyContainerFactory::class =>
                                [
                                    //my Config
                                ],
                        ]
            );

**reminder :** your container must implement [container interop interface](https://github.com/container-interop/container-interop).

\#<br/>
#<br/>
# Update an existing extension :

In your update class :


    $injectorConfig = [
                            \oat\oatbox\service\factory\ZendServiceManager::class => [
                                // my config
                            ]
    ];

    $injector = $this->getServiceManager()->get(ServiceInjectorRegistry::SERVICE_ID);
                    $injector->overLoad(
                        $injectorConfig
                    );

### Over load an other extension :

is it possible to overload an other extension configuration :

example :

MyExtension 1 config :

     [
                            \myVendor\myExtension\model\MyContainerFactory::class =>
                                [
                                    'alias' =>
                                    [
                                        'model1' => \myVendor\myExtension\model\Model1
                                    ]
                                ],
                        ]

My Extension 2 config

     [
                            \myVendor\myExtension\model\MyContainerFactory::class =>
                                [
                                    'alias' =>
                                    [
                                        'model1' => \myVendor\myNewExtension\model\OverLoadModel1,
                                        'model2' => \myVendor\myNewExtension\model\Model2,
                                    ]
                                ],
                        ]

