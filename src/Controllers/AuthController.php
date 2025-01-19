<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Entities\User;
use Exception;
use App\Exceptions\UserModelException;

class AuthController extends AbstractController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
        try {
            $data = $_POST;

            if (empty($data['name']) || empty($data['firstname']) || empty($data['email']) || empty($data['password']) || $data['password'] !== $data['confirm_password']) {
                $this->render('register', ['isRegister' => true, 'data' => $data, 'error' => 'Veuillez remplir tous les champs correctement.']);
                return;
            }

            if (!$this->isStrongPassword($data['password'])) {
                $this->render('register', ['isRegister' => true, 'data' => $data, 'error' => 'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.']);
                return;
            }

            $user = new User(
                '',
                $data['name'],
                $data['firstname'],
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                'client'
            );

            $this->userModel->create($user);

            $this->render('login', ['success' => 'Inscription réussie. Vous pouvez maintenant vous connecter.']);
            exit();
        } catch (UserModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de l\'inscription. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de l\'inscription.']);
        }
    }

    public function login()
    {
        try {
            $data = $_POST;

            if (empty($data['email']) || empty($data['password'])) {
                $this->render('login', ['error' => 'Veuillez remplir tous les champs correctement.']);
                return;
            }

            $user = $this->userModel->findByEmail($data['email']);

            if ($user && password_verify($data['password'], $user->getPassword())) {
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'role' => $user->getRole(),
                ];

                $this->redirect('/');
                exit();
            }

            $this->render('login', ['error' => 'Email ou mot de passe incorrect.']);
        } catch (UserModelException $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la connexion. Veuillez vérifier la connexion à la base de données.']);
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur inattendue est survenue lors de la connexion.']);
        }
    }

    public function logout()
    {
        try {
            session_unset();
            session_destroy();
            $this->render('login');
            exit();
        } catch (Exception $e) {
            $this->render('error', ['message' => 'Une erreur est survenue lors de la déconnexion.']);
        }
    }

    private function isStrongPassword(string $password): bool
    {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        return preg_match($pattern, $password) === 1;
    }
}