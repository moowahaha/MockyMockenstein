# MockyMockenstein

Another PHP mocking framework. Doesn't do much. Not yet finished.

## Prerequisites

* Install runkit:
    * `sudo pecl install http://github.com/downloads/zenovich/runkit/runkit-1.0.3.tgz`
    * Add `extension=runkit.so` to you /etc/php.ini
* Install php-test-helpers:
    * `pear channel-discover pear.phpunit.de`
    * `pecl install phpunit/test_helpers`
    * Add `zend_extension=test-helpers.so` to your /etc/php.ini. If you are using Xdebug, make sure this line goes after xdebug.so is loaded.

## Installation

Grab my channel:
`pear channel-discover moowahaha.github.com/pear`

Install:
`pear install moowahaha/MockyMockenstein`

## Usage...

Further info can be found on the [wiki](https://github.com/moowahaha/MockyMockenstein/wiki).

### Setting up your test...

Your test should inherit from MockyMockenstein_TestCase, rather than the usual

## Running the Tests (development)

`phpunit tests/`

