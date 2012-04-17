<?php

abstract class MockyMockenstein_TestCase extends PHPUnit_Framework_TestCase {
    private $instance_mocks = array();
    private $static_mocks = array();

    protected function mockInstance($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildInstance($mock_name);
        $this->instance_mocks[] = $mock;
        return $mock;
    }

    protected function mockClass($mock_name) {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $mock = $mock_builder->buildClass($mock_name, $this);
        $this->static_mocks[] = $mock;
        return $mock;
    }

    function tearDown() {
        parent::tearDown();
        foreach($this->instance_mocks as $mock) {
            $mock->assertExpectationsAreMet();
        }
        foreach($this->static_mocks as $mock) {
            $mock::assertExpectationsAreMet();
        }
        \MockyMockenstein\Router::clearAll();
    }
}

