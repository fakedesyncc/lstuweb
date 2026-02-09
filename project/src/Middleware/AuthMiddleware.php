<?php

namespace App\Middleware;

use App\Session;

/**
 * @author fakedesyncc
 */
class AuthMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        if (!Session::isLoggedIn()) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $next();
    }
}
