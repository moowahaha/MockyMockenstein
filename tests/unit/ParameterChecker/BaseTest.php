<?php

abstract class ParameterChecker_BaseTest extends MockyMockenstein_TestCase {
    function setUp() {
        parent::setUp();
        $this->mock_test = $this->mockInstance('a test');
    }

    private function build($expected, $got, $position) {
        $class = $this->tested_class;
        $checker = new $class(array(
            'expected' => $expected,
            'test' => $this->mock_test
        ));

        $checker->assert($got, $position);
    }

    protected function assertError($expected, $got, $error, $position) {
        $this->mock_test->willReceive('fail')->with($this->value($error));
        $this->build($expected, $got, $position);
    }

    protected function assertOk($expected, $got, $position) {
        $this->build($expected, $got, $position);
    }
}
