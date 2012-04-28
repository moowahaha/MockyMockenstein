<?php

class MockIntegrationTest extends BaseMockTest {
    function setUp() {
        parent::setUp();
        $this->instance_mock = $this->buildMockInstance('some mock');
        $this->class_mock = $this->buildMockClass('some mock');
    }

    function testInstanceMethodIsCalled() {
        $this->instance_mock->willReceive('someMethodCall');
        $this->instance_mock->someMethodCall();
    }

    function testStaticMethodIsCalled() {
        $class = $this->class_mock;
        $class->willReceive('someStaticMethodCall');
        $class::someStaticMethodCall();
    }

    function testReplacingConstructor() {
        $instance_mock = $this->instance_mock;
        $instance_mock->willReceive('someMethod');

        $class = $this->buildMockClass('some class');
        $class->willInstantiate($instance_mock)->with($this->value('a'));

        $replaced = new $class('a');
        $replaced->someMethod();

        $this->assertEquals(get_class($instance_mock), get_class($replaced));
    }
}

