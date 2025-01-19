<?php

namespace App\Models;

use App\Entities\Category;
use App\Exceptions\CategoryModelException;
use Exception;
use PDO;
use App\DTO\CategoryWithProductsCountDTO;

class CategoryModel extends AbstractModel
{
    protected string $table = "categories";

    protected function createEntity(array $data): Category
    {
        return new Category(
            $data['id'] ?? $data['category_id'],
            $data['name'] ?? $data['category_name']
        );
    }

    public function findWithProductsCount(): array
    {
        try {
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
        } catch (Exception $e) {
            throw new CategoryModelException('Une erreur est survenue lors de la récupération des catégories avec le nombre de produits.', 500, $e);
        }
    }

    public function create(Category $category): void
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO $this->table (name) VALUES (:name)");
            $name = $category->getName();
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new CategoryModelException('Une erreur est survenue lors de la création de la catégorie.', 500, $e);
        }
    }

    public function update(Category $category): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE $this->table SET name = :name WHERE id = :id");
            $name = $category->getName();
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $id = $category->getId();
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new CategoryModelException('Une erreur est survenue lors de la mise à jour de la catégorie.', 500, $e);
        }
    }
}