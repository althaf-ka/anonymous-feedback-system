<?php

declare(strict_types=1);

namespace Core;

final class Env
{
    private static ?array $env = null;

    private function __construct() {}

    public static function load(string $path = __DIR__ . '/../.env'): void
    {
        if (self::$env !== null) {
            return;
        }

        if (!file_exists($path)) {
            throw new \RuntimeException(".env file not found at path: {$path}");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        self::$env = [];

        foreach ($lines as $line) {
            // skip comments
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode('=', $line, 2));
            if (!empty($key)) {
                self::$env[$key] = $value;
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (self::$env === null) {
            throw new \RuntimeException("Environment not loaded. Call Env::load() first.");
        }

        return $_ENV[$key] ?? self::$env[$key] ?? $default;
    }
}
