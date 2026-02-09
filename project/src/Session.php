<?php

namespace App;

/**
 * @author fakedesyncc
 */
class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        self::start();
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return self::has('user_id');
    }

    public static function getUser(): ?array
    {
        if (self::isLoggedIn()) {
            return [
                'id' => self::get('user_id'),
                'username' => self::get('username'),
                'email' => self::get('email'),
                'role' => self::get('role')
            ];
        }
        return null;
    }
}
