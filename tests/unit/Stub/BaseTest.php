<?php

abstract class Stub_BaseTest extends MockyMockenstein_TestCase {
    protected $mock_test;
    protected $mock_builder;
    protected $mock;
    private $stub;

    function setUp() {
        $this->mock_test = $this->mockInstance('mock test');
        $this->mock_builder = new \MockyMockenstein\MockBuilder($this->mock_test);
        $this->mock = $this->setUpMock();
        $this->stub = $this->mock->willReceive('method');
    }

    function testCalled() {
        $this->expectNoError();
        $this->callMethod();
    }

    function testReturnValue() {
        $this->expectNoError();
        $this->stub->andReturn('hello');
        $this->assertEquals('hello', $this->callMethod());
    }

    function testParameters() {
        $this->expectNoError();
        $this->stub->with($this->value('a'), $this->type('Stub_BaseTest'));
        $this->callMethod('a', $this);
    }

    function testDefaultParameterChecker() {
        $this->expectNoError();
        $this->stub->with('a', $this->type('Stub_BaseTest'));
        $this->callMethod('a', $this);
    }

    function testMissingParameters() {
        $this->expectErrorOf('method (testing!) expected 1 parameters, got 0');
        $this->stub->with($this->value('x'));
        $this->callMethod();
    }

    function testCalledNTimes() {
        $this->expectErrorOf('method (testing!) expected to be called 3 times, actually called 1 times');
        $this->stub->calledTimes(3);
        $this->callMethod();
    }

    function testNotCalled() {
        $this->expectErrorOf('method (testing!) expected to be called 1 times, actually called 0 times');
    }

    function testCalledAnyNumberOfTimes() {
        $this->expectNoError();
        $this->stub->calledTimes(0);
    }

    function tearDown() {
        $this->mock->assertExpectationsAreMet();
        parent::tearDown();
    }

    protected function expectErrorOf($expectedError) {
        $this->mock_test->willReceive('fail')->with($this->value($expectedError));
    }

    protected function expectNoError() {
        $this->mock_test->willNotReceive('fail');
    }
}
