<?php

class Abc {}

class MockTest extends PHPUnit_Framework_TestCase {
    function testStubCreated() {
        $mock = new \MockyMockenstein\Mock('Abc');
        $this->assertEquals(
            get_class($mock->shouldReceive('abc')),
            'MockyMockenstein\Stub'
        );
    }

    function testStaticStubCreated() {
        $mock = new \MockyMockenstein\Mock('Abc');
        $this->assertEquals(
            get_class($mock->staticShouldReceive('abc')),
            'MockyMockenstein\StaticStub'
        );
    }
}

