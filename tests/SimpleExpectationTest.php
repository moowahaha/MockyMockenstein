<?php

class Motor {
    function ignite() {
    }
}

class Rocket {
    function __construct() {
        $this->motor = new Motor();
    }

    function launch() {
        $this->motor->ignite();
    }
}

class SimpleExpectationTest extends MockyMockenstein_TestCase {
    function testMethodIsCalled() {
        $mock = $this->mock('Motor');
        $mock->shouldReceive('ignite');
        $rocket = new Rocket();
        $rocket->launch();
    }
}
