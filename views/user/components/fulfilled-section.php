<?php
include_once 'feedback-card.php';

$completedSuggestions = [
    [
        'id' => 1,
        'category' => 'academics',
        'category_name' => 'Academics',
        'title' => 'Extended Library Hours During Exams',
        'preview' => 'The library should stay open 24/7 during exam periods to accommodate different study schedules and reduce overcrowding during peak hours.',
        'votes' => 23,
        'status' => 'Resolved',
        'date' => '2 days ago'
    ],
    [
        'id' => 2,
        'category' => 'facilities',
        'category_name' => 'Facilities',
        'title' => 'More Study Spaces in Common Areas',
        'preview' => 'Convert some recreational areas into quiet study spaces with proper lighting, charging stations, and comfortable seating for students.',
        'votes' => 18,
        'status' => 'Resolved',
        'date' => '4 days ago'
    ],
];
?>


<section class="fulfilled-suggestions">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Recently Fulfilled Suggestions</h2>
            <p class="section-subtitle">See how your feedback is making a real difference on campus</p>
        </div>


        <section class="suggestions-wrapper">
            <div class="suggestions-container">
                <?php foreach ($completedSuggestions as $suggestion): ?>
                    <?= renderFeedbackCard($suggestion) ?>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</section>

<!-- Shares css properties from recent-public-suggestions component -->
<style>
    .fulfilled-suggestions {
        margin-top: 4rem;
        margin-bottom: 4rem;
    }
</style>