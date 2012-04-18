<?php
namespace MockyMockenstein;

class InstanceMonkeyPatch extends MonkeyPatch {

    public function willReceive($method_name) {
        $stub = new InstanceStub(array(
            'mock_name' => $this->class_name,
            'mock_class_name' => $this->class_name,
            'test' => $this->test,
            'method_name' => $method_name
        ));
        return $this->addStub($stub);
    }
}
