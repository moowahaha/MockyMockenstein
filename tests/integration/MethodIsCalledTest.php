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
        $class = $this->mockClass('some mock');
        $class::willReceive('new');
        new $class();
    }
}

