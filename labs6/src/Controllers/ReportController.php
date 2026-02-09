<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Utils\ReportGenerator;
use App\Views\View;

/**
 * @author fakedesyncc
 */
class ReportController
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
        $cars = $this->carModel->getAll();
        $this->view->render('reports/index', ['cars' => $cars]);
    }

    public function generate(string $format): void
    {
        $cars = $this->carModel->getAll();
        
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
                header('Location: /labs6/index.php');
                exit;
        }
    }
}
