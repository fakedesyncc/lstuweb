<div class="card">
    <h2>Информация об автомобиле</h2>

    <?php if ($car): ?>
        <?php 
        $imageUrl = $car['image_url'] ?? '/images/cars/' . strtolower(str_replace([' ', '-'], '-', $car['brand'] ?? '')) . '-' . strtolower(str_replace([' ', '-'], '-', $car['model'] ?? '')) . '.jpg';
        if (empty($car['image_url'])) {
            $imageUrl = '/images/cars/placeholder.jpg';
        }
        ?>
        <div style="margin-bottom: 3rem; text-align: center; background: rgba(255,255,255,0.02); padding: 2rem; border-radius: 12px;">
            <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>" style="max-width: 100%; max-height: 600px; width: auto; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.6);" onerror="this.src='/images/cars/placeholder.jpg'">
        </div>
        
        <table>
            <tbody>
                <tr>
                    <th style="width: 200px;">ID</th>
                    <td><?= htmlspecialchars($car['id'] ?? '') ?></td>
                </tr>
                <tr>
                    <th>Марка</th>
                    <td><strong><?= htmlspecialchars($car['brand'] ?? '') ?></strong></td>
                </tr>
                <tr>
                    <th>Модель</th>
                    <td><?= htmlspecialchars($car['model'] ?? '') ?></td>
                </tr>
                <tr>
                    <th>Цена</th>
                    <td><strong style="color: var(--avtovaz-orange); font-size: 1.2rem;"><?= number_format($car['price'] ?? 0, 0, '.', ' ') ?> ₽</strong></td>
                </tr>
                <tr>
                    <th>Год выпуска</th>
                    <td><?= htmlspecialchars($car['year'] ?? '') ?></td>
                </tr>
                <tr>
                    <th>Цвет</th>
                    <td><?= htmlspecialchars($car['color'] ?? '') ?></td>
                </tr>
                <tr>
                    <th>Дата добавления</th>
                    <td><?= htmlspecialchars($car['created_at'] ?? '') ?></td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 2rem;">
            <a href="/cars" class="btn btn-secondary">← Вернуться к списку</a>
        </div>
    <?php else: ?>
        <div class="alert alert-error">
            <p>Автомобиль не найден.</p>
        </div>
        <a href="/cars" class="btn btn-secondary">← Вернуться к списку</a>
    <?php endif; ?>
</div>
