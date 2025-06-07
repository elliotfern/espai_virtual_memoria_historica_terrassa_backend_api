<?php

namespace App\Application;

use App\Application\Contract\RouterInterface;

class Router implements RouterInterface
{
    private array $routes = [];

    public function get(string $route, callable $handler): void
    {
        $this->routes[] = ['method' => 'GET', 'route' => $route, 'handler' => $handler];
    }

    public function post(string $route, callable $handler): void
    {
        $this->routes[] = ['method' => 'POST', 'route' => $route, 'handler' => $handler];
    }

    public function match(string $uri): ?array
    {
        // Comprobamos si alguna de las rutas coincide con la URI
        foreach ($this->routes as $route) {
            if ($route['route'] === $uri) {
                return ['routeInfo' => $route, 'params' => []];
            }
        }

        // Si no hay coincidencia, retornamos null
        return null;
    }
}
