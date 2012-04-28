<?php
namespace MockyMockenstein;

abstract class Stub {
    protected $method_type;

    private $backed_up_method;
    private $mock_name;
    private $test;
    private $return_value;
    private $run_count = 0;
    private $expected_run_count = 0;
    private $expected_parameters = array();

    public $mock_class_name;
    public $method_name;

    public function __construct($params) {
        $this->mock_name = $params['mock_name'];
        $this->mock_class_name = $params['mock_class_name'];
        $this->test = $params['test'];
        $this->method_name = $params['method_name'];

        $this->generateMethod();
    }

    public function run($parameters = array()) {
        if ($this->expected_run_count === 0) {
            $this->test->fail(
                $this->toString() . ' did not expect to be called.'
            );
        }

        $this->assertParameters($parameters);
        $this->run_count++;
        return $this->return_value;
    }

    public function calledAnytime() {
        $this->expected_run_count = null;
        return $this;
    }

    public function calledTimes($times) {
        $this->expected_run_count = (int)$times;
        return $this;
    }

    public function with() {
        $this->expected_parameters = array();

        foreach (func_get_args() as $expected_param) {
            $this->expected_parameters[] = is_a(
                $expected_param, 'MockyMockenstein\\ParameterChecker'
            ) ? $expected_param : new ParameterChecker_Value(array('expected' => $expected_param, 'test' => $this->test));
        }
        return $this;
    }

    public function andReturn($value) {
        $this->return_value = $value;
        return $this;
    }

    public function areExpectationsMet() {
        return $this->calledCorrectNumberOfTimes();
    }

    public function assertExpectationsAreMet() {
        if (!$this->calledCorrectNumberOfTimes()) {
            $this->test->fail(
                $this->toString() . ' expected to be called ' . $this->expected_run_count . ' times, actually called ' . $this->run_count . ' times'
            );
        }
    }

    public function destroy() {
        if (method_exists($this->mock_class_name, $this->method_name)) {
            runkit_method_remove(
                $this->mock_class_name, $this->method_name
            );
        }

        if ($this->backed_up_method) {
            runkit_method_rename(
                $this->mock_class_name, $this->backed_up_method, $this->method_name
            );
        }
    }

    private function calledCorrectNumberOfTimes() {
        if ($this->expected_run_count != null) {
            if ($this->run_count != $this->expected_run_count) {
                return false;
            }
        }

        return true;
    }

    private function assertParameters($parameters) {
        if (empty($this->expected_parameters)) {
            return;
        }

        if (count($parameters) != count($this->expected_parameters)) {
            $this->test->fail(
                sprintf(
                    '%s expected %d parameters, got %d', $this->toString(), count($this->expected_parameters),
                    count($parameters)
                )
            );
            return;
        }

        foreach ($this->expected_parameters as $index => $expected) {
            $expected->assert($parameters[$index], $index + 1);
        }
    }

    private function toString() {
        return $this->method_name . ' (' . $this->mock_name . ')';
    }

    private function generateMethod() {
        $class_name = $this->mock_class_name;
        $this->expected_run_count = 1;

        // we need to copy and redefine if exists or add, rather than rename and replace because, for some reason,
        // the latter will cause segfaults when php is cleaning itself up. this works though!
        if (method_exists($class_name, $this->method_name)) {
            $this->backed_up_method = $this->method_name . '_MockyMockensteinBackup';
            runkit_method_copy(
                $class_name, $this->backed_up_method, $class_name, $this->method_name
            );
            runkit_method_redefine(
                $class_name, $this->method_name, '',
                "return \MockyMockenstein\Router::routeToStub('$class_name', '$this->method_name', func_get_args());",
                $this->method_type
            );
        } else {
            runkit_method_add(
                $class_name, $this->method_name, '',
                "return \MockyMockenstein\Router::routeToStub('$class_name', '$this->method_name', func_get_args());",
                $this->method_type
            );
        }
    }
}

