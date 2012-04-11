<?php
namespace MockyMockenstein;

class Mock {
    public $class_name;
    public $stubs = array();

    public function __construct($class_name) {
        $this->class_name = $class_name;
        Router::clearAllFor($this);
    }

    public function shouldReceive($method_name) {
        $stub = new Stub($this, $method_name);
        Router::add($this, $stub);
        $this->stubs[$method_name] = $stub;
        return $stub;
    }

    public function assertExpectationsAreMet() {
        foreach($this->stubs as $stub) {
            $stub->assertExpectationsAreMet();
        }
    }
}

