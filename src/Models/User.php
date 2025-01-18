<?php

namespace App\Models;

use App\Entities\User as UserEntity;
use PDO;


class User extends AbstractModel
{
    protected string $table = 'users';

    protected function createEntity(array $data): UserEntity
    {
        return new UserEntity(
            $data['id'],
            $data['name'],
            $data['firstname'],
            $data['email'],
            $data['password'],
            $data['role']
        );
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $this->createEntity($result);
        }
    
        return null;
    }

    public function create(UserEntity $user): void
    {
        $stmt = $this->db->prepare("INSERT INTO $this->table (name, firstname, email, password, role) VALUES (:name, :firstname, :email, :password, :role)");
        
        $name = $user->getName();
        $firstname = $user->getFirstname();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function update(string $id, string $role): void
    {
        $stmt = $this->db->prepare("UPDATE $this->table SET role = :role WHERE id = :id");

        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        $stmt->execute();
    }
}
