<?php

namespace App\Router;

/**
 * Простой роутер для маршрутизации запросов
 * 
 * @author fakedesyncc
 */
class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function get(string $path, $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    public function patch(string $path, $handler): void
    {
        $this->addRoute('PATCH', $path, $handler);
    }

    private function addRoute(string $method, string $path, $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';
        
        if (strpos($uri, '/project/public') === 0) {
            $uri = substr($uri, strlen('/project/public'));
            $uri = rtrim($uri, '/') ?: '/';
        }
        
        if ($uri === '/index.php') {
            $uri = '/';
        }

        if (preg_match('#^/labs[0-9]+#', $uri)) {
            return;
        }

        if (preg_match('#\.(css|js|png|jpg|jpeg|gif|svg|mp3|wav|ogg|m4a|woff|woff2|ttf|eot|ico)$#i', $uri)) {
            $staticFile = '/var/www/html/project/public' . $uri;
            if (file_exists($staticFile) && is_readable($staticFile)) {
                return;
            }
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = $this->convertToRegex($route['path']);
            
            if (preg_match($pattern, $uri, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_numeric($key)) {
                        $params[] = $value;
                    }
                }
                
                $handler = $route['handler'];
                
                if (is_callable($handler)) {
                    call_user_func_array($handler, $params);
                    return;
                }
                
                if (is_string($handler) && strpos($handler, '@') !== false) {
                    [$class, $method] = explode('@', $handler);
                    if (class_exists($class)) {
                        $controller = new $class();
                        if (method_exists($controller, $method)) {
                            call_user_func_array([$controller, $method], $params);
                            return;
                        }
                    }
                }
            }
        }

        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Route not found']);
        exit;
    }

    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/:(\w+)/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function extractParams(array $matches): array
    {
        $params = [];
        foreach ($matches as $key => $value) {
            if (!is_numeric($key)) {
                $params[] = $value;
            }
        }
        return $params;
    }
}
