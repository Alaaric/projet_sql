<?php

namespace App\Models;

use PDO;

class Product extends AbstractModel
{
    protected string $table = "products";

    public function findAllWithCategory(): array
    {
        $stmt = $this->db->query(
            "SELECT 
            p.id AS product_id, 
            p.name AS product_name, 
            p.description, 
            p.price, 
            p.stock, 
            p.category_id,
            p.image, 
            c.name AS category_name
        FROM $this->table AS p
        LEFT JOIN categories AS c ON p.category_id = c.id"
        );
        return $stmt->fetchAll();
    }

    public function findFiltered(array $filters): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $conditions = [];
        $params = [];

        if (!empty($filters['category_id'])) {
            $conditions[] = "category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }

        if (!empty($filters['min_price'])) {
            $conditions[] = "price >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $conditions[] = "price <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO $this->table (name, description, price, stock, category_id, image)
             VALUES (:name, :description, :price, :stock, :category_id, :image)"
        );
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update(string $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET name = :name, description = :description, price = :price, 
             stock = :stock, category_id = :categoryId, image = :image WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':categoryId', $data['categoryId'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);

        return $stmt->execute();
    }
}
