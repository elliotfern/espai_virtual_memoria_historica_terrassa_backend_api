<?php

// src/Domain/Repositories/UserRepository.php
namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepository
{
    public function findAll(): array;

    public function findByEmail(string $email): ?User;
}
