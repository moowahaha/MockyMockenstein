<?php
namespace MockyMockenstein;

class StaticMonkeyPatch extends MonkeyPatch {
    public function willReceive($method_name) {
        $stub = new StaticStub(array(
            'mock_name' => $this->class_name,
            'mock_class_name' => $this->class_name,
            'test' => $this->test,
            'method_name' => $method_name
        ));

        return $this->addStub($stub);
    }

    public function willInstantiate($mock) {
        $mock_class_name = get_class($mock);
        $class_name = $this->class_name;
        $constructor_router_name = 'mockyMockensteinConstructor_' . str_replace('\\', '_', $class_name);

        runkit_function_add(
            $constructor_router_name,
            '$requested_class_name',
            "return \$requested_class_name == '$class_name' ? '$mock_class_name' : \$requested_class_name;"
        );

        $stub = $mock->willReceive('__construct');

        set_new_overload($constructor_router_name);

        return $stub;
    }
}
