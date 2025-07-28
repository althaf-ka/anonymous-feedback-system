<?php
$title = "Home Page";

ob_start();
?>

<?php require_once 'components/hero-section.php'; ?>

<div class="container">
    <?php
    $suggestions = [
        ['title' => 'Add dark mode support', 'created_at' => '2025-07-27 10:20:00', 'upvotes' => 22],
        ['title' => 'Enable anonymous posting', 'created_at' => '2025-07-25 18:40:00', 'upvotes' => 37],
    ];

    require_once 'components/feedback-card.php';

    foreach ($suggestions as $s) {
        renderFeedbackCard($s['title'], $s['created_at'], $s['upvotes']);
    }
    ?>
</div>


<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
