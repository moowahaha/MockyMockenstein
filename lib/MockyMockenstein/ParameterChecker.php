<?php
namespace MockyMockenstein;

abstract class ParameterChecker {
    protected $test;
    protected $expected;

    function __construct($params) {
        $this->test = $params['test'];
        $this->expected = $params['expected'];
    }
}
