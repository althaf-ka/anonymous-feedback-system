<?php
function renderFeedbackCard($title, $createdAt, $upvotes)
{
    $createdDate = date('F j, Y, g:i a', strtotime($createdAt));
    ?>
    <div class="suggestion-card">
        <div class="suggestion-content">
            <h2 class="suggestion-title"><?= htmlspecialchars($title) ?></h2>
            <p class="suggestion-date">Posted on <?= $createdDate ?></p>
        </div>
        <div class="suggestion-actions">
            <button class="btn-upvote" onclick="handleUpvote(this)">
                👍 <span class="upvote-count"><?= (int) $upvotes ?></span>
            </button>
        </div>
    </div>
    <?php
}
?>


<style>
    .suggestion-card {
        background-color: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        transition: box-shadow 0.2s ease;
    }

    .suggestion-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .suggestion-title {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--color-text);
    }

    .suggestion-date {
        margin: 0.25rem 0 0;
        font-size: 0.875rem;
        color: var(--color-text-muted);
    }

    .btn-upvote {
        background-color: var(--color-primary);
        color: white;
        border: none;
        padding: 0.5rem 0.9rem;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-upvote:hover {
        background-color: #166534;
    }

    .upvote-count {
        margin-left: 0.5rem;
        font-weight: bold;
    }

    @media (max-width: 640px) {
        .suggestion-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .suggestion-actions {
            align-self: stretch;
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }
    }
</style>

<script>
    function handleUpvote(button) {
        const countSpan = button.querySelector('.upvote-count');
        let count = parseInt(countSpan.innerText, 10);
        countSpan.innerText = count + 1;
        // TODO: Trigger AJAX to update backend
    }
</script>