<?php

class Abc {}

class MockTest extends PHPUnit_Framework_TestCase {
    function testStubCreated() {
        $mock = new \MockyMockenstein\Mock('Abc');
        $this->assertEquals(
            get_class($mock->willReceive('doSomething')),
            'MockyMockenstein\Stub'
        );
    }

    function testStaticStubCreated() {
        $mock = new \MockyMockenstein\Mock('Abc');
        $this->assertEquals(
            get_class($mock->willStaticallyReceive('doSomethingElse')),
            'MockyMockenstein\StaticStub'
        );
    }
}

