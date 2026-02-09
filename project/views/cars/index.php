<div class="card">
    <h2>Список автомобилей</h2>
    
    <form method="GET" action="/cars" class="search-form">
        <input type="text" name="brand" placeholder="Марка" value="<?= htmlspecialchars($criteria['brand'] ?? '') ?>">
        <input type="text" name="model" placeholder="Модель" value="<?= htmlspecialchars($criteria['model'] ?? '') ?>">
        <button type="submit" class="btn">Поиск</button>
        <a href="/cars" class="btn btn-secondary">Сбросить</a>
    </form>

    <?php if (!empty($cars)): ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
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
                        <td>
                            <?php 
                            $imageUrl = $car['image_url'] ?? '/images/cars/placeholder.jpg';
                            ?>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.4);" onerror="this.src='/images/cars/placeholder.jpg'">
                                <strong style="font-size: 1.1rem;"><?= htmlspecialchars($car['brand'] ?? '') ?></strong>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($car['model'] ?? '') ?></td>
                        <td><strong style="color: var(--avtovaz-orange); font-size: 1.1rem;"><?= number_format($car['price'] ?? 0, 0, '.', ' ') ?> ₽</strong></td>
                        <td><?= htmlspecialchars($car['year'] ?? '') ?></td>
                        <td><?= htmlspecialchars($car['color'] ?? '') ?></td>
                        <td><?= htmlspecialchars($car['created_at'] ?? '') ?></td>
                        <td>
                            <a href="/cars/<?= $car['id'] ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Просмотр</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if (isset($pagination) && ($pagination['current_page'] > 1 || $pagination['has_next'])): ?>
            <div class="pagination">
                <?php if ($pagination['current_page'] > 1): ?>
                    <a href="?page=<?= $pagination['current_page'] - 1 ?><?= !empty($criteria['brand']) ? '&brand=' . urlencode($criteria['brand']) : '' ?><?= !empty($criteria['model']) ? '&model=' . urlencode($criteria['model']) : '' ?>" class="btn btn-secondary">← Предыдущая</a>
                <?php endif; ?>
                
                <span class="current">Страница <?= $pagination['current_page'] ?> из <?= $pagination['total_pages'] ?></span>
                
                <?php if ($pagination['has_next']): ?>
                    <a href="?page=<?= $pagination['current_page'] + 1 ?><?= !empty($criteria['brand']) ? '&brand=' . urlencode($criteria['brand']) : '' ?><?= !empty($criteria['model']) ? '&model=' . urlencode($criteria['model']) : '' ?>" class="btn btn-secondary">Следующая →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Автомобили не найдены. <a href="/cars/create" style="color: var(--accent-color);">Добавить первый автомобиль</a></p>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 2rem;">
        <a href="/cars/create" class="btn">+ Добавить автомобиль</a>
    </div>
</div>
