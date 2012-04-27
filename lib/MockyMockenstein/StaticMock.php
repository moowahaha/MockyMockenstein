<?php
namespace MockyMockenstein;

abstract class StaticMock extends Mock {

    protected $stub_class = '\MockyMockenstein\StaticStub';

    public function willInstantiate($mock) {
        Router::addConstructorOverride(get_called_class(), $mock);
        $stub = $mock->willReceive('__construct');
        return $stub;
    }
}
