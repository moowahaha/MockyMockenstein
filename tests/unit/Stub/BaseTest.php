<?php

abstract class Stub_BaseTest extends MockyMockenstein_TestCase {
    protected $mock_test;
    protected $mock_builder;
    protected $mock;
    private $stub;

    function setUp() {
        $this->mock_test = $this->buildInstanceMock('mock test');
        $this->mock_builder = new \MockyMockenstein\MockBuilder($this->mock_test);
        $this->mock = $this->setUpMock();
        $this->stub = $this->mock->willReceive('method');
    }

    function testCalled() {
        $this->expectNoError();
        $this->callMethod();
        $this->assertTrue($this->stub->areExpectationsMet());
    }

    function testReturnValue() {
        $this->expectNoError();
        $this->stub->andReturn('hello');
        $this->assertEquals('hello', $this->callMethod());
        $this->assertTrue($this->stub->areExpectationsMet());
    }

    function testParameters() {
        $this->expectNoError();
        $this->stub->with($this->value('a'), $this->type('Stub_BaseTest'));
        $this->callMethod('a', $this);
        $this->assertTrue($this->stub->areExpectationsMet());
    }

    function testDefaultParameterChecker() {
        $this->expectNoError();
        $this->stub->with('a', $this->type('Stub_BaseTest'));
        $this->callMethod('a', $this);
        $this->assertTrue($this->stub->areExpectationsMet());
    }

    function testMissingParameters() {
        $this->expectErrorOf('method (testing!) expected 1 parameters, got 0');
        $this->stub->with($this->value('x'));
        $this->callMethod();
    }

    function testNotCalledNTimes() {
        $this->expectErrorOf('method (testing!) expected to be called 3 times, actually called 2 times');
        $this->stub->calledTimes(3);
        $this->callMethod();
        $this->callMethod();
        $this->assertFalse($this->stub->areExpectationsMet());
    }

    function testCalledNTimes() {
        $this->expectNoError();
        $this->stub->calledTimes(2);
        $this->callMethod();
        $this->callMethod();
        $this->assertTrue($this->stub->areExpectationsMet());
    }

    function testOrdered() {
        $this->expectNoError();
        $this->stub->with('first')->andReturn(1);
        $this->mock->willReceive($this->stub->method_name)->with('second')->andReturn(2);

        $this->assertEquals($this->callMethod('first'), 1);
        $this->assertEquals($this->callMethod('second'), 2);
        $this->assertTrue($this->stub->areExpectationsMet());
    }

    function testBadlyOrdered() {
        $this->expectErrorOf("Parameter 1 expected to be value 'first', got 'second'");
        $this->stub->with('first')->andReturn(1);
        $this->mock->willReceive($this->stub->method_name)->with('second')->andReturn(2);

        $this->callMethod('second');
        $this->callMethod('first');
    }

    function testNotCalled() {
        $this->expectErrorOf('method (testing!) expected to be called 1 times, actually called 0 times');
    }

    function testCalledAnyNumberOfTimes() {
        $this->expectNoError();
        $this->stub->calledAnytime();
        $this->assertFalse($this->stub->areExpectationsMet());
    }

    function testUnexpectedCall() {
        $this->expectErrorOf("method (testing!) did not expect to be called.");
        $this->mock->willNotReceive($this->stub->method_name);
        $this->callMethod();
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
