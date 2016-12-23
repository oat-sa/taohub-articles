<!--
created_at: '2011-03-02 18:05:10'
updated_at: '2013-03-13 13:03:02'
authors:
    - 'Jérôme Bogaerts'
contributors:
    - 'Somsack Sipasseuth'
tags:
    - 'Workflow Engine'
-->



Service Creation with API “Process Authoring Service”
=====================================================

The services of an activity define the actual business of the activity.

1. Preloaded services in TAO
----------------------------

Most of the available actions in the TAO back-office are available as a service.<br/>

The complete list of service is loaded into TAO during the installation process: they are available in the advanced authoring tool.

The complete description of services can be found here : [Services_definition.pdf](../resources/Services_definition.pdf)

### 1.2. Groups services

-   Group class selection
-   Group selection
-   Group add
-   Group editor
-   Group full editor
-   Group class editor
-   Group translation
-   Group related subjects
-   Group related deliveries
-   Groups searching
-   Group removing

### 1.3. Items services

-   Item class selection
-   Item selection
-   Item add
-   Item editor
-   Item full editor
-   Item class editor
-   Item preview
-   Item authoring
-   Item translation
-   Items searching
-   Item removing

### 1.4. Results services

-   Results searching
-   Result Table

### 1.5. Subjects services

-   Subject class selection
-   Subject selection
-   Subject add
-   Subject editor
-   Subject full editor
-   Subject class editor
-   Subject translation
-   Subject’s group selection
-   Subjects searching
-   Subject removing

### 1.6. Tests services

-   Test class selection
-   Test selection
-   Test add
-   Test editor
-   Test full editor
-   Test class editor
-   Test’s items authoring
-   Test parameters
-   Test preview
-   Test translation
-   Test related items
-   Tests searching
-   Test removing

### 1.7. Delivery services

-   Delivery class selection
-   Delivery selection
-   Deliveries searching
-   Delivery add
-   Delivery editor
-   Delivery full editor
-   Delivery class editor
-   Delivery exclude subject
-   Delivery related campaigns
-   Delivery removing
-   Delivery compilation
-   Campaign class selection
-   Campaign selection
-   Campaigns searching
-   Campaign add
-   Campaign editor
-   Campaign full editor
-   Campaign class editor
-   Campaign related delivery
-   Campaign removing
-   ResultServer class selection
-   ResultServer selection
-   ResultServers searching
-   ResultServer add
-   ResultServer editor
-   ResultServer full editor
-   ResultServer class editor
-   ResultServer related delivery
-   ResultServer removing

For instance, the source of the service to edit an item is in the following file: *yourWebRootPath/taoItems/actions/class.SaSItems.php*<br/>

As previously said in Process Definition Model\#Service_definition, a service is defined by its URL. Provided that its url is accesible via URL, it can be a service in TAO. The service *’sasEditInstance’* below is accessible via the URL */taoItems/SaSItems/sasEditInstance* (with URL rewriting engine activated in TAO)


    class taoItems_actions_SaSItems extends taoItems_actions_Items {
        [...]
        public function sasEditInstance(){
            $clazz = $this->getCurrentClass();
            $instance = $this->getCurrentInstance();


            $formContainer = new tao_actions_form_Instance($clazz, $instance);
            $myForm = $formContainer->getForm();

            if($myForm->isSubmited()){
                if($myForm->isValid()){
                    $instance = $this->service->bindProperties($instance, $myForm->getValues());
                    $instance = $this->service->setDefaultItemContent($instance);
                    $this->setData('message', __('Item saved'));
                }
            }

            $this->setData('uri', tao_helpers_Uri::encode($instance->uriResource));
            $this->setData('classUri', tao_helpers_Uri::encode($clazz->uriResource));
            $this->setData('formTitle', __('Edit item'));
            $this->setData('myForm', $myForm->render());
            $this->setView('form.tpl', true);
        }
        [...]
    }

2. Create a service definition accessible via the web
-----------------------------------------------------

You can use previously listed services of TAO or create your own and import it into TAO.

You may use the *createServiceDefinition()* method of the process authoring tool to create a service definition in the ontology.

-   The first parameter is the label of the service definition (here, *“myServiceDefinition”*).
-   The second is the URL to be called to access the service (here, *“http://www.myWebSite.com/myServiceScript.php”*).
-   The last is an array of *formal parameters* that will be created (if they do not exist yet) or set (if they already exist) for the service. The associative array follows the format *’parameter name’ =<br/>
> ’default value’*. The *parameter name* is the key to be used to retrieve the parameter value in the service (*<br/>
$_GET method*). The default value is either a constant or a process variable. The example below has two parameters (*param3* and *param4*) with default values set to constants (respectively *’myConstantValue’* and *null*). If you want to define the default value as a process variable like *param1* or *param2* below, add a *“\^”* before the code of your process variable, e.g. *<br/>
^myProcessVarCode2*, where *myProcessVarCode2* is the *code* of a process variable (say *“process variable 2”*). If the process variable with the code *myProcessVarCode2* exists, it will be set. If it does not exist yet, it will be created during the service definition creation. Alternatively, you can also directly give in the array a process variable resource like the *param1* below.

For more details about the way the complete URL of a service is built at runtime (including the parameters), please refer to Execution of a process\#From the activity definition to the screen display|the process execution section.


    $myProcessVar1 = null;
    $myProcessVar1 = $this->authoringService->getProcessVariable('myProcessVarCode1', true);

    $inputParameters = array(
        'param1' => $myProcessVar1,
        'param2' => '^myProcessVarCode2',
        'param3' => 'myConstantValue',
        'param4' => null
    );

    $serviceUrl = 'http://www.myWebSite.com/myServiceScript.php';
    $serviceDefinition = $authoringService->createServiceDefinition('myServiceDefinition', $serviceUrl, $inputParameters);

3. Create a service following the MVC php framework of TAO
----------------------------------------------------------

You may want to implement a service directly within your TAO file system, to take advantage of some available functionality:

-   direct access to your service in your local file system, to make your service independent from a remote service availability
-   direct access to the Generis API, to manage TAO resources
-   leverage the Models|MViews|VControllers|C php Framework|framework of TAO, as well as the services and helpers already built in TAO.

The short tutorial below shows how to create a basic service that embeds a URL in an iframe, in the taoDelivery extension.

To build a basic service, you need to create a controller in the actions folder of an extension, that extends *CommonModule*.<br/>

First create a new controller, called *taoDelivery_actions_WebService* (see: Guidelines\#Namespace|naming convention in TAO) in the actions directory of the taoDelivery extension: *yourWebRootPath/taoDeliveries/actions/class.WebService.php*


    class taoDelivery_actions_WebService extends tao_actions_CommonModule{
        public function __construct(){}
    }

Next, add a default *“index”* method, which will be the default action called for this controller:


    class taoDelivery_actions_WebService extends tao_actions_CommonModule{
        public function __construct(){}
        public function index(){
            $url = urldecode($this->getRequestParameter('url'));
            echo '';
        }
    }

_Note: you can directly reuse the method of the php framwork like *getRequestParameter()* to get a parameter from the *<br/>
$_REQUEST* global array, or use the *<br/>
$_POST* or *<br/>
$_GET* global arrays instead._

The current service is called by the url */taoDelivery/WebService/index* (URL rewriting engine on).<br/>

The *“url”* parameter for the service needs to be given via the *HTTP method GET*.

Such a service definition can be created in TAO with the same previously introduced method *createServiceDefinition()*:


    $serviceDefinition = $authoringService->createServiceDefinition(
        'a web service',
        '/taoDelivery/WebService/index',
        array(
            'url' => ''
        )
    );

You can add more parameters to make your service more customizable:


    public function index(){
        $width = $this->hasRequestParameter('width')?$this->getRequestParameter('width'):'100%';
        $height = $this->hasRequestParameter('height')?$this->getRequestParameter('height'):'100%';
        $url = urldecode($this->getRequestParameter('url'));
        echo '';
    }

The snippet to import your service definition becomes:


    $serviceDefinition = $authoringService->createServiceDefinition(
        'a web service',
        '/taoDelivery/WebService/index',
        array(
            'url' => '',
            'width' => '100%',
            'height' => '100%'
        )
    );

To build more complicated services to manage your ontology resources, you could follow the examples of the preloaded TAO services.


