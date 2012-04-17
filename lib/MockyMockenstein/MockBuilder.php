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
        return new $class_name($mock_name, $this->test);
    }

    public function buildClass($mock_name) {
        $class_name = $this->generateClass($mock_name, 'StaticMock');
        $class_name::$test = $this->test;
        $class_name::$mock_name = $mock_name;

        return $class_name;
    }

    private function generateClass($mock_name, $base_class) {
        $class_name = 'MockyMockensteinMock_' . self::$mock_count;
        eval("namespace MockyMockenstein;\nclass $class_name extends $base_class {}");
        self::$mock_count++;
        return '\MockyMockenstein\\' . $class_name;
    }
}

