<?php

namespace controllers;

class UserController
{
    public function home()
    {
        require __DIR__ . '/../views/user/home.php';
    }

    public function submitFeedback()
    {
        require __DIR__ . '/../views/user/submit-feedback.php';
    }

    public function publicSuggestions()
    {
        require __DIR__ . '/../views/user/public-suggestions.php';
    }
}
