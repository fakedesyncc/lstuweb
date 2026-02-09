<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CarModel;
use App\Session;
use App\Views\View;

/**
 * @author fakedesyncc
 */
class ProfileController
{
    private UserModel $userModel;
    private CarModel $carModel;
    private View $view;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->carModel = new CarModel();
        $this->view = new View();
        Session::start();
        
        if (!Session::isLoggedIn()) {
            header('Location: /labs5/index.php?action=login');
            exit;
        }
    }

    public function index(): void
    {
        $user = Session::getUser();
        
        if ($user === null || !isset($user['id'])) {
            header('Location: /labs5/index.php?action=login');
            exit;
        }
        
        $userData = $this->userModel->getById($user['id']);
        $cars = $this->carModel->getByUserId($user['id']);
        
        $this->view->render('profile/index', [
            'user' => $userData,
            'cars' => $cars
        ]);
    }
}
