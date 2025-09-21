<?php

namespace Controllers;

use Core\Response;
use Core\Validator;
use Services\FeedbackService;

class FeedbackController
{
    private FeedbackService $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function handleSubmitFeedback(): void
    {
        Validator::require(['title', 'message', 'category'], $_POST);
        Validator::string('title', $_POST, 1, 80); // optional max length
        Validator::string('message', $_POST, 1, 600);

        $data = [
            'title' => trim($_POST['title']),
            'message' => trim($_POST['message']),
            'category_id' => $_POST['category'],
            'allow_public' => isset($_POST['allow_public']) ? 1 : 0,
            'contact_details' => trim($_POST['contact'] ?? null),
            'rating' => trim($_POST['rating'] ?? 0),
        ];

        $this->feedbackService->submitFeedback($data);

        Response::success('Feedback submitted successfully!');
    }
}
