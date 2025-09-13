<?php
$title        = "Feedback | Admin Panel";
$headAssets[] = '<link rel="stylesheet" href="/assets/css/pages/feedback.css">';
$showSidebar  = $showHeader = true;

$rows = [
    ['id' => 101, 'title' => 'Improve campus Wi-Fi', 'cat' => 'IT Support', 'st' => 'new', 'votes' => 12, 'pub' => true, 'time' => '2024-09-13 14:30:25'],
    ['id' => 102, 'title' => 'Extend library hours', 'cat' => 'Facilities', 'st' => 'review', 'votes' => 8, 'pub' => false, 'time' => '2024-09-12 09:15:42'],
    ['id' => 103, 'title' => 'Add more parking', 'cat' => 'Facilities', 'st' => 'progress', 'votes' => 15, 'pub' => true, 'time' => '2024-09-10 16:22:18'],
    ['id' => 104, 'title' => 'Upgrade gym equipment', 'cat' => 'Facilities', 'st' => 'resolved', 'votes' => 20, 'pub' => false, 'time' => '2024-09-06 11:45:33'],
    ['id' => 105, 'title' => 'Digitize lab manuals', 'cat' => 'Academics', 'st' => 'new', 'votes' => 5, 'pub' => true, 'time' => '2024-09-13 11:20:17'],
];

include __DIR__ . "/components/status-selector.php";

ob_start();
?>

<section class="feedback-section">
    <header class="page-head">
        <h1 class="admin-page-title">Feedback</h1>

        <?php
        $cfg = [
            'searchPH' => 'Search feedback…',
            'selects'  => [
                ['id' => 'status', 'label' => 'Status', 'options' => [
                    '' => 'All',
                    'new' => 'New',
                    'review' => 'Review',
                    'progress' => 'In Progress',
                    'resolved' => 'Resolved'
                ]],
                ['id' => 'category', 'label' => 'Category', 'options' => [
                    '' => 'All',
                    'academics' => 'Academics',
                    'facilities' => 'Facilities',
                    'food' => 'Food Services',
                    'mental-health' => 'Mental Health',
                    'general' => 'General'
                ]],
                ['id' => 'sort', 'label' => 'Sort By', 'options' => [
                    'votes' => 'Most Votes',
                    'recent' => 'Most Recent',
                    'oldest' => 'Oldest First',
                    'title' => 'Title A-Z'
                ]],
            ],
        ];
        include __DIR__ . '/../global/filters-section.php';
        ?>
    </header>


    <form method="post" action="/admin/feedback/bulk-delete">
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
                    <?php foreach ($rows as $fb): ?>
                        <div role="row" class="table-row">
                            <div role="gridcell" class="cell checkbox-cell">
                                <input type="checkbox"
                                    class="row-cb"
                                    name="ids[]"
                                    value="<?= $fb['id'] ?>"
                                    onclick="event.stopPropagation()">
                            </div>
                            <a href="/admin/feedback/<?= $fb['id'] ?>" class="row-link" data-id="<?= $fb['id'] ?>">
                                <div role="gridcell" class="cell">
                                    <?= htmlspecialchars($fb['title']) ?>
                                </div>
                                <div role="gridcell" class="cell">
                                    <?= htmlspecialchars($fb['cat']) ?>
                                </div>
                                <div role="gridcell" class="cell time-cell">
                                    <?= htmlspecialchars($fb['time']) ?>
                                </div>
                                <div role="gridcell" class="cell votes-cell">
                                    <?= $fb['pub'] ? $fb['votes'] : '–' ?>
                                </div>
                            </a>
                            <div role="gridcell" class="cell status-cell">
                                <?php renderStatusSelector($fb['st'], $fb['id']); ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <button type="submit"
            name="action" value="delete"
            class="bulk-delete-btn rounded-sm">
            Delete Selected
        </button>
    </form>
</section>


<script>
    const boxes = document.querySelectorAll('.row-cb'),
        delBtn = document.querySelector('.bulk-delete-btn');

    function toggleBtn() {
        if ([...boxes].some(cb => cb.checked)) {
            delBtn.classList.add('show');
        } else {
            delBtn.classList.remove('show');
        }
    }

    boxes.forEach(cb => cb.addEventListener('change', toggleBtn));
</script>

<?php $content = ob_get_clean();
include __DIR__ . '/layout.php'; ?>