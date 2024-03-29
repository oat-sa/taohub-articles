# Readme: TAO _taoOutcomeRds_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-outcomerds.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-outcomerds.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-outcomerds.svg)

> Extension that allows a storage in relational database

## Installation instructions

These instructions assume that you have already a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.

If you installed your TAO instance through [package/tao](https://github.com/oat-sa/package-tao),
`oat-sa/extension-tao-outcomerds` is very likely already installed. You can verify this under _Settings -> Extension
manager_, where it would appear on the left hand side as `taoOutcomeRds`. Alternatively you would find it in
the code at `/config/generis/installation.conf.php`.

_Note, that you have to be logged in as System Administrator to do this._

Add the extension to your TAO composer and to the autoloader:
```bash
composer require oat-sa/extension-tao-outcomerds
```

Install the extension on the CLI from the project root:

**Linux:**
```bash
sudo php tao/scripts/installExtension oat-sa/extension-tao-outcomerds
```

**Windows:**
```bash
php tao\scripts\installExtension oat-sa/extension-tao-outcomerds
```

As a system administrator you also install it through the TAO Extension Manager:
- Settings (the gears on the right hand side of the menu) -> Extension manager
- Select _taoOutcomeRds_ on the right hand side, check the box and hit _install_

<!-- Uncomment and describe if applicable
## REST API

[](https://openapi.taotesting.com/viewer/?url=https://raw.githubusercontent.com/oat-sa/extension-tao-outcomerds/master/doc/rest.json)
-->

<!-- Uncomment and describe if applicable
## LTI Endpoints

-->

## Configuration options

## RdsResultStorage.conf.php

#### Configuration option `persistence`

*Description :* contains a persistence value of the RDS result storage .

*Possible values of the `persistence` key:* 
* a string value which equals to `default`.

## Extension Wiki

You can find the [extension wiki here](https://github.com/oat-sa/extension-tao-outcomerds/wiki).