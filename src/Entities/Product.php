<?php

namespace App\Entities;

class Product
{
    private string $id;
    private string $name;
    private string $description;
    private float $price;
    private int $stock;
    private ?string $categoryId;
    private ?string $image;

    public function __construct(string $id, string $name, string $description, float $price, int $stock, ?string $categoryId, ?string $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->categoryId = $categoryId;
        $this->image = $image;
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}