<?php

// src/Domain/Services/UserService.php
namespace App\Domain\Services;

use App\Domain\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Método para obtener todos los usuarios
    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }
}
