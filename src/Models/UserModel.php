<?php

namespace App\Models;

use App\Entities\User;
use App\Exceptions\UserModelException;
use Exception;
use PDO;


class UserModel extends AbstractModel
{
    protected string $table = 'users';

    protected function createEntity(array $data): User
    {
        return new User(
            $data['id'],
            $data['name'],
            $data['firstname'],
            $data['email'],
            $data['password'],
            $data['role']
        );
    }

    public function findByEmail(string $email): ?User
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
        
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($result) {
                return $this->createEntity($result);
            }
        
            return null;
        } catch (Exception $e) {
            throw new UserModelException('Une erreur est survenue lors de la récupération de l\'utilisateur par email.', 500, $e);
        }
    }

    public function create(User $user): void
    {
        try {
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
        } catch (Exception $e) {
            throw new UserModelException('Une erreur est survenue lors de la création de l\'utilisateur.', 500, $e);
        }
    }

    public function update(string $id, string $role): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE $this->table SET role = :role WHERE id = :id");

            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

            $stmt->execute();
        } catch (Exception $e) {
            throw new UserModelException('Une erreur est survenue lors de la mise à jour de l\'utilisateur.', 500, $e);
        }
    }
}
