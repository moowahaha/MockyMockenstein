<?php

class SomeClass {
    function someMethod() {
        return 'original';
    }
}

class MonkeyPatchIntegrationTest extends MockyMockenstein_TestCase {
    function testInstanceMethodIsCalled() {
        $monkey_patch_instance = $this->monkeyPatchInstance('SomeClass');
        $monkey_patch_instance->willReceive('someMethod');

        $instance = new SomeClass();
        $instance->someMethod();
    }

    function testOriginalMethodIsRestored() {
        $instance = new SomeClass();
        $this->assertEquals('original', $instance->someMethod());
    }

    function testStaticMethodIsCalled() {
        $monkey_patch_class = $this->monkeyPatchClass('SomeClass');
        $monkey_patch_class->willReceive('someStaticMethodCall');
        SomeClass::someStaticMethodCall();
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

