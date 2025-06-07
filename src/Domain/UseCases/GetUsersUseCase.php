<?php

namespace App\Domain\UseCases;

use App\Domain\Services\UserService;  // Importar UserService
use App\Domain\Repositories\UserRepository;

class GetUsersUseCase
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function execute(): array
    {
        return $this->userService->getAllUsers();
    }
}
