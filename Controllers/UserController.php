<?php

namespace Controllers;

use Services\CategoryService;

class UserController
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function home(): void
    {
        require __DIR__ . '/../views/user/home.php';
    }

    public function showSubmitFeedback(): void
    {
        $categories = $this->categoryService->getCategoriesForFeedback();

        require __DIR__ . '/../views/user/submit-feedback.php';
    }

    public function publicSuggestions(): void
    {
        require __DIR__ . '/../views/user/public-suggestions.php';
    }
    public function viewFeedback(string $id): void
    {
        $feedbackId = $id;
        require __DIR__ . "/../views/user/view-feedback.php";
    }
}
