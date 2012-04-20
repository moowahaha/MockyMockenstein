<?php
namespace MockyMockenstein;

abstract class StaticMock extends Mock {
    public static function willReceive($method_name) {
        $stub = new StaticStub(array(
            'mock_name' => self::$mock_name,
            'mock_class_name' => get_called_class(),
            'test' => self::$test,
            'method_name' => $method_name
        ));

        return self::addStub($stub);
    }

    public static function willInstantiate($mock) {
        Router::addConstructorOverride(get_called_class(), $mock);
        $stub = $mock->willReceive('__construct');
        return $stub;
    }
}
