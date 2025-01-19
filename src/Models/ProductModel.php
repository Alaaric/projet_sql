<?php

namespace App\Models;

use App\Entities\Product;
use App\DTO\ProductWithCategoryDTO;
use PDO;
use App\Exceptions\ProductModelException;
use Exception;

class ProductModel extends AbstractModel
{
    protected string $table = "products";

    protected function createEntity(array $data): Product
    {
        return new Product(
            $data['id'] ?? $data['product_id'],
            $data['name'] ?? $data['product_name'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['category_id'],
            $data['image']
        );
    }

    public function findAllWithCategory(): array
    {
        try {
            $stmt = $this->db->query("SELECT p.id AS product_id, p.name AS product_name, p.description, p.price, p.stock, p.category_id, p.image, c.name AS category_name FROM $this->table AS p LEFT JOIN categories AS c ON p.category_id = c.id");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($results as $result) {
                $productWithCategoryDTO = new ProductWithCategoryDTO($this->createEntity($result), $result['category_name']);
                $products[] = $productWithCategoryDTO;
            }

            return $products;
        } catch (Exception $e) {
            throw new ProductModelException('Une erreur est survenue lors de la récupération des produits avec leur catégorie.', 500, $e);
        }
    }

    public function findFiltered(array $filters): array
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $conditions = [];
            $params = [];

            if (!empty($filters['category_id'])) {
                $conditions[] = $this->buildInClause('category_id', $filters['category_id'], $params);
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

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($results as $result) {
                $products[] = $this->createEntity($result);
            }

            return $products;
        } catch (Exception $e) {
            throw new ProductModelException('Une erreur est survenue lors de la récupération des produits filtrés.', 500, $e);
        }
    }

    // gestion dynamique de la construction de la clause IN pour le filtrage multiple des catégories
    private function buildInClause(string $column, array $values, array &$params): string
    {
        $paramBinders = [];
        foreach ($values as $index => $value) {
            $paramBinder = ":{$column}_{$index}";
            $paramBinders[] = $paramBinder;
            $params[$paramBinder] = $value;
        }

        return "$column IN (" . implode(',', $paramBinders) . ")";
    }

    public function create(Product $product): void
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO $this->table (name, description, price, stock, category_id, image) VALUES (:name, :description, :price, :stock, :category_id, :image)");
            $name = $product->getName();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $stock = $product->getStock();
            $categoryId = $product->getCategoryId();
            $image = $product->getImage();

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new ProductModelException('Une erreur est survenue lors de la création du produit.', 500, $e);
        }
    }

    public function update(Product $product): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET name = :name, description = :description, price = :price, stock = :stock, category_id = :categoryId, image = :image WHERE id = :id");
            $id = $product->getId();
            $name = $product->getName();
            $description = $product->getDescription();
            $price = $product->getPrice();
            $stock = $product->getStock();
            $categoryId = $product->getCategoryId();
            $image = $product->getImage();

            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new ProductModelException('Une erreur est survenue lors de la mise à jour du produit.', 500, $e);
        }
    }
}
