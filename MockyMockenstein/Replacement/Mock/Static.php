<?php
namespace MockyMockenstein;

abstract class Replacement_Mock_Static extends Replacement_Mock {
    protected $stub_class = '\MockyMockenstein\Stub_Static';

    public function willInstantiate(Replacement_Mock_Instance $mock) {
        $stub = $mock->willReceive('__construct');
        $stub->is_constructor = true;
        Router::addConstructorOverride(get_called_class(), $mock, $stub);
        return $stub;
    }
}
