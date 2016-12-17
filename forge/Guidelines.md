---
tags: Forge
---

{{\>toc}}

Guidelines
==========

1. Coding Standards
-------------------

When contributing to TAO you must follow its coding standards.

TAO decided to follow standards defined in [PSR-1](resources/http://www.php-fig.org/psr/psr-1/) [PSR-2](resources/http://www.php-fig.org/psr/psr-2/) and we start to update our autoload strategy to fit [PSR-4](resources/http://www.php-fig.org/psr/psr-4/). New contributions may fullfill those requirements.

2. Unit Testing
---------------

In order to try and improve code Quality for TAO we are using [PHP Unit](resources/http://phpunit.de)

h3 Installation and usage

[PHPUnit installation Guide and manual](resources/http://phpunit.de/manual/current/en/installation.html)

Class to extends to build your own test case [[GenerisPhpUnitTestRunner]] or [[TaoPhpUnitTestRunner]] depending where you are

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

