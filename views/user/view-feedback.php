<?php

use views\global\FeedbackComponent;

$title = "Extended Library Hours During Exams | Feedback System";
$headAssets = [
    '<link rel="stylesheet" href="/assets/css/components/feedback-component.css">',
];

$componentData = [
    'feedbackId' => $feedbackData['id'],
    'title' => $feedbackData['title'],
    'description' => $feedbackData['description'],
    'category' => $feedbackData['category_name'] ?? 'Uncategorized',
    'categoryColor' => $feedbackData['category_color'] ?? '#ccc',
    'status' => $feedbackData['status'],
    'created_at' => $feedbackData['created_at'],
    'resolved_at' => $feedbackData['resolved_at'] ?? null,
    'voteCount' => (int)($feedbackData['vote_count'] ?? 0),
    'rating' => (int)($feedbackData['rating'] ?? 0),
    'allow-public' => true,
    'is-public' => true,
    'official_response' => [
        'content' => $feedbackData['official_response_content'] ?? '',
        'date' => $feedbackData['official_response_date'] ?? '',
    ],
    'timeAgo' => $feedbackData['feedback_date'] ?? 'Just now',
];

$feedback = new FeedbackComponent($componentData, false);
$content = $feedback->render();

include __DIR__ . '/layout.php';
?>

<!-- JS should be outside PHP -->
<script>
    function handleVote(button, feedbackId) {
        const voteCount = button.querySelector('.vote-count');
        let currentVotes = parseInt(voteCount.textContent);
        let isVoted = button.classList.contains('voted');

        if (isVoted) {
            currentVotes--;
            button.classList.remove('voted');
            showToast('Vote removed', 'info');
        } else {
            currentVotes++;
            button.classList.add('voted');
            showToast('Vote added!', 'success');
        }

        voteCount.textContent = currentVotes;

        // TODO: AJAX call
        // updateVoteInDatabase(feedbackId, isVoted ? 'remove' : 'add');
    }

    function copyLink() {
        const url = window.location.href;

        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                showToast('Link copied!', 'success');
            });
        } else {
            const tempInput = document.createElement('input');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            showToast('Link copied!', 'success');
        }
    }
</script>