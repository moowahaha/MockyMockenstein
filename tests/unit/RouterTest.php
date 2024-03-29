<?php

class SomeSortOfOriginalClass {}
class SomeSortOfReplacementClass {}

class RouterTest extends MockyMockenstein_TestCase {
    function testConstructorMapping() {
        $mock_stub = $this->buildInstanceMock('a stub');
        $mock_stub->willReceive('areExpectationsMet')->calledTimes(3)->andReturn(false);

        \MockyMockenstein\Router::addConstructorOverride(
            'SomeSortOfOriginalClass',
            new SomeSortOfReplacementClass(),
            $mock_stub
        );

        $this->assertEquals(
            'SomeSortOfReplacementClass',
            \MockyMockenstein\Router::routeToClass('SomeSortOfOriginalClass')
        );

        $this->assertEquals(
            'SomeSortOfReplacementClass',
            get_class(new SomeSortOfOriginalClass())
        );

        $this->assertEquals(
            get_class(new SomeSortOfOriginalClass()),
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
        $mock_stub = $this->buildInstanceMock('a stub');
        $mock_stub->method_name = 'sayHello';
        $mock_stub->willReceive('run')->andReturn('hello');
        $mock_stub->willReceive('destroy')->calledAnytime();
        $mock_stub->willReceive('areExpectationsMet')->andReturn(true);
        \MockyMockenstein\Router::add('SomeSortOfOriginalClass', 'sayHello', array($mock_stub));

        $this->assertEquals(
            'hello',
            \MockyMockenstein\Router::routeToStub('SomeSortOfOriginalClass', 'sayHello', '')
        );
    }
}
