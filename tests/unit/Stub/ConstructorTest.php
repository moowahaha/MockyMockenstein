<?php

class SomeDummyClass {}

class Stub_ConstructorTest extends MockyMockenstein_TestCase {
    function setUp() {
        $this->mock_test = $this->buildInstanceMock('mock test');
        $mock_builder = new \MockyMockenstein\MockBuilder($this->mock_test);

        $this->mock = $mock_builder->buildInstance('testing!');
        $this->spy = $this->spyForStatic('SomeDummyClass');
    }

    function testConstructorReplacedOnce() {
        $this->spy->willInstantiate($this->mock);
        $this->assertTrue(is_a(new SomeDummyClass(), 'MockyMockenstein\\Replacement'));
    }

    function testConstructorParameters() {
        $this->mock_test->willReceive('fail')->with('__construct (testing!) expected 1 parameters, got 0');
        $this->spy->willInstantiate($this->mock)->with('a');
        new SomeDummyClass();
    }

    function testConstructorReturnValueNotAllowed() {
        $exception = null;

        try {
            $this->spy->willInstantiate($this->mock)->andReturn('something');
        } catch (\MockyMockenstein\Exception $e) {
            $exception = $e->getMessage();
        }

        $this->assertEquals('Invalid call to "andReturn": A constructor does not have return values', $exception);
    }

    function testConstructorOrdered() {
        $other_mock = $this->buildInstanceMock('another mock');

        $this->spy->willInstantiate($this->mock);
        $this->spy->willInstantiate($other_mock);

        $this->assertEquals(get_class($this->mock), get_class(new SomeDummyClass()));
        $this->assertEquals(get_class($other_mock), get_class(new SomeDummyClass()));
        $this->assertEquals(get_class(new SomeDummyClass()), get_class(new SomeDummyClass()));
    }

    function testConstructorOrderedWithCalledTimes() {
        $other_mock = $this->buildInstanceMock('another mock');

        $this->spy->willInstantiate($this->mock)->calledTimes(2);
        $this->spy->willInstantiate($other_mock);

        $this->assertEquals(get_class($this->mock), get_class(new SomeDummyClass()));
        $this->assertEquals(get_class($this->mock), get_class(new SomeDummyClass()));
        $this->assertEquals(get_class($other_mock), get_class(new SomeDummyClass()));
        $this->assertEquals(get_class(new SomeDummyClass()), get_class(new SomeDummyClass()));
    }

    function testConstructorOrderedWithCalledAnyTime() {
        $this->spy->willInstantiate($this->mock)->calledAnytime();

        $this->assertEquals(get_class($this->mock), get_class(new SomeDummyClass()));
        $this->assertEquals(get_class($this->mock), get_class(new SomeDummyClass()));
    }
}
