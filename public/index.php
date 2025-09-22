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
$router->post('/feedback/vote', 'VoteController@castVote');

//Admin Routes
$router->get('/admin/login', 'AdminController@loginPage');
$router->post('/admin/login', 'AdminController@loginProcess');
$router->get('/admin/logout', 'AdminController@logout');
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/admin/feedback', 'AdminController@showAdminFeedbackPage');
$router->post('/admin/delete/feedback', 'FeedbackController@deleteFeedbacks');
$router->get('/admin/feedback/{id}', 'AdminController@viewFeedback');
$router->get('/admin/api/feedbacks', 'FeedbackController@fetchFeedbacks');
$router->get('/admin/categories', 'AdminController@viewCategories');
$router->get('/admin/api/categories', 'CategoryController@getCategories');
$router->post('/admin/delete/category', 'CategoryController@deleteCategory');
$router->post('/admin/categories/add', 'CategoryController@createCategory');
$router->post('/admin/category/delete', 'CategoryController@deleteCategory');
$router->post('/admin/status/change', 'FeedbackController@changeStatus');


$router->resolve();
