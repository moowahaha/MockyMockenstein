<?php

namespace MockyMockenstein;

abstract class Replacement {
    private $stub_groups = array();

    public $name;
    public $test;

    public function assertExpectationsAreMet() {
        foreach ($this->stub_groups as $stubs) {
            foreach ($stubs as $stub) {
                $stub->assertExpectationsAreMet();
                $stub->destroy();
            }
        }
    }

    public function willReceive($method_name) {
        $stub = $this->buildStub($method_name);
        $this->addStub($stub);
        return $stub;
    }

    public function willNotReceive($method_name) {
        $stub = $this->buildStub($method_name)->calledTimes(0);
        $this->stub_groups[$stub->method_name] = array();
        $this->addStub($stub);
        return $stub;
    }

    private function addStub($stub) {
        if (!isset($stubs[$stub->method_name])) {
            $stubs[$stub->method_name] = array();
        }
        $this->stub_groups[$stub->method_name][] = $stub;

        Router::add($stub->mock_class_name, $stub->method_name, $this->stub_groups[$stub->method_name]);
    }
}
