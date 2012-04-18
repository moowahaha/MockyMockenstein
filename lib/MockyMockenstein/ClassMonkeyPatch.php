<?php
namespace MockyMockenstein;

class ClassMonkeyPatch extends MonkeyPatch {

    private $stubs = array();

    private $class_name;
    private $test;

    public function __construct($class_name, $test) {
        $this->class_name = $class_name;
        $this->test = $test;
    }

    public static function willReceive($method_name) {
        $stub = new StaticStub(array(
            'mock_name' => $this->class_name,
            'mock_class_name' => $this->class_name,
            'test' => $this->test,
            'method_name' => $method_name
        ));
        return $this->addStub($stub);
    }

    public function assertExpectationsAreMet() {
        foreach($this->stubs as $stub) {
            $stub->assertExpectationsAreMet();
        }
    }

    private function addStub($stub) {
        Router::add($stub->mock_class_name, $stub);
        $this->stubs[$stub->method_name] = $stub;
        return $stub;
    }
}
