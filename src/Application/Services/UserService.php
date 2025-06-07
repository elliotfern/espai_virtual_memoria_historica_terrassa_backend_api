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

    public function getUsers(): array
    {
        $users = $this->userRepository->findAll();
        error_log(print_r($users, true));  // Verifica qué devuelve findAll()
        return $users;
    }
}
