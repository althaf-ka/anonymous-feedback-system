<?php
$seo = [
    'title'       => 'Public Suggestions | Anonymous Feedback System',
    'description' => 'Browse, search, and filter through all public feedback and suggestions raised by the community. Upvote ideas you support and see their current status.'
];

$headAssets = [
    '<link rel="stylesheet" href="/assets/css/pages/public-suggestions.css">'
];


ob_start();
?>

<section class="suggestions-hero">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Public Suggestions</h2>
            <p class="section-subtitle">
                Discover ideas and help amplify important issues by voting on suggestions that matter to you.
            </p>
        </div>
    </div>
</section>

<section class="suggestions-filters">
    <div class="container">
        <form id="public-feedback-filters-form">
            <?php

            $categoryOptions = ['' => 'All Categories'];
            if (!empty($categories)) {
                $categoryOptions += array_column($categories, 'name', 'id');
            }

            $cfg = [
                'searchName' => 'search',
                'searchPH' => 'Search suggestions…',
                'selects'  => [
                    [
                        'id' => 'status',
                        'label' => 'Status',
                        'options' => [
                            '' => 'All',
                            'review' => 'In Review',
                            'progress' => 'In Progress',
                            'resolved' => 'Resolved'
                        ]
                    ],
                    [
                        'id' => 'category',
                        'label' => 'Category',
                        'options' => $categoryOptions
                    ],
                    [
                        'id' => 'sort',
                        'label' => 'Sort By',
                        'options' => [
                            'votes' => 'Most Votes',
                            'recent' => 'Most Recent',
                            'oldest' => 'Oldest First',
                        ]
                    ],
                ],
            ];
            include __DIR__ . '/../global/filters-section.php';
            ?>
        </form>
    </div>
</section>

<section class="suggestions-main">
    <div class="container">

        <div class="suggestions-container" id="suggestionsContainer">
            <?php
            require_once 'components/feedback-card.php';

            if (empty($initialDataFromServer['feedbacks'])) {
                echo '<div class="empty-state"><p>No suggestions found yet. Be the first to submit one!</p></div>';
            } else {
                foreach ($initialDataFromServer['feedbacks'] as $suggestion) {
                    echo renderFeedbackCard($suggestion);
                }
            }
            ?>
        </div>

    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>

<script>
    const initialSuggestions = <?= json_encode($initialDataFromServer) ?>;
</script>
<script src="/assets/js/public-suggestions-manager.js" defer></script>