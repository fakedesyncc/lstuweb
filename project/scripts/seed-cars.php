<?php
/**
 * Скрипт для добавления тестовых данных автомобилей в базу данных
 * ТОЛЬКО РУССКИЕ МАРКИ: ВАЗ, УАЗ, ГАЗ, Волга
 * 
 * @author fakedesyncc
 */

require_once __DIR__ . '/../src/bootstrap.php';

use App\Repository\CarRepository;

try {
    $repository = new CarRepository();
    
    // ТОЛЬКО РУССКИЕ АВТОМОБИЛИ
    $testCars = [
        // ВАЗ - Классика
        [
            'brand' => 'ВАЗ',
            'model' => '2101',
            'price' => 150000,
            'year' => 1975,
            'color' => 'Бежевый',
            'image_url' => '/images/cars/vaz-2101.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2103',
            'price' => 180000,
            'year' => 1978,
            'color' => 'Белый',
            'image_url' => '/images/cars/vaz-2103.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2105',
            'price' => 200000,
            'year' => 1985,
            'color' => 'Красный',
            'image_url' => '/images/cars/vaz-2105.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2106',
            'price' => 220000,
            'year' => 1990,
            'color' => 'Синий',
            'image_url' => '/images/cars/vaz-2106.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2107',
            'price' => 250000,
            'year' => 1995,
            'color' => 'Черный',
            'image_url' => '/images/cars/vaz-2107.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2109',
            'price' => 280000,
            'year' => 2000,
            'color' => 'Белый',
            'image_url' => '/images/cars/vaz-2109.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2110',
            'price' => 320000,
            'year' => 2005,
            'color' => 'Серебристый',
            'image_url' => '/images/cars/vaz-2110.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2114',
            'price' => 350000,
            'year' => 2010,
            'color' => 'Красный',
            'image_url' => '/images/cars/vaz-2114.jpg'
        ],
        [
            'brand' => 'ВАЗ',
            'model' => '2115',
            'price' => 380000,
            'year' => 2012,
            'color' => 'Серый',
            'image_url' => '/images/cars/vaz-2115.jpg'
        ],
        
        // ВАЗ - Современные модели
        [
            'brand' => 'LADA',
            'model' => 'Granta',
            'price' => 650000,
            'year' => 2023,
            'color' => 'Белый',
            'image_url' => '/images/cars/lada-granta.jpg'
        ],
        [
            'brand' => 'LADA',
            'model' => 'Vesta',
            'price' => 1200000,
            'year' => 2024,
            'color' => 'Серый металлик',
            'image_url' => '/images/cars/lada-vesta.jpg'
        ],
        [
            'brand' => 'LADA',
            'model' => 'Priora',
            'price' => 750000,
            'year' => 2020,
            'color' => 'Черный',
            'image_url' => '/images/cars/lada-priora.jpg'
        ],
        [
            'brand' => 'LADA',
            'model' => 'Iskra',
            'price' => 850000,
            'year' => 2024,
            'color' => 'Оранжевый',
            'image_url' => '/images/cars/lada-iskra.jpg'
        ],
        [
            'brand' => 'LADA',
            'model' => 'Niva',
            'price' => 1500000,
            'year' => 2024,
            'color' => 'Красный',
            'image_url' => '/images/cars/lada-niva.jpg'
        ],
        [
            'brand' => 'LADA',
            'model' => 'Niva Travel',
            'price' => 1800000,
            'year' => 2024,
            'color' => 'Белый',
            'image_url' => '/images/cars/lada-niva-travel.jpg'
        ],
        [
            'brand' => 'LADA',
            'model' => 'Largus',
            'price' => 1100000,
            'year' => 2023,
            'color' => 'Серый',
            'image_url' => '/images/cars/lada-largus.jpg'
        ],
        [
            'brand' => 'LADA',
            'model' => 'XRAY',
            'price' => 1400000,
            'year' => 2024,
            'color' => 'Синий',
            'image_url' => '/images/cars/lada-xray.jpg'
        ],
        
        // УАЗ
        [
            'brand' => 'УАЗ',
            'model' => 'Патриот',
            'price' => 2500000,
            'year' => 2024,
            'color' => 'Белый',
            'image_url' => '/images/cars/uaz-patriot.jpg'
        ],
        [
            'brand' => 'УАЗ',
            'model' => 'Хантер',
            'price' => 1800000,
            'year' => 2023,
            'color' => 'Зеленый',
            'image_url' => '/images/cars/uaz-hunter.jpg'
        ],
        [
            'brand' => 'УАЗ',
            'model' => 'Буханка',
            'price' => 1200000,
            'year' => 2022,
            'color' => 'Бежевый',
            'image_url' => '/images/cars/uaz-bukanka.jpg'
        ],
        
        // ГАЗ
        [
            'brand' => 'ГАЗ',
            'model' => 'Газель Next',
            'price' => 2200000,
            'year' => 2024,
            'color' => 'Белый',
            'image_url' => '/images/cars/gaz-gazel-next.jpg'
        ],
        [
            'brand' => 'ГАЗ',
            'model' => 'Соболь',
            'price' => 1800000,
            'year' => 2023,
            'color' => 'Серый',
            'image_url' => '/images/cars/gaz-sobol.jpg'
        ],
        
        // Волга
        [
            'brand' => 'Волга',
            'model' => 'ГАЗ-21',
            'price' => 800000,
            'year' => 1970,
            'color' => 'Черный',
            'image_url' => '/images/cars/volga-21.jpg'
        ],
        [
            'brand' => 'Волга',
            'model' => 'ГАЗ-24',
            'price' => 950000,
            'year' => 1980,
            'color' => 'Белый',
            'image_url' => '/images/cars/volga-24.jpg'
        ],
        [
            'brand' => 'Волга',
            'model' => 'ГАЗ-3102',
            'price' => 1200000,
            'year' => 1995,
            'color' => 'Черный',
            'image_url' => '/images/cars/volga-3102.jpg'
        ],
        [
            'brand' => 'Волга',
            'model' => 'ГАЗ-3110',
            'price' => 1500000,
            'year' => 2000,
            'color' => 'Серебристый',
            'image_url' => '/images/cars/volga-3110.jpg'
        ],
        [
            'brand' => 'Волга',
            'model' => 'ГАЗ-31105',
            'price' => 1800000,
            'year' => 2010,
            'color' => 'Черный',
            'image_url' => '/images/cars/volga-31105.jpg'
        ]
    ];
    
    // Очищаем старые данные (иностранные марки)
    $db = \App\Database\Database::getConnection();
    $db->exec("DELETE FROM cars WHERE brand NOT IN ('ВАЗ', 'LADA', 'УАЗ', 'ГАЗ', 'Волга')");
    
    $added = 0;
    $skipped = 0;
    
    foreach ($testCars as $carData) {
        // Проверяем, существует ли уже такой автомобиль
        $existing = $repository->findByBrandAndModel($carData['brand'], $carData['model']);
        
        if (empty($existing)) {
            $result = $repository->create($carData);
            if ($result) {
                $added++;
                echo "✓ Добавлен: {$carData['brand']} {$carData['model']}\n";
            }
        } else {
            $skipped++;
            echo "- Пропущен (уже существует): {$carData['brand']} {$carData['model']}\n";
        }
    }
    
    echo "\n";
    echo "✅ Добавлено автомобилей: $added\n";
    echo "⏭ Пропущено (уже существуют): $skipped\n";
    echo "📊 Всего в базе: " . count($repository->findAll()) . "\n";
    echo "🇷🇺 Только русские автомобили!\n";
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
    exit(1);
}
