<?php

class FakeClass {}

class StubTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $mock = new \MockyMockenstein\Mock('FakeClass');
        $this->stub = new \MockyMockenstein\Stub($mock, 'some_method');
        \MockyMockenstein\Router::add($mock, $this->stub);
        $this->fake_class = new FakeClass();
        $this->fake_test = $this->getMock('FakeTest', array('fail'));
    }

    function testMethodCalled() {
        $this->fake_test->expects($this->never())->method('fail');
        $this->fake_class->some_method();
        $this->stub->assertExpectationsAreMet($this->fake_test);
    }

    function testMethodNotCalled() {
        $this->fake_test
            ->expects($this->once())
            ->method('fail')
            ->with(
                $this->equalTo(
                    'FakeClass::some_method expected to be called 1 times, actually called 0 times'
                )
            );
        $this->stub->assertExpectationsAreMet($this->fake_test);
    }
}

