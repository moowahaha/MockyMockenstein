<?php
namespace MockyMockenstein;

class Mock {
    public $class_name;
    public $stubs = array();

    public function __construct($class_name) {
        $this->class_name = $class_name;
        Router::clearAllFor($this);
    }

    public function will($method_name) {
        $stub = new Stub($this, $method_name);
        return $this->addStub($stub);
    }

    public function willStatically($method_name) {
        $stub = new StaticStub($this, $method_name);
        return $this->addStub($stub);
    }

    public function assertExpectationsAreMet($test) {
        foreach($this->stubs as $stub) {
            $stub->assertExpectationsAreMet($test);
        }
    }

    private function addStub($stub) {
        Router::add($this, $stub);
        $this->stubs[$stub->method_name] = $stub;
        return $stub;
    }
}

