<?php

namespace App\Controllers;

use App\Service\UserService;
use App\Validation\UserValidator;
use App\Helpers\CsrfHelper;
use App\Session;
use App\Views\View;

/**
 * @author fakedesyncc
 */
class AuthController
{
    private UserService $userService;
    private View $view;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->view = new View();
    }

    public function login(): void
    {
        if (Session::isLoggedIn()) {
            header('Location: /profile');
            exit;
        }

        $this->view->render('auth/login', [
            'title' => 'Вход в систему'
        ]);
    }

    public function authenticate(): void
    {
        if (!CsrfHelper::validateRequest()) {
            $this->view->render('auth/login', [
                'error' => 'Недействительный токен безопасности',
                'errors' => ['csrf' => 'Недействительный токен безопасности'],
                'title' => 'Вход в систему'
            ]);
            return;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userService->authenticate($username, $password);

        if ($user) {
            Session::set('user_id', $user['id']);
            Session::set('username', $user['username']);
            Session::set('email', $user['email']);
            Session::set('role', $user['role'] ?? 'user');
            
            header('Location: /profile');
            exit;
        }

        $this->view->render('auth/login', [
            'error' => 'Неверное имя пользователя или пароль',
            'errors' => ['auth' => 'Неверное имя пользователя или пароль'],
            'data' => ['username' => $username],
            'title' => 'Вход в систему'
        ]);
    }

    public function register(): void
    {
        if (Session::isLoggedIn()) {
            header('Location: /profile');
            exit;
        }

        $this->view->render('auth/register', [
            'title' => 'Регистрация'
        ]);
    }

    public function store(): void
    {
        if (!CsrfHelper::validateRequest()) {
            $this->view->render('auth/register', [
                'error' => 'Недействительный токен безопасности',
                'errors' => ['csrf' => 'Недействительный токен безопасности'],
                'title' => 'Регистрация'
            ]);
            return;
        }

        $data = UserValidator::sanitize($_POST);
        $errors = UserValidator::validateRegistration($data);

        if (empty($errors)) {
            try {
                $user = $this->userService->register($data);
                
                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);
                Session::set('email', $user['email']);
                Session::set('role', $user['role'] ?? 'user');
                
                header('Location: /profile');
                exit;
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            $error = 'Исправьте ошибки в форме';
        }

        $this->view->render('auth/register', [
            'error' => $error ?? null,
            'errors' => $errors,
            'data' => $data,
            'title' => 'Регистрация'
        ]);
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: /auth/login');
        exit;
    }
}
