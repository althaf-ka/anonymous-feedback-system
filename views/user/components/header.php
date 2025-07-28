<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="/" class="header-logo">
                <div class="flex">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                </div>
                <h1 class="header-title">Feedback System</h1>
            </a>

            <a href="/submit-feedback" class="btn btn-primary header-btn" onclick="submitFeedback()">Submit
                Feedback</a>
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
    }

    .header-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--color-text);
        letter-spacing: -0.015em;
        margin: 0;
        line-height: 1.2;
    }

    .header-logo {
        display: flex;
        gap: 8px;
        align-items: center;
        color: var(--color-secondary);
    }

    .header-btn {
        font-size: 0.875rem;
        padding: 0.625rem 1.25rem;
    }

    @media (max-width: 640px) {
        .header-content {
            gap: 0.5rem;
        }

        .header-title {
            font-size: 1.25rem;
        }

        .header-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>

<script>
    function submitFeedback() {
        alert("Feedback submitted!");
    }
</script>