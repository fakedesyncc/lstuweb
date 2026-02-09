<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Views\View;
use App\Helpers\CsrfHelper;
use App\Validation\CarValidator;

/**
 * @author fakedesyncc
 */
class CarController
{
    private CarModel $carModel;
    private View $view;

    public function __construct()
    {
        $this->carModel = new CarModel();
        $this->view = new View();
    }

    public function index(): void
    {
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 10;
        
        $criteria = [];
        if (!empty($_GET['brand'])) {
            $criteria['brand'] = $_GET['brand'];
        }
        if (!empty($_GET['model'])) {
            $criteria['model'] = $_GET['model'];
        }
        
        if (!empty($criteria)) {
            $cars = $this->carModel->search($criteria, $page, $perPage);
        } else {
            $cars = $this->carModel->getAll($page, $perPage);
        }
        
        $this->view->render('cars/index', [
            'cars' => $cars,
            'page' => $page,
            'criteria' => $criteria,
            'title' => 'Лабораторная 4 - MVC Архитектура'
        ]);
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CsrfHelper::validateRequest()) {
                $this->view->render('cars/create', [
                    'error' => 'Недействительный токен безопасности',
                    'errors' => ['csrf' => 'Недействительный токен безопасности']
                ]);
                return;
            }

            $data = CarValidator::sanitize($_POST);
            $errors = CarValidator::validate($data);
            
            if (empty($errors)) {
                if ($this->carModel->create($data)) {
                    header('Location: /labs4/index.php?action=index');
                    exit;
                } else {
                    $error = 'Ошибка при сохранении данных';
                }
            } else {
                $error = 'Исправьте ошибки в форме';
            }
            
            $this->view->render('cars/create', [
                'error' => $error ?? null,
                'errors' => $errors,
                'data' => $data
            ]);
            return;
        }
        
        $this->view->render('cars/create');
    }

    public function show(array $params): void
    {
        $id = isset($params['id']) ? (int)$params['id'] : null;
        if ($id !== null && $id > 0) {
            $car = $this->carModel->getById($id);
            if ($car !== null) {
                $this->view->render('cars/show', ['car' => $car]);
                return;
            }
        }
        header('Location: /labs4/index.php?action=index');
        exit;
    }

}
