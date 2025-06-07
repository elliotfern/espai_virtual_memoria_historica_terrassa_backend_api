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
        $stmt = $this->pdo->query("SELECT id, nom, email, password FROM auth_users ");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userEntities = [];
        foreach ($users as $userData) {
            $userEntities[] = new User($userData['id'], $userData['nom'], $userData['email'], $userData['password']);
        }

        return $userEntities;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM auth_users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verificamos que los campos importantes estén presentes
        $id = $user['id'] ?? null;
        $email = $user['email'] ?? null;
        $password = $user['password'] ?? null;
        $nom = $user['nom'] ?? null;

        // Si los valores requeridos no están presentes, retornamos null
        if (!$id || !$email || !$password) {
            return null;
        }

        // Creamos y devolvemos un objeto User
        return new User($id, $nom, $email, $password);
    }
}
