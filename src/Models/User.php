<?php

namespace App\Models;

use PDO;


class User extends AbstractModel
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create($data)
    {

        $sql = "INSERT INTO $this->table (name, firstname, email, password, role) 
                VALUES (:name, :firstname, :email, :password, :role)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $stmt->bindParam(':role', $data['role'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update($id, $data)
    {

        $sql = "UPDATE $this->table 
                SET role = :role 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $data['role'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
