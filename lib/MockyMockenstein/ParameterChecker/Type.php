<?php
namespace MockyMockenstein;

class ParameterChecker_Type extends ParameterChecker {
    public function assert($instance, $position) {
        if (!is_object($instance) || !is_a($instance, $this->expected)) {
            $this->test->fail(sprintf("Parameter %d expected to be type of %s", $position, $this->expected));
        }
    }
}
