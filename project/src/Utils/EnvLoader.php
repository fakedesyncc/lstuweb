<?php

namespace App\Utils;

/**
 * @author fakedesyncc
 */
class EnvLoader
{
    public static function load(string $envFile): void
    {
        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        if ($lines === false) {
            return;
        }
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            if (strpos($line, '#') === 0 || strpos($line, '=') === false) {
                continue;
            }
            
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
        }
    }
}
