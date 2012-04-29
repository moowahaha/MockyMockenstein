<?php

class MockyMockenstein_TestCaseTest extends MockyMockenstein_TestCase {
    function testMockInstance() {
        $fake_mock = $this->setUpMockExpectations('buildInstance');
        $this->assertEquals($fake_mock, $this->buildInstanceMock('mock name'));
    }

    function testMockClass() {
        $fake_mock = $this->setUpMockExpectations('buildStatic');
        $this->assertEquals($fake_mock, $this->buildStaticMock('mock name'));
    }

    function testSpyInstance() {
        $fake_spy = $this->setUpSpyExpectations('patchInstance');
        $this->assertEquals($fake_spy, $this->spyForInstance('mock name'));
    }

    function testSpyStatic() {
        $fake_spy = $this->setUpSpyExpectations('patchStatic');
        $this->assertEquals($fake_spy, $this->spyForStatic('mock name'));
    }

    function testValueParameter() {
        $patch = $this->spyForStatic('MockyMockenstein\\ParameterChecker_Value');
        $mock_parameter = $this->buildInstanceMock('fake param!');
        $patch->willInstantiate($mock_parameter);
        $this->assertEquals(get_class($mock_parameter), get_class($this->value('a')));
    }

    function testTypeParameter() {
        $patch = $this->spyForStatic('MockyMockenstein\\ParameterChecker_Type');
        $mock_parameter = $this->buildInstanceMock('fake param!');
        $patch->willInstantiate($mock_parameter);
        $this->assertEquals(get_class($mock_parameter), get_class($this->type('a')));
    }

    private function setUpMockExpectations($builder_method) {
        $fake_mock = $this->buildInstanceMock('fake mock');
        $fake_mock->willReceive('assertExpectationsAreMet')->calledAnytime();

        $fake_builder = $this->buildInstanceMock('fake builder');
        $fake_builder->willReceive($builder_method)->with($this->value('mock name'))->andReturn($fake_mock);

        $builder = $this->spyForStatic('MockyMockenstein\\MockBuilder');
        $builder->willInstantiate($fake_builder)->with($this->type('MockyMockenstein_TestCaseTest'));

        return $fake_mock;
    }

    private function setUpSpyExpectations($builder_method) {
        $fake_mock = $this->buildInstanceMock('fake mock');
        $fake_mock->willReceive('assertExpectationsAreMet')->calledAnytime();

        $fake_builder = $this->buildInstanceMock('fake builder');
        $fake_builder->willReceive($builder_method)->with($this->value('mock name'))->andReturn($fake_mock);

        $builder = $this->spyForStatic('MockyMockenstein\\SpyMaster');
        $builder->willInstantiate($fake_builder)->with($this->type('MockyMockenstein_TestCaseTest'));

        return $fake_mock;
    }
}