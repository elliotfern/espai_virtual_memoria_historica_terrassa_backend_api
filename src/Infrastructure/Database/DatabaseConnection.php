<?php

namespace App\Infrastructure\Database;

use PDO;
use PDOException;

class DatabaseConnection
{
    private PDO $pdo;

    public function __construct(string $host, string $dbName, string $user, string $password)
    {
        try {

            $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8";
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
