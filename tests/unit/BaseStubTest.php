<?php

abstract class BaseStubTest extends PHPUnit_Framework_TestCase {
    protected function stubHasError($expectedError) {
        try {
            $this->stub->assertExpectationsAreMet();
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            if ($expectedError == $e->toString()) {
                return true;
            }
        }

        return false;
    }
}
