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

    public function getFilteredFeedbacks(array $filters, int $limit, int $offset, string $sort): array
    {
        return $this->feedbackRepo->findFiltered($filters, $limit, $offset, $sort);
    }

    public function changeFeedbackStatus(string $id, string $status): bool
    {
        $response = $this->feedbackRepo->updateStatus($id, $status);

        if (!$response) {
            throw new Exception("Unable to update feedback status. Please try again later.");
        }

        return $response;
    }
}
