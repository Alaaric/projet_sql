<?php

namespace App\DTO;

use App\Entities\Category;

class CategoryWithProductsCountDTO
{
    private Category $category;
    private int $productCount;

    public function __construct(Category $category, int $productCount)
    {
        $this->category = $category;
        $this->productCount = $productCount;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getProductCount(): int
    {
        return $this->productCount;
    }
}