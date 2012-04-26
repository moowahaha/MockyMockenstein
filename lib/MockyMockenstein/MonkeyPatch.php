<?php
namespace MockyMockenstein;

abstract class MonkeyPatch {

    private $stubs = array();

    protected $class_name;
    protected $test;

    public function __construct($class_name, $test) {
        $this->class_name = $class_name;
        $this->test = $test;
    }

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
        $stub = $this->buildStub($method_name);
        $stub->calledTimes(0);
        return $stub;
    }

    private function addStub($stub) {
        Router::add($stub->mock_class_name, $stub);
        $this->stubs[$stub->method_name] = $stub;
        return $stub;
    }

    protected function buildStub($method_name) {
        $stub_class = $this->stub_class;

        $stub = new $stub_class(array(
            'mock_name' => $this->class_name,
            'mock_class_name' => $this->class_name,
            'test' => $this->test,
            'method_name' => $method_name
        ));
        return $this->addStub($stub);
    }


}
