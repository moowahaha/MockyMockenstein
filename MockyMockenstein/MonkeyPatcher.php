<?php
namespace MockyMockenstein;

class MonkeyPatcher {
    private $test;

    public function __construct($test) {
        $this->test = $test;
    }

    public function patchInstance($class_name) {
        $this->assertClassExists($class_name);
        $monkey_patch = new Replacement_MonkeyPatch_Instance();
        $monkey_patch->name = $class_name;
        $monkey_patch->test = $this->test;
        return $monkey_patch;
    }

    public function patchClass($class_name) {
        $this->assertClassExists($class_name);
        $monkey_patch = new Replacement_MonkeyPatch_Static();
        $monkey_patch->name = $class_name;
        $monkey_patch->test = $this->test;
        return $monkey_patch;
    }

    private function assertClassExists($class_name) {
        try {
            new \ReflectionClass($class_name); // just so PHP loads the class before runkit looks at it.
        } catch (\ReflectionException $e) {
            throw new Exception("Cannot monkey patch $class_name: No such class $class_name.");
        }
    }
}

