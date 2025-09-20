<?php

namespace Core;

class Response
{
    public static function success(string $message, array $data = [], int $status = 200): void
    {
        self::send(true, $message, $data, $status);
    }

    public static function error(string $message, array $errors = [], int $status = 400): void
    {
        self::send(false, $message, $errors, $status);
    }

    private static function send(bool $success, string $message, array $payload, int $status): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            $success ? 'data' : 'errors' => $payload
        ]);
        exit;
    }
}
