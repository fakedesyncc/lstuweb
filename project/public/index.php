<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\Router\Router;

$router = new Router();

$router->get('/', function() {
    $title = 'Автосалон - Главная';
    ob_start();
    ?>
    <div class="card">
        <div class="page-header">
            <h1>Автосалон</h1>
            <p>Полнофункциональное веб-приложение для управления автомобилями</p>
        </div>
        
        
        <div class="stats">
            <div class="stat-card">
                <h3>7</h3>
                <p>Лабораторных работ</p>
            </div>
            <div class="stat-card">
                <h3>100%</h3>
                <p>Готовность проекта</p>
            </div>
            <div class="stat-card">
                <h3>PHP 8.3</h3>
                <p>Современные технологии</p>
            </div>
        </div>
        
        <div class="card">
            <h2>Доступные разделы</h2>
            <div class="section-grid">
                <a href="/cars" class="section-card">
                    <h3>Автомобили</h3>
                    <p>Управление автомобилями, поиск и фильтрация</p>
                </a>
                <a href="/auth/login" class="section-card">
                    <h3>Авторизация</h3>
                    <p>Вход и регистрация пользователей</p>
                </a>
                <a href="/profile" class="section-card">
                    <h3>Личный кабинет</h3>
                    <p>Профиль пользователя и управление данными</p>
                </a>
                <a href="/reports" class="section-card">
                    <h3>Отчеты</h3>
                    <p>Генерация отчетов в различных форматах</p>
                </a>
            </div>
        </div>
        
        <div class="card">
            <h2>Демонстрация лабораторных работ</h2>
            <p style="color: var(--avtovaz-light-gray); margin-bottom: 2rem;">Каждая лабораторная работа демонстрирует конкретную функциональность проекта</p>
            <div class="section-grid">
                <a href="/labs1/index.php" class="section-card">
                    <h3>Лабораторная 1</h3>
                    <p>Docker окружение и настройка PHP/Apache</p>
                </a>
                <a href="/labs2/index.php" class="section-card">
                    <h3>Лабораторная 2</h3>
                    <p>Основы PHP и работа с формами</p>
                </a>
                <a href="/labs3/index.php" class="section-card">
                    <h3>Лабораторная 3</h3>
                    <p>Работа с базами данных MySQL</p>
                </a>
                <a href="/labs4/index.php" class="section-card">
                    <h3>Лабораторная 4</h3>
                    <p>MVC архитектура и роутинг</p>
                </a>
                <a href="/labs5/index.php" class="section-card">
                    <h3>Лабораторная 5</h3>
                    <p>Авторизация и личный кабинет</p>
                </a>
                <a href="/labs6/index.php" class="section-card">
                    <h3>Лабораторная 6</h3>
                    <p>Генерация отчетов (PDF, Excel, CSV)</p>
                </a>
            </div>
        </div>
        
    </div>
    <?php
    $content = ob_get_clean();
    include __DIR__ . '/layout.php';
});

$router->get('/cars', 'App\Controllers\CarController@index');
$router->get('/cars/create', 'App\Controllers\CarController@create');
$router->post('/cars/create', 'App\Controllers\CarController@store');
$router->get('/cars/:id', 'App\Controllers\CarController@show');

$router->get('/auth/login', 'App\Controllers\AuthController@login');
$router->post('/auth/login', 'App\Controllers\AuthController@authenticate');
$router->get('/auth/register', 'App\Controllers\AuthController@register');
$router->post('/auth/register', 'App\Controllers\AuthController@store');
$router->get('/auth/logout', 'App\Controllers\AuthController@logout');

$router->get('/profile', 'App\Controllers\ProfileController@index');

$router->get('/reports', 'App\Controllers\ReportController@index');
$router->get('/reports/generate/:format', 'App\Controllers\ReportController@generate');

$router->get('/api/cars', 'App\Api\ApiController@getCars');
$router->get('/api/cars/:id', 'App\Api\ApiController@getCar');
$router->post('/api/cars', 'App\Api\ApiController@createCar');
$router->put('/api/cars/:id', 'App\Api\ApiController@updateCar');
$router->delete('/api/cars/:id', 'App\Api\ApiController@deleteCar');

// Labs обрабатываются напрямую Apache через Alias - роутер их пропускает
$router->dispatch();
