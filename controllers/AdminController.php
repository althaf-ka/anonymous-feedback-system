<?php

namespace controllers;

class AdminController {
    public function login(): void {
        require __DIR__ . '/../views/admin/login.php';
    }

    public function dashboard(): void {
      require __DIR__ . "/../views/admin/dashboard.php";
    }

    public function feedback(): void {
      require __DIR__ . "/../views/admin/feedback.php";
    }

    public function viewFeedback(string $id): void {
      $feedbackId = $id;
      require __DIR__ . "/../views/admin/view-feedback.php";
    }

    public function viewCategories():void{
      require __DIR__ . "/../views/admin/view-categories.php";
    }
}
