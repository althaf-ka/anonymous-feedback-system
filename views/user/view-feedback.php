<?php

use views\global\FeedbackComponent;

$title = "Extended Library Hours During Exams | Feedback System";
$headAssets = [
    '<link rel="stylesheet" href="/assets/css/components/feedback-component.css">',
];

$feedbackData = [
    'id' => 123,
    'title' => "Extended Library Hours During Exams",
    'description' => "
        The library should stay open 24/7 during exam periods to accommodate different study schedules and reduce overcrowding during peak hours. Many students prefer studying late at night or early in the morning, and the current limited hours create unnecessary stress during already challenging exam periods.
        This would particularly benefit students with different sleep schedules, international students adjusting to time zones, students with part-time jobs who can only study at night, and those who find the library less crowded during off-peak hours.
        The implementation could include additional security measures and maybe a reduced staff presence during overnight hours, but keeping the main study areas accessible would make a significant difference to student success.
    ",
    'category' => 'Academics',
    'status' => 'progress',
    'is_public' => true,
    'created_at' => '2025-01-10 14:30:00',
    'voteCount' => 45,
    'rating' => 4,
    'contact' => 'student@example.com',
    'official_response' => [
        'content' => "Thank you for this suggestion. We have implemented extended library hours during exam periods 
                      starting this semester. The library will now be open 24/7 during the two weeks before final exams.",
        'date' => '2025-01-11 09:00:00',
    ],
    'allow-public' => true,
    'is-public' => true,
];

$feedback = new FeedbackComponent($feedbackData, false);
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