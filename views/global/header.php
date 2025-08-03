<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="/" class="header-logo">
                <div class="flex">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                </div>
                <h1 class="header-title"><?= $title ?? 'Feedback System' ?></h1>
            </a>

            <div class="header-actions">
                <?php if (!empty($isAdmin)): ?>
                    <a href="/logout" class="btn btn-primary header-btn">Logout</a>
                <?php else: ?>
                    <a href="/submit-feedback" class="btn btn-primary header-btn">Submit Feedback</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<style>
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background-color: rgba(255, 255, 255, 0.90);
        border-bottom: 1px solid var(--color-border);
        z-index: 50;
        box-shadow: var(--shadow-sm);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 4rem;
        width: 100%;
    }

    .header-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--color-text);
        letter-spacing: -0.015em;
        margin: 0;
        line-height: 1.2;
        white-space: nowrap;
    }

    .header-logo {
        display: flex;
        gap: 8px;
        align-items: center;
        color: var(--color-secondary);
        text-decoration: none;
        flex-shrink: 0;
    }

    .header-btn {
        font-size: 0.875rem;
        padding: 0.625rem 1.25rem;
        white-space: nowrap;
        flex-shrink: 0;
        min-width: auto;
    }

    /* Tablet */
    @media (max-width: 768px) {
        .container {
            padding: 0 1rem;
        }

        .header-content {
            gap: 1rem;
        }

        .header-title {
            font-size: 1.3rem;
        }

        .header-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 640px) {
        .container {
            padding: 0 0.75rem;
        }

        .header-content {
            gap: 0.75rem;
        }

        .header-title {
            font-size: 1.2rem;
        }

        .header-btn {
            padding: 0.5rem 0.875rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 0.5rem;
        }

        .header-content {
            gap: 0.5rem;
        }

        .header-title {
            font-size: 1.1rem;
        }

        .header-btn {
            padding: 0.45rem 0.75rem;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 360px) {
        .header-title {
            font-size: 1rem;
        }

        .header-btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.7rem;
        }
    }
</style>