<?php
ob_start();

$title = $title ?? 'Feedback System';
$headerTitle  = "Feedback System";

$isAdmin = false;

require __DIR__ . '/../global/header.php';
?>

<main style="margin-top: 3rem;">
    <?= $content ?? '' ?>
</main>

<?php require __DIR__ . '/components/footer.php'; ?>

<?php
$body = ob_get_clean();
require __DIR__ . '/../global/base-layout.php';
