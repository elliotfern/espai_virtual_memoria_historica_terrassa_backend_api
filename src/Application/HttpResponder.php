<?php

namespace App\Application;

use App\Application\Contract\HttpResponderInterface;
use App\Infrastructure\Middleware\AuthMiddleware;

class HttpResponder implements HttpResponderInterface
{
    private AuthMiddleware $authMiddleware;

    public function __construct(AuthMiddleware $authMiddleware)
    {
        $this->authMiddleware = $authMiddleware;
    }

    public function respondToApiRoute($routeInfo, array $params): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($routeInfo === null) {
            http_response_code(404);
            echo json_encode(['error' => 'API endpoint not found']);
            return;
        }

        $needsAuth = $routeInfo['needs_auth'] ?? false;
        if ($needsAuth) {
            $this->authMiddleware->handle();
        }

        $viewPath = __DIR__ . '/../../../' . $routeInfo['view'];

        if (file_exists($viewPath)) {
            extract($params);
            include $viewPath;
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'API handler not found']);
        }
    }
}
