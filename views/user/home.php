<?php
$seo = [
    'title'       => 'Anonymous Feedback System | Share Your Ideas',
    'description' => 'Welcome to our platform for anonymous feedback. Share your suggestions, upvote popular ideas, and help us improve our community together.'
];

ob_start();
?>

<?php require_once 'components/hero-section.php'; ?>

<?php
$suggestions = $data['recentSuggestions'];
$completedSuggestions = $data['fulfilledSuggestions'];
$totalSuggestions = $data['totalSuggestions'];


require_once 'components/recent-public-suggestion.php';
require_once 'components/fulfilled-section.php';
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
