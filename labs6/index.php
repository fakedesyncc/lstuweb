<?php
require_once __DIR__ . '/../project/src/bootstrap.php';
require_once __DIR__ . '/src/Models/CarModel.php';
require_once __DIR__ . '/src/Controllers/ReportController.php';
require_once __DIR__ . '/src/Views/View.php';
require_once __DIR__ . '/../project/src/Repository/CarRepository.php';

use App\Controllers\ReportController;

$action = $_GET['action'] ?? 'index';
$controller = new ReportController();

if ($action === 'generate' && isset($_GET['format'])) {
    $controller->generate($_GET['format']);
} else {
    $controller->index();
}
