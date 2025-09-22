<?php
include 'feedback-card.php';
?>

<section class="recent-suggestions">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Recent Public Suggestions</h2>
            <p class="section-subtitle">See what your fellow students are saying</p>
        </div>
        <?php if (!empty($suggestions)): ?>
            <div class="suggestions-wrapper">
                <div class="suggestions-container">
                    <?php foreach ($suggestions as $index => $suggestion): ?>
                        <div class="suggestion-item <?= $index === count($suggestions) - 1 ? 'last-item' : '' ?>">
                            <?= renderFeedbackCard($suggestion) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="blur-overlay">
                    <div class="overlay-content">
                        <a href="/public-suggestions" class="btn btn-outline view-all-btn">
                            <span>View All Suggestions</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                        <!-- We subtract the count of suggestions shown from the total -->
                        <p class="overlay-text">+<?= $totalSuggestions - count($suggestions) ?> more suggestions</p>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <div class="empty-state">
                <div class="empty-state__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </div>
                <h3 class="empty-state__title">Be the First to Suggest an Idea!</h3>
                <p class="empty-state__message">
                    This space is waiting for brilliant ideas from our community. Share your thoughts and help shape our campus future.
                </p>
                <a href="/submit-feedback" class="btn btn-primary submit-idea-btn">
                    <span>Share Your Idea</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

        <?php endif; ?>

    </div>
</section>

<style>
    /* Your existing styles are perfect, just add the new ones below */
    .recent-suggestions {
        padding: 4rem 1.5rem;
        position: relative;
    }

    .suggestions-wrapper {
        position: relative;
        opacity: 0;
        animation: fadeInUp 0.6s ease 0.2s forwards;
    }

    .suggestions-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .suggestion-item.last-item {
        position: relative;
        mask: linear-gradient(to bottom,
                rgba(0, 0, 0, 1) 0%,
                rgba(0, 0, 0, 1) 50%,
                rgba(0, 0, 0, 0.4) 80%,
                rgba(0, 0, 0, 0) 100%);
        -webkit-mask: linear-gradient(to bottom,
                rgba(0, 0, 0, 1) 0%,
                rgba(0, 0, 0, 1) 50%,
                rgba(0, 0, 0, 0.4) 80%,
                rgba(0, 0, 0, 0) 100%);
    }

    .blur-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: all 0.3s ease;
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
        background: linear-gradient(to bottom,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.5) 40%,
                rgba(255, 255, 255, 0.8) 70%,
                rgba(255, 255, 255, 1) 100%);
    }

    .overlay-content {
        text-align: center;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease 0.8s forwards;
        opacity: 0;
    }

    .view-all-btn {
        display: inline-flex;
        align-items: center;
        padding: 1rem 2rem;
        gap: 8px;
        margin-bottom: 0.5rem;
        transform: translateY(0);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .view-all-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .overlay-text {
        color: var(--color-text-muted);
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
        opacity: 0.8;
    }

    /* ================================== */
    /* ✨ NEW: Empty State Styles Here ✨ */
    /* ================================== */

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background-color: #f8f9fa;
        /* A light, neutral background */
        border-radius: 8px;
        border: 1px solid #e9ecef;
        /* A subtle border */
        margin-top: 1.5rem;
        /* Space between header and this box */
        opacity: 0;
        animation: fadeInUp 0.6s ease 0.2s forwards;
    }

    .empty-state__icon {
        color: #0d6efd;
        /* Your primary brand color */
        margin-bottom: 1rem;
    }

    .empty-state__icon svg {
        opacity: 0.7;
    }

    .empty-state__title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #343a40;
        /* Darker text for the title */
        margin-bottom: 0.5rem;
    }

    .empty-state__message {
        font-size: 1rem;
        color: #6c757d;
        /* Softer text color for the message */
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .submit-idea-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 1.5rem;
        padding: 0.875rem 1.75rem;
    }


    @media (max-width: 768px) {
        .recent-suggestions {
            padding: 3rem 0rem;
        }

        .section-subtitle {
            font-size: 1.10rem;
        }

        .view-all-btn {
            max-width: 280px;
            justify-content: center;
        }

        .blur-overlay {
            height: 160px;
        }

        .overlay-content {
            transform: translateY(15px);
        }
    }

    @media (max-width: 480px) {
        .recent-suggestions {
            padding: 2.5rem 0rem;
        }

        .blur-overlay {
            height: 160px;
        }

        .view-all-btn {
            padding: 0.875rem 1.5rem;
            font-size: 0.9rem;
        }

        .overlay-text {
            font-size: 0.8rem;
        }
    }
</style>