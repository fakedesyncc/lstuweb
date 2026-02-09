<div class="card" style="max-width: 500px; margin: 0 auto;">
    <h2>Регистрация</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="/auth/register">
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
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" required>
            <?php if (isset($errors['email'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль *</label>
            <input type="password" id="password" name="password" required minlength="6">
            <?php if (isset($errors['password'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="password_confirm">Подтверждение пароля *</label>
            <input type="password" id="password_confirm" name="password_confirm" required minlength="6">
            <?php if (isset($errors['password_confirm'])): ?>
                <div class="alert alert-error" style="margin-top: 0.5rem; padding: 0.5rem;"><?= htmlspecialchars($errors['password_confirm']) ?></div>
            <?php endif; ?>
        </div>
        
        <?php if (isset($errors['save'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($errors['save']) ?></div>
        <?php endif; ?>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <button type="submit" class="btn">Зарегистрироваться</button>
            <p style="text-align: center; color: var(--text-primary); opacity: 0.9;">
                Уже есть аккаунт? <a href="/auth/login" style="color: var(--accent-color);">Войти</a>
            </p>
        </div>
    </form>
</div>

