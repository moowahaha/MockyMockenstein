<?php
namespace MockyMockenstein;

abstract class Replacement_Mock extends Replacement {

    protected function buildStub($method_name) {
        $stub_class = $this->stub_class;

        $stub = new $stub_class(array(
            'mock_name' => $this->name,
            'mock_class_name' => get_called_class(),
            'test' => $this->test,
            'method_name' => $method_name
        ));

        return $this->addStub($stub);
    }
}
