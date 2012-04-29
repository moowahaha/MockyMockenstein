<?php

class SomeClass {
    function someMethod() {
        return 'original';
    }
}

class SpyIntegrationTest extends BaseMockTest {
    function setUp() {
        parent::setUp();
        $this->instance_mock = $this->spyForInstance('SomeClass');
        $this->class_mock = $this->spyForStatic('SomeClass');
    }

    function testInstanceMethodIsCalled() {
        $this->instance_mock->willReceive('someMethodCall');
        $instance = new SomeClass();
        $instance->someMethodCall();
    }

    function testStaticMethodIsCalled() {
        $spy_class = $this->spyForStatic('SomeClass');
        $spy_class->willReceive('someStaticMethodCall');
        SomeClass::someStaticMethodCall();
    }

    function testReplacingConstructor() {
        $mock = $this->buildInstanceMock('some mock');
        $mock->willReceive('someMethod');

        $spy_class = $this->spyForStatic('SomeClass');
        $spy_class->willInstantiate($mock)->with($this->value('a'));

        $replaced = new SomeClass('a');
        $replaced->someMethod();

        $this->assertEquals(get_class($mock), get_class($replaced));
    }

    function testNonExistentClass() {
        $exception = null;
        try {
            $this->spyForStatic('WHATEVER');
        } catch (\MockyMockenstein\Exception $e) {
            $exception = $e->getMessage();
        }

        $this->assertEquals('Cannot spy on WHATEVER: No such class WHATEVER.', $exception);
    }
}

