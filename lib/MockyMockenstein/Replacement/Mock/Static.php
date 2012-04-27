<?php
namespace MockyMockenstein;

abstract class Replacement_Mock_Static extends Replacement_Mock {

    protected $stub_class = '\MockyMockenstein\Stub_Static';

    public function willInstantiate($mock) {
        Router::addConstructorOverride(get_called_class(), $mock);
        $stub = $mock->willReceive('__construct');
        return $stub;
    }
}
