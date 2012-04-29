<?php

class Stub_StaticTest extends Stub_BaseTest {
    protected function setUpMock() {
        return $this->mock_builder->buildStatic('testing!');
    }

    protected function callMethod() {
        return call_user_func_array(array(get_class($this->mock), 'method'), func_get_args());
    }
}
