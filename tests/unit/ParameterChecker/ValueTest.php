<?php

class ParameterChecker_ValueTest extends ParameterChecker_BaseTest {
    protected $tested_class = '\MockyMockenstein\ParameterChecker_Value';

    function testMatch() {
        $this->assertOk('a', 'a', 1);
    }

    function testNoMatch() {
        $this->assertError('a', 'x', "Parameter 1 expected to be value 'a', got 'x'", 1);
    }
}
