MockyMockenstein
==================

Another PHP mocking framework. Doesn't do much. Not yet finished.

Prerequisites
---------------

* Install runkit:
    * `sudo pecl install http://github.com/downloads/zenovich/runkit/runkit-1.0.3.tgz`
    * Add `extension=runkit.so` to you /etc/php.ini
* Install php-test-helpers:
    * `pear channel-discover pear.phpunit.de`
    * `pecl install phpunit/test_helpers`
    * Add

Installation
------------

`pear channel-discover moowahaha.github.com/pear`
`pear install moowahaha/MockyMockenstein`

Running the Tests
-----------------

`phpunit tests/`

