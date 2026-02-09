<div class="card">
    <h2>Добавление автомобиля</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/cars/create">
        <?= \App\Helpers\CsrfHelper::field() ?>
        <?php if (isset($errors['csrf'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($errors['csrf']) ?></div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="brand">Марка *</label>
            <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($data['brand'] ?? '') ?>" required>
            <?php if (isset($errors['brand'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['brand']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="model">Модель *</label>
            <input type="text" id="model" name="model" value="<?= htmlspecialchars($data['model'] ?? '') ?>" required>
            <?php if (isset($errors['model'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['model']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="price">Цена (руб.) *</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($data['price'] ?? '') ?>" required>
            <?php if (isset($errors['price'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['price']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="year">Год выпуска *</label>
            <input type="number" id="year" name="year" min="1900" max="<?= date('Y') + 1 ?>" value="<?= htmlspecialchars($data['year'] ?? '') ?>" required>
            <?php if (isset($errors['year'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['year']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="color">Цвет</label>
            <input type="text" id="color" name="color" value="<?= htmlspecialchars($data['color'] ?? '') ?>">
            <?php if (isset($errors['color'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['color']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="image_url">URL изображения</label>
            <input type="text" id="image_url" name="image_url" placeholder="/images/cars/vaz-2101.jpg" value="<?= htmlspecialchars($data['image_url'] ?? '') ?>">
            <small style="color: var(--avtovaz-light-gray); font-size: 0.9rem;">Путь к изображению автомобиля (например: /images/cars/vaz-2101.jpg)</small>
            <?php if (isset($errors['image_url'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['image_url']) ?></div>
            <?php endif; ?>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn">Добавить автомобиль</button>
            <a href="/cars" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
