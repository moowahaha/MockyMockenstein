<?php
namespace MockyMockenstein;

class StaticMonkeyPatch extends MonkeyPatch {
    protected $stub_class = '\MockyMockenstein\StaticStub';

    public function willInstantiate($mock) {
        Router::addConstructorOverride($this->name, $mock);
        $stub = $mock->willReceive('__construct');
        return $stub;
    }
}
