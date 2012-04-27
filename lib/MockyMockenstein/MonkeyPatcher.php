<?php
namespace MockyMockenstein;

class MonkeyPatcher {
    private $test;

    public function __construct($test) {
        $this->test = $test;
    }

    public function patchInstance($class_name) {
        $monkey_patch = new Replacement_MonkeyPatch_Instance();
        $monkey_patch->name = $class_name;
        $monkey_patch->test = $this->test;
        return $monkey_patch;
    }

    public function patchClass($class_name) {
        $monkey_patch = new Replacement_MonkeyPatch_Static();
        $monkey_patch->name = $class_name;
        $monkey_patch->test = $this->test;
        return $monkey_patch;
    }
}

