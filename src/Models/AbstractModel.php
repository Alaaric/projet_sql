<?php

namespace App\Models;

use PDO;
use App\Databases\Database;

abstract class AbstractModel
{
    protected PDO $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    abstract protected function createEntity(array $data);

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $entities = [];
        foreach ($results as $result) {
            $entities[] = $this->createEntity($result);
        }

        return $entities;
    }

    public function findById(string $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $this->createEntity($result);
        }

        return null;
    }

    public function delete(string $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        return $stmt->execute();
    }
}