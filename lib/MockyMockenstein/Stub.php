<?php
namespace MockyMockenstein;

abstract class Stub {
    protected $method_type;
    private $mock_name;
    private $mock_class_name;
    private $test;
    private $return_value;
    private $run_count = 0;
    private $expected_run_count = 0;
    public $method_name;

    public function __construct($params) {
        $this->mock_name = $params['mock_name'];
        $this->mock_class_name = $params['mock_class_name'];
        $this->test = $params['test'];
        $this->method_name = $params['method_name'];

        $this->replaceOriginalMethod();
    }

    public function run() {
        $params = func_get_args();
        $this->run_count++;
        return $this->return_value;
    }

    public function assertExpectationsAreMet() {
        if ($this->run_count != $this->expected_run_count) {
            $this->test->fail(
                $this->toString() .
                ' expected to be called ' . $this->expected_run_count .
                ' times, actually called ' . $this->run_count. ' times'
            );
        }
    }

    private function toString() {
        return $this->method_name . ' (' . $this->mock_name . ')';
    }

    private function replaceOriginalMethod() {
        $class_name = $this->mock_class_name;
        $this->expected_run_count = 1;

        runkit_method_add(
            $class_name,
            $this->method_name,
            '',
            "return \MockyMockenstein\Router::routeToStub('$class_name', '$this->method_name', func_get_args());",
            $this->method_type
        );
    }
}

