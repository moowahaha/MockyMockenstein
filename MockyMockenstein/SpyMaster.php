<?php
namespace MockyMockenstein;

class SpyMaster {
    private $test;

    public function __construct($test) {
        $this->test = $test;
    }

    public function patchInstance($class_name) {
        $this->assertClassExists($class_name);
        $spy = new Replacement_Spy_Instance();
        $spy->name = $class_name;
        $spy->test = $this->test;
        return $spy;
    }

    public function patchStatic($class_name) {
        $this->assertClassExists($class_name);
        $spy = new Replacement_Spy_Static();
        $spy->name = $class_name;
        $spy->test = $this->test;
        return $spy;
    }

    private function assertClassExists($class_name) {
        try {
            new \ReflectionClass($class_name); // just so PHP loads the class before runkit looks at it.
        } catch (\ReflectionException $e) {
            throw new Exception("Cannot spy on $class_name: No such class $class_name.");
        }
    }
}

