# Readme: TAO _taoOutcomeUi_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-outcomeui.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-outcomeui.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-outcomeui.svg)

> Extension implements resultServer interface to store results using ontology/statements table

## Installation instructions

These instructions assume that you have already a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.

If you installed your TAO instance through [package/tao](https://github.com/oat-sa/package-tao),
`oat-sa/extension-tao-outcomeui` is very likely already installed. You can verify this under _Settings -> Extension
manager_, where it would appear on the left hand side as `taoOutcomeUi`. Alternatively you would find it in
the code at `/config/generis/installation.conf.php`.

_Note, that you have to be logged in as System Administrator to do this._

Add the extension to your TAO composer and to the autoloader:
```bash
composer require oat-sa/extension-tao-outcomeui
```

Install the extension on the CLI from the project root:

**Linux:**
```bash
sudo php tao/scripts/installExtension oat-sa/extension-tao-outcomeui
```

**Windows:**
```bash
php tao\scripts\installExtension oat-sa/extension-tao-outcomeui
```

As a system administrator you also install it through the TAO Extension Manager:
- Settings (the gears on the right hand side of the menu) -> Extension manager
- Select _taoOutcomeUi_ on the right hand side, check the box and hit _install_

<!-- Uncomment and describe if applicable
## REST API

[](https://openapi.taotesting.com/viewer/?url=https://raw.githubusercontent.com/oat-sa/extension-tao-outcomeui/master/doc/rest.json)
-->

<!-- Uncomment and describe if applicable
## LTI Endpoints

-->

## Configuration options

## resultService.conf.php

#### Configuration option `class`

*Description :* contains the class name of a delivery results service.

*Possible values of the `class` key:* 
* an instance of any class that implements the `ServiceLocatorAwareInterface` interface.

#### Configuration option `resultColumnsChunkSize`

*Description :* contains a chunk size value.

*Possible values of the `resultColumnsChunkSize` key:* 
* a preset integer value of `20`

### resultViewer.conf.php

### Configuration option `deleteDeliveryExecutionDataServices`

*Description:* an instance of any class that implements the `ServiceLocatorAwareInterface` interface.

*Possible values:* 
* a `ResultsViewerService` model.

### Registering default (phpfile) result page cache

```bash
 $ sudo -u www-data php index.php '\oat\taoOutcomeUi\scripts\tools\RegisterDefaultResultCache'
```

### Delete result cache for a delivery execution aka. result

```bash
 $ sudo -u www-data php index.php 'oat\taoOutcomeUi\scripts\tools\DeleteResultCache' -u {deliveryExecutionUri}
```

## Extension Wiki

You can find the [extension wiki here](https://github.com/oat-sa/extension-tao-outcomeui/wiki).