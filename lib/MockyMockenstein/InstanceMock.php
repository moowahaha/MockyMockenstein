<?php
namespace MockyMockenstein;

abstract class InstanceMock extends Mock {

    private function buildStub($method_name) {
        $stub = new InstanceStub(array(
            'mock_name' => self::$mock_name,
            'mock_class_name' => get_class($this),
            'test' => self::$test,
            'method_name' => $method_name
        ));
        return self::addStub($stub);
    }

    public function willReceive($method_name) {
        return $this->buildStub($method_name);
    }

    public function willNotReceive($method_name) {
        $stub = $this->buildStub($method_name);
        $stub->calledTimes(0);
        return $stub;
    }

}
