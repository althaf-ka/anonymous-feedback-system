<?php

declare(strict_types=1);

namespace Core;

use Throwable;

class ErrorHandler
{
    private static string $logFile = __DIR__ . '/../storage/logs/error.log';
    private static string $lastError = '';

    public static function register(): void
    {
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleException(Throwable $e): void
    {
        self::log($e->getMessage(), $e->getFile(), $e->getLine());
        $status = $e->getCode() ?: 500;
        $message = $e->getMessage() ?: "An unexpected error occurred. Please try again later.";
        Response::error($message, [], $status);
    }

    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        self::log($errstr, $errfile, $errline);

        // Don’t stop script execution (false means PHP continues normal flow)
        return false;
    }

    public static function handleShutdown(): void
    {
        $error = error_get_last();

        if ($error !== null && $error['type'] === E_ERROR) {
            self::log($error['message'], $error['file'], $error['line']);
            Response::error("A critical error occurred. Please try again later.", [], 500);
        }
    }

    private static function log(string $message, string $file, int $line): void
    {
        $entry = "[" . date('Y-m-d H:i:s') . "] {$message} in {$file}:{$line}" . PHP_EOL;

        // Prevent duplicate consecutive logs
        if ($entry === self::$lastError) {
            return;
        }

        self::$lastError = $entry;

        if (!is_dir(dirname(self::$logFile))) {
            mkdir(dirname(self::$logFile), 0777, true);
        }

        file_put_contents(self::$logFile, $entry, FILE_APPEND);
    }
}
