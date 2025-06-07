<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\UserRepository;

class LoginUserUseCase
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password)
    {
        // Buscar al usuario en la base de datos por el email
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user->getHashedPassword())) {
            // Si no se encuentra el usuario o la contraseña es incorrecta
            return null;
        }

        // Si el usuario es válido, retornar el objeto de usuario
        return $user;
    }
}
