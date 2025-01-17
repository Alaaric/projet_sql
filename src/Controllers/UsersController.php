<?php

namespace App\Controllers;

use App\Models\User;

class UsersController extends AbstractController
{

    protected User $model;
    public function __construct()
    {
        $this->model = new User();
    }
    public function index()
    {
        $users =  $this->model->findAll();

        $this->render('users', ['users' => $users]);
    }
}
