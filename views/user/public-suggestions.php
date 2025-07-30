<?php
$title = "Public Suggestions | Feedback System";
$additionalHead = '<link rel="stylesheet" href="../../assets/css/pages/public-suggestions.css">';

ob_start();
?>

<!-- Hero Section -->
<section class="suggestions-hero">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Public Suggestions</h2>
            <p class="section-subtitle">
                Discover ideas from fellow students and help amplify important issues by voting on suggestions that
                matter to you.
            </p>
        </div>
    </div>
</section>

<!-- Filters and Search Section -->
<section class="suggestions-filters">
    <div class="container">
        <div class="filters-container">
            <div class="search-section">
                <div class="search-wrapper">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input rounded-sm"
                        placeholder="Search suggestions...">
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-group">
                    <label class="filter-label" for="categoryFilter">Category</label>
                    <select id="categoryFilter" class="filter-select rounded-sm">
                        <option value="">All Categories</option>
                        <option value="academics">Academics</option>
                        <option value="facilities">Facilities</option>
                        <option value="food">Food Services</option>
                        <option value="mental-health">Mental Health</option>
                        <option value="general">General</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label" for="statusFilter">Status</label>
                    <select id="statusFilter" class="filter-select rounded-sm">
                        <option value="">All Status</option>
                        <option value="New">New</option>
                        <option value="Under Review">Under Review</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Approved">Approved</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label" for="sortFilter">Sort By</label>
                    <select id="sortFilter" class="filter-select rounded-sm">
                        <option value="votes">Most Votes</option>
                        <option value="recent">Most Recent</option>
                        <option value="oldest">Oldest First</option>
                        <option value="title">Title A-Z</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Suggestions Section -->
<section class="suggestions-main">
    <div class="container">

        <div class="suggestions-container" id="suggestionsContainer">
            <?php
            // Include your feedback card component
            require_once 'components/feedback-card.php';

            // Sample data (this would come from your database)
            $publicSuggestions = [
                [
                    'id' => 1,
                    'category' => 'academics',
                    'category_name' => 'Academics',
                    'title' => 'Extended Library Hours During Exams',
                    'preview' => 'The library should stay open 24/7 during exam periods to accommodate different study schedules and reduce overcrowding during peak hours.',
                    'votes' => 45,
                    'status' => 'Under Review',
                    'date' => '2 days ago'
                ],
                [
                    'id' => 2,
                    'category' => 'facilities',
                    'category_name' => 'Facilities',
                    'title' => 'More Study Spaces in Common Areas',
                    'preview' => 'Convert some recreational areas into quiet study spaces with proper lighting, charging stations, and comfortable seating.',
                    'votes' => 32,
                    'status' => 'New',
                    'date' => '4 days ago'
                ],
                [
                    'id' => 3,
                    'category' => 'food',
                    'category_name' => 'Food Services',
                    'title' => 'Healthier Meal Options in Cafeteria',
                    'preview' => 'Include more vegetarian, vegan, and gluten-free options with clear nutritional information and ingredient lists.',
                    'votes' => 28,
                    'status' => 'In Progress',
                    'date' => '1 week ago'
                ],
                [
                    'id' => 4,
                    'category' => 'mental-health',
                    'category_name' => 'Mental Health',
                    'title' => 'Peer Support Groups',
                    'preview' => 'Establish student-led support groups for stress management, anxiety, and academic pressure with professional guidance.',
                    'votes' => 67,
                    'status' => 'Approved',
                    'date' => '3 days ago'
                ],
                [
                    'id' => 5,
                    'category' => 'academics',
                    'category_name' => 'Academics',
                    'title' => 'Online Course Material Access',
                    'preview' => 'Provide better digital access to course materials, including recorded lectures and downloadable resources.',
                    'votes' => 89,
                    'status' => 'Completed',
                    'date' => '2 weeks ago'
                ],
                [
                    'id' => 6,
                    'category' => 'general',
                    'category_name' => 'General',
                    'title' => 'Better Campus WiFi Coverage',
                    'preview' => 'Improve internet connectivity in dormitories and outdoor areas with stronger and more reliable WiFi access points.',
                    'votes' => 54,
                    'status' => 'Under Review',
                    'date' => '5 days ago'
                ]
            ];

            // Render feedback cards using your existing component
            foreach ($publicSuggestions as $suggestion): ?>
                <?= renderFeedbackCard($suggestion) ?>
            <?php endforeach; ?>
        </div>

        <!-- Load More Button -->
        <div class="load-more-section">
            <button class="btn btn-primary load-more-btn" id="loadMoreBtn">
                <span>Load More Suggestions</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </button>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const sortFilter = document.getElementById('sortFilter');
        const suggestionsContainer = document.getElementById('suggestionsContainer');
        const resultsCount = document.getElementById('resultsCount');
        const loadMoreBtn = document.getElementById('loadMoreBtn');

        // Search functionality
        searchInput.addEventListener('input', debounce(filterSuggestions, 300));

        // Filter functionality
        categoryFilter.addEventListener('change', filterSuggestions);
        statusFilter.addEventListener('change', filterSuggestions);
        sortFilter.addEventListener('change', filterSuggestions);

        // Load more functionality
        loadMoreBtn.addEventListener('click', function () {
            this.innerHTML = '<span>Loading...</span>';

            // Simulate loading more content
            setTimeout(() => {
                showToast('More suggestions loaded!', 'success');
                this.innerHTML = '<span>Load More Suggestions</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>';
            }, 1000);
        });

        function filterSuggestions() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;
            const selectedStatus = statusFilter.value;
            const sortBy = sortFilter.value;

            const cards = Array.from(suggestionsContainer.querySelectorAll('.feedback-card'));
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.querySelector('.feedback-title').textContent.toLowerCase();
                const preview = card.querySelector('.feedback-preview').textContent.toLowerCase();
                const category = card.dataset.category;
                const status = card.querySelector('.status-badge').textContent.trim();

                const matchesSearch = !searchTerm || title.includes(searchTerm) || preview.includes(searchTerm);
                const matchesCategory = !selectedCategory || category === selectedCategory;
                const matchesStatus = !selectedStatus || status === selectedStatus;

                if (matchesSearch && matchesCategory && matchesStatus) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update results count
            resultsCount.textContent = visibleCount;

            // Sort visible cards
            if (sortBy && visibleCount > 0) {
                sortSuggestions(sortBy);
            }
        }

        function sortSuggestions(sortBy) {
            const cards = Array.from(suggestionsContainer.querySelectorAll('.feedback-card[style*="flex"]'));

            cards.sort((a, b) => {
                switch (sortBy) {
                    case 'votes':
                        const votesA = parseInt(a.querySelector('.vote-count').textContent);
                        const votesB = parseInt(b.querySelector('.vote-count').textContent);
                        return votesB - votesA;
                    case 'recent':
                        return 0; // Would implement proper date sorting in real app
                    case 'title':
                        const titleA = a.querySelector('.feedback-title').textContent;
                        const titleB = b.querySelector('.feedback-title').textContent;
                        return titleA.localeCompare(titleB);
                    default:
                        return 0;
                }
            });

            // Re-append sorted cards
            cards.forEach(card => suggestionsContainer.appendChild(card));
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }


    });

</script>