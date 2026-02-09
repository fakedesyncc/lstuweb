<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Автосалон') ?></title>
    <link rel="stylesheet" href="/css/style.css?v=<?= time() ?>">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="/" class="logo">
                    <img src="/images/lada-logo.png" alt="LADA" class="logo-image" style="height: 50px; width: auto;">
                    <span class="logo-text">AUTOSALON</span>
                </a>
                <ul class="nav-links">
                    <li><a href="/">Главная</a></li>
                    <li><a href="/cars">Автомобили</a></li>
                    <li><a href="/auth/login">Вход</a></li>
                    <li><a href="/profile">Профиль</a></li>
                    <li><a href="/reports">Отчеты</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if (isset($content)): ?>
                <?= $content ?>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> Автосалон. Все права защищены.</p>
        </div>
    </footer>

    <script src="/js/main.js?v=<?= time() ?>"></script>
</body>
</html>
