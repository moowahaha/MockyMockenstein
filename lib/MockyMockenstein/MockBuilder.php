<?php
namespace MockyMockenstein;

class MockBuilder {
    private static $mock_count = 0;

    private $test;

    public function __construct($test) {
        $this->test = $test;
    }

    public function buildInstance($mock_name) {
        $class_name = $this->generateClass($mock_name, 'InstanceMock');
        $mock = new $class_name();

        return $mock;
    }

    public function buildClass($mock_name) {
        $class_name = $this->generateClass($mock_name, 'StaticMock');

        return $class_name;
    }

    private function generateClass($mock_name, $base_class) {
        $class_name = 'MockyMockensteinMock_' . self::$mock_count;
        self::$mock_count++;

        eval("namespace MockyMockenstein;\nclass $class_name extends $base_class {}");

        $namespaced_class_name = '\MockyMockenstein\\' . $class_name;
        $namespaced_class_name::$test = $this->test;
        $namespaced_class_name::$mock_name = $mock_name;

        return $namespaced_class_name;
    }
}

