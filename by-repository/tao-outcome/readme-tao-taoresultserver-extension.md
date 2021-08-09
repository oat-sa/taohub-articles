# Readme: TAO _taoResultServer_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-outcome.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-outcome.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-outcome.svg)

> Result Core Extension. Provides a results server management, exposes interfaces for results data submission

## Installation instructions{#installation-instructions}

These instructions assume that you have already a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.

If you installed your TAO instance through [package/tao](https://github.com/oat-sa/package-tao),
`oat-sa/extension-tao-outcome` is very likely already installed. You can verify this under _Settings -> Extension
manager_, where it would appear on the left hand side as `taoResultServer`. Alternatively you would find it in
the code at `/config/generis/installation.conf.php`.

_Note, that you have to be logged in as System Administrator to do this._

Add the extension to your TAO composer and to the autoloader:
```bash
composer require oat-sa/extension-tao-outcome
```

Install the extension on the CLI from the project root:

**Linux:**
```bash
sudo php tao/scripts/installExtension oat-sa/extension-tao-outcome
```

**Windows:**
```bash
php tao\scripts\installExtension oat-sa/extension-tao-outcome
```

As a system administrator you can also install it through the TAO Extension Manager:
- Settings (the gears on the right hand side of the menu) -> Extension manager
- Select _taoResultServer_ on the right hand side, check the box and hit _install_

## REST API{#rest-api}

[QTI Result REST API](https://openapi.taotesting.com/viewer/?url=https://raw.githubusercontent.com/oat-sa/extension-tao-outcome/master/doc/rest.json)

<!-- Uncomment and describe if applicable
## LTI Endpoints{#lti-endpoints}

-->

## Configuration options{#configuration-options}

## qtiResultsService.conf.php

*Description:* Returns the storage engine of the result server.

*Possible values:* 
* Objects of a class that implements the `QtiResultsService` interface.

### ResultAliasService.conf.php{#resultaliasserviceconfphp}

*Description:* Default implementation of service treats delivery execution id as result id and vice versa.

*Possible values:* 
* Objects of a class that implements the `ResultAliasService` interface.

### resultservice.conf.php{#resultserviceconfphp}

### Configuration option `result_storage`

*Description:* Gets tao results storage.

*Possible values:* 
* Objects of a class that implements the `ResultServerService` interface.

## Command to switch to file storage{#command-to-switch-to-file-storage}

```bash
php index.php '\oat\taoResultServer\scripts\install\InstallFileStorage'
``` 

## Extension Wiki{#extension-wiki}

You can find the [extension wiki here](https://github.com/oat-sa/extension-tao-outcome/wiki).