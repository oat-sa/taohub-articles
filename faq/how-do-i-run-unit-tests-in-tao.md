<!--
authors: [Patrick Plichart]
created_at: 2016-03-03
-->

#How do I run unit tests in TAO ? I have trouble with classes not found when running them

Unit tests are managed with [phpunit](https://phpunit.de/)

You need to launch the unit tests from the root folder of TAO, for example: 

`sudo -u www-data phpunit taoTestTaker/test/TestTakerTest`