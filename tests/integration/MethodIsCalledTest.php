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

    function runChecks() {
        Motor::isAMotor();
    }
}

class MethodIsCalledTest extends MockyMockenstein_TestCase {
    function testMethodIsCalled() {
        $mock = $this->mock('Motor');
        $mock->willReceive('ignite');
        $rocket = new Rocket();
        $rocket->launch();
    }

    function testStaticMethodIsCalled() {
        $mock = $this->mock('Motor');
        $mock->willStaticallyReceive('isAMotor');
        $rocket = new Rocket();
        $rocket->runChecks();
    }
}
