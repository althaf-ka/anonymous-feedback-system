<?php

namespace controllers;

class UserController
{
    public function home(): void
    {
        require __DIR__ . '/../views/user/home.php';
    }

    public function submitFeedback(): void
    {
        require __DIR__ . '/../views/user/submit-feedback.php';
    }

    public function publicSuggestions(): void
    {
        require __DIR__ . '/../views/user/public-suggestions.php';
    }
    public function viewFeedback(string $id): void {
      $feedbackId = $id;
      require __DIR__ . "/../views/user/view-feedback.php";
    }
}
