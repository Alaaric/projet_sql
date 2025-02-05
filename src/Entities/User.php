<?php

namespace App\Entities;

class User
{
    private string $id;
    private string $name;
    private string $firstname;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(string $id, string $name, string $firstname, string $email, string $password, string $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

}