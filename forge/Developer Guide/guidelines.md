<!--
parent: 'Developer Guide'
created_at: '2011-02-08 10:41:00'
updated_at: '2015-07-02 10:13:41'
authors:
    - 'Konstantin Sasim'
tags:
    - 'Developer Guide'
-->



Guidelines
==========

1. Coding Standards
-------------------

When contributing to TAO you must follow its coding standards.

TAO decided to follow standards defined in [PSR-1](http://www.php-fig.org/psr/psr-1/) [PSR-2](http://www.php-fig.org/psr/psr-2/) and we start to update our autoload strategy to fit [PSR-4](http://www.php-fig.org/psr/psr-4/). New contributions may fulfill those requirements.

2. Unit Testing
---------------

In order to try and improve code Quality for TAO we are using [PHP Unit](http://phpunit.de)

h3 Installation and usage

[PHPUnit installation Guide and manual](http://phpunit.de/manual/current/en/installation.html)

Class to extends to build your own test case GenerisPhpUnitTestRunner or [TaoPhpUnitTestRunner](../guidelines/taophpunittestrunner.md) depending where you are

A global testsuite is available in the root to launch all tests.

### Goals

-   Test all classes
-   Test Isolated methods
-   Avoid Non-regression, improve refactoring
-   Run TestSuites very often
-   Mostly Test logical part of the application

### Principles

-   One Class, one TestCase
-   Test all non-trivial methods
-   Build separate TestSuite for different parts of the application.


