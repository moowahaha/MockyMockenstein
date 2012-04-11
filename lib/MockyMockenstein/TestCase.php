<?php

abstract class MockyMockenstein_TestCase extends PHPUnit_Framework_TestCase {
    private $mocks = array();

    protected function mock($class_name) {
        $mock = new \MockyMockenstein\Mock($class_name);
        $this->mocks[] = $mock;
        return $mock;
    }

    function tearDown() {
        parent::tearDown();
        foreach($this->mocks as $mock) {
            $mock->assertExpectationsAreMet();
        }
        \MockyMockenstein\Router::clearAll();
    }
}

