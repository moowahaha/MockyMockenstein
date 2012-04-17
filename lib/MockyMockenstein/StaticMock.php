<?php
namespace MockyMockenstein;

abstract class StaticMock {
    private static $stubs = array();

    public static $mock_name;
    public static $test;

    public static function assertExpectationsAreMet() {
        foreach(self::$stubs as $stub) {
            $stub->assertExpectationsAreMet();
        }
    }

    public static function willReceive($method_name) {
        $stub = $method_name == 'new' ? self::replaceConstructor() : self::addMethod($method_name);
        return self::addStub($stub);
    }

    private static function replaceConstructor() {
        $class_name = get_called_class();
        $class_name_parts = explode('\\', $class_name);
        $constructor_router_name = 'mockyMockensteinConstructor_' . array_pop($class_name_parts);

        runkit_function_add(
            $constructor_router_name,
            '',
            "return '$class_name';"
        );

        $stub = new InstanceStub(array(
            'mock_name' => self::$mock_name,
            'mock_class_name' => $class_name,
            'test' => self::$test,
            'method_name' => '__construct'
        ));

        set_new_overload($constructor_router_name);

        return $stub;
    }

    private static function addMethod($method_name) {
        $stub = new StaticStub(array(
            'mock_name' => self::$mock_name,
            'mock_class_name' => get_called_class(),
            'test' => self::$test,
            'method_name' => $method_name
        ));
        return $stub;
    }

    private static function addStub($stub) {
        Router::add(get_called_class(), $stub);
        self::$stubs[$stub->method_name] = $stub;
        return $stub;
    }
}
