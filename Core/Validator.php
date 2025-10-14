<?php

declare(strict_types=1);

namespace Core;

class Validator
{
    public static function require(array $fields, array $data): void
    {
        $errors = [];

        foreach ($fields as $field) {
            if (!array_key_exists($field, $data) || $data[$field] === null) {
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

    public static function string(string $field, array $data, int $min, ?int $max = null): void
    {
        $value = $data[$field] ?? '';
        if (!is_string($value)) {
            Response::error("Validation failed", [
                $field => "Must be a string"
            ], 422);
        }
        if (strlen($value) < $min) {
            Response::error("Validation failed", [
                $field => "Must be at least $min characters"
            ], 422);
        }
        if ($max !== null && strlen($value) > $max) {
            Response::error("Validation failed", [
                $field => "Must be no more than $max characters"
            ], 422);
        }
    }
}
