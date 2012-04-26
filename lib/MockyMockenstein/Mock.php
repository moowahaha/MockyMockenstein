<?php
namespace MockyMockenstein;

abstract class Mock {
    protected static $stubs = array();

    public static $mock_name;
    public static $test;

    public static function assertExpectationsAreMet() {
        foreach(self::$stubs as $stub) {
            $stub->assertExpectationsAreMet();
            $stub->destroy();
        }
    }

    protected static function addStub($stub) {
        Router::add($stub->mock_class_name, $stub);
        self::$stubs[$stub->method_name] = $stub;
        return $stub;
    }
}
