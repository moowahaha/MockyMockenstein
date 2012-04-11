<?php
namespace MockyMockenstein;

class Router {
    private static $routes = array();

    public static function clearAllFor($mock) {
        unset(self::$routes[$mock->class_name]);
    }

    public static function add($mock, $stub) {
        if (!isset(self::$routes[$mock->class_name])) {
            self::$routes[$mock->class_name] = array();
        }
        self::$routes[$mock->class_name][$stub->method_name] = $stub;
    }

    public static function clearAll() {
        self::$routes = array();
    }

    public static function routeToStub($class_name, $method_name, $method_params) {
        $stub = self::$routes[$class_name][$method_name];
        return $stub->run($method_params);
    }
}
