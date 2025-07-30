<?php

$request = $_SERVER["REQUEST_URI"];
$request = parse_url($request, PHP_URL_PATH);

switch ($request) {
    case '/':
        require_once __DIR__ . '/views/user/home.php';
        break;

    case '/submit-feedback':
        require_once __DIR__ . '/views/user/submit-feedback.php';
        break;

    case '/admin/login':
        require_once __DIR__ . '/views/admin/login.php';
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
}