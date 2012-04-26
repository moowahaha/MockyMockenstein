<?php

class SomeClass {
    function someMethod() {
        return 'original';
    }
}

class MonkeyPatchIntegrationTest extends BaseMockTest {
    function setUp() {
        parent::setUp();
        $this->instance_mock = $this->monkeyPatchInstance('SomeClass');
        $this->class_mock = $this->monkeyPatchClass('SomeClass');
    }

    function testInstanceMethodIsCalled() {
        $this->instance_mock->willReceive('someMethodCall');
        $instance = new SomeClass();
        $instance->someMethodCall();
    }

    function testStaticMethodIsCalled() {
        $monkey_patch_class = $this->monkeyPatchClass('SomeClass');
        $monkey_patch_class->willReceive('someStaticMethodCall');
        SomeClass::someStaticMethodCall();
    }

    function testStaticMethodIsNotCalled() {
        $this->class_mock->willNotReceive('someStaticMethodCall');
    }

    function testReplacingConstructor() {
        $mock = $this->mockInstance('some mock');
        $mock->willReceive('someMethodCall');

        $monkey_patch_class = $this->monkeyPatchClass('SomeClass');
        $monkey_patch_class->willInstantiate($mock);

        $object = new SomeClass();
        $object->someMethodCall();
        $this->assertEquals($mock::$mock_name, $object::$mock_name);
    }
}

