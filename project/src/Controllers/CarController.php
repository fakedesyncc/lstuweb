<?php

namespace App\Controllers;

use App\Service\CarService;
use App\Validation\CarValidator;
use App\Helpers\CsrfHelper;
use App\Views\View;

/**
 * @author fakedesyncc
 */
class CarController
{
    private CarService $carService;
    private View $view;

    public function __construct()
    {
        $this->carService = new CarService();
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
        
        $cars = $this->carService->search($criteria, $page, $perPage);
        $pagination = $this->carService->getPaginationInfo($page, $perPage, $criteria);
        
        $this->view->render('cars/index', [
            'cars' => $cars,
            'page' => $page,
            'criteria' => $criteria,
            'pagination' => $pagination,
            'title' => 'Список автомобилей'
        ]);
    }

    public function create(): void
    {
        $this->view->render('cars/create', [
            'title' => 'Добавление автомобиля'
        ]);
    }

    public function store(): void
    {
        if (!CsrfHelper::validateRequest()) {
            $this->view->render('cars/create', [
                'error' => 'Недействительный токен безопасности',
                'errors' => ['csrf' => 'Недействительный токен безопасности'],
                'title' => 'Добавление автомобиля'
            ]);
            return;
        }

        $data = CarValidator::sanitize($_POST);
        $errors = CarValidator::validate($data);
        
        if (empty($errors)) {
            try {
                $car = $this->carService->create($data);
                header('Location: /cars');
                exit;
            } catch (\Exception $e) {
                $error = 'Ошибка при сохранении данных: ' . $e->getMessage();
            }
        } else {
            $error = 'Исправьте ошибки в форме';
        }
        
        $this->view->render('cars/create', [
            'error' => $error ?? null,
            'errors' => $errors,
            'data' => $data,
            'title' => 'Добавление автомобиля'
        ]);
    }

    public function show(int $id): void
    {
        $car = $this->carService->getById($id);
        
        if (!$car) {
            http_response_code(404);
            echo 'Автомобиль не найден';
            return;
        }
        
        $this->view->render('cars/show', [
            'car' => $car,
            'title' => 'Просмотр автомобиля'
        ]);
    }
}
