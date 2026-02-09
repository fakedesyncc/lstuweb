<?php

require_once __DIR__ . '/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    require_once __DIR__ . '/Utils/EnvLoader.php';
    \App\Utils\EnvLoader::load(__DIR__ . '/../.env');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

