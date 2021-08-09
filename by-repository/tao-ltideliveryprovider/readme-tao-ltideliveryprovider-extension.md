# Readme: TAO _ltiDeliveryProvider_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-ltideliveryprovider.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-ltideliveryprovider.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-ltideliveryprovider.svg)

> The LTI Delivery extension allows test-takers to take a delivery (delivered test) via LTI

The endpoint for this service to proctor a specific delivery is:
`https://YOUR_DOMAIN/ltiDeliveryProvider/DeliveryTool/launch?delivery=YOUR_DELIVERY_URI`

or

`https://YOUR_DOMAIN/ltiDeliveryProvider/DeliveryTool/{"delivery":"YOUR_URI"}(base64 encoded)`

This link can retrieved using the LTI button in the deliveries section in the TAO admin user interface.


Alternatively a configurable link can be used by omitting the delivery parameter
`https://YOUR_DOMAIN/ltiDeliveryProvider/DeliveryTool/launch`

In this scenario the instructor would need to call the LTI service first, and will be presented with a list of deliveries.
Once he has chosen one of these deliveries it can no longer be changed. Test-takers subsequently clicking on the same link (as identified by Resource ID) will
start the delivery chosen by the instructor.

The expected roles are:
* `Learner` for people taking a test
* `Instructor` for people configuring a link

Custom parameters:
* `max_attempts` Overrides the number of executions allowed on the delivery. Expects a positive integer value or 0 for unlimited attempts. Attempts on LTI calls are calculated per `resource_link_id` instead of per delivery.

Return Values:
* `log message` will contain the status of the delivery execution
  * **100** for an active delivery
  * **101** for a paused delivery
  * **200** for a finished delivery
  * **201** for a terminated delivery

## Installation instructions

These instructions assume that you have already a TAO installation on your system. If you don't, go to
[package/tao](https://github.com/oat-sa/package-tao) and follow the installation instructions.

If you installed your TAO instance through [package/tao](https://github.com/oat-sa/package-tao),
`oat-sa/extension-tao-ltideliveryprovider` is very likely already installed. You can verify this under _Settings -> Extension
manager_, where it would appear on the left hand side as `ltiDeliveryProvider`. Alternatively you would find it in
the code at `/config/generis/installation.conf.php`.

_Note, that you have to be logged in as System Administrator to do this._

Add the extension to your TAO composer and to the autoloader:
```bash
composer require oat-sa/extension-tao-ltideliveryprovider
```

Install the extension on the CLI from the project root:

**Linux:**
```bash
sudo php tao/scripts/installExtension oat-sa/extension-tao-ltideliveryprovider
```

**Windows:**
```bash
php tao\scripts\installExtension oat-sa/extension-tao-ltideliveryprovider
```

As a system administrator you also install it through the TAO Extension Manager:
- Settings (the gears on the right hand side of the menu) -> Extension manager
- Select _ltiDeliveryProvider_ on the right hand side, check the box and hit _install_

## REST API

[LTI delivery service REST API](https://openapi.taotesting.com/viewer/?url=https://raw.githubusercontent.com/oat-sa/extension-tao-ltideliveryprovider/master/doc/rest.json)

<!-- Uncomment and describe if applicable
## LTI Endpoints

-->

## Configuration options

## LaunchQueue.conf.php

#### Configuration option `relaunchInterval`

*Description:* specifies time (in seconds) for a test taker to wait before the page is reloaded when waiting in LTI queue

*Possible values:*
* Any numerical value (> 0)

#### Configuration option `relaunchIntervalDeviation`

*Description:* specifies time (in seconds) to pick a random amount of seconds between 0 and `relaunchIntervalDeviation`, then the random result is randomly added to or subtracted from relaunchInterval for each time the queue page is being reloaded. 
The goal of this option is to prevent knocking the backend simultaneously by multiple clients. 

*Possible values:*
* Any numerical value between 0 and `relaunchInterval`

### LtiDeliveryExecution.conf.php

### Configuration option `queue_persistence`

*Description:* a persistence that LTI delivery execution service should work based on. Should be a persistence name that's registered in `generis/persistences.conf.php`

*Value example:* 
* `default`
* `cache`

### LtiNavigation.conf.php

### Configuration option `thankyouScreen`

*Description:* whether the 'thank you' screen should be shown once a test is passed through LTI.
 It only takes effect if the `custom_skip_thankyou` LTI parameter is omitted. Otherwise, it's only depends on the LTI parameter.

*Possible values:* 
* `true`
* `false`

#### Configuration option `delivery_return_status`

*Description:* if enabled, the `deliveryExecutionStatus` return parameter will be included in a consumer return URL.
This parameter will always be set to a delivery execution state label.

*Possible values:* 
* `true`: include the parameter in consumer return URLs
* `false`: omit the parameter

#### Configuration option `message`

*Description:* a factory for producing LTI messages

*Possible values:* 
* an instance of any class that has the `getLtiMessage` method

*Value example:* 
* `new oat\ltiDeliveryProvider\model\navigation\DefaultMessageFactory()`

### LtiResultIdStorage.conf.php

### Configuration option `persistence`
*Description:* a persistence that LTI result aliases should be stored in. Should be a persistence name that's registered in `generis/persistences.conf.php`

*Value example:* 
* `default`
* `cache`

## Extension Wiki

You can find the [extension wiki here](https://github.com/oat-sa/extension-tao-ltideliveryprovider/wiki).