<?php

namespace App\Application\Controllers;

use App\Domain\Services\AuthService;
use App\Domain\UseCases\LoginUserUseCase;
use App\Application\HttpResponder;

class LoginController
{
    private LoginUserUseCase $loginUserUseCase;
    private HttpResponder $httpResponder;
    private AuthService $authService;

    public function __construct(
        LoginUserUseCase $loginUserUseCase,
        HttpResponder $httpResponder,
        AuthService $authService
    ) {
        $this->loginUserUseCase = $loginUserUseCase;
        $this->httpResponder = $httpResponder;
        $this->authService = $authService;
    }

    public function login(): void
    {
        // Obtener los datos de la solicitud (por ejemplo, el email y la contraseña)
        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            // Validar que los campos no estén vacíos
            $this->httpResponder->respondWithError(400, 'Email y contraseña son requeridos');
            return;
        }

        // Llamar al caso de uso de login
        $user = $this->loginUserUseCase->execute($email, $password);

        if (!$user) {
            // Si el usuario no es válido
            $this->httpResponder->respondWithError(401, 'Credenciales incorrectas');
            return;
        }

        // Generar JWT para el usuario autenticado
        $jwt = $this->authService->generateJwt(['id' => $user->getId(), 'email' => $user->getEmail()]);

        // Responder con el JWT
        $this->httpResponder->respondWithJson([
            'status' => 'success',
            'message' => '"Has iniciat sessió correctament. Redirigint...',
            'token' => $jwt
        ]);
    }
}
