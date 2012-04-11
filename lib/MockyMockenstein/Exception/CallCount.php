<?php

namespace MockyMockenstein;

class CallCountException extends Exception {
    public function __construct($class, $method, $expected_count, $actual_count) {
        $message = "Expected $class::$method to be called $expected_count times, actually called $actual_count times";
        parent::__construct($message, 0, null);
    }

    public function __toString() {
        return __CLASS__ . ": " . $this->message;
    }
}

