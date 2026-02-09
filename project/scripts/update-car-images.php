<?php

require_once __DIR__ . '/../src/bootstrap.php';

use App\Repository\CarRepository;

$repository = new CarRepository();
$cars = $repository->findAll();

$imageMap = [
    'ВАЗ-2101' => '/images/cars/vaz-2101.jpg',
    'ВАЗ-2103' => '/images/cars/vaz-2103.jpg',
    'ВАЗ-2105' => '/images/cars/vaz-2105.jpg',
    'ВАЗ-2106' => '/images/cars/vaz-2106.jpg',
    'ВАЗ-2107' => '/images/cars/vaz-2107.jpg',
    'ВАЗ-2109' => '/images/cars/vaz-2109.jpg',
    'ВАЗ-2110' => '/images/cars/vaz-2110.jpg',
    'ВАЗ-2114' => '/images/cars/vaz-2114.jpg',
    'ВАЗ-2115' => '/images/cars/vaz-2115.jpg',
    'LADA-Granta' => '/images/cars/lada-granta.jpg',
    'LADA-Vesta' => '/images/cars/lada-vesta.jpg',
    'LADA-Priora' => '/images/cars/lada-priora.jpg',
    'LADA-Iskra' => '/images/cars/lada-iskra.jpg',
    'LADA-Niva' => '/images/cars/lada-niva.jpg',
    'LADA-Niva Travel' => '/images/cars/lada-niva-travel.jpg',
    'LADA-Largus' => '/images/cars/lada-largus.jpg',
    'LADA-XRAY' => '/images/cars/lada-xray.jpg',
    'УАЗ-Патриот' => '/images/cars/uaz-patriot.jpg',
    'УАЗ-Хантер' => '/images/cars/uaz-hunter.jpg',
    'УАЗ-Буханка' => '/images/cars/uaz-bukanka.jpg',
    'ГАЗ-Газель Next' => '/images/cars/gaz-gazel-next.jpg',
    'ГАЗ-Соболь' => '/images/cars/gaz-sobol.jpg',
    'Волга-ГАЗ-21' => '/images/cars/volga-21.jpg',
    'Волга-ГАЗ-24' => '/images/cars/volga-24.jpg',
    'Волга-ГАЗ-3102' => '/images/cars/volga-3102.jpg',
    'Волга-ГАЗ-3110' => '/images/cars/volga-3110.jpg',
    'Волга-ГАЗ-31105' => '/images/cars/volga-31105.jpg',
];

$updated = 0;
foreach ($cars as $car) {
    $key = $car['brand'] . '-' . $car['model'];
    $imageUrl = $imageMap[$key] ?? '/images/cars/placeholder.jpg';
    
    $repository->update($car['id'], ['image_url' => $imageUrl]);
    $updated++;
    echo "Updated: {$car['brand']} {$car['model']} -> {$imageUrl}\n";
}

echo "\nUpdated {$updated} cars\n";
