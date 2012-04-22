<?php

class SomeArbitraryType {}
class SomeArbitraryChild extends SomeArbitraryType {}
class SomeOtherArbitraryType {}

class ParameterChecker_TypeTest extends ParameterChecker_BaseTest {
    protected $tested_class = '\MockyMockenstein\ParameterChecker_Type';

    function testMatchingType() {
        $this->assertOk('SomeArbitraryType', new SomeArbitraryType(), 1);
    }

    function testChildClass() {
        $this->assertOk('SomeArbitraryType', new SomeArbitraryChild(), 1);
    }

    function testMisMatch() {
        $this->assertError(
            'SomeArbitraryType',
            new SomeOtherArbitraryType(),
            'Parameter 2 expected to be type of SomeArbitraryType',
            2
        );
    }

    function testNotObject() {
        $this->assertError(
            'SomeArbitraryType',
            'xyz',
            'Parameter 2 expected to be type of SomeArbitraryType',
            2
        );
    }
}
