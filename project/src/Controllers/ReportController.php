<?php

namespace App\Controllers;

use App\Service\CarService;
use App\Utils\ReportGenerator;
use App\Views\View;

/**
 * @author fakedesyncc
 */
class ReportController
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
        $cars = $this->carService->getAll(1, 1000);
        
        $this->view->render('reports/index', [
            'cars' => $cars,
            'title' => 'Генерация отчетов'
        ]);
    }

    public function generate(string $format): void
    {
        $cars = $this->carService->getAll(1, 1000);
        
        $headers = ['ID', 'Марка', 'Модель', 'Цена (руб.)', 'Год', 'Цвет', 'Дата добавления'];
        $data = [];
        
        foreach ($cars as $car) {
            $data[] = [
                $car['id'] ?? '',
                $car['brand'] ?? '',
                $car['model'] ?? '',
                number_format((float)($car['price'] ?? 0), 2, '.', ' '),
                $car['year'] ?? '',
                $car['color'] ?? '',
                $car['created_at'] ?? ''
            ];
        }
        
        $filename = 'cars_report_' . date('Y-m-d_H-i-s');
        
        switch ($format) {
            case 'csv':
                ReportGenerator::generateCsv($data, $headers, $filename . '.csv');
                break;
                
            case 'excel':
                ReportGenerator::generateExcel($data, $headers, $filename . '.xlsx');
                break;
                
            case 'pdf':
                ReportGenerator::generatePdf($data, $headers, $filename . '.pdf', 'Отчет по автомобилям');
                break;
                
            default:
                header('Location: /reports');
                exit;
        }
    }
}
