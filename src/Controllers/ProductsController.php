<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductsController extends AbstractController
{
    protected Product $model;
    protected Category $categoryModel;

    public function __construct()
    {
        $this->model = new Product();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $filters = [
            'category_id' => $_GET['category_id'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null,
        ];

        $products = $this->model->findFiltered($filters);
        $categories = $this->categoryModel->findAll();

        $this->render('products', ['products' => $products, 'categories' => $categories, 'filters' => $filters]);
    }

}
