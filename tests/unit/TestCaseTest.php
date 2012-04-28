<?php

class MockyMockenstein_TestCaseTest extends MockyMockenstein_TestCase {
    function testMockInstance() {
        $fake_mock = $this->setUpMockExpectations('buildInstance');
        $this->assertEquals($fake_mock, $this->buildMockInstance('mock name'));
    }

    function testMockClass() {
        $fake_mock = $this->setUpMockExpectations('buildClass');
        $this->assertEquals($fake_mock, $this->buildMockClass('mock name'));
    }

    function testMonkeyPatchInstance() {
        $fake_monkey_patch = $this->setUpMonkeyPatchExpectations('patchInstance');
        $this->assertEquals($fake_monkey_patch, $this->monkeyPatchInstanceOf('mock name'));
    }

    function testMonkeyPatchClass() {
        $fake_monkey_patch = $this->setUpMonkeyPatchExpectations('patchClass');
        $this->assertEquals($fake_monkey_patch, $this->monkeyPatchClassOf('mock name'));
    }

    function testValueParameter() {
        $patch = $this->monkeyPatchClassOf('MockyMockenstein\\ParameterChecker_Value');
        $mock_parameter = $this->buildMockInstance('fake param!');
        $patch->willInstantiate($mock_parameter);
        $this->assertEquals(get_class($mock_parameter), get_class($this->value('a')));
    }

    function testTypeParameter() {
        $patch = $this->monkeyPatchClassOf('MockyMockenstein\\ParameterChecker_Type');
        $mock_parameter = $this->buildMockInstance('fake param!');
        $patch->willInstantiate($mock_parameter);
        $this->assertEquals(get_class($mock_parameter), get_class($this->type('a')));
    }

    private function setUpMockExpectations($builder_method) {
        $fake_mock = $this->buildMockInstance('fake mock');
        $fake_mock->willReceive('assertExpectationsAreMet')->calledAnytime();

        $fake_builder = $this->buildMockInstance('fake builder');
        $fake_builder->willReceive($builder_method)->with($this->value('mock name'))->andReturn($fake_mock);

        $builder = $this->monkeyPatchClassOf('MockyMockenstein\\MockBuilder');
        $builder->willInstantiate($fake_builder)->with($this->type('MockyMockenstein_TestCaseTest'));

        return $fake_mock;
    }

    private function setUpMonkeyPatchExpectations($builder_method) {
        $fake_mock = $this->buildMockInstance('fake mock');
        $fake_mock->willReceive('assertExpectationsAreMet')->calledAnytime();

        $fake_builder = $this->buildMockInstance('fake builder');
        $fake_builder->willReceive($builder_method)->with($this->value('mock name'))->andReturn($fake_mock);

        $builder = $this->monkeyPatchClassOf('MockyMockenstein\\MonkeyPatcher');
        $builder->willInstantiate($fake_builder)->with($this->type('MockyMockenstein_TestCaseTest'));

        return $fake_mock;
    }
}