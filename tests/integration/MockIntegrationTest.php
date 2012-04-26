<?php

class MockIntegrationTest extends BaseMockTest {
    function setUp() {
        parent::setUp();
        $this->instance_mock = $this->mockInstance('some mock');
        $this->class_mock = $this->mockClass('some mock');
    }

    function testInstanceMethodIsCalled() {
        $this->instance_mock->willReceive('someMethodCall');
        $this->instance_mock->someMethodCall();
    }

    function testStaticMethodIsCalled() {
        $class = $this->class_mock;
        $class::willReceive('someStaticMethodCall');
        $class::someStaticMethodCall();
    }

    function testStaticMethodIsNotCalled() {
        $class = $this->class_mock;
        $class::willNotReceive('someStaticMethodCall');
    }

    function testReplacingConstructor() {
        $instance_mock = $this->instance_mock;
        $instance_mock->willReceive('someMethodCall');

        $class = $this->mockClass('some class');
        $class::willInstantiate($instance_mock);

        $object = new $class();
        $object->someMethodCall();
        $this->assertEquals($instance_mock::$mock_name, $object::$mock_name);
    }
}

