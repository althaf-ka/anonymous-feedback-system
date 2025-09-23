<?php

use views\global\FeedbackComponent;

$title = "Feedback Details | Admin";
$headAssets = [
    '<link rel="stylesheet" href="/assets/css/components/feedback-component.css">',
];

$feedbackData = [
    'feedbackId' => $feedback['id'] ?? 0,
    'title' => $feedback['title'] ?? '',
    'description' => $feedback['description'] ?? '',
    'category' => $feedback['category_name'] ?? '',
    'categoryColor' => $feedback['category_color'] ?? '#6B7280',
    'status' => $feedback['status'] ?? 'new',
    'is_public' => (bool)($feedback['is_public'] ?? false),
    'allow-public' => (bool)($feedback['allow_public'] ?? false),
    'created_at' => $feedback['created_at'] ?? null,
    'resolved_at' => $feedback['resolved_at'] ?? null,
    'voteCount' => (int)($feedback['vote_count'] ?? 0),
    'rating' => (int)($feedback['rating'] ?? 0),
    'contact' => $feedback['contact_details'] ?? null,
    'official_response' => [
        'content' => $feedback['official_response_content'] ?? '',
        'date' => $feedback['official_response_date'] ?? null,
    ],
    'feedback_date' => $feedback['feedback_date'] ?? '',
    'response_date' => $feedback['response_date'] ?? '',
];



$feedback = new FeedbackComponent($feedbackData, true);
$content = $feedback->render();

include __DIR__ . '/layout.php';
