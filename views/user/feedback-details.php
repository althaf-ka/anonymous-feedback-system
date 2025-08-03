<?php
$title = "Extended Library Hours During Exams | Feedback System";
$additionalHead = '<link rel="stylesheet" href="/assets/css/pages/feedback-details.css">';

ob_start();
?>

<!-- Improved Clean Header -->
<section class="feedback-header">
    <div class="container">
        <h1 class="section-title">Extended Library Hours During Exams</h1>
        <div class="feedback-meta">
            <span class="meta-item rounded-sm academics category-indicator">
                Academics
            </span>
            <span class="rounded-sm status-resolved meta-item">
                Resolved
            </span>
            <span class="meta-item rounded-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                2 days ago
            </span>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="feedback-content">
    <div class="container">
        <div class="content-layout">
            <!-- Main Content Area -->
            <div class="main-content">
                <div class="content-card rounded-sm">
                    <div class="card-header">
                        <h2 class="card-title">Feedback Description</h2>
                    </div>
                    <div class="card-content">
                        <div class="description-text">
                            <p>The library should stay open 24/7 during exam periods to accommodate different study schedules and reduce overcrowding during peak hours. Many students prefer studying late at night or early in the morning, and the current limited hours create unnecessary stress during already challenging exam periods.</p>
                            
                            <p>This would particularly benefit students with different sleep schedules, international students adjusting to time zones, students with part-time jobs who can only study at night, and those who find the library less crowded during off-peak hours.</p>
                            
                            <p>The implementation could include additional security measures and maybe a reduced staff presence during overnight hours, but keeping the main study areas accessible would make a significant difference to student success.</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Official Response Section -->
                <div class="content-card official-response rounded-sm">
                    <div class="card-header">
                        <div class="official-badge">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Official Response
                        </div>
                        <span class="response-date">1 day ago</span>
                    </div>
                    <div class="card-content">
                        <p>Thank you for this suggestion. We have implemented extended library hours during exam periods starting this semester. The library will now be open 24/7 during the two weeks before final exams.</p>
                    </div>
                </div>
            </div>

            <!-- Updated Sidebar with Feedback Card Style Vote Button -->
            <div class="sidebar">
                <!-- Updated Vote Section -->
                <div class="vote-card rounded-sm">
                    <div class="vote-section">
                        <?php
                        // Sample data - replace with your actual data
                        $feedback_status = 'New'; // or 'Under Review', 'New', etc.
$vote_count = 45;
$feedback_id = 123;
?>
                        
                        <?php if ($feedback_status === 'Resolved'): ?>
                            <div class="vote-display">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12l2 2 4-4" />
                                </svg>
                                <span class="vote-count"><?= $vote_count ?></span>
                            </div>
                        <?php else: ?>
                            <button class="vote-button" onclick="handleVote(this, <?= $feedback_id ?>)">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M7 10l5-5 5 5" />
                                    <path d="M12 5v14" />
                                </svg>
                                <span class="vote-count"><?= $vote_count ?></span>
                            </button>
                        <?php endif; ?>
                        <span class="vote-label">votes</span>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="details-card rounded-sm">
                    <h3 class="details-title">Details</h3>
                    <div class="details-grid">
                        <div class="detail-item">
                            <span class="detail-label">Status</span>
                            <span class="detail-value status-resolved">Resolved</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Category</span>
                            <span class="detail-value">Academics</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Priority</span>
                            <span class="detail-value priority-high">High</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Date</span>
                            <span class="detail-value">Dec 28, 2024</span>
                        </div>
                    </div>
                    
                    <!-- Compact Copy Button -->
                    <div class="actions-section">
                        <button class="btn btn-primary copy-button" onclick="copyLink()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                            </svg>
                            Share Feedback
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
function handleVote(button, feedbackId) {
    const voteCount = button.querySelector('.vote-count');
    let currentVotes = parseInt(voteCount.textContent);
    let isVoted = button.classList.contains('voted');
    
    if (isVoted) {
        currentVotes--;
        button.classList.remove('voted');
        showToast('Vote removed', 'info');
    } else {
        currentVotes++;
        button.classList.add('voted');
        showToast('Vote added!', 'success');
    }
    
    voteCount.textContent = currentVotes;
    
    // Here you would make an AJAX call to update the vote in your database
    // updateVoteInDatabase(feedbackId, isVoted ? 'remove' : 'add');
}

function copyLink() {
    const url = window.location.href;
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            showToast('Link copied!', 'success');
        });
    } else {
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        showToast('Link copied!', 'success');
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
