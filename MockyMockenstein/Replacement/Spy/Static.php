<?php
namespace MockyMockenstein;

class Replacement_Spy_Static extends Replacement_Spy {
    protected $stub_class = '\MockyMockenstein\Stub_Static';

    public function willInstantiate($mock) {
        Router::addConstructorOverride($this->name, $mock);
        $stub = $mock->willReceive('__construct');
        return $stub;
    }
}
