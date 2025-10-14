<?php

namespace Middleware;

use Core\Response;

class AuthMiddleware
{
    public function handle(): void
    {
        $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if (str_starts_with($uri, '/admin') && $uri !== '/admin/login') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['admin'])) {
                $isApiRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

                if ($isApiRequest) {
                    Response::error("Unauthorized. Your session may have expired.", [], 401);
                } else {
                    header("Location: /admin/login");
                    exit;
                }
            }
        }
    }
}
