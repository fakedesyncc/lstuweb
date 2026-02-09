<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Session;
use App\Views\View;
use App\Helpers\CsrfHelper;
use App\Validation\UserValidator;

/**
 * @author fakedesyncc
 */
class AuthController
{
    private UserModel $userModel;
    private View $view;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->view = new View();
        Session::start();
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateRequest()) {
                $this->view->render('auth/register', [
                    'error' => 'Недействительный токен безопасности',
                    'errors' => ['csrf' => 'Недействительный токен безопасности']
                ]);
                return;
            }

            $data = UserValidator::sanitize($_POST);
            $errors = UserValidator::validateRegistration($data);
            
            if (empty($errors)) {
                if ($this->userModel->findByUsername($data['username'])) {
                    $errors['username'] = 'Пользователь с таким именем уже существует';
                } elseif ($this->userModel->findByEmail($data['email'])) {
                    $errors['email'] = 'Пользователь с таким email уже существует';
                } else {
                    if ($this->userModel->create([
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'password' => $data['password'],
                        'role' => 'user'
                    ])) {
                        header('Location: /labs5/index.php?action=login&registered=1');
                        exit;
                    } else {
                        $errors['save'] = 'Ошибка при регистрации';
                    }
                }
            }
            
            $this->view->render('auth/register', [
                'error' => !empty($errors) ? 'Исправьте ошибки в форме' : null,
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }
        
        $this->view->render('auth/register');
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateRequest()) {
                $this->view->render('auth/login', [
                    'error' => 'Недействительный токен безопасности',
                    'errors' => ['csrf' => 'Недействительный токен безопасности']
                ]);
                return;
            }

            $data = UserValidator::sanitize($_POST);
            $errors = UserValidator::validateLogin($data);
            
            if (empty($errors)) {
                $user = $this->userModel->findByUsername($data['username']);
                
                if ($user && password_verify($data['password'], $user['password'])) {
                    Session::set('user_id', $user['id']);
                    Session::set('username', $user['username']);
                    Session::set('email', $user['email']);
                    Session::set('role', $user['role']);
                    
                    header('Location: /labs5/index.php?action=profile');
                    exit;
                } else {
                    $errors['auth'] = 'Неверное имя пользователя или пароль';
                }
            }
            
            $this->view->render('auth/login', [
                'error' => !empty($errors) ? 'Исправьте ошибки в форме' : null,
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }
        
        $registered = isset($_GET['registered']) ? 'Регистрация успешна! Войдите в систему.' : null;
        $this->view->render('auth/login', ['message' => $registered]);
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: /labs5/index.php?action=login');
        exit;
    }
}
