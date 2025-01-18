<?php

namespace App\Models;

use App\Entities\Category as CategoryEntity;
use PDO;
use App\DTO\CategoryWithProductsCountDTO;

class Category extends AbstractModel
{
    protected string $table = "categories";

    protected function createEntity(array $data): CategoryEntity
    {
        return new CategoryEntity(
            $data['id'] ?? $data['category_id'],
            $data['name'] ?? $data['category_name']
        );
    }

    public function findWithProductsCount(): array
    {
        $stmt = $this->db->query("SELECT c.id AS category_id, c.name AS category_name, COUNT(p.id) AS product_count
            FROM {$this->table} c
            INNER JOIN products p ON c.id = p.category_id
            GROUP BY c.id, c.name");
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $categories = [];
        foreach ($results as $result) {
            $categoryDTO = new CategoryWithProductsCountDTO(
                $this->createEntity($result),
                $result['product_count']
            );
            $categories[] = $categoryDTO;
        }
    
        return $categories;
    }

    public function create(CategoryEntity $category): void
    {
        $stmt = $this->db->prepare("INSERT INTO $this->table (name) VALUES (:name)");
        $name = $category->getName();
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function update(CategoryEntity $category): void
    {
        $stmt = $this->db->prepare("UPDATE $this->table SET name = :name WHERE id = :id");
        $name = $category->getName();
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $id = $category->getId();
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
    }
}