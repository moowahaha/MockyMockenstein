<?php

class InstanceStubTest extends BaseStubTest {
    function setUp() {
        $mock_builder = new \MockyMockenstein\MockBuilder($this);
        $this->mock = $mock_builder->buildInstance('testing!');
        $this->stub = $this->mock->willReceive('method');
    }

    function testNotCalled() {
        $this->assertTrue($this->stubHasError('method (testing!) expected to be called 1 times, actually called 0 times'));
    }

    function testCalled() {
        $this->mock->method();
        $this->assertFalse($this->stubHasError('method (testing!) expected to be called 1 times, actually called 0 times'));
    }

    function testReturnValue() {
        $this->stub->andReturn('hello');
        $this->assertEquals('hello', $this->mock->method());
    }

    function testCalledAnyNumberOfTimes() {
        $this->stub->calledAnytime();
        $this->assertFalse($this->stubHasError('method (testing!) expected to be called 1 times, actually called 0 times'));
    }

    function testCalledNTimes() {
        $this->stub->calledTimes(3);
        $this->assertTrue($this->stubHasError('method (testing!) expected to be called 3 times, actually called 0 times'));
        $this->mock->method();
        $this->assertTrue($this->stubHasError('method (testing!) expected to be called 3 times, actually called 1 times'));
        $this->mock->method();
        $this->mock->method();
    }
}
