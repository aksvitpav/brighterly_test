<?php

namespace App;

class Env
{
    private static array $variables = [];

    public static function load(string $file): void
    {
        if (file_exists($file)) {
            $lines = file($file);
            foreach ($lines as $line) {
                $line = trim($line);
                // Ignore comments or empty lines
                if ($line && $line[0] !== '#') {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    self::$variables[$key] = $value;
                }
            }
        }
    }

    public static function get(string $key, $default = null)
    {
        return self::$variables[$key] ?? $default;
    }
}