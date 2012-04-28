<?php

class SomeClass {
    function someMethod() {
        return 'original';
    }
}

class MonkeyPatchIntegrationTest extends BaseMockTest {
    function setUp() {
        parent::setUp();
        $this->instance_mock = $this->monkeyPatchInstanceOf('SomeClass');
        $this->class_mock = $this->monkeyPatchClassOf('SomeClass');
    }

    function testInstanceMethodIsCalled() {
        $this->instance_mock->willReceive('someMethodCall');
        $instance = new SomeClass();
        $instance->someMethodCall();
    }

    function testStaticMethodIsCalled() {
        $monkey_patch_class = $this->monkeyPatchClassOf('SomeClass');
        $monkey_patch_class->willReceive('someStaticMethodCall');
        SomeClass::someStaticMethodCall();
    }

    function testReplacingConstructor() {
        $mock = $this->buildMockInstance('some mock');
        $mock->willReceive('someMethod');

        $monkey_patch_class = $this->monkeyPatchClassOf('SomeClass');
        $monkey_patch_class->willInstantiate($mock)->with($this->value('a'));

        $replaced = new SomeClass('a');
        $replaced->someMethod();

        $this->assertEquals(get_class($mock), get_class($replaced));
    }

    function testNonExistentClass() {
        $exception = null;
        try {
            $this->monkeyPatchClassOf('WHATEVER');
        } catch (\MockyMockenstein\Exception $e) {
            $exception = $e->getMessage();
        }

        $this->assertEquals('Cannot monkey patch WHATEVER: No such class WHATEVER.', $exception);
    }
}

