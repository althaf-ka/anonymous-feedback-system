<?php
function renderStatusSelector(string $current, int | string $id): void
{
    $statuses = [
        'new'      => 'New',
        'review'   => 'In Review',
        'progress' => 'In Progress',
        'resolved' => 'Resolved'
    ];
?>
    <div class="status-dropdown" data-id="<?= $id ?>">
        <button type="button" class="status-dropdown__btn rounded-sm status-<?= $current ?>">
            <span class="status-dropdown__label"><?= htmlspecialchars($statuses[$current] ?? ucfirst($current)) ?></span>
            <svg class="status-dropdown__chevron" width="12" height="12" viewBox="0 0 24 24">
                <path fill="currentColor" d="M7 10l5 5 5-5z" />
            </svg>
        </button>

        <ul class="status-dropdown__menu rounded-sm">
            <?php foreach ($statuses as $key => $label): ?>
                <li data-value="<?= $key ?>"
                    class="status-dropdown__option status-<?= $key ?><?= $key === $current ? ' active' : '' ?>">
                    <?= htmlspecialchars($label) ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php
}
?>