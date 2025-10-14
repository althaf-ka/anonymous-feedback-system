<?php
$defaults = [
    'title'       => 'Anonymous Feedback System',
    'description' => 'A modern platform for collecting anonymous community feedback and suggestions.',
    'image'       => 'https://' . ($_SERVER['HTTP_HOST'] ?? '') . '/default-og-image.png',
    'url'         => 'https://' . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? ''),
    'type'        => 'website',
    'site_name'   => 'Anonymous Feedback System'
];

$seo = array_merge($defaults, $seo ?? []);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($seo['title']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seo['description']) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($seo['url']) ?>" />

    <meta property="og:title" content="<?= htmlspecialchars($seo['title']) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($seo['description']) ?>" />
    <meta property="og:image" content="<?= htmlspecialchars($seo['image']) ?>" />
    <meta property="og:url" content="<?= htmlspecialchars($seo['url']) ?>" />
    <meta property="og:type" content="<?= htmlspecialchars($seo['type']) ?>" />
    <meta property="og:site_name" content="<?= htmlspecialchars($seo['site_name']) ?>" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= htmlspecialchars($seo['title']) ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($seo['description']) ?>" />
    <meta name="twitter:image" content="<?= htmlspecialchars($seo['image']) ?>" />

    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Feedback" />
    <link rel="manifest" href="/site.webmanifest" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/global.css">

    <?php foreach ($headAssets ?? [] as $asset): ?>
        <?= $asset . PHP_EOL ?>
    <?php endforeach; ?>
</head>

<body>
    <?= $body ?? '' ?>
    <script src="/assets/js/toast.js" defer></script>
</body>

</html>