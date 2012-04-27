<?php

namespace MockyMockenstein;

abstract class Replacement {
    protected $stubs = array();

    public $name;
    public $test;

    public function assertExpectationsAreMet() {
        foreach($this->stubs as $stub) {
            $stub->assertExpectationsAreMet();
            $stub->destroy();
        }
    }

    public function willReceive($method_name) {
        return $this->buildStub($method_name);
    }

    public function willNotReceive($method_name) {
        return $this->buildStub($method_name)->calledTimes(0);
    }

    protected function addStub($stub) {
        Router::add($stub->mock_class_name, $stub);
        $this->stubs[$stub->method_name] = $stub;
        return $stub;
    }
}
