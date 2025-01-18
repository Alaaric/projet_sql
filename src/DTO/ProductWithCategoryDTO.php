<?php

namespace App\DTO;

use App\Entities\Product;

class ProductWithCategoryDTO
{
    private Product $product;
    private ?string $categoryName;

    public function __construct(Product $product, ?string $categoryName)
    {
        $this->product = $product;
        $this->categoryName = $categoryName;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }
}