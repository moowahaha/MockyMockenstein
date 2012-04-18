<?php
namespace MockyMockenstein;

class MonkeyPatcher {
    private $test;

    public function __construct($test) {
        $this->test = $test;
    }

    public function patchInstance($class_name) {
        return new InstanceMonkeyPatch($class_name, $this->test);
    }

    public function patchClass($class_name) {
        return new StaticMonkeyPatch($class_name, $this->test);
    }
}

