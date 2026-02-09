<div class="card">
    <div class="page-header">
        <h1>MVC Архитектура</h1>
        <p>Управление автомобилями</p>
    </div>
    
    <h2>Список автомобилей</h2>
    
    <form method="GET" action="/labs4/index.php" class="search-form">
        <input type="text" name="brand" placeholder="Марка" value="<?= htmlspecialchars($criteria['brand'] ?? '') ?>">
        <input type="text" name="model" placeholder="Модель" value="<?= htmlspecialchars($criteria['model'] ?? '') ?>">
        <button type="submit" class="btn">Поиск</button>
        <a href="/labs4/index.php" class="btn btn-secondary">Сбросить</a>
    </form>

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
                    <th>Действия</th>
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
                        <td>
                            <a href="/labs4/index.php?action=show&id=<?= $car['id'] ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Просмотр</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if ($page > 1 || count($cars) >= 10): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?><?= !empty($criteria['brand']) ? '&brand=' . urlencode($criteria['brand']) : '' ?><?= !empty($criteria['model']) ? '&model=' . urlencode($criteria['model']) : '' ?>" class="btn btn-secondary">← Предыдущая</a>
                <?php endif; ?>
                
                <span class="current">Страница <?= $page ?></span>
                
                <?php if (count($cars) >= 10): ?>
                    <a href="?page=<?= $page + 1 ?><?= !empty($criteria['brand']) ? '&brand=' . urlencode($criteria['brand']) : '' ?><?= !empty($criteria['model']) ? '&model=' . urlencode($criteria['model']) : '' ?>" class="btn btn-secondary">Следующая →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Автомобили не найдены. <a href="/labs4/index.php?action=create" style="color: var(--accent-color);">Добавить первый автомобиль</a></p>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 2rem;">
        <a href="/labs4/index.php?action=create" class="btn">+ Добавить автомобиль</a>
    </div>
</div>
