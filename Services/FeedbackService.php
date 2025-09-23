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
    public function deleteFeedbacks(array $ids): int
    {
        $deleted = $this->feedbackRepo->deleteByIds($ids);

        if ($deleted === 0) {
            throw new Exception("No feedback entries were deleted.");
        }

        return $deleted;
    }

    public function getPublicFeedback(string $id)
    {
        $row = $this->feedbackRepo->findPublicFeedbackById($id);
        error_log(print_r($row, true));

        if (!$row) {
            throw new Exception("Feedback not found or not public.");
        }

        return $row;
    }

    public function getAdminFeedback(string $id): array
    {
        $row = $this->feedbackRepo->findAdminById($id);

        if (!$row) {
            throw new Exception("Feedback not found.");
        }

        return $row;
    }
}
