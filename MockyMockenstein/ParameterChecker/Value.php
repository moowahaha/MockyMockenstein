<?php
namespace MockyMockenstein;

class ParameterChecker_Value extends ParameterChecker {
    public function assert($value, $position) {
        if ($value !== $this->expected) {
            $this->test->fail(sprintf(
                "Parameter %d expected to be value '%s', got '%s'",
                $position,
                $this->expected,
                $value
            ));
        }
    }
}
