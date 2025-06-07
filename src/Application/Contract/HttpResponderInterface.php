<?php

namespace App\Application\Contract;

interface HttpResponderInterface
{
    public function respondWithJson(array $data, int $statusCode = 200): void;

    public function respondSuccess(string $key, $data = null): void;

    public function respondError(string $key, array $errors = [], int $httpCode = 400): void;

    public function respondCreated(string $key, $data = null): void;

    public function respondUnauthorized(string $key, array $errors = []): void;

    public function respondNotFound(string $key, array $errors = []): void;

    public function respondServerError(string $key, array $errors = []): void;
}
