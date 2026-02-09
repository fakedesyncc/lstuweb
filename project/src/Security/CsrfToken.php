<?php

namespace App\Security;

class CsrfToken
{
    private const TOKEN_NAME = 'csrf_token';
    private const TOKEN_LENGTH = 32;

    public static function generate(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
        $_SESSION[self::TOKEN_NAME] = $token;

        return $token;
    }

    public static function get(): ?string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION[self::TOKEN_NAME] ?? null;
    }

    public static function validate(string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $storedToken = $_SESSION[self::TOKEN_NAME] ?? null;

        if ($storedToken === null) {
            return false;
        }

        return hash_equals($storedToken, $token);
    }

    public static function clear(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION[self::TOKEN_NAME]);
    }

    public static function getFieldName(): string
    {
        return self::TOKEN_NAME;
    }
}
