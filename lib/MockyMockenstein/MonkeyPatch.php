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
        }
    }

    protected function addStub($stub) {
        Router::add($stub->mock_class_name, $stub);
        $this->stubs[$stub->method_name] = $stub;
        return $stub;
    }
}
