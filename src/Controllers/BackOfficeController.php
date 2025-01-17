<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class BackOfficeController extends AbstractController
{
    protected Category $categoryModel;
    protected Product $productModel;
    protected User $userModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->productModel = new Product();
        $this->userModel = new User();
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();
        $products = $this->productModel->findAllWithCategory();
        $productsCountByCategory = $this->categoryModel->findWithProductsCount();
        $users = $this->userModel->findAll();

        $this->render('backOffice', ['categories' => $categories, 'products' => $products, 'users' => $users, 'productsCountByCategory' => $productsCountByCategory]);
    }

    public function handleAction()
    {
        $action = $_POST['action'] ?? null;
        $entity = $_POST['entity'] ?? null;

        if (!$action || !$entity) {
            $this->redirect('/backoffice');
            return;
        }

        switch ($entity) {
            case 'category':
                $this->handleCategoryAction($action, $_POST);
                break;
            case 'product':
                $this->handleProductAction($action, $_POST);
                break;
            case 'user':
                $this->handleUserAction($action, $_POST);
                break;
            default:
                $this->redirect('/backoffice');
                return;
        }

        $this->redirect('/backoffice');
    }

    private function handleCategoryAction($action, $data)
    {
        switch ($action) {
            case 'add':
                if (isset($data['name']) && !empty($data['name'])) {
                    $this->categoryModel->create($data['name']);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            case 'edit':
                if (isset($data['id'], $data['name']) && !empty($data['name'])) {
                    $this->categoryModel->update($data['id'], $data['name']);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            case 'delete':
                if (isset($data['id'])) {
                    $this->categoryModel->delete($data['id']);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            default:
                $this->redirect('/backoffice');
        }
    }

    private function handleProductAction($action, $data)
    {
        switch ($action) {
            case 'add':
                if (
                    isset($data['name'], $data['description'], $data['price'], $data['category_id']) && is_numeric($data['price'])
                ) {
                    $data['image'] = !empty($_FILES['image']['name']) ? $this->uploadImage($_FILES['image']) : 'chat1.jpg';
                    $this->productModel->create($data);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            case 'edit':
                if (
                    isset($data['id'], $data['name'], $data['description'], $data['price'], $data['categoryId']) &&
                    is_numeric($data['price'])
                ) {
                    $data['image'] = $_FILES['image']['error'] !== 4 ? $this->uploadImage($_FILES['image']) : $data['current_image'];
                    $this->productModel->update($data['id'], $data);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            case 'delete':
                if (isset($data['id'])) {
                    $this->productModel->delete($data['id']);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            default:
                $this->redirect('/backoffice');
        }
    }

    private function handleUserAction($action, $data)
    {
        switch ($action) {
            case 'edit':
                if (isset($data['id'], $data['role'])) {
                    $this->userModel->update($data['id'], $data);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            case 'delete':
                if (isset($data['id'])) {
                    $this->userModel->delete($data['id']);
                } else {
                    $this->redirect('/backoffice');
                }
                break;
            default:
                $this->redirect('/backoffice');
        }
    }


    private function uploadImage($file)
    {
        $targetDir = __DIR__ . '/../../public/assets/';
        $uuid = uniqid();
        $targetFile = $targetDir . $uuid . '-' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $targetFile);
        return $uuid . '-' . basename($file['name']);
    }
}
