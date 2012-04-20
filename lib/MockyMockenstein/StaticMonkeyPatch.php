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
        Router::addConstructorOverride($this->class_name, $mock);
        $stub = $mock->willReceive('__construct');
        return $stub;
    }
}
