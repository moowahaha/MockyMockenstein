<?php
namespace MockyMockenstein;

class Replacement_MonkeyPatch_Static extends Replacement_MonkeyPatch {
    protected $stub_class = '\MockyMockenstein\Stub_Static';

    public function willInstantiate($mock) {
        Router::addConstructorOverride($this->name, $mock);
        $stub = $mock->willReceive('__construct');
        return $stub;
    }
}
