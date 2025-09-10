<?php

require_once __DIR__ . '/../config/database.php';

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

use core\Router;

$router = new Router();

//User Routes
$router->get('/', 'UserController@home');
$router->get('/submit-feedback', 'UserController@submitFeedback');
$router->get('/public-suggestions', 'UserController@publicSuggestions');
$router->get('/feedback/{id}', 'FeedbackController@show');

//Admin Routes
$router->get('/admin/login', 'AdminController@login');
$router->get('/admin/dashboard', 'AdminController@dashboard');


$router->resolve();
