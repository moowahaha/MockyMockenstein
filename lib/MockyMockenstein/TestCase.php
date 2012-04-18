<?php

abstract class MockyMockenstein_TestCase extends PHPUnit_Framework_TestCase {
    private $static_replacements = array();
    private $instance_replacements = array();

    protected function mockInstance($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildInstance($mock_name);
        $this->static_replacements[] = $mock;
        return $mock;
    }

    protected function mockClass($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildClass($mock_name, $this);
        $this->static_replacements[] = $mock;
        return $mock;
    }

    protected function monkeyPatchInstance($class_name) {
        $monkey_patcher = new \MockyMockenstein\MonkeyPatcher($this);
        $instance = $monkey_patcher->patchInstance($class_name);
        $this->instance_replacements[] = $instance;
        return $instance;
    }

    protected function monkeyPatchClass($mock_name) {
        $monkey_patcher = new \MockyMockenstein\MonkeyPatcher($this);
        $static = $monkey_patcher->patchClass($mock_name, $this);
        $this->instance_replacements[] = $static;
        return $static;
    }

    function tearDown() {
        parent::tearDown();
        foreach($this->static_replacements as $replacement) {
            $replacement::assertExpectationsAreMet();
        }
        foreach($this->instance_replacements as $replacement) {
            $replacement->assertExpectationsAreMet();
        }
        \MockyMockenstein\Router::clearAll();
    }
}

