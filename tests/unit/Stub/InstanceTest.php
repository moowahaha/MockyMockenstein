<?php

class Stub_InstanceTest extends Stub_BaseTest {
    function setUpMock() {
        return $this->mock_builder->buildInstance('testing!');
    }

    protected function callMethod() {
        return call_user_func_array(array($this->mock, 'method'), func_get_args());
    }
}
