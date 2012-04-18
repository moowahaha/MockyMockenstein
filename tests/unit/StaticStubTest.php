<?php

class StaticStubTest extends BaseStubTest {
    function setUp() {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $this->mock = $mock_builder->buildClass('testing!');
        $mock = $this->mock;
        $this->stub = $mock::willReceive('method');
    }

    function testNotCalled() {
        $this->assertTrue($this->stubHasError('method (testing!) expected to be called 1 times, actually called 0 times'));
    }

    function testCalled() {
        $mock = $this->mock;
        $mock::method();
        $this->assertFalse($this->stubHasError('method (testing!) expected to be called 1 times, actually called 0 times'));
    }

    function testReturnValue() {
        $mock = $this->mock;
        $this->stub->andReturn('hello');
        $this->assertEquals('hello', $mock::method());
    }
}
