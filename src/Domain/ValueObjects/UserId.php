<?php

// src/Domain/ValueObjects/UserId.php
namespace App\Domain\ValueObjects;

class UserId
{
    private $id;

    public function __construct($id)
    {
        if (!$this->isValid($id)) {
            throw new \InvalidArgumentException("Invalid User ID");
        }
        $this->id = $id;
    }

    private function isValid($id)
    {
        // Validación del ID
        return preg_match('/^[a-f0-9]{32}$/', $id);
    }

    public function getId()
    {
        return $this->id;
    }
}
