?>

<div class="card">
    <div class="alert alert-info">
        <p><strong>Выберите формат</strong> для генерации отчета по автомобилям:</p>
    </div>
    
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin: 2rem 0;">
        <a href="/reports/generate/csv" class="btn btn-success">📊 Скачать CSV</a>
        <a href="/reports/generate/excel" class="btn" style="background: linear-gradient(135deg, #2196F3, #1976D2);">📈 Скачать Excel</a>
        <a href="/reports/generate/pdf" class="btn btn-danger">📄 Скачать PDF</a>
    </div>
</div>

<div class="card">
    <h2>Данные для отчета</h2>
    
    <?php if (!empty($cars)): ?>
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
        
        <div class="stats" style="margin-top: 2rem;">
            <div class="stat-card">
                <h3><?= count($cars) ?></h3>
                <p>Всего автомобилей</p>
            </div>
            <div class="stat-card">
                <h3><?= number_format(array_sum(array_column($cars, 'price')) / count($cars), 0, '.', ' ') ?> ₽</h3>
                <p>Средняя цена</p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Нет данных для отчета. Добавьте автомобили в системе.</p>
        </div>
    <?php endif; ?>
</div>

