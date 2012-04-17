<?php
namespace MockyMockenstein;

class Router {
    private static $routes = array();

    public static function clearAllFor($mock) {
        unset(self::$routes[$mock->class_name]);
    }

    public static function add($class_name, $stub) {
        if (!isset(self::$routes[$class_name])) {
            self::$routes[$class_name] = array();
        }
        self::$routes[$class_name][$stub->method_name] = $stub;
    }

    public static function clearAll() {
        unset_new_overload();
        self::$routes = array();
    }

    public static function routeToStub($class_name, $method_name, $method_params) {
        $stub = self::$routes[$class_name][$method_name];
        return $stub->run($method_params);
    }
}
