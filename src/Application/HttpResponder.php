<?php

namespace App\Application;

use App\Application\Contract\HttpResponderInterface;
use App\Utils\MissatgesAPI;

class HttpResponder implements HttpResponderInterface
{
    // Responder con un JSON genérico
    public function respondWithJson(array $data, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);  // Configuramos el código HTTP
        echo json_encode($data);
        exit;
    }

    // Responder con éxito usando los mensajes centralizados
    public function respondSuccess(string $key, $data = null): void
    {
        $message = MissatgesAPI::success($key);  // Obtenemos el mensaje de éxito
        $this->respondWithJson([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], 200);  // Código HTTP 200 OK
    }

    // Responder con error usando los mensajes centralizados
    public function respondError(string $key, array $errors = [], int $httpCode = 400): void
    {
        $message = MissatgesAPI::error($key);  // Obtenemos el mensaje de error
        $this->respondWithJson([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $httpCode);  // El código HTTP puede variar, por defecto es 400 (Bad Request)
    }

    // Nuevo método para manejar respuestas de error
    public function respondWithError(int $httpCode, string $message): void
    {
        http_response_code($httpCode);
        $this->respondWithJson([
            'status' => 'error',
            'message' => $message,
            'errors' => [],
        ]);
    }

    // Responder con una creación exitosa
    public function respondCreated(string $key, $data = null): void
    {
        $message = MissatgesAPI::success($key);  // Obtenemos el mensaje de éxito
        $this->respondWithJson([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], 201);  // Código HTTP 201 Created
    }

    // Responder con error 401 (No autorizado)
    public function respondUnauthorized(string $key, array $errors = []): void
    {
        $message = MissatgesAPI::error($key);  // Obtenemos el mensaje de error
        $this->respondWithJson([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], 401);  // Código HTTP 401 Unauthorized
    }

    // Responder con error 404 (No encontrado)
    public function respondNotFound(string $key, array $errors = []): void
    {
        $message = MissatgesAPI::error($key);  // Obtenemos el mensaje de error
        $this->respondWithJson([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], 404);  // Código HTTP 404 Not Found
    }

    // Responder con error 500 (Error interno del servidor)
    public function respondServerError(string $key, array $errors = []): void
    {
        $message = MissatgesAPI::error($key);  // Obtenemos el mensaje de error
        $this->respondWithJson([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], 500);  // Código HTTP 500 Internal Server Error
    }
}
