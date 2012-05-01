<?php
namespace MockyMockenstein;

class Replacement_Spy_Static extends Replacement_Spy {
    protected $stub_class = '\MockyMockenstein\Stub_Static';

    public function willInstantiate(Replacement_Mock_Instance $mock) {
        $stub = $mock->willReceive('__construct');
        $stub->is_constructor = true;
        Router::addConstructorOverride($this->name, $mock, $stub);
        return $stub;
    }
}
