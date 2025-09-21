<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        error_log("[Autoload Error] Class '$class' not found at path: $path");
    }
});

use Core\ErrorHandler;
use Middleware\AuthMiddleware;
use Core\Router;
use Core\Env;
use Core\Container;
use Core\Database;

Env::load();
ErrorHandler::register();

$container = new Container();

$container->singleton(Database::class, function () {
    return Database::getInstance();
});

$router = new Router($container);

//Bind Middleware
$router->use(AuthMiddleware::class);

//User Routes
$router->get('/', 'UserController@home');
$router->get('/submit-feedback', 'UserController@showSubmitFeedback');
$router->post('/submit-feedback', 'FeedbackController@handleSubmitFeedback');
$router->get('/public-suggestions', 'UserController@publicSuggestions');
$router->get('/feedback/{id}', 'UserController@viewFeedback');

//Admin Routes
$router->get('/admin/login', 'AdminController@loginPage');
$router->post('/admin/login', 'AdminController@loginProcess');
$router->get('/admin/logout', 'AdminController@logout');
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/admin/feedback', 'AdminController@feedback');
$router->get('/admin/feedback/{id}', 'AdminController@viewFeedback');
$router->get('/admin/categories', 'AdminController@viewCategories');
$router->post('/admin/categories/add', 'CategoryController@createCategory');


$router->resolve();
