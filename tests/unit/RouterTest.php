<?php

class SomeSortOfOriginalClass {}
class SomeSortOfReplacementClass {}

class RouterTest extends PHPUnit_Framework_TestCase {
    function tearDown() {
        \MockyMockenstein\Router::clearAll();
    }

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
        $stub = new \MockyMockenstein\StaticStub(array(
            'mock_name' => 'whatever',
            'mock_class_name' => 'SomeSortOfOriginalClass',
            'test' => $this,
            'method_name' => 'sayHello'
        ));

        $stub->andReturn('hello');

        \MockyMockenstein\Router::add('SomeSortOfOriginalClass', $stub);

        $this->assertEquals(
            'hello',
            \MockyMockenstein\Router::routeToStub('SomeSortOfOriginalClass', 'sayHello', '')
        );
    }
}
