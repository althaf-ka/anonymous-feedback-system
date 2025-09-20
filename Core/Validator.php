<?php

declare(strict_types=1);

namespace Core;

class Validator
{
    public static function require(array $fields, array $data): void
    {
        $errors = [];

        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = ucfirst($field) . " is required";
            }
        }

        if (!empty($errors)) {
            Response::error("Validation failed", $errors, 422);
        }
    }

    public static function email(string $field, array $data): void
    {
        if (!filter_var($data[$field] ?? '', FILTER_VALIDATE_EMAIL)) {
            Response::error("Validation failed", [
                $field => "Invalid email format"
            ], 422);
        }
    }
}
