<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="header-left">
                <?php if (!empty($isAdmin)): ?>
                    <button class="hamburger" id="sidebarToggle" aria-label="Toggle Sidebar" onclick="toggleSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor">
                            <path d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,72H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Z" />
                        </svg>
                    </button>
                <?php endif; ?>

                <a href="/" class="header-logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                    <h1 class="header-title"><?= $headerTitle ?? 'Feedback System' ?></h1>
                </a>
            </div>

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
        background-color: rgba(255, 255, 255, 0.95);
        border-bottom: 1px solid var(--color-border);
        z-index: 50;
        box-shadow: var(--shadow-sm);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        box-sizing: border-box;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 4rem;
        width: 100%;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-logo {
        display: flex;
        gap: 8px;
        align-items: center;
        text-decoration: none;
        flex-shrink: 0;
    }

    .header-logo svg {
        color: var(--color-secondary);
    }

    .header-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.2;
        white-space: nowrap;
    }

    .hamburger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 8px;
        background-color: transparent;
        cursor: pointer;
        color: var(--color-text);
        transition: background-color 0.2s ease;
    }

    .hamburger svg {
        width: 22px;
        height: 22px;
        fill: currentColor;
    }

    .hamburger:hover {
        background-color: var(--color-surface-hover, rgba(0, 0, 0, 0.05));
    }

    .hamburger:active {
        background-color: var(--color-surface-active, rgba(0, 0, 0, 0.1));
    }

    @media (min-width: 769px) {
        .header {
            display: none;
        }

        .hamburger {
            display: none;
        }
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-btn {
        font-size: 0.875rem;
        padding: 0.625rem 1.25rem;
        white-space: nowrap;
        flex-shrink: 0;
    }
</style>