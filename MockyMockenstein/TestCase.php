<?php

abstract class MockyMockenstein_TestCase extends PHPUnit_Framework_TestCase {
    private $replacements = array();

    protected function buildInstanceMock($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildInstance($mock_name);
        $this->replacements[] = $mock;
        return $mock;
    }

    protected function buildStaticMock($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildStatic($mock_name);
        $this->replacements[] = $mock;
        return $mock;
    }

    protected function spyForInstance($class_name) {
        $spy_master = new \MockyMockenstein\SpyMaster($this);
        $instance = $spy_master->patchInstance($class_name);
        $this->replacements[] = $instance;
        return $instance;
    }

    protected function spyForStatic($class_name) {
        $spy_master = new \MockyMockenstein\SpyMaster($this);
        $static = $spy_master->patchStatic($class_name);
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
        foreach($this->replacements as $replacement) {
            $replacement->assertExpectationsAreMet();
        }
        \MockyMockenstein\Router::clearAll();
        parent::tearDown();
    }
}

