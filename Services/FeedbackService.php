<?php

namespace Services;

use Exception;
use Repositories\FeedbackRepository;

class FeedbackService
{
    private FeedbackRepository $feedbackRepo;

    public function __construct(FeedbackRepository $feedbackRepo)
    {
        $this->feedbackRepo = $feedbackRepo;
    }

    public function submitFeedback(array $data): bool
    {
        $response = $this->feedbackRepo->insert($data);

        if (!$response) {
            throw new Exception("Feedback submission failed. Please try again later.");
        }

        return $response;
    }
}
