<?php

abstract class MockyMockenstein_TestCase extends PHPUnit_Framework_TestCase {
    private $mocks = array();
    private $monkey_patches = array();

    protected function mockInstance($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildInstance($mock_name);
        $this->mocks[] = $mock;
        return $mock;
    }

    protected function mockClass($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildClass($mock_name, $this);
        $this->mocks[] = $mock;
        return $mock;
    }

    protected function monkeyPatchInstance($class_name) {
        $monkey_patcher = new \MockyMockenstein\MonkeyPatcher($this);
        $instance = $monkey_patcher->patchInstance($class_name);
        $this->monkey_patches[] = $instance;
        return $instance;
    }

    protected function monkeyPatchClass($class_name) {
        $monkey_patcher = new \MockyMockenstein\MonkeyPatcher($this);
        $static = $monkey_patcher->patchClass($class_name, $this);
        $this->monkey_patches[] = $static;
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
        foreach($this->mocks as $replacement) {
            $replacement::assertExpectationsAreMet();
        }
        foreach($this->monkey_patches as $replacement) {
            $replacement->assertExpectationsAreMet();
        }
        \MockyMockenstein\Router::clearAll();
    }
}

