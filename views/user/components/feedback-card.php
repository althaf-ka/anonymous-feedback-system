<?php
function renderFeedbackCard($data)
{
    ob_start();
?>
    <a href="/feedback/<?= urlencode($data['id']) ?>" class="feedback-card-link">
        <div class="feedback-card rounded-sm" data-category="<?= htmlspecialchars($data['category']) ?>"
            data-status="<?= htmlspecialchars($data['status']) ?>">

            <div class="card-left">
                <div class="category-indicator" style="--indicator-color: <?= htmlspecialchars($data['category_color']) ?>;"></div>
                <div class="card-content">
                    <div class="card-meta">
                        <span class="category-name"><?= htmlspecialchars($data['category']) ?></span>
                        <span class="date-posted">
                            <?php if (strtolower($data['status']) === 'resolved'): ?>
                                Resolved <?= htmlspecialchars($data['created_at']) ?>
                            <?php else: ?>
                                <?= htmlspecialchars($data['created_at']) ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <h3 class="feedback-title"><?= htmlspecialchars($data['title']) ?></h3>
                    <p class="feedback-preview"><?= htmlspecialchars($data['message']) ?></p>
                </div>
            </div>

            <div class="card-right">
                <div class="rounded-sm status-badge status-<?= strtolower($data['status']) ?>">
                    <?= htmlspecialchars($data['status']) ?>
                </div>
                <div class="vote-section">
                    <?php if (strtolower($data['status']) === 'resolved'): ?>
                        <div class="vote-display">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 10l5-5 5 5" />
                                <path d="M12 5v14" />
                            </svg>
                            <span class="vote-count"><?= $data['votes'] ?></span>
                        </div>
                    <?php else: ?>
                        <button class="vote-button" data-id="<?= htmlspecialchars($data['id']) ?>"
                            onclick="event.preventDefault(); event.stopPropagation(); handleVote(this, '<?= htmlspecialchars($data['id']) ?>')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 10l5-5 5 5" />
                                <path d="M12 5v14" />
                            </svg>
                            <span class="vote-count"><?= $data['votes'] ?></span>
                        </button>
                    <?php endif; ?>
                    <span class="vote-label">votes</span>
                </div>
            </div>
        </div>
    </a>
<?php
    return ob_get_clean();
}
?>