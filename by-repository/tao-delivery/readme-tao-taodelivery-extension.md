# Readme: TAO _taoDelivery_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-delivery.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-delivery.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-delivery.svg)

> Extension to manage deliveries

## Installation instructions{#installation-instructions}

These instructions assume that you have already a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.

If you installed your TAO instance through [package/tao](https://github.com/oat-sa/package-tao),
`oat-sa/extension-tao-delivery` is very likely already installed. You can verify this under _Settings -> Extension
manager_, where it would appear on the left hand side as `taoDelivery`. Alternatively you would find it in
the code at `/config/generis/installation.conf.php`.

_Note, that you have to be logged in as System Administrator to do this._

Add the extension to your TAO composer and to the autoloader:
```bash
composer require oat-sa/extension-tao-delivery
```

Install the extension on the CLI from the project root:

**Linux:**
```bash
sudo php tao/scripts/installExtension oat-sa/extension-tao-delivery
```

**Windows:**
```bash
php tao\scripts\installExtension oat-sa/extension-tao-delivery
```

As a system administrator you also install it through the TAO Extension Manager:
- Settings (the gears on the right hand side of the menu) -> Extension manager
- Select _taoDelivery_ on the right hand side, check the box and hit _install_

## REST API{#rest-api}

[Open API Specification](https://openapi.taotesting.com/viewer/?url=https://raw.githubusercontent.com/oat-sa/extension-tao-delivery/master/doc/rest.json)

<!-- Uncomment and describe if applicable
## LTI Endpoints{#lti-endpoints}

-->

## Configuration options{#configuration-options}

## AttemptService.conf.php

#### Configuration option `states_to_exclude`{#configuration-option-states-to-exclude}

*Description :* when retrieving attempts (executions), those attempts with specified states won't be retrieved

*Possible states :* 
* `http://www.tao.lu/Ontologies/TAODelivery.rdf#DeliveryExecutionStatusActive`: active state
* `http://www.tao.lu/Ontologies/TAODelivery.rdf#DeliveryExecutionStatusPaused`: paused state
* `http://www.tao.lu/Ontologies/TAODelivery.rdf#DeliveryExecutionStatusFinished`: finished state
* `http://www.tao.lu/Ontologies/TAODelivery.rdf#DeliveryExecutionStatusTerminated`: terminated state

One can specify multiple states as an array to exclude.

### authorization.conf.php{#authorizationconfphp}

### Configuration option `providers`

*Description :* when verifying that a given delivery execution is allowed to be executed, the specified providers are used. For an execution to be rejected, at least one provider should throw an exception, return values are not considered 

*Possible values:* 
* Objects of a class that implements the `AuthorizationProvider` interface

*Value examples :* 
* `[ new oat\taoDelivery\model\authorization\strategy\StateValidation() ]`
* `[ new oat\taoDelivery\model\authorization\strategy\StateValidation(), oat\taoDelivery\model\authorization\strategy\AuthorizationAggregator() ]`


### DeliveryExecutionDelete.conf.php{#deliveryexecutiondeleteconfphp}

### Configuration option `deleteDeliveryExecutionDataServices`

*Description:* the list of services to remove a delivery execution

*Possible values:* 
* Objects of a class that implements the `DeliveryExecutionDelete` interface.


### deliveryFields.conf.php{#deliveryfieldsconfphp}

### Configuration option `http://www.tao.lu/Ontologies/TAODelivery.rdf#CustomLabel`

*Description:* the use roles able to see delivery custom labels

*Possible values:* 
* Any TAO roles

*Value examples:* 
* `[ 'http://www.tao.lu/Ontologies/TAO.rdf#DeliveryRole' ]`

### returnUrl.conf.php{#returnurlconfphp}

### Configuration option `extension`

*Description:* an extension name for composing a return URL

*Possible values:* 
* Any TAO extension name

*Value examples:* 
* `taoDelivery`

#### Configuration option `controller`{#configuration-option-controller}

*Description:* a controller (module) name for composing a return URL

*Possible values:* 
* Any controller within the extension above

*Value examples:* 
* `Main`

#### Configuration option `method`{#configuration-option-method}

*Description:* a method (action) for composing a return URL

*Possible values:* 
* any public method within the controller above

*Value examples:* 
* `index`

## Extension Wiki{#extension-wiki}

You can find the [extension wiki here](https://github.com/oat-sa/extension-tao-delivery/wiki).