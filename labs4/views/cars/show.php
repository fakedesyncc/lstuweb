<div class="card">
    <h2>Информация об автомобиле</h2>

    <?php if ($car): ?>
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
                    <td><strong style="color: var(--accent-color); font-size: 1.2rem;"><?= number_format($car['price'] ?? 0, 0, '.', ' ') ?> ₽</strong></td>
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
            <a href="/labs4/index.php?action=index" class="btn btn-secondary">← Вернуться к списку</a>
        </div>
    <?php else: ?>
        <div class="alert alert-error">
            <p>Автомобиль не найден.</p>
        </div>
        <a href="/labs4/index.php?action=index" class="btn btn-secondary">← Вернуться к списку</a>
    <?php endif; ?>
</div>
