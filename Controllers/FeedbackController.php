<?php

namespace Controllers;

use Core\Response;
use Core\Validator;
use Exception;
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

    public function fetchFeedbacks(): void
    {
        $filters = [
            'status'   => $_GET['status'] ?? null,
            'category' => $_GET['category'] ?? null,
            'search'   => $_GET['search'] ?? null,
        ];

        $sort   = $_GET['sort'] ?? 'recent';
        $limit  = (int)($_GET['limit'] ?? 20);
        $offset = (int)($_GET['offset'] ?? 0);

        $rows = $this->feedbackService->getFilteredFeedbacks($filters, $limit, $offset, $sort);
        // error_log(print_r($rows, true));

        Response::success('Feedback fetched successfully', $rows);
    }

    public function changeStatus(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        Validator::require(['id', 'status'], $data);

        $id     = $data['id'];
        $status = strtolower($data['status']);

        $this->feedbackService->changeFeedbackStatus($id, $status);

        Response::success('Feedback status updated successfully');
    }

    public function deleteFeedbacks(): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $ids = $data['ids'] ?? null;

            if (empty($ids) || !is_array($ids)) {
                Response::error('No feedback IDs provided.', [], 422);
                return;
            }

            $deletedResponse = $this->feedbackService->deleteFeedbacks($ids);

            if ($deletedResponse) {
                Response::success("Feedback deleted successfully.");
            } else {
                Response::error("No matching items were found to delete.", [], 404);
            }
        } catch (\Throwable $e) {
            error_log("Bulk delete error: " . $e->getMessage());
            Response::error("An internal server error occurred while deleting.", [], 500);
        }
    }

    public function setVisibility(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        Validator::require(['id', 'isPublic'], $data);

        $id = $data['id'];
        $isPublic = (bool)$data['isPublic'];

        try {
            $feedback = $this->feedbackService->getAdminFeedback($id);

            // Only allow public if user opted for public
            if ($isPublic && empty($feedback['allow_public'])) {
                Response::error("Cannot make feedback public because user opted out.", [], 403);
                return;
            }

            $this->feedbackService->setPublicVisibility($id, $isPublic);
            Response::success("Visibility updated successfully", ['isPublic' => $isPublic]);
        } catch (\Throwable $e) {
            error_log("Visibility update failed: " . $e->getMessage());
            Response::error("Failed to update visibility. Please try again.", [], 500);
        }
    }

    public function saveOfficialResponse(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        Validator::require(['id', 'content'], $data);

        $id = $data['id'];
        $content = trim($data['content']);

        try {
            $this->feedbackService->saveOfficialResponse($id, $content);
            Response::success("Official response saved successfully", ['content' => $content, 'date' => date("Y-m-d H:i:s")]);
        } catch (\Throwable $e) {
            error_log("Official response save failed: " . $e->getMessage());
            Response::error("Failed to save official response. Please try again.", [], 500);
        }
    }

    public function fetchPublicSuggestions(): void
    {
        $filters = [
            'status'   => $_GET['status'] ?? null,
            'category' => $_GET['category'] ?? null,
            'search'   => $_GET['search'] ?? null,
        ];
        $sort   = $_GET['sort'] ?? 'votes';
        $limit  = (int)($_GET['limit'] ?? 10);
        $offset = (int)($_GET['offset'] ?? 0);


        $resultData = $this->feedbackService->getPublicFilteredSuggestions($filters, $limit, $offset, $sort);

        Response::success('Suggestions fetched successfully', $resultData);
    }
}
