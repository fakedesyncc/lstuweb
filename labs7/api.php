<?php
require_once __DIR__ . '/../project/src/bootstrap.php';

use App\Api\ApiController;
use App\Middleware\RateLimitMiddleware;

$rateLimit = new RateLimitMiddleware(100, 60);
$rateLimit->handle(function() {
    $controller = new ApiController();
    $controller->handleRequest();
});
