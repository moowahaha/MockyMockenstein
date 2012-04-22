<?php

class SomeSortOfOriginalClass {}
class SomeSortOfReplacementClass {}

class RouterTest extends MockyMockenstein_TestCase {
    function testConstructorMapping() {
        \MockyMockenstein\Router::addConstructorOverride(
            'SomeSortOfOriginalClass',
            new SomeSortOfReplacementClass()
        );

        $this->assertEquals(
            'SomeSortOfReplacementClass',
            \MockyMockenstein\Router::routeToClass('SomeSortOfOriginalClass')
        );

        $this->assertEquals(
            'SomeSortOfReplacementClass',
            get_class(new SomeSortOfOriginalClass())
        );
    }

    function testUnsetConstructorMapping() {
        $this->assertEquals(
            'SomeClass',
            \MockyMockenstein\Router::routeToClass('SomeClass')
        );
    }

    function testStubMapping() {
        $mock_stub = $this->mockInstance('a stub');
        $mock_stub->method_name = 'sayHello';
        $mock_stub->willReceive('run')->andReturn('hello');
        $mock_stub->willReceive('destroy')->calledAnytime();
        \MockyMockenstein\Router::add('SomeSortOfOriginalClass', $mock_stub);

        $this->assertEquals(
            'hello',
            \MockyMockenstein\Router::routeToStub('SomeSortOfOriginalClass', 'sayHello', '')
        );
    }
}