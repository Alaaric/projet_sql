<?php

namespace App;

class Router
{
    private $routes = [];

    public function get(string $uri, string $controllerAction, string $role = 'public')
    {
        $this->addRoute('GET', $uri, $controllerAction, $role);
    }

    public function post(string $uri, string $controllerAction, string $role = 'public')
    {
        $this->addRoute('POST', $uri, $controllerAction, $role);
    }

    private function addRoute(string $method, string $uri, string $controllerAction, string $role)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controllerAction' => $controllerAction,
            'role' => $role
        ];
    }

    public function route(string $uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($this->convertToRegex($route['uri']), $uri, $matches)) {
                if (!$this->checkPermissions($route['role'])) {
                    echo "Accès interdit !";
                    return;
                }

                list($controllerName, $method) = explode('@', $route['controllerAction']);
                $controller = "App\\Controllers\\$controllerName";
                $controller = new $controller();

                array_shift($matches);
                call_user_func_array([$controller, $method],array_values($matches));
                return;
            }
        }

        echo "Page non trouvée!";
    }

    private function convertToRegex($uri)
    {
        return "#^" . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $uri) . "$#";
    }

    private function checkPermissions(string $requiredRole): bool
    {
        if ($requiredRole === 'public') {
            return true;
        }

        if (!isset($_SESSION['user']['role'])) {
            return false;
        }

        if ($requiredRole === 'admin' && $_SESSION['user']['role'] !== 'admin') {
            return false;
        }

        return true;
    }
}
