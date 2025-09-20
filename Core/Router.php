<?php

namespace Core;

class Router
{
    private $routes = [];
    private array $middleware = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function use(string $middlewareClass): void
    {
        $this->middleware[] = $middlewareClass;
    }

    public function get($pattern, $callback)
    {
        $this->routes['GET'][$pattern] = $callback;
        return $this;
    }

    public function post(string $pattern, $callback): self
    {
        $this->routes['POST'][$pattern] = $callback;
        return $this;
    }

    public function resolve()
    {
        $this->runMiddleware();

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
            $controllerClass = 'Controllers\\' . $controller;
            $controller = $this->container->get($controllerClass);

            if (method_exists($controller, $method)) {
                return call_user_func_array([$controller, $method], $params);
            }

            throw new \Exception("Method $method not found in controller $controllerClass");
            // if (class_exists($controllerClass)) {
            //     $instance = new $controllerClass();
            //     return call_user_func_array([$instance, $method], $params);
            // }
        }
    }

    private function notFound()
    {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
    }

    private function runMiddleware(): void
    {
        foreach ($this->middleware as $middlewareClass) {
            $middleware = $this->container->get($middlewareClass);
            $middleware->handle();
        }
    }
}
