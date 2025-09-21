<?php

namespace Middleware;

use Core\Response;

class AuthMiddleware
{
    public function handle(): void
    {
        $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if (str_starts_with($uri, '/admin') && $uri !== '/admin/login') {
            session_start();

            if (!isset($_SESSION['admin'])) {
                $acceptsJson = isset($_SERVER['HTTP_ACCEPT']) &&
                    str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');

                if ($acceptsJson) {
                    Response::error("Unauthorized. Please login first", [], 401);
                    header("Location: /admin/login");
                    exit;
                } else {
                    header("Location: /admin/login");
                    exit;
                }
            }
        }
    }
}
