<?php

namespace App\Middleware;

/**
 * @author fakedesyncc
 */
interface MiddlewareInterface
{
    public function handle(callable $next): void;
}
