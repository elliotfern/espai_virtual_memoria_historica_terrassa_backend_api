<?php

// src/Infrastructure/Persistence/MySqlUserRepository.php
namespace App\Infrastructure\Persistence;

use App\Domain\Repositories\UserRepository;
use App\Domain\Entities\User;
use App\Infrastructure\Database\DatabaseConnection;
use PDO;

class MySqlUserRepository implements UserRepository
{
    private PDO $pdo;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->pdo = $databaseConnection->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT id, nom AS name, email FROM auth_users ");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userEntities = [];
        foreach ($users as $userData) {
            $userEntities[] = new User($userData['id'], $userData['name'], $userData['email']);
        }

        return $userEntities;
    }
}
