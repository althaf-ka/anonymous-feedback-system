<?php

declare(strict_types=1);

namespace Controllers;

use Core\Response;
use Core\Validator;
use Services\AuthService;
use Services\CategoryService;
use Services\FeedbackService;

class AdminController
{
  private AuthService $authService;
  private FeedbackService $feedbackService;
  private CategoryService $categoryService;

  public function __construct(AuthService $authService, FeedbackService $feedbackService, CategoryService $categoryService)
  {
    $this->authService = $authService;
    $this->feedbackService = $feedbackService;
    $this->categoryService = $categoryService;
  }


  public function loginPage(): void
  {
    session_start();

    if (isset($_SESSION['admin'])) {
      header('Location: /admin/dashboard');
      exit;
    }

    require __DIR__ . '/../views/admin/login.php';
  }
  public function loginProcess(): void
  {
    session_start();

    if (isset($_SESSION['admin'])) {
      header('Location: /admin/dashboard');
      exit;
    }

    Validator::require(['email', 'password'], $_POST);
    Validator::email('email', $_POST);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $admin = $this->authService->login($email, $password);

    $_SESSION['admin'] = $admin->email;

    Response::success("Login successful", ['redirect' => '/admin/dashboard']);
  }

  public function dashboard(): void
  {
    require __DIR__ . "/../views/admin/dashboard.php";
  }

  public function showAdminFeedbackPage(): void
  {
    $categories = $this->categoryService->getCategoriesForFeedback();

    $filters = [];
    $limit = 20;
    $offset = 0;
    $sort = 'recent';

    $rows = $this->feedbackService->getFilteredFeedbacks($filters, $limit, $offset, $sort);
    // error_log(print_r($rows, true));

    require __DIR__ . "/../views/admin/feedback.php";
  }

  public function viewFeedback(string $id): void
  {
    $feedbackId = $id;
    require __DIR__ . "/../views/admin/view-feedback.php";
  }

  public function viewCategories(): void
  {
    require __DIR__ . "/../views/admin/view-categories.php";
  }

  public function logout(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    session_unset();

    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    session_destroy();
    session_regenerate_id(true);
    header('Location: /admin/login');
    exit;
  }
}
