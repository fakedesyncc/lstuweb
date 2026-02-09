<?php
require_once __DIR__ . '/../project/src/bootstrap.php';
require_once __DIR__ . '/src/Session.php';
require_once __DIR__ . '/src/Models/UserModel.php';
require_once __DIR__ . '/src/Models/CarModel.php';
require_once __DIR__ . '/src/Controllers/AuthController.php';
require_once __DIR__ . '/src/Controllers/ProfileController.php';
require_once __DIR__ . '/src/Views/View.php';
require_once __DIR__ . '/../project/src/Repository/UserRepository.php';
require_once __DIR__ . '/../project/src/Repository/CarRepository.php';

use App\Session;
use App\Controllers\AuthController;
use App\Controllers\ProfileController;

$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'register':
        (new AuthController())->register();
        break;
        
    case 'login':
        (new AuthController())->login();
        break;
        
    case 'logout':
        (new AuthController())->logout();
        break;
        
    case 'profile':
        (new ProfileController())->index();
        break;
        
    default:
        header('Location: /labs5/index.php?action=login');
        exit;
}
