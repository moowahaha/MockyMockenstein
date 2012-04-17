<?php
namespace MockyMockenstein;

class MockClass extends Mock {
    public $class_name;
    public $stubs = array();

    public function willReceive($method_name) {
        if ($method_name == 'new') {
            $new_constructor = '_' . $this->class_name . '_mockensteinConstructor';
            runkit_function_add(
                $new_constructor,
                '',
                "\$mock = new \MockyMockenstein\MockInstance('$class_name');",
                'return new \MockyMockenstein\Stub($mock, "new")'
            );
            set_new_overload($new_constructor);
        } else {
            $stub = new StaticStub($this, $method_name);
        }
        return $this->addStub($stub);
    }
}

