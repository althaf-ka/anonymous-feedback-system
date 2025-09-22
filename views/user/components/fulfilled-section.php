<?php
include_once 'feedback-card.php';
?>

<section class="fulfilled-suggestions">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Recently Fulfilled Suggestions</h2>
            <p class="section-subtitle">See how your feedback is making a real difference on campus</p>
        </div>

        <section class="suggestions-wrapper">
            <div class="suggestions-container">

                <?php if (!empty($completedSuggestions)): ?>

                    <?php foreach ($completedSuggestions as $suggestion): ?>
                        <?= renderFeedbackCard($suggestion) ?>
                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="empty-state">
                        <div class="empty-state__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                        </div>
                        <h3 class="empty-state__title">We're On It!</h3>
                        <p class="empty-state__message">
                            We're actively working on your feedback. Recently fulfilled suggestions will be showcased here as a testament to our community's great ideas!
                        </p>
                    </div>

                <?php endif; ?>

            </div>
        </section>

    </div>
</section>

<style>
    .fulfilled-suggestions {
        margin-top: 4rem;
        margin-bottom: 4rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        width: 100%;
    }

    .empty-state__icon {
        color: var(--color-secondary);
        margin-bottom: 1rem;
    }

    .empty-state__icon svg {
        opacity: 0.9;
    }

    .empty-state__title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 0.5rem;
    }

    .empty-state__message {
        font-size: 1rem;
        color: #6c757d;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
</style>