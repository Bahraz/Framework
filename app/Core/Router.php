<?php

namespace Bahraz\Framework\Core;

use PDOException;
use RuntimeException;
use InvalidArgumentException;

class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    private function normalizePath(string $path): string
    {
        $path = rtrim($path, '/');
        return $path === '' ? '/' : $path;
    }

    public function get(string $path, $handler): void
    {
        $this->routes['GET'][$this->normalizePath($path)] = $handler;
    }

    public function post(string $path, $handler): void
    {
        $this->routes['POST'][$this->normalizePath($path)] = $handler;
    }

    public function put(string $path, $handler): void
    {
        $this->routes['PUT'][$this->normalizePath($path)] = $handler;
    }

    public function patch(string $path, $handler): void
    {
        $this->routes['PATCH'][$this->normalizePath($path)] = $handler;
    }

    public function delete(string $path, $handler): void
    {
        $this->routes['DELETE'][$this->normalizePath($path)] = $handler;
    }

    public function dispatch(string $uri): void
    {
        $path = $this->normalizePath(parse_url($uri, PHP_URL_PATH));
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        foreach ($this->routes[$method] as $route => $handler) {

            $paramNames = [];
            if (preg_match_all('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', $route, $matchesNames)) {
                $paramNames = $matchesNames[1];
            }

            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([a-zA-Z0-9_-]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                $params = ($paramNames && count($paramNames) === count($matches))
                    ? array_combine($paramNames, $matches)
                    : $matches;

                try {
                    if (is_callable($handler)) {
                        call_user_func_array($handler, $params);
                    } elseif (is_string($handler) && strpos($handler, '@') !== false) {
                        [$controllerName, $methodName] = explode('@', $handler);
                        if (!class_exists($controllerName)) {
                            throw new RuntimeException("Controller $controllerName not found");
                        }
                        $controller = new $controllerName();
                        if (!method_exists($controller, $methodName)) {
                            throw new RuntimeException("Method $methodName not found in $controllerName");
                        }
                        call_user_func_array([$controller, $methodName], $params);
                    } else {
                        throw new InvalidArgumentException("Invalid handler for route $route");
                    }
                } catch (\Throwable $e) {
                    http_response_code(500);
                    echo $e->getMessage();
                }
                return;
            }
        }
        http_response_code(404);
        echo "Route not found.";
    }
}