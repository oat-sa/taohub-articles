# Frontend logger

> This article explains how to configure frontend log

`core/logger` library is responsible for logging events on client side:
https://github.com/oat-sa/tao-core/blob/master/views/js/core/logger.js

`core/logger` must be configured with logger providers and log levels for each of them.

Default provider is `core/logger/console` (https://github.com/oat-sa/tao-core/blob/master/views/js/core/logger/console.js).
Obviously this provides sends log messages to the browser's console.

`core/logger/http` (https://github.com/oat-sa/tao-core/blob/master/views/js/core/logger/http.js) provider is used to send log messages to the server via http call and store it in the Tao log. Do not configure this provider with low log level because it may cause a lot of http requests. By default messages will be sent to `/tao/Log/log` controller and logged with `frontend` tag.

Logged message example:
```
2018-05-17 06:36:33 [ERROR] [frontend] '{"level":"error","v":0,"time":"2018-05-17T06:36:32.467Z","msg":"Caught[via window.onerror]: 'Uncaught Error: Example error message sent from frontend' from http:\/\/package-tao\/taoAct\/views\/js\/controller\/TransmissionMonitoring\/index.js?buster=3.3.0-sprint76:41:11","err":[],"name":"core\/logger","pid":1,"hostname":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/66.0.3359.181 Safari\/537.36"}' D:\domains\package-tao\generis\common\class.Logger.php 200
```

Configuration example:
`tao/client_lib_config_registry.conf.php`:
```
<?php
return new oat\oatbox\config\ConfigurationService(array(
    'config' => array(
        //...
        'core/logger' => array(
            'level' => 'warn',
            'loggers' => array(
                'core/logger/console' => array(
                    'level' => 'warn'
                ),
                'core/logger/http' => array(
                    'level' => 'error'
                ),
            )
        ),
        //...
    )
));
```