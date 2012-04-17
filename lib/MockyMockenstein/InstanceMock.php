<?php
namespace MockyMockenstein;

abstract class InstanceMock {
    private $stubs = array();

    public $mock_name;
    public $test;

    public function __construct($mock_name, $test) {
        $this->mock_name = $mock_name;
        $this->test = $test;
    }

    public function assertExpectationsAreMet() {
        foreach($this->stubs as $stub) {
            $stub->assertExpectationsAreMet();
        }
    }

    public function willReceive($method_name) {
        $stub = new InstanceStub(array(
            'mock_name' => $this->mock_name,
            'mock_class_name' => get_class($this),
            'test' => $this->test,
            'method_name' => $method_name
        ));
        return $this->addStub($stub);
    }

    private function addStub($stub) {
        Router::add(get_class($this), $stub);
        $this->stubs[$stub->method_name] = $stub;
        return $stub;
    }
}
