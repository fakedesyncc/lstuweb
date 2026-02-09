<?php
require_once __DIR__ . '/../project/src/bootstrap.php';

use App\Utils\CsvHandler;
use App\Helpers\CsrfHelper;
use App\Validation\CarValidator;

$title = 'Добавление автомобиля';
$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CsrfHelper::validateRequest()) {
        $errors['csrf'] = 'Недействительный токен безопасности';
    } else {
        $data = CarValidator::sanitize($_POST);
        $validationErrors = CarValidator::validate($data);
        
        if (empty($validationErrors)) {
            $csvFile = __DIR__ . '/cars.csv';
            $headers = ['brand', 'model', 'price', 'year', 'color'];
            $csvData = [$data['brand'], $data['model'], $data['price'], $data['year'], $data['color']];
            
            if (CsvHandler::writeToCsv($csvFile, $csvData, $headers)) {
                $message = 'Автомобиль успешно добавлен!';
            } else {
                $errors['save'] = 'Ошибка при сохранении данных';
            }
        } else {
            $errors = $validationErrors;
        }
    }
}

$cars = [];
$csvFile = __DIR__ . '/cars.csv';
if (file_exists($csvFile)) {
    $cars = CsvHandler::readFromCsv($csvFile);
}

ob_start();
?>

<div class="card">
    <h2>Добавление автомобиля в CSV</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <?= CsrfHelper::field() ?>
        <?php if (isset($errors['csrf'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($errors['csrf']) ?></div>
        <?php endif; ?>
        <?php if (isset($errors['save'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($errors['save']) ?></div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="brand">Марка *</label>
            <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($_POST['brand'] ?? '') ?>" required>
            <?php if (isset($errors['brand'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['brand']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="model">Модель *</label>
            <input type="text" id="model" name="model" value="<?= htmlspecialchars($_POST['model'] ?? '') ?>" required>
            <?php if (isset($errors['model'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['model']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="price">Цена (руб.) *</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
            <?php if (isset($errors['price'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['price']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="year">Год выпуска *</label>
            <input type="number" id="year" name="year" min="1900" max="<?= date('Y') + 1 ?>" value="<?= htmlspecialchars($_POST['year'] ?? '') ?>" required>
            <?php if (isset($errors['year'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['year']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="color">Цвет</label>
            <input type="text" id="color" name="color" value="<?= htmlspecialchars($_POST['color'] ?? '') ?>">
            <?php if (isset($errors['color'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['color']) ?></div>
            <?php endif; ?>
        </div>
        
        <button type="submit" class="btn">Добавить автомобиль</button>
    </form>
</div>

<?php if (!empty($cars)): ?>
    <div class="card">
        <h2>Список автомобилей</h2>
        <table>
            <thead>
                <tr>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Цена</th>
                    <th>Год</th>
                    <th>Цвет</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($car['brand'] ?? '') ?></strong></td>
                        <td><?= htmlspecialchars($car['model'] ?? '') ?></td>
                        <td><strong style="color: var(--accent-color);"><?= number_format($car['price'] ?? 0, 0, '.', ' ') ?> ₽</strong></td>
                        <td><?= htmlspecialchars($car['year'] ?? '') ?></td>
                        <td><?= htmlspecialchars($car['color'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../project/public/layout.php';
?>
