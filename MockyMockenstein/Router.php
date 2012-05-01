<?php
namespace MockyMockenstein;

class Router {
    const CONSTRUCTOR_ROUTER = 'mockyMockensteinConstructorRouter';

    private static $routes = array();
    private static $constructors = array();

    public static function clearAllFor($mock) {
        unset(self::$routes[$mock->class_name]);
    }

    public static function add($class_name, $method_name, $stubs) {
        if (!isset(self::$routes[$class_name])) {
            self::$routes[$class_name] = array();
        }

        self::$routes[$class_name][$method_name] = $stubs;
    }

    public static function addConstructorOverride($old_class, $mock, $stub) {
        if (!isset(self::$constructors[$old_class])) {
            self::$constructors[$old_class] = array();
        }

        self::$constructors[$old_class][] = array('class' => get_class($mock), 'stub' => $stub);

        if (!function_exists(self::CONSTRUCTOR_ROUTER)) {
            runkit_function_add(
                self::CONSTRUCTOR_ROUTER, '$requested_class_name',
                'return \\MockyMockenstein\\Router::routeToClass($requested_class_name);'
            );

            set_new_overload(self::CONSTRUCTOR_ROUTER);
        }
    }

    public static function clearAll() {
        unset_new_overload();

        if (function_exists(self::CONSTRUCTOR_ROUTER)) {
            runkit_function_remove(self::CONSTRUCTOR_ROUTER);
        }

        self::$constructors = array();
        self::$routes = array();
    }

    public static function routeToClass($requested_class_name) {
        if (!isset(self::$constructors[$requested_class_name]) || empty(self::$constructors[$requested_class_name])) {
            return $requested_class_name;
        }

        $replacement = self::$constructors[$requested_class_name][0];
        $stub = $replacement['stub'];

        if ($stub->areExpectationsMet()) {
            array_shift(self::$constructors[$requested_class_name]);
            if (empty(self::$constructors[$requested_class_name])) {
                return $requested_class_name;
            }
            $replacement = self::$constructors[$requested_class_name][0];
        }

        return $replacement['class'];
    }

    public static function routeToStub($class_name, $method_name, $method_params) {
        if (!isset(self::$routes[$class_name]) || !isset(self::$routes[$class_name][$method_name]) || empty(self::$routes[$class_name][$method_name])) {
            return;
        }

        $stub = self::$routes[$class_name][$method_name][0];
        $return_value = $stub->run($method_params);
        if ($stub->areExpectationsMet()) {
            array_shift(self::$routes[$class_name][$method_name]);
        }

        return $return_value;
    }
}
