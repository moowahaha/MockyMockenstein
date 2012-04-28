<?php
namespace MockyMockenstein;

abstract class Replacement_MonkeyPatch extends Replacement {

    protected function buildStub($method_name) {
        $stub_class = $this->stub_class;

        $stub = new $stub_class(array(
            'mock_name' => $this->name,
            'mock_class_name' => $this->name,
            'test' => $this->test,
            'method_name' => $method_name
        ));

        return $stub;
    }


}
