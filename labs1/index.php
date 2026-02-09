<?php
$title = 'Docker окружение';
ob_start();
?>

<div class="card">
    <div class="page-header">
        <h1>🚀 Docker окружение</h1>
        <p>Проверка работы PHP и Apache</p>
    </div>
    
    <div class="card">
        <h2>Информация о PHP</h2>
        <div style="overflow-x: auto;">
            <?php phpinfo(); ?>
        </div>
    </div>
    
    <div class="card">
        <div class="stats">
            <div class="stat-card">
                <h3><?= phpversion() ?></h3>
                <p>Версия PHP</p>
            </div>
            <div class="stat-card">
                <h3><?= apache_get_version() ?></h3>
                <p>Версия Apache</p>
            </div>
            <div class="stat-card">
                <h3><?= extension_loaded('pdo_mysql') ? '✅' : '❌' ?></h3>
                <p>PDO MySQL</p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../project/public/layout.php';
?>
