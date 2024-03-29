# Logger

Tao platform logger is set in config `generis/log.conf.php`. It accepts a Psr3 logger interface.

To make life easier a wrapper exists to send log through monolog.

### 1°) Propagation

The logger is passed to object in platform bootstrapping. It means that `ConfigurableService`, `Action` and Controller using LoggerAwareInterface will receive the logger.
It can be accessed also via ServiceManager with key `generis/log`

### 2°) Log Level

To implements different strategy, developers must use logger following log level  described by [RFC 5424](http://tools.ietf.org/html/rfc5424).
                                                                                 
     - **DEBUG** (100): Detailed debug information.
     
     - **INFO** (200): Interesting events. Examples: User logs in, SQL logs.
     
     - **NOTICE** (250): Normal but significant events.
     
     - **WARNING** (300): Exceptional occurrences that are not errors. Examples:
       Use of deprecated APIs, poor use of an API, undesirable things that are not
       necessarily wrong.
     
     - **ERROR** (400): Runtime errors that do not require immediate action but
       should typically be logged and monitored.
     
     - **CRITICAL** (500): Critical conditions. Example: Application component
       unavailable, unexpected exception.
     
     - **ALERT** (550): Action must be taken immediately. Example: Entire website
       down, database unavailable, etc. This should trigger the SMS alerts and wake
       you up.
     
     - **EMERGENCY** (600): Emergency: system is unusable.
     
The `LoggerAwareTrait` provides wrapper methods, see \Psr\Log\LoggerTrait

### 3°) Tao Monolog

To send log to monolog a wrapper exists: `TaoMonolog`. It is a configurable service in charge to build the monolog logger from a config.<br/>
All monolog handlers can be loaded through taoMonolog. An handler is an array with `class` to construct and `options` as constructor arguments.

Example of generis/log config: 
```php
return new oat\oatbox\log\LoggerService(array(
       'logger' => array(
           'class' => 'oat\\oatbox\\log\\logger\\TaoMonolog',
           'options' => array(
               'name' => 'tao',
               'handlers' => array(
                   array(
                       'class' => 'Monolog\\Handler\\StreamHandler',
                       'options' => array(
                           '/var/www/tao/package-tao/test-log.log',
                           100
                       )
                   ),
               )
           )
       )
   ));
```
To have a better view of monolog possibility, please check:
* generis/config/header/log.conf.php
* https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md

### 4°) Backward compatibility

To ensure backward compatibility `common_Logger` wrap all cal to logger service. 
`common_Logger` is now deprecated.

To keep logger backward compatibility a `TaoLog` logger can use old parameter format:
```php
return new oat\oatbox\log\LoggerService(array(
    'logger' => array(
        'class' => 'oat\\oatbox\\log\\logger\\TaoLog',
        'options' => array(
            'appenders' => array(
                //Example of a UDP Appender
                array(
                    'class' => 'UDPAppender',
                    'host' => '127.0.0.1',
                    'port' => 5775,
                    'threshold' => 1,
                    'prefix' => 'tao'
                ),
            )
        )
    ))
));
```

### 5°) Using setup.json

To use TaoMonolog:
```json
{
  "generis": {
    "log" : {
      "type": "configurableService",
      "class":"oat\\oatbox\\log\\LoggerService",
      "options": {
        "logger": {
		  "class": "oat\\oatbox\\log\\logger\\TaoMonolog",
		  "options": {
			"name": "tao",
			"handlers": [
			  {
			    "class": "Monolog\\Handler\\StreamHandler",
				"options": [
                    "/var/www/tao/package-tao/test-log.log",
                    100
				]
			  },
			  {
				"class": "Monolog\\Handler\\BrowserConsoleHandler",
				"options": [
					200
				]
			  },
			  {
				"class": "Monolog\\Handler\\SlackWebhookHandler",
				"options": [
                    "https://hooks.slack.com/services/XXXXXX/XXXXXX/XXXXXX",
                    "#test",
                    "tao-bot"
                ]
              },
              {
                "class": "Monolog\\Handler\\SyslogUdpHandler",
                "options": [
                    "127.0.0.1",
                    "5775"
                ],
                "processors": [
                    {
                      "class": "oat\\oatbox\\log\\logger\\processor\\BacktraceProcessor",
                      "options": [
                        300
                      ]
                    },
                    {
                      "class": "Monolog\\Processor\\MemoryUsageProcessor"
                    },
                    {
                       "class": "Monolog\\Processor\\MemoryPeakUsageProcessor"
                    }
                ]
              }
            ],
            "processors": [
                {
                    "class": "Monolog\\Processor\\PsrLogMessageProcessor"
                },
                {
                    "class": "Monolog\\Processor\\UidProcessor",
                    "options": [
                      24
                    ]
                }
            ]
        }
    }
}
                  
```

### 6°) Fluentd Logger

To use Fluentd as log handler combined with trace and environment processors and TAO JSON formatter.

```php
<?php

return new oat\oatbox\log\LoggerService(array(
    'logger' => array(
        'class' => 'oat\\oatbox\\log\\logger\\TaoMonolog',
        'options' => array(
            'name' => 'tao',
            'handlers' => array(
                array(
                    'class' => \oat\oatbox\log\logger\handler\FluentdHandler::class,
                    'options' => [
                        new \Fluent\Logger\FluentLogger(
                            \Fluent\Logger\FluentLogger::DEFAULT_ADDRESS,
                            \Fluent\Logger\FluentLogger::DEFAULT_LISTEN_PORT
                        )
                    ],
                    'processors' => array(
                        array(
                            'class' => \oat\oatbox\log\logger\processor\EnvironmentProcessor::class,
                            'options' => array(
                                100, // Monolog level e.q. debug
                            )
                        ),
                        array(
                            'class' => \oat\oatbox\log\logger\processor\BacktraceProcessor::class,
                            'options' => array(
                                300, // Monolog level e.q. error
                                true,
                            )
                        )
                    ),
                    'formatter' => array(
                        'class' => \oat\oatbox\log\logger\formatter\TaoJsonLogFormatter::class,
                    ),
                ),
            ),
        )
    )
));
```

To use the old format:
```json
{
  "log": {
    "type": "configurableService",
    "class":"oat\\oatbox\\log\\LoggerService",
    "options": {
      "logger": {
        "class": "oat\\oatbox\\log\\logger\\TaoLog",
        "options": {
            "appenders": [
                {
                   "class": "UDPAppender",
                   "host": "127.0.0.1",
                   "port": 5775,
                   "threshold": 1,
                   "prefix": "offline"
                }
            ]
        }
      }
    }
  }
}
```