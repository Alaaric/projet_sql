<?php

namespace App\Models;

use PDO;
use App\Databases\Database;
use Exception;

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
        try {
            $stmt = $this->db->query("SELECT * FROM {$this->table}");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $entities = [];
            foreach ($results as $result) {
                $entities[] = $this->createEntity($result);
            }

            return $entities;
        } catch (Exception $e) {
            throw new Exception('Une erreur est survenue lors de la récupération des enregistrements.', 500, $e);
        }
    }

    public function findById(string $id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $this->createEntity($result);
            }

            return null;

        } catch (Exception $e) {
            throw new Exception('Une erreur est survenue lors de la récupération de l\'enregistrement.', 500, $e);
        }
    }

    public function delete(string $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('Une erreur est survenue lors de la suppression de l\'enregistrement.', 500, $e);
        }
    }
}