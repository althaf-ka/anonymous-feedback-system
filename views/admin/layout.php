<?php
ob_start();

$title        = htmlspecialchars($title ?? 'Admin');
$headerTitle  = "Admin";
$isAdmin      = true;
$headAssets[] = '<link rel="stylesheet" href="/assets/css/sidebar.css">';



if ($showHeader) {
    require __DIR__ . '/../global/header.php';
}

// if ($showSidebar) {
//     require __DIR__ . '/components/sidebar.php';
// }
// 
?>


<div class="admin-layout">
    <?php if ($showSidebar): ?>
        <?php require __DIR__ . '/components/sidebar.php'; ?>
    <?php endif; ?>

    <main style="<?= $showHeader ? 'margin-top:3rem;' : '' ?>">
        <div class="container">
            <?= $content ?? '' ?>
        </div>
    </main>
</div>


<?php
$body = ob_get_clean();
require __DIR__ . '/../global/base-layout.php';
