<?php

namespace App\Helpers;

use App\Security\CsrfToken;

class CsrfHelper
{
    public static function field(): string
    {
        $token = CsrfToken::generate();
        return '<input type="hidden" name="' . CsrfToken::getFieldName() . '" value="' . htmlspecialchars($token) . '">';
    }

    public static function token(): string
    {
        return CsrfToken::generate();
    }

    public static function validateRequest(): bool
    {
        $token = $_POST[CsrfToken::getFieldName()] ?? $_GET[CsrfToken::getFieldName()] ?? null;

        if ($token === null) {
            return false;
        }

        return CsrfToken::validate($token);
    }
}
