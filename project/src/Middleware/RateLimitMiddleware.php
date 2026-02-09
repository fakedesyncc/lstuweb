<?php

namespace App\Middleware;

/**
 * @author fakedesyncc
 */
class RateLimitMiddleware implements MiddlewareInterface
{
    private int $maxRequests;
    private int $windowSeconds;
    private string $storagePath;

    public function __construct(int $maxRequests = 100, int $windowSeconds = 60)
    {
        $this->maxRequests = $maxRequests;
        $this->windowSeconds = $windowSeconds;
        $this->storagePath = sys_get_temp_dir() . '/rate_limit_' . md5($_SERVER['REMOTE_ADDR'] ?? 'default');
    }

    public function handle(callable $next): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = md5($ip);

        $data = $this->loadData($key);
        $now = time();

        if ($data === null || ($now - $data['reset_time']) > $this->windowSeconds) {
            $data = [
                'count' => 1,
                'reset_time' => $now
            ];
        } else {
            $data['count']++;
        }

        if ($data['count'] > $this->maxRequests) {
            http_response_code(429);
            header('Content-Type: application/json');
            header('Retry-After: ' . ($this->windowSeconds - ($now - $data['reset_time'])));
            echo json_encode([
                'error' => 'Too Many Requests',
                'retry_after' => $this->windowSeconds - ($now - $data['reset_time'])
            ]);
            exit;
        }

        $this->saveData($key, $data);
        $next();
    }

    private function loadData(string $key): ?array
    {
        $file = $this->storagePath . '_' . $key;
        if (!file_exists($file)) {
            return null;
        }

        $content = file_get_contents($file);
        return $content ? json_decode($content, true) : null;
    }

    private function saveData(string $key, array $data): void
    {
        $file = $this->storagePath . '_' . $key;
        file_put_contents($file, json_encode($data));
    }
}
