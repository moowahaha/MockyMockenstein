<?php
namespace MockyMockenstein;

class Stub {
    protected $method_type = RUNKIT_ACC_PUBLIC;
    private $mock;
    private $return_value;
    private $run_count = 0;
    private $expected_run_count = 0;
    public $method_name;

    public function __construct($mock, $method_name) {
        $this->mock = $mock;
        $this->method_name = $method_name;

        $this->replaceOriginalMethod();
    }

    public function run() {
        $params = func_get_args();
        $this->run_count++;
        return $this->return_value;
    }

    public function assertExpectationsAreMet($test) {
        if ($this->run_count != $this->expected_run_count) {
            $test->fail(
                $this->toString() .
                ' expected to be called ' . $this->expected_run_count .
                ' times, actually called ' . $this->run_count. ' times'
            );
        }
    }

    private function toString() {
        return $this->mock->class_name . '::' . $this->method_name;
    }

    private function replaceOriginalMethod() {
        $class_name = $this->mock->class_name;
        $this->expected_run_count = 1;

        $gen_method_function = method_exists($class_name, $this->method_name) ? 'runkit_method_redefine' : 'runkit_method_add';

        $gen_method_function(
            $class_name,
            $this->method_name,
            '',
            "return \MockyMockenstein\Router::routeToStub('$class_name', '$this->method_name', func_get_args());",
            $this->method_type
        );
    }
}

