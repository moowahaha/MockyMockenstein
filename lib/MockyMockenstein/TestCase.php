<?php

abstract class MockyMockenstein_TestCase extends PHPUnit_Framework_TestCase {
    private $replacements = array();

    protected function mockInstance($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildInstance($mock_name);
        $this->replacements[] = $mock;
        return $mock;
    }

    protected function mockClass($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildClass($mock_name);
        $this->replacements[] = $mock;
        return $mock;
    }

    protected function monkeyPatchInstance($class_name) {
        $monkey_patcher = new \MockyMockenstein\MonkeyPatcher($this);
        $instance = $monkey_patcher->patchInstance($class_name);
        $this->replacements[] = $instance;
        return $instance;
    }

    protected function monkeyPatchClass($class_name) {
        $monkey_patcher = new \MockyMockenstein\MonkeyPatcher($this);
        $static = $monkey_patcher->patchClass($class_name);
        $this->replacements[] = $static;
        return $static;
    }

    protected function value($expected_value) {
        return new \MockyMockenstein\ParameterChecker_Value(array(
            'expected' => $expected_value,
            'test' => $this
        ));
    }

    protected function type($expected_type) {
        return new \MockyMockenstein\ParameterChecker_Type(array(
            'expected' => $expected_type,
            'test' => $this
        ));
    }

    function tearDown() {
        parent::tearDown();
        foreach($this->replacements as $replacement) {
            $replacement->assertExpectationsAreMet();
        }
        \MockyMockenstein\Router::clearAll();
    }
}

