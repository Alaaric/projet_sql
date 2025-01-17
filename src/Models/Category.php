<?php

namespace App\Models;

use PDO;

class Category extends AbstractModel
{
    protected string $table = "categories";

    public function findWithProductsCount()
    {
        $stmt = $this->db->query("SELECT c.id AS category_id, c.name AS category_name, COUNT(p.id) AS product_count
        FROM {$this->table} c
        INNER JOIN products p ON c.id = p.category_id
        GROUP BY c.id, c.name;
    ");
        return $stmt->fetchAll();
    }

    public function create(string $name)
    {
        $stmt = $this->db->prepare("INSERT INTO $this->table (name) VALUES (:name)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function update(string $id, string $name)
    {
        $sql = "UPDATE $this->table SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
    }
}
