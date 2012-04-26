<?php

abstract class Stub_BaseTest extends MockyMockenstein_TestCase {
    protected $mock_test;

    function setUp() {
        $this->mock_test = $this->mockInstance('mock test');
    }

    function testNotCalled() {
        $this->expectErrorOf('method (testing!) expected to be called 1 times, actually called 0 times');
    }

    function testCalledAnyNumberOfTimes() {
        $this->expectNoError();
        $this->stub->calledTimes(0);
    }

    protected function expectErrorOf($expectedError) {
        $this->mock_test->willReceive('fail')->with($this->value($expectedError));
    }

    protected function expectNoError() {
        $this->mock_test->willNotReceive('fail');
    }
}
