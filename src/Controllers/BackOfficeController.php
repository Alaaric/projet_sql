<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Entities\Category;
use App\Entities\Product;
use App\Entities\User;
use Exception;
use App\Exceptions\CategoryModelException;
use App\Exceptions\ProductModelException;
use App\Exceptions\UserModelException;

class BackOfficeController extends AbstractController
{
    protected CategoryModel $categoryModel;
    protected ProductModel $productModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        try {
            $categories = $this->categoryModel->findAll();
            $products = $this->productModel->findAllWithCategory();
            $productsCountByCategory = $this->categoryModel->findWithProductsCount();
            $users = $this->userModel->findAll();

            $this->render('backOffice', ['categories' => $categories, 'products' => $products, 'users' => $users, 'productsCountByCategory' => $productsCountByCategory]);
        } catch (CategoryModelException | ProductModelException | UserModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors du chargement des données du backoffice. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors du chargement des données du backoffice.']);
        }
    }

    public function handleAction()
    {
        $action = $_POST['action'] ?? null;
        $entity = $_POST['entity'] ?? null;

        if (!$action || !$entity) {
            $this->redirect('/backoffice');
            return;
        }
        try {
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
        } catch (CategoryModelException | ProductModelException | UserModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la gestion de l\'action. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la gestion de l\'action.']);
        }

        $this->redirect('/backoffice');
    }

    private function handleCategoryAction($action, $data)
    {
        try {
            switch ($action) {
                case 'add':
                    if (isset($data['name']) && !empty($data['name'])) {
                        $category = new Category('', $data['name']);
                        $this->categoryModel->create($category);
                    } else {
                        $this->redirect('/backoffice');
                    }
                    break;
                case 'edit':
                    if (isset($data['id'], $data['name']) && !empty($data['name'])) {
                        $category = new Category($data['id'], $data['name']);
                        $this->categoryModel->update( $category);
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
        } catch (CategoryModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la gestion de la catégorie. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la gestion de la catégorie.']);
        }
    }

    private function handleProductAction($action, $data)
    {
        try {
            switch ($action) {
                case 'add':
                    if (
                        isset($data['name'], $data['description'], $data['price'], $data['category_id']) && is_numeric($data['price'])
                    ) {
                        $product = new Product(
                            '',
                            $data['name'],
                            $data['description'],
                            (float)$data['price'],
                            (int)$data['stock'],
                            $data['category_id'],
                            $data['image'] = !empty($_FILES['image']['name']) ? $this->uploadImage($_FILES['image']) : 'chat1.jpg'
                        );
                        $this->productModel->create($product);
                    } else {
                        $this->redirect('/backoffice');
                    }
                    break;
                case 'edit':
                    if (
                        isset($data['id'], $data['name'], $data['description'], $data['price'], $data['categoryId']) &&
                        is_numeric($data['price'])
                    ) {
                        $product = new Product(
                            $data['id'],
                            $data['name'],
                            $data['description'],
                            (float)$data['price'],
                            (int)$data['stock'],
                            $data['categoryId'],
                            $data['image'] = $_FILES['image']['error'] !== 4 ? $this->uploadImage($_FILES['image']) : $data['current_image']
                        );
                        $this->productModel->update($product);
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
        } catch (ProductModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la gestion du produit. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la gestion du produit.']);
        }
    }

    private function handleUserAction($action, $data)
    {
        try {
            switch ($action) {
                case 'add':
                    if (isset($data['name'], $data['firstname'], $data['email'], $data['password'], $data['role']) && !empty($data['name'])) {
                        $user = new User(
                            '',
                            $data['name'],
                            $data['firstname'],
                            $data['email'],
                            password_hash($data['password'], PASSWORD_DEFAULT),
                            $data['role']
                        );
                        $this->userModel->create($user);
                    } else {
                        $this->redirect('/backoffice');
                    }
                    break;
                case 'edit':
                    if (isset($data['id'], $data['role'])) {
                        $this->userModel->update($data['id'], $data['role']);
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
        } catch (UserModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la gestion de l\'utilisateur. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la gestion de l\'utilisateur.']);
        }
    }


    private function uploadImage($file)
    {
        try {
            $targetDir = __DIR__ . '/../../public/assets/';
            $uuid = uniqid();
            $targetFile = $targetDir . $uuid . '-' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $targetFile);
            return $uuid . '-' . basename($file['name']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors du téléchargement de l\'image.']);
        }
    }
    
}
