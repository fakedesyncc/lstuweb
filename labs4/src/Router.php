<?php

namespace App;

/**
 * @author fakedesyncc
 */
class Router
{
    private array $routes = [];
    private array $params = [];

    public function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function match(string $method, string $path): ?array
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {
                return [
                    'controller' => $route['controller'],
                    'action' => $route['action'],
                    'params' => $this->params
                ];
            }
        }
        return null;
    }

    private function matchPath(string $routePath, string $requestPath): bool
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        $this->params = [];

        for ($i = 0; $i < count($routeParts); $i++) {
            if (strpos($routeParts[$i], '{') === 0 && strpos($routeParts[$i], '}') === strlen($routeParts[$i]) - 1) {
                $paramName = trim($routeParts[$i], '{}');
                $this->params[$paramName] = $requestParts[$i];
            } elseif ($routeParts[$i] !== $requestParts[$i]) {
                return false;
            }
        }

        return true;
    }
}
