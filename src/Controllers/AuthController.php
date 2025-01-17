<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends AbstractController
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showRegisterForm()
    {
        $this->render('register', ['isRegister' => true]);
    }

    public function showLoginForm()
    {
        $this->render('login');
    }

    public function register()
    {
        $data = $_POST;

        if (empty($data['name']) || empty($data['firstname']) || empty($data['email']) || empty($data['password']) || $data['password'] !== $data['confirm_password']) {
            $this->render('register', ['isRegister' => true, 'data' => $data, 'error' => 'Veuillez remplir tous les champs correctement.']);
            return;
        }

        $this->userModel->create([
            'name' => $data['name'],
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'role' => 'client',
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        $this->render('login', ['success' => 'Inscription réussie. Vous pouvez maintenant vous connecter.']);
        exit();
    }

    public function login()
    {
        $data = $_POST;

        if (empty($data['email']) || empty($data['password'])) {
            $this->render('login', ['error' => 'Veuillez remplir tous les champs correctement.']);
            return;
        }


        $user = $this->userModel->findByEmail($data['email']);

        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => $user['role'],
            ];

            $this->redirect('/');
            exit();
        }

        $this->render('login', ['error' => 'Email ou mot de passe incorrect.']);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->render('login');
        exit();
    }
}
