<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\Router;

session_start();

require_once '../vendor/autoload.php';

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/products', 'ProductsController@index');
$router->get('/auth/login', 'AuthController@showLoginForm');
$router->get('/auth/register', 'AuthController@showRegisterForm');
$router->post('/auth/login/submit', 'AuthController@login');
$router->post('/auth/register/submit', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');
$router->get('/article', 'ArticleController@index');
$router->get('/article/create', 'ArticleController@create', 'admin');
$router->post('/article/create', 'ArticleController@create', 'admin');
$router->get('/article/edit/{id}', 'ArticleController@edit', 'admin');
$router->post('/article/edit/{id}', 'ArticleController@edit', 'admin');
$router->post('/article/delete/{id}', 'ArticleController@delete', 'admin');
$router->get('/privacy-policy', 'HomeController@privacyPolicy');
$router->get('/contact', 'HomeController@contact');
$router->get('/about', 'HomeController@about');
$router->get('/backoffice', 'BackOfficeController@index', 'admin');
$router->post('/backoffice/categories/add', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/categories/edit', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/categories/delete', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/products/add', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/products/edit', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/products/delete', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/users/add', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/users/edit', 'BackOfficeController@handleAction', 'admin');
$router->post('/backoffice/users/delete', 'BackOfficeController@handleAction', 'admin');

$router->route($_SERVER['REQUEST_URI']);
