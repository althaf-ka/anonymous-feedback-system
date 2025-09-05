<?php
ob_start();

$title       = htmlspecialchars($title ?? 'Admin');
$isAdmin     = true;
$showSidebar = $showSidebar ?? true;
$showHeader  = $showHeader ?? true;

if ($showHeader) {
    require __DIR__ . '/../global/header.php';
}

if ($showSidebar) {
    require __DIR__ . '/components/sidebar.php';
}
?>

<main style="<?= $showHeader ? 'margin-top:3rem;' : '' ?>">
    <?= $content ?? '' ?>
</main>

<?php
$body = ob_get_clean();
require __DIR__ . '/../global/base-layout.php';
