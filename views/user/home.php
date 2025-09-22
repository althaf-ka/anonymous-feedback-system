<?php
$title = "Feedback System";

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
