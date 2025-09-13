<?php
ob_start();

$title        = htmlspecialchars($title ?? 'Admin');
$headerTitle  = "Admin";
$isAdmin      = true;
$headAssets = [
    ...$headAssets,
    '<link rel="stylesheet" href="/assets/css/components/sidebar.css">',
    '<link rel="stylesheet" href="/assets/css/components/status-selector.css">',
];



if ($showHeader) {
    require __DIR__ . '/../global/header.php';
}
?>


<div class="<?= $showSidebar ? 'admin-layout' : '' ?>">
    <?php if ($showSidebar): ?>
        <?php require __DIR__ . '/components/sidebar.php'; ?>
    <?php endif; ?>

    <main style="<?= $showHeader ? 'margin-top:3rem;' : '' ?>">
        <div class="container">
            <?= $content ?? '' ?>
        </div>
    </main>
</div>

<script src="/assets/js/admin.js" defer></script>


<?php
$body = ob_get_clean();
require __DIR__ . '/../global/base-layout.php';
