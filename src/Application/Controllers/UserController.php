<?php

namespace App\Application\Controllers;

use App\Domain\UseCases\GetUsersUseCase;
use App\Application\HttpResponder;

class UserController
{
    private GetUsersUseCase $getUsersUseCase;
    private HttpResponder $httpResponder;

    public function __construct(GetUsersUseCase $getUsersUseCase, HttpResponder $httpResponder)
    {
        $this->getUsersUseCase = $getUsersUseCase;
        $this->httpResponder = $httpResponder;
    }

    public function getUsers(): void
    {
        // Llamar al caso de uso para obtener usuarios
        $users = $this->getUsersUseCase->execute();

        // Convertir usuarios a un formato adecuado (array o JSON)
        $formattedUsers = array_map(function ($user) {
            return [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ];
        }, $users);

        // Responder con los usuarios en formato JSON
        $this->httpResponder->respondWithJson($formattedUsers);
    }
}
