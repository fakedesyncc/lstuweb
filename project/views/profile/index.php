?>

<div class="card">
    <h2>Личный кабинет</h2>

    <div class="stats" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <h3><?= htmlspecialchars($userData['id'] ?? 'N/A') ?></h3>
            <p>ID пользователя</p>
        </div>
        <div class="stat-card">
            <h3><?= htmlspecialchars($userData['role'] ?? 'user') ?></h3>
            <p>Роль</p>
        </div>
        <div class="stat-card">
            <h3><?= count($cars ?? []) ?></h3>
            <p>Автомобилей</p>
        </div>
    </div>

    <div class="card" style="margin-bottom: 2rem;">
        <h3>Информация о пользователе</h3>
        <table>
            <tbody>
                <tr>
                    <th style="width: 200px;">Имя пользователя</th>
                    <td><strong><?= htmlspecialchars($userData['username'] ?? '') ?></strong></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($userData['email'] ?? '') ?></td>
                </tr>
                <tr>
                    <th>Роль</th>
                    <td><?= htmlspecialchars($userData['role'] ?? 'user') ?></td>
                </tr>
                <tr>
                    <th>Дата регистрации</th>
                    <td><?= htmlspecialchars($userData['created_at'] ?? '') ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Мои автомобили</h3>

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
        <?php else: ?>
            <div class="alert alert-info">
                <p>У вас пока нет автомобилей.</p>
            </div>
        <?php endif; ?>
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
        <a href="/auth/logout" class="btn btn-danger">Выйти</a>
    </div>
</div>

