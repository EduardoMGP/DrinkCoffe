<?php

namespace Mosyle;

class Routers
{

    /**
     * @var Route[]
     */
    private static array $routes;

    public static function get($uri, $controller, $action)
    {
        $route = new Route($uri, $controller, 'GET', $action);
        self::$routes[] = $route;
        return $route;
    }

    public static function post($uri, $controller, $action)
    {
        $route = new Route($uri, $controller, 'POST', $action);
        self::$routes[] = $route;
        return $route;
    }

    public static function put($uri, $controller, $action)
    {
        $route = new Route($uri, $controller, 'PUT', $action);
        self::$routes[] = $route;
        return $route;
    }

    public static function delete($uri, $controller, $action)
    {
        $route = new Route($uri, $controller, 'DELETE', $action);
        self::$routes[] = $route;
        return $route;
    }

    public static function getRoute($uri, $method)
    {
        foreach (self::$routes as $route) {
            if ($route->uri() == $uri && $route->method() == $method) {
                return (object)[
                    'route'  => $route,
                    'params' => []
                ];
            }
        }
        foreach (self::$routes as $route) {
            $regex = '#{([a-zA-Z]|[0-9])+\}#';
            $regex = '#^' . preg_replace($regex, '([a-zA-Z]+|[0-9]+)', $route->uri()) . '$#';
            if (preg_match_all($regex, $uri, $matches, PREG_SET_ORDER) && $route->method() == $method) {
                return (object)[
                    'route'  => $route,
                    'params' => array_slice($matches[0], 1)
                ];
            }
        }

        return null;

    }

}