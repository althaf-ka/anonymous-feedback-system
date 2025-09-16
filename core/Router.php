<?php

namespace core;

class Router
{
    private $routes = [];

    public function get($pattern, $callback)
    {
        $this->routes['GET'][$pattern] = $callback;
        return $this;
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        if (!isset($this->routes[$method])) {
            return $this->notFound();
        }

        foreach ($this->routes[$method] as $pattern => $callback) {
            $params = $this->match($pattern, $uri);
            if ($params !== false) {
                return $this->call($callback, $params);
            }
        }


        return $this->notFound();
    }

    private function match($pattern, $uri)
    {
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern); //For getting id from routes {variable}
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';


        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches);
            return $matches;
        }
        return false;
    }

    private function call($callback, $params)
    {
        if (is_string($callback) && strpos($callback, '@')) {
            [$controller, $method] = explode('@', $callback);
            $controllerClass = 'controllers\\' . $controller;

            if (class_exists($controllerClass)) {
                $instance = new $controllerClass();
                return call_user_func_array([$instance, $method], $params);
            }
        }
    }

    private function notFound()
    {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
    }
}
