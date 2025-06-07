<?php

namespace App\Domain\Services;

use Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class AuthService
{
    private string $secretKey;

    public function __construct()
    {
        // Secret key for JWT
        $jwtSecret = $_ENV['TOKEN'];
        $this->secretKey = $jwtSecret;  // Cambia esto por una clave secreta segura
    }

    public function generateJwt(array $userData): string
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // El token expira en 1 hora
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $userData
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function validateJwt(string $jwt): array
    {
        try {

            $decoded = JWT::decode($jwt, new Key($this->secretKey, 'HS256'));
            return (array) $decoded->data;
        } catch (\Exception $e) {
            return [];  // JWT inválido o expirado
        }
    }
}
