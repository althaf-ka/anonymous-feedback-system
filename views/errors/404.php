<?php
http_response_code(404);


$seo = [
    'title'       => 'Page Not Found | Anonymous Feedback System',
    'description' => 'Sorry, the page you are looking for could not be found. Please return to the homepage.'
];


ob_start();
?>

<div class="error-page-container">
    <h1 class="error-code">404</h1>
    <h2 class="error-title">Page Not Found</h2>
    <p class="error-message">
        Sorry, the page you were looking for doesn't exist. It might have been moved, deleted, or you may have typed the URL incorrectly.
    </p>
    <a href="/" class="error-home-link rounded-sm">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        Return to Homepage
    </a>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/../admin/layout.php';
?>

<style>
    .error-page-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 100vh;
        padding: 2rem;
        color: var(--color-text);
    }

    .error-code {
        font-size: 6rem;
        font-weight: 800;
        color: var(--color-primary);
        line-height: 1;
        margin: 0;
    }

    .error-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 1rem 0 0.5rem 0;
    }

    .error-message {
        color: var(--color-text-muted);
        max-width: 400px;
        margin: 0 0 2rem 0;
    }

    .error-home-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5em;
        padding: 0.75rem 1.5rem;
        background: var(--color-primary);
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s ease;
    }

    .error-home-link:hover {
        background: #146C3A;
    }
</style>