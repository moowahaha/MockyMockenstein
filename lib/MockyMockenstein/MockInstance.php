<?php
namespace MockyMockenstein;

class MockInstance extends Mock {
    public function willReceive($method_name) {
        $stub = new Stub($this, $method_name);
        return $this->addStub($stub);
    }
}

