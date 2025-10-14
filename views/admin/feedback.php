<?php
$seo = [
    'title' => 'All Feedback | Admin Panel',
    'description' => 'View, manage, filter, and search all feedback submissions in the admin panel.'
];
$headAssets[] = '<link rel="stylesheet" href="/assets/css/pages/feedback.css">';
$showSidebar = $showHeader = true;

include __DIR__ . "/components/status-selector.php";
require_once __DIR__ . "/components/modal.php";

ob_start();
?>

<section class="feedback-section">
    <header class="page-head">
        <h1 class="admin-page-title">Feedback</h1>
    </header>

    <form id="feedback-filters-form">
        <div class="admin-feedback-filter">

            <?php
            $categoryOptions = ['' => 'All'];
            if (!empty($categories)) {
                $categoryOptions += array_column($categories, 'name', 'id');
            }
            $cfg = [
                'searchName' => 'search',
                'searchPH'   => 'Search feedback…',
                'selects'    => [
                    ['id' => 'status', 'label' => 'Status', 'options' => [
                        '' => 'All',
                        'new' => 'New',
                        'review' => 'Review',
                        'progress' => 'In Progress',
                        'resolved' => 'Resolved'
                    ]],
                    ['id' => 'category', 'label' => 'Category', 'options' => $categoryOptions],
                    ['id' => 'sort', 'label' => 'Sort By', 'options' => [
                        'recent' => 'Most Recent',
                        'votes' => 'Most Votes',
                        'oldest' => 'Oldest First',
                        'title' => 'Title A-Z'
                    ]],
                ],
            ];
            include_once __DIR__ . '/../global/filters-section.php';
            ?>
        </div>


        <?php if (empty($rows['feedbacks'])): ?>
            <div class="no-feedback-message">
                <p>No feedback has been found.</p>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <div role="grid" class="feedback-table rounded-sm">
                    <div role="row" class="table-header">
                        <div role="columnheader" class="cell checkbox-cell"></div>
                        <div role="columnheader" class="cell">Subject</div>
                        <div role="columnheader" class="cell">Category</div>
                        <div role="columnheader" class="cell">Time</div>
                        <div role="columnheader" class="cell votes-cell">Votes</div>
                        <div role="columnheader" class="cell status-cell">Status</div>
                    </div>

                    <div role="rowgroup" class="table-body">
                        <?php foreach ($rows['feedbacks'] as $fb): ?>
                            <div role="row" class="table-row">
                                <div role="gridcell" class="cell checkbox-cell">
                                    <input type="checkbox" class="row-cb" name="ids[]" value="<?= $fb['id'] ?>" onclick="event.stopPropagation()">
                                </div>
                                <a href="/admin/feedback/<?= $fb['id'] ?>" class="row-link" data-id="<?= $fb['id'] ?>">
                                    <div role="gridcell" class="cell"><?= htmlspecialchars($fb['title']) ?></div>
                                    <div role="gridcell" class="cell text-capitalize"><?= htmlspecialchars($fb['cat']) ?></div>
                                    <div role="gridcell" class="cell time-cell"><?= htmlspecialchars($fb['created_at']) ?></div>
                                    <div role="gridcell" class="cell votes-cell"><?= $fb['allow_public'] ? $fb['votes'] : '–' ?></div>
                                </a>
                                <div role="gridcell" class="cell status-cell">
                                    <?php renderStatusSelector($fb['status'], $fb['id']); ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>

            <button type="submit" name="action" value="delete" class="bulk-delete-btn rounded-sm">
                Delete Selected
            </button>
        <?php endif; ?>

        <div id="feedback-error-container"></div>
    </form>
</section>

<?php
$deleteModalFooter = <<<HTML
    <button type="button" class="btn btn-ghost" data-close-modal="delete-confirmation-modal">Cancel</button>
    <button type="button" id="confirm-delete-btn" class="btn btn-danger">Confirm Delete</button>
HTML;

renderModal(
    'delete-confirmation-modal',
    'Confirm Deletion',
    '<p>Are you sure you want to delete the selected item(s)? This action cannot be undone.</p>',
    $deleteModalFooter
);
?>

<script>
    const initialFeedbackData = <?= json_encode($rows) ?>;
</script>
<script src="/assets/js/feedback-manager.js" defer></script>

<?php $content = ob_get_clean();
include __DIR__ . '/layout.php'; ?>

<?php
$deleteModalFooter = <<<HTML
    <button type="button" class="btn btn-ghost" data-close-modal="delete-confirmation-modal">Cancel</button>
    <button type="button" id="confirm-delete-btn" class="btn btn-danger">Confirm Delete</button>
HTML;

renderModal(
    'delete-confirmation-modal',
    'Confirm Deletion',
    '<p>Are you sure you want to delete the selected item(s)? This action cannot be undone.</p>',
    $deleteModalFooter
);
?>