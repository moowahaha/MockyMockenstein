<?php

abstract class BaseMockTest extends MockyMockenstein_TestCase {
    protected $instance_mock;
    protected $class_mock;

    function testInstanceMethodIsNotCalled() {
        $this->instance_mock->willNotReceive('someMethodCall');
    }

    function testStaticMethodIsNotCalled() {
        $this->class_mock->willNotReceive('someStaticMethodCall');
    }
}
