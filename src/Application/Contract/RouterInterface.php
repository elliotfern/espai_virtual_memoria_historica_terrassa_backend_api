<?php

namespace App\Application\Contract;

interface RouterInterface
{
    public function get(string $route, callable $handler);
    public function match(string $uri): ?array; // El router debe devolver la información de la ruta
}
