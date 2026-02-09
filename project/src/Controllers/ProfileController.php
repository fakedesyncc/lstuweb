<?php

namespace App\Controllers;

use App\Session;
use App\Service\UserService;
use App\Service\CarService;
use App\Views\View;

/**
 * @author fakedesyncc
 */
class ProfileController
{
    private UserService $userService;
    private CarService $carService;
    private View $view;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->carService = new CarService();
        $this->view = new View();
    }

    public function index(): void
    {
        if (!Session::isLoggedIn()) {
            header('Location: /auth/login');
            exit;
        }

        $userId = Session::get('user_id');
        $userData = $this->userService->getById($userId);
        $cars = $this->carService->getByUserId($userId);

        $this->view->render('profile/index', [
            'userData' => $userData,
            'cars' => $cars,
            'title' => 'Личный кабинет'
        ]);
    }
}
