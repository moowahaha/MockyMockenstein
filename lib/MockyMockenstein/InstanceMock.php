<?php
namespace MockyMockenstein;

abstract class InstanceMock extends Mock {

    public function willReceive($method_name) {
        $stub = new InstanceStub(array(
            'mock_name' => self::$mock_name,
            'mock_class_name' => get_class($this),
            'test' => self::$test,
            'method_name' => $method_name
        ));
        return self::addStub($stub);
    }

}
