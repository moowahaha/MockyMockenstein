<?php
namespace MockyMockenstein;

class MockBuilder {
    private static $mock_count = 0;

    private $test;

    public function __construct($test) {
        $this->test = $test;
    }

    public function buildInstance($mock_name) {
        return $this->generateClass($mock_name, 'Replacement_Mock_Instance');
    }

    public function buildStatic($mock_name) {
        return $this->generateClass($mock_name, 'Replacement_Mock_Static');
    }

    private function generateClass($mock_name, $base_class) {
        $class_name = 'Mock_' . self::$mock_count;
        self::$mock_count++;

        eval("namespace MockyMockenstein;\nclass $class_name extends $base_class {}");

        $namespaced_class_name = '\MockyMockenstein\\' . $class_name;
        $mock = new $namespaced_class_name();

        $mock->class_name = $namespaced_class_name;
        $mock->name = $mock_name;
        $mock->test = $this->test;

        return $mock;
    }
}

