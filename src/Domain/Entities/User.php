<?php
// src/Domain/Entities/User.php
namespace App\Domain\Entities;


class User
{
    private string $id;
    private string $nom;
    private string $email;
    private string $hashedPassword;

    public function __construct(string $id, string $nom, string $email, string $hashedPassword)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;  // Guardar el hash
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    // Solo exponer el método para obtener el hash de la contraseña
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    // Opcional: Puedes agregar un método para verificar si una contraseña dada coincide con el hash
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->hashedPassword); // Verificar con password_verify
    }
}
