<?php

class Stub_StaticBaseTest extends Stub_BaseTest {
    function setUp() {
        parent::setUp();
        $mock_builder = new \MockyMockenstein\MockBuilder($this->mock_test);
        $this->mock = $mock_builder->buildClass('testing!');
        $mock = $this->mock;
        $this->stub = $mock::willReceive('method');
    }

    function testCalled() {
        $this->expectNoError();
        $mock = $this->mock;
        $mock::method();
    }

    function testReturnValue() {
        $mock = $this->mock;
        $this->stub->andReturn('hello');
        $this->assertEquals('hello', $mock::method());
    }

    function testCalledNTimes() {
        $this->expectErrorOf('method (testing!) expected to be called 3 times, actually called 1 times');
        $this->stub->calledTimes(3);
        $mock = $this->mock;
        $mock::method();
    }
}
