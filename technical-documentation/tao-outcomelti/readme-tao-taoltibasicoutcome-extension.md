# Readme: TAO _taoLtiBasicOutcome_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-outcomelti.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-outcomelti.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-outcomelti.svg)

> Extension implements the LTI basic outcome engine for LTI Result Server

## Installation instructions

These instructions assume that you have already a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.

If you installed your TAO instance through [package/tao](https://github.com/oat-sa/package-tao),
`oat-sa/extension-tao-outcomelti` is very likely already installed. You can verify this under _Settings -> Extension
manager_, where it would appear on the left hand side as `taoLtiBasicOutcome`. Alternatively you would find it in
the code at `/config/generis/installation.conf.php`.

_Note, that you have to be logged in as System Administrator to do this._

Add the extension to your TAO composer and to the autoloader:
```bash
composer require oat-sa/extension-tao-outcomelti
```

Install the extension on the CLI from the project root:

**Linux:**
```bash
sudo php tao/scripts/installExtension oat-sa/extension-tao-outcomelti
```

**Windows:**
```bash
php tao\scripts\installExtension oat-sa/extension-tao-outcomelti
```

As a system administrator you also install it through the TAO Extension Manager:
- Settings (the gears on the right hand side of the menu) -> Extension manager
- Select _taoLtiBasicOutcome_ on the right hand side, check the box and hit _install_

<!-- Uncomment and describe if applicable
## REST API

[](https://openapi.taotesting.com/viewer/?url=https://raw.githubusercontent.com/oat-sa/extension-tao-outcomelti/master/doc/rest.json)
-->

<!-- Uncomment and describe if applicable
## LTI Endpoints

-->

<!-- Uncomment and describe if applicable
## Configuration options

## *.conf.php

#### Configuration option `*`

*Description :* some text.

*Possible values of the `*` key:* 
* some text.
-->

## Extension Wiki

You can find the [extension wiki here](https://github.com/oat-sa/extension-tao-outcomelti/wiki).