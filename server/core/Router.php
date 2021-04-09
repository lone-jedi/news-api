<?php

class Router
{
    protected static $routes = [];
    protected static $route  = [];

    public static function add($regexp, $route = []) {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes() {
        return self::$routes;
    }

    public static function getRoute() {
        return self::$route;
    }

    public static function dispatch($url) {
        if(self::matchRoute($url)) {
            $controller = self::$route['controller'] . 'Controller';
            if(class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']);
                $param  = self::$route['param'];
                
                if(method_exists($controllerObject, $action)) {
                    $class = new ReflectionClass($controllerObject);
                    $method = $class->getMethod($action);
                    $params = $method->getParameters();
                    if($params === []) {
                        return $controllerObject->$action();
                    } else {
                        return $controllerObject->$action($param);
                    }
                }
                else {
                    throw new \Exception("Метод $controller::$action не найден!", 404);
                }
            }
            else {
                throw new \Exception("Контроллер $controller не найден!", 404);
            }
        }
        else {
            throw new \Exception("Страница не найдена!", 404);
        }
    }

    public static function matchRoute($url) {
        foreach (self::$routes as $pattern => $route) {
            if(preg_match("#{$pattern}#", $url, $matches)) {

                foreach ($matches as $k => $v) {
                    if(is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                if(empty($route['action'])) {
                    $route['action'] = 'index';
                }

                if(empty($route['param'])) {
                    $route['param'] = null;
                }

                
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    // CamelCase
    protected static function upperCamelCase($name) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    // camelCase
    protected static function lowerCamelCase($name) {
        return lcfirst(self::upperCamelCase($name));
    }

    protected static function removeQueryString($url) {
        if($url) {
            $params = explode('&', $url, 2);
            if(false ===  strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            }
            else {
                return '';
            }
        }
    }
}