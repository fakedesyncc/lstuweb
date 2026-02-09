<?php
require_once __DIR__ . '/../project/src/bootstrap.php';

use App\Database\Database;

$title = 'Работа с базой данных';
$message = '';
$error = '';

try {
    $db = Database::getConnection();
    
    $csvFile = __DIR__ . '/../labs2/cars.csv';
    if (file_exists($csvFile) && isset($_GET['migrate'])) {
        require_once __DIR__ . '/../project/src/Utils/CsvHandler.php';
        $cars = \App\Utils\CsvHandler::readFromCsv($csvFile);
        if (!empty($cars)) {
            $stmt = $db->prepare("INSERT INTO cars (brand, model, price, year, color) VALUES (?, ?, ?, ?, ?)");
            
            foreach ($cars as $car) {
                $stmt->execute([
                    $car['brand'] ?? '',
                    $car['model'] ?? '',
                    (float)($car['price'] ?? 0),
                    (int)($car['year'] ?? 0),
                    $car['color'] ?? ''
                ]);
            }
            $message = 'Данные успешно перенесены из CSV в MySQL!';
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $brand = trim($_POST['brand'] ?? '');
        $model = trim($_POST['model'] ?? '');
        $price = filter_var($_POST['price'] ?? 0, FILTER_VALIDATE_FLOAT);
        $year = filter_var($_POST['year'] ?? 0, FILTER_VALIDATE_INT);
        $color = trim($_POST['color'] ?? '');
        
        if (!empty($brand) && !empty($model) && $price !== false && $price > 0 && $year !== false && $year >= 1900) {
            $stmt = $db->prepare("INSERT INTO cars (brand, model, price, year, color) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$brand, $model, $price, $year, $color])) {
                $message = 'Автомобиль успешно добавлен в базу данных!';
            } else {
                $error = 'Ошибка при сохранении данных';
            }
        } else {
            $error = 'Заполните все обязательные поля корректно';
        }
    }
    
    $stmt = $db->query("SELECT * FROM cars ORDER BY created_at DESC");
    $cars = $stmt->fetchAll();
    
} catch (Exception $e) {
    $error = 'Ошибка подключения к базе данных: ' . $e->getMessage();
    $cars = [];
}

ob_start();
?>

<div class="card">
    <h2>Работа с базой данных MySQL</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="brand">Марка *</label>
            <input type="text" id="brand" name="brand" required>
        </div>
        
        <div class="form-group">
            <label for="model">Модель *</label>
            <input type="text" id="model" name="model" required>
        </div>
        
        <div class="form-group">
            <label for="price">Цена (руб.) *</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required>
        </div>
        
        <div class="form-group">
            <label for="year">Год выпуска *</label>
            <input type="number" id="year" name="year" min="1900" max="<?= date('Y') + 1 ?>" required>
        </div>
        
        <div class="form-group">
            <label for="color">Цвет</label>
            <input type="text" id="color" name="color">
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn">Добавить автомобиль</button>
            <a href="?migrate=1" class="btn btn-secondary">Перенести данные из CSV</a>
        </div>
    </form>
</div>

<?php if (!empty($cars)): ?>
    <div class="card">
        <h2>Список автомобилей из базы данных</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Цена</th>
                    <th>Год</th>
                    <th>Цвет</th>
                    <th>Дата добавления</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><?= htmlspecialchars($car['id'] ?? '') ?></td>
                        <td><strong><?= htmlspecialchars($car['brand'] ?? '') ?></strong></td>
                        <td><?= htmlspecialchars($car['model'] ?? '') ?></td>
                        <td><strong style="color: var(--accent-color);"><?= number_format($car['price'] ?? 0, 0, '.', ' ') ?> ₽</strong></td>
                        <td><?= htmlspecialchars($car['year'] ?? '') ?></td>
                        <td><?= htmlspecialchars($car['color'] ?? '') ?></td>
                        <td><?= htmlspecialchars($car['created_at'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card">
        <div class="alert alert-info">
            <p>База данных пуста. Добавьте автомобили или перенесите данные из CSV.</p>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../project/public/layout.php';
?>
