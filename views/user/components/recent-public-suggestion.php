<?php

include 'feedback-card.php';


$suggestions = [
    [
        'id' => 1,
        'category' => 'academics',
        'category_name' => 'Academics',
        'title' => 'Extended Library Hours During Exams',
        'preview' => 'The library should stay open 24/7 during exam periods to accommodate different study schedules and reduce overcrowding during peak hours.',
        'votes' => 23,
        'status' => 'Under Review',
        'date' => '2 days ago'
    ],
    [
        'id' => 2,
        'category' => 'facilities',
        'category_name' => 'Facilities',
        'title' => 'More Study Spaces in Common Areas',
        'preview' => 'Convert some recreational areas into quiet study spaces with proper lighting, charging stations, and comfortable seating for students.',
        'votes' => 18,
        'status' => 'New',
        'date' => '4 days ago'
    ],
    [
        'id' => 3,
        'category' => 'food',
        'category_name' => 'Food Services',
        'title' => 'Healthier Meal Options in Cafeteria',
        'preview' => 'Include more vegetarian, vegan, and gluten-free options with clear nutritional information and ingredient lists for students.',
        'votes' => 15,
        'status' => 'In Progress',
        'date' => '1 week ago'
    ],
    [
        'id' => 4,
        'category' => 'mental-health',
        'category_name' => 'Mental Health',
        'title' => 'Peer Support Groups',
        'preview' => 'Establish student-led support groups for stress management, anxiety, and academic pressure with professional guidance.',
        'votes' => 31,
        'status' => 'Approved',
        'date' => '1 week ago'
    ]
];
?>

<section class="recent-suggestions">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Recent Public Suggestions</h2>
            <p class="section-subtitle">See what your fellow students are saying</p>
        </div>

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
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    <p class="overlay-text">+12 more suggestions</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
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