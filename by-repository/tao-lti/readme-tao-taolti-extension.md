# Readme: TAO _taoLti_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-lti.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-lti.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-lti.svg)

> Extension to manage LTI services for TAO

## Installation instructions{#installation-instructions}

These instructions assume that you have already a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.

If you installed your TAO instance through [package/tao](https://github.com/oat-sa/package-tao),
`oat-sa/extension-tao-lti` is very likely already installed. You can verify this under _Settings -> Extension
manager_, where it would appear on the left hand side as `taoLti`. Alternatively you would find it in
the code at `/config/generis/installation.conf.php`.

_Note, that you have to be logged in as System Administrator to do this._

Add the extension to your TAO composer and to the autoloader:
```bash
composer require oat-sa/extension-tao-lti
```

Install the extension on the CLI from the project root:

**Linux:**
```bash
sudo php tao/scripts/installExtension oat-sa/extension-tao-lti
```

**Windows:**
```bash
php tao\scripts\installExtension oat-sa/extension-tao-lti
```

As a system administrator you can also install it through the TAO Extension Manager:
- Settings (the gears on the right hand side of the menu) -> Extension manager
- Select _taoLti_ on the right hand side, check the box and hit _install_

## REST API{#rest-api}

[Lti REST API](https://openapi.taotesting.com/viewer/?url=https://raw.githubusercontent.com/oat-sa/extension-tao-lti/master/doc/rest.json)

<!-- Uncomment and describe if applicable
## LTI Endpoints{#lti-endpoints}

-->

## Configuration options{#configuration-options}

## auth.conf.php

#### Configuration option `config`{#configuration-option-config}

*Description:* this specifies a single option as the `adapter` key of the array. This adapter is to be used to authenticate LTI requests and is retrieved in [FactoryLtiAuthAdapterService](taoLti/models/classes/FactoryLtiAuthAdapterService.php).

*Possible values of the `adapter` key:* 
* an instance of any class that implements the `common_user_auth_Adapter` interface

*Value examples:* 
* `['config' => ['adapter' => 'oat\\taoLti\\models\\classes\\LtiAuthAdapter']]`


### CookieVerifyService.conf.php{#cookieverifyserviceconfphp}

### Configuration option `verify_cookie`

*Description:* This option determine whether to check if the 'session' request parameter matches the internal PHP session ID before launching an LTI tool

*Possible values:* 
* `true`: enable the session check. 2 more HTTP redirects are needed
* `false`: disable the session check

### LtiUserService.conf.php{#ltiuserserviceconfphp}

### Configuration option `factoryLtiUser`

*Description:* factory for producing LTI users

*Possible values:* 
* an instance of any class that implements the `oat\taoLti\models\classes\user\LtiUserFactoryInterface` interface

#### Configuration option `transaction-safe` (only for `OntologyLtiUserService` implementation){#configuration-option-transaction-safe-only-for-ontologyltiuserservice-implementation}

*Description:* not used

#### Configuration option `transaction-safe-retry` (only for `OntologyLtiUserService` implementation){#configuration-option-transaction-safe-retry-only-for-ontologyltiuserservice-implementation}

*Description:* not used

#### Configuration option `lti_ku_` (only for `KvLtiUserService` implementation){#configuration-option-lti-ku-only-for-kvltiuserservice-implementation}

*Description:* a prefix for storing `taoId` => `ltiId` relation in the key-value storage to look up LTI users

*Possible values:* 
* any unique string

#### Configuration option `lti_ku_lkp_` (only for `KvLtiUserService` implementation){#configuration-option-lti-ku-lkp-only-for-kvltiuserservice-implementation}

*Description:* a prefix for storing `ltiId` => `taoId` relation in the key-value storage to execute reverse lookup

*Possible values:* 
* any unique string

### LtiValidatorService.conf.php{#ltivalidatorserviceconfphp}

### Configuration option `launchDataValidator`

*Description:* specifies a list of validators to be used for validating LTI launch data

*Possible values:* 
* a list of instances of any classes that implement the `LtiValidatorInterface` interface. Validators should throw `LtiException` in case of not valid data, return values are not considered

*Value examples:* 
* `[ new oat\taoLti\models\classes\LaunchData\Validator\Lti11LaunchDataValidator() ]`

## Extension Wiki{#extension-wiki}

You can find the [extension wiki here](https://github.com/oat-sa/extension-tao-lti/wiki).