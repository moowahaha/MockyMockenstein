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
        $replaced_class_name = get_called_class();
        $class_name = get_class($mock);
        $class_name_parts = explode('\\', $class_name);
        $constructor_router_name = 'mockyMockensteinConstructor_' . array_pop($class_name_parts);

        runkit_function_add(
            $constructor_router_name,
            '$requested_class_name',
            "return \$requested_class_name == '$replaced_class_name' ? '$class_name' : \$requested_class_name;"
        );

        $stub = $mock->willReceive('__construct');

        set_new_overload($constructor_router_name);

        return $stub;
    }
}
