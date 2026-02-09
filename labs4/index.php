<?php
/**
 * Лабораторная работа 4: MVC Архитектура
 * Демонстрация работы MVC паттерна
 * 
 * @author fakedesyncc
 */

require_once __DIR__ . '/../project/src/bootstrap.php';
require_once __DIR__ . '/src/Router.php';
require_once __DIR__ . '/src/Controllers/CarController.php';
require_once __DIR__ . '/src/Models/CarModel.php';
require_once __DIR__ . '/src/Views/View.php';
require_once __DIR__ . '/../project/src/Repository/CarRepository.php';

use App\Controllers\CarController;

$title = 'MVC Архитектура - Лабораторная 4';
$action = $_GET['action'] ?? 'index';
$controller = new CarController();

if ($action === 'show' && isset($_GET['id'])) {
    $controller->show(['id' => (int)$_GET['id']]);
} elseif ($action === 'create') {
    $controller->create();
} else {
    $controller->index();
}
