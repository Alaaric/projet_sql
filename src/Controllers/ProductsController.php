<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use Exception;
use App\Exceptions\ProductModelException;
use App\Exceptions\CategoryModelException;

class ProductsController extends AbstractController
{
    protected ProductModel $productModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        try {
            $filters = [
                'category_id' => $_GET['category_id'] ?? [],
                'min_price' => $_GET['min_price'] ?? null,
                'max_price' => $_GET['max_price'] ?? null,
            ];

            $products = $this->productModel->findFiltered($filters);
            $categories = $this->categoryModel->findAll();
            
            $this->render('products', ['products' => $products, 'filters' => $filters, 'categories' => $categories]);
        } catch (ProductModelException | CategoryModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors du chargement des produits. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors du chargement des produits.']);
        }
    }
}