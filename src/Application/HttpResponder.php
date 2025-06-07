<?php

namespace App\Application;

use App\Application\Contract\HttpResponderInterface;


class HttpResponder implements HttpResponderInterface
{

    public function respondWithJson(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function respondWithData(int $status, array $data): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function respondWithError(int $status, string $message): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode(['error' => $message]);
    }

    public function respondToApiRoute(array $routeInfo, array $params): void
    {
        // Llamamos al handler de la ruta, que es el controlador
        call_user_func($routeInfo['handler']);
    }
}
