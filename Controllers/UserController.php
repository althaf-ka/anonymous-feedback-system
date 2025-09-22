<?php

namespace Controllers;

use Services\CategoryService;
use Services\UserService;

class UserController
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService, private UserService $userService)
    {
        $this->categoryService = $categoryService;
    }

    public function home(): void
    {
        $data = $this->userService->getHomePageData();

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
