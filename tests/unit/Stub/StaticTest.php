<?php

class Stub_StaticTest extends Stub_BaseTest {
    function setUp() {
        parent::setUp();
        $this->mock = $this->mock_builder->buildClass('testing!');
        $this->stub = $this->mock->willReceive('method');
    }

    function testCalled() {
        $this->expectNoError();
        $mock = $this->mock;
        $mock::method();
    }

    function testReturnValue() {
        $this->stub->andReturn('hello');
        $mock = $this->mock;
        $this->assertEquals('hello', $mock::method());
    }

    function testCalledNTimes() {
        $this->expectErrorOf('method (testing!) expected to be called 3 times, actually called 1 times');
        $this->stub->calledTimes(3);
        $mock = $this->mock;
        $mock::method();
    }
}
