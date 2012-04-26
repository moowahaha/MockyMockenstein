<?php

class Stub_InstanceBaseTest extends Stub_BaseTest {
    function setUp() {
        parent::setUp();
        $mock_builder = new \MockyMockenstein\MockBuilder($this->mock_test);
        $this->mock = $mock_builder->buildInstance('testing!');
        $this->stub = $this->mock->willReceive('method');
    }

    function testCalled() {
        $this->expectNoError();
        $this->mock->method();
    }

    function testReturnValue() {
        $this->stub->andReturn('hello');
        $this->assertEquals('hello', $this->mock->method());
    }

    function testCalledNTimes() {
        $this->expectErrorOf('method (testing!) expected to be called 3 times, actually called 1 times');
        $this->stub->calledTimes(3);
        $this->mock->method();
    }
}
