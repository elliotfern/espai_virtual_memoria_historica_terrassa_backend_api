<?php

namespace App\Application\Contract;

interface HttpResponderInterface
{
    public function respondWithData(int $status, array $data): void;
    public function respondWithError(int $status, string $message): void;
    public function respondToApiRoute(array $routeInfo, array $params): void;
}
