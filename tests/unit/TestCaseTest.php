<?php

class MockyMockenstein_TestCaseTest extends MockyMockenstein_TestCase {
    function testMockInstance() {
        $fake_mock = $this->setUpMockExpectations('buildInstance');
        $this->assertEquals($fake_mock, $this->mockInstance('mock name'));
    }

    function testMockClass() {
        $fake_mock = $this->setUpMockExpectations('buildClass');
        $this->assertEquals($fake_mock, $this->mockClass('mock name'));
    }

    function testMonkeyPatchInstance() {
        $fake_monkey_patch = $this->setUpMonkeyPatchExpectations('patchInstance');
        $this->assertEquals($fake_monkey_patch, $this->monkeyPatchInstance('mock name'));
    }

    function testMonkeyPatchClass() {
        $fake_monkey_patch = $this->setUpMonkeyPatchExpectations('patchClass');
        $this->assertEquals($fake_monkey_patch, $this->monkeyPatchClass('mock name'));
    }

    private function setUpMockExpectations($builder_method) {
        $fake_mock = $this->mockInstance('fake mock');
        $fake_mock->willReceive('assertExpectationsAreMet')->calledAnytime();

        $fake_builder = $this->mockInstance('fake builder');
        $fake_builder->willReceive($builder_method)->with($this->value('mock name'))->andReturn($fake_mock);

        $builder = $this->monkeyPatchClass('MockyMockenstein\\MockBuilder');
        $builder->willInstantiate($fake_builder)->with($this->type('MockyMockenstein_TestCaseTest'));

        return $fake_mock;
    }

    private function setUpMonkeyPatchExpectations($builder_method) {
        $fake_mock = $this->mockInstance('fake mock');
        $fake_mock->willReceive('assertExpectationsAreMet')->calledAnytime();

        $fake_builder = $this->mockInstance('fake builder');
        $fake_builder->willReceive($builder_method)->with($this->value('mock name'))->andReturn($fake_mock);

        $builder = $this->monkeyPatchClass('MockyMockenstein\\MonkeyPatcher');
        $builder->willInstantiate($fake_builder)->with($this->type('MockyMockenstein_TestCaseTest'));

        return $fake_mock;
    }
}