# Readme: Extension ltiTestReview

Extension for reviewing passed tests, with the display of actual and correct answers, as well as the number of points for each answer.

### Usage

Run `composer require "oat-sa/extension-lti-test-review"` for including the code to the project and install extension using extension manager or with CLI `php tao/scripts/installExtension.php ltiTestReview`. 

### LTI calls

To run review of specific delivery execution use the next endpoint:
```
https://YOUR_DOMAIN/ltiTestReview/ReviewTool/launch?execution=YOUR_DELIVERY_EXECUTION_URI
```

Endpoint without `execution` parameter (`https://YOUR_DOMAIN/ltiTestReview/ReviewTool/launch`) will use `lis_result_sourcedid` field from lauch data to determine delivery execution.

### LTI options

Various modes are available to review a test. By default the simplest mode is applied, showing only the test as it was passed, with the student's responses and no score.

The following custom parameters controls the mode:

| parameter               | description |
|-------------------------|-------------|
| `custom_show_score=1`   | Show the student's score. |
| `custom_show_correct=1` | Show the correct responses when the student has failed. **Note:** This option discloses all the correct responses, for the whole test. |

When you use the [IMS emulator](http://ltiapps.net/test/tc.php) you must remove the prefix `custom_`.

#### Default values

By default the options `show_score` and `show_correct` are turned off. To turn them on by default you may change the platform configuration, in the file `config/ltiTestReview/DeliveryExecutionFinderService.conf.php`:
```php
return new oat\ltiTestReview\models\DeliveryExecutionFinderService([
    'show_score' => false,
    'show_correct' => false
]);
```
**Note:** This will set the default value of these options for the whole platform. If you enable them by default, you can still disable them using LTI custom parameters.