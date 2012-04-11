<?php

error_reporting(E_ALL | E_STRICT);
set_include_path(get_include_path() . PATH_SEPARATOR . './lib/');

require_once 'MockyMockenstein/Loader.php';
require_once 'MockyMockenstein/TestCase.php';

$loader = new \MockyMockenstein\Loader;
$loader->register();

