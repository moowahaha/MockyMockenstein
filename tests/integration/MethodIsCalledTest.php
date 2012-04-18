<?php

class SomeClass {
}

class MethodIsCalledTest extends MockyMockenstein_TestCase {
    function testInstanceMethodIsCalled() {
        $mock = $this->mockInstance('some mock');
        $mock->willReceive('someMethodCall');
        $mock->someMethodCall();
    }

    function testStaticMethodIsCalled() {
        $class = $this->mockClass('some mock');
        $class::willReceive('someStaticMethodCall');
        $class::someStaticMethodCall();
    }

    function testReplacingConstructor() {
        $mock = $this->mockInstance('some mock');
        $mock->willReceive('someMethodCall');

        $class = $this->mockClass('some class');
        $class::willInstantiate($mock);

        $object = new $class();
        $object->someMethodCall();
        $this->assertEquals($mock::$mock_name, $object::$mock_name);
    }
}

