<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h2>Вход в систему</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/auth/login">
        <?= \App\Helpers\CsrfHelper::field() ?>
        <?php if (isset($errors['csrf'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($errors['csrf']) ?></div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="username">Имя пользователя *</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($data['username'] ?? '') ?>" required>
            <?php if (isset($errors['username'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['username']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль *</label>
            <input type="password" id="password" name="password" required>
            <?php if (isset($errors['password'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </div>
        
        <?php if (isset($errors['auth'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($errors['auth']) ?></div>
        <?php endif; ?>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <button type="submit" class="btn">Войти</button>
            <p style="text-align: center; color: var(--text-primary); opacity: 0.9;">
                Нет аккаунта? <a href="/auth/register" style="color: var(--accent-color);">Зарегистрироваться</a>
            </p>
        </div>
    </form>
</div>

