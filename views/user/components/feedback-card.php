<?php
function renderFeedbackCard($data)
{
    $categoryColors = [
        'academics' => 'academics',
        'facilities' => 'facilities',
        'food' => 'food',
        'mental-health' => 'mental-health',
        'general' => 'general'
    ];

    $statusClasses = [
        'New' => 'status-new',
        'Under Review' => 'status-review',
        'In Progress' => 'status-progress',
        'Resolved' => 'status-resolved',
    ];

    $categoryClass = $categoryColors[$data['category']] ?? 'general';
    $statusClass = $statusClasses[$data['status']] ?? 'status-new';

    ob_start();
    ?>
    <div class="feedback-card rounded-sm" data-category="<?= htmlspecialchars($data['category']) ?>"
        data-status="<?= htmlspecialchars($data['status']) ?>">
        <div class="card-left">
            <div class="category-indicator <?= $categoryClass ?>"></div>
            <div class="card-content">
                <div class="card-meta">
                    <span class="category-name"><?= htmlspecialchars($data['category_name']) ?></span>
                    <span class="date-posted">
                        <?php if ($data['status'] === 'Resolved'): ?>
                            Resolved <?= htmlspecialchars($data['date']) ?>
                        <?php else: ?>
                            <?= htmlspecialchars($data['date']) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <h3 class="feedback-title"><?= htmlspecialchars($data['title']) ?></h3>
                <p class="feedback-preview"><?= htmlspecialchars($data['preview']) ?></p>
            </div>
        </div>
        <div class="card-right">
            <div class="status-badge <?= $statusClass ?>">
                <?= htmlspecialchars($data['status']) ?>
            </div>
            <div class="vote-section">
                <?php if ($data['status'] === 'Resolved'): ?>
                    <div class="vote-display">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 10l5-5 5 5" />
                            <path d="M12 5v14" />
                        </svg>
                        <span class="vote-count"><?= $data['votes'] ?></span>
                    </div>
                <?php else: ?>
                    <button class="vote-button" onclick="handleVote(this, <?= $data['id'] ?>)">
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
    <?php
    return ob_get_clean();
}
?>


<style>
    .feedback-card {
        background: var(--color-surface);
        border: 2px solid var(--color-border);
        padding: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow:
            0 2px 8px rgba(15, 81, 50, 0.04),
            0 1px 3px rgba(15, 81, 50, 0.02);
        position: relative;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .feedback-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg,
                rgba(74, 222, 128, 0.008) 0%,
                rgba(15, 81, 50, 0.004) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .feedback-card:hover::before {
        opacity: 1;
    }

    .feedback-card:hover {
        box-shadow:
            0 8px 25px rgba(15, 81, 50, 0.08),
            0 4px 12px rgba(15, 81, 50, 0.04);
        border-color: var(--color-secondary-light, #6EE7B7);
    }

    .card-left {
        flex: 1;
        display: flex;
        gap: 0.75rem;
        position: relative;
        z-index: 2;
        min-width: 0;
    }

    .category-indicator {
        width: 4px;
        min-height: 60px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* Category Colors Based on Type */
    .category-indicator.academics {
        background: linear-gradient(180deg, #3B82F6, #60A5FA);
    }

    .category-indicator.facilities {
        background: linear-gradient(180deg, #8B5CF6, #A78BFA);
    }

    .category-indicator.food {
        background: linear-gradient(180deg, #F59E0B, #FBBF24);
    }

    .category-indicator.mental-health {
        background: linear-gradient(180deg, #EC4899, #F472B6);
    }

    .category-indicator.general {
        background: linear-gradient(180deg, #6B7280, #9CA3AF);
    }

    .card-content {
        flex: 1;
        min-width: 0;
    }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }

    .category-name {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--color-primary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    .date-posted {
        font-size: 0.75rem;
        color: var(--color-text-muted);
        font-weight: 500;
        white-space: nowrap;
    }

    .feedback-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--color-text);
        margin-bottom: 0.5rem;
        line-height: 1.3;
        letter-spacing: -0.01em;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .feedback-preview {
        text-overflow: ellipsis;
        line-clamp: 2;
        font-size: 0.9rem;
        color: var(--color-text-secondary, #475569);
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .card-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.75rem;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.7rem;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        white-space: nowrap;
        text-align: center;
    }

    .vote-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.50rem;
    }

    .vote-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        background: var(--color-surface);
        border: 2px solid var(--color-border);
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
        color: var(--color-text-secondary, #475569);
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 50px;
    }

    .vote-button:hover {
        background: var(--color-secondary);
        border-color: var(--color-secondary);
        color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 222, 128, 0.25);
    }

    .vote-button.voted {
        background: var(--color-secondary);
        border-color: var(--color-secondary);
        color: var(--color-primary);
    }

    .vote-count {
        font-size: 1rem;
        font-weight: 800;
        line-height: 1;
    }

    .vote-label {
        font-size: 0.65rem;
        color: var(--color-text-muted);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .vote-display {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        background: rgba(34, 197, 94, 0.1);
        color: var(--color-success, #22C55E);
        border: 1px solid rgba(34, 197, 94, 0.3);
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
        font-weight: 700;
        min-width: 50px;
    }

    .vote-display svg {
        color: var(--color-success, #22C55E);
    }

    @media (max-width: 768px) {
        .feedback-card {
            padding: 1rem;
            gap: 0.75rem;
        }

        .card-left {
            gap: 0.75rem;
        }

        .card-meta {
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }


        .date-posted {
            font-size: 0.7rem;
        }

        .feedback-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .feedback-preview {
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .card-right {
            gap: 0.5rem;
        }

        .status-badge {
            font-size: 0.65rem;
            padding: 0.3rem 0.6rem;
        }

        .vote-button {
            padding: 0.5rem 0.6rem;
            min-width: 45px;
        }

        .vote-count {
            font-size: 0.9rem;
        }

        .vote-label {
            font-size: 0.6rem;
        }

        .vote-display {
            padding: 0.5rem 0.6rem;
            min-width: 45px;
        }

        .vote-display .vote-count {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .feedback-card {
            flex-direction: column;
            padding: 0;
            gap: 0;
        }

        .card-left {
            width: 100%;
            flex-direction: column;
            gap: 0;
        }

        .category-indicator {
            width: 100%;
            height: 4px;
            min-height: 4px;
            border-radius: 0;
            order: -1;
            /* Move to top */
        }

        .card-content {
            padding: 1rem;
        }

        .card-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
            margin-bottom: 0.75rem;
        }

        .feedback-title {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }

        .feedback-preview {
            text-overflow: ellipsis;
            line-clamp: 3;
            -webkit-line-clamp: 3;
        }

        .card-right {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-top: 1px solid var(--color-border);
            background: rgba(0, 0, 0, 0.02);
        }

        .vote-section {
            flex-direction: row-reverse;
            align-items: center;
        }

        .vote-button {
            flex-direction: row;
            padding: 0.5rem 0.75rem;
            min-width: auto;
            gap: 0.5rem;
        }

        .vote-button svg {
            width: 16px;
            height: 16px;
        }

        .vote-count {
            font-size: 0.9rem;
        }

        .vote-label {
            font-size: 0.65rem;
        }

        .vote-display {
            flex-direction: row;
            min-width: auto;
            gap: 0.5rem;
        }

        .vote-display svg {
            width: 16px;
            height: 16px;
        }
    }

    @media (max-width: 360px) {
        .feedback-title {
            font-size: 1rem;
        }

        .feedback-preview {
            font-size: 0.8rem;
        }

        .status-badge {
            font-size: 0.6rem;
            padding: 0.25rem 0.5rem;
        }

        .vote-button {
            padding: 0.4rem 0.6rem;
        }

        .vote-count {
            font-size: 0.85rem;
        }
    }
</style>