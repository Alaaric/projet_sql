<?php

namespace App\Controllers;

use App\Models\Category;

class CategoriesController extends AbstractController
{
  protected Category $model;
  public function __construct()
  {
    $this->model = new Category();
  }
  public function index()
  {
    $categories = $this->model->findAll();

    $this->render('categories', ['categories' => $categories]);
  }

  public function debug()
  {

    $this->render('home', ['category' => 'rien']);
  }
}
