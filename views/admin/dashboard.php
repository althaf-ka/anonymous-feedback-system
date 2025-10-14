<?php
$seo = [
    'title' => 'Dashboard | Admin Panel',
    'description' => 'Admin dashboard for the Anonymous Feedback System.'
];
$headAssets = [
    '<link rel="stylesheet" href="/assets/css/pages/dashboard.css">'
];
$showSidebar = $showHeader = true;

ob_start();
?>

<div class="dashboard">
    <header class="dashboard-header">
        <h1 class="admin-page-title">Dashboard</h1>
    </header>

    <!-- ===== Metrics Section ===== -->
    <section class="metrics-section">
        <div class="metrics-grid">
            <!-- Total Feedback -->
            <article class="metric-card primary-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon primary rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="24" height="24">
                            <rect width="24" height="24" fill="none" />
                            <path d="M45.15,230.11A8,8,0,0,1,32,224V64a8,8,0,0,1,8-8H216a8,8,0,0,1,8,8V192a8,8,0,0,1-8,8H80Z"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">Total Feedback</h3>
                        <p class="metric-value"><?= number_format($dashboardData['metrics']['totalFeedback']) ?></p>
                        <span class="metric-trend neutral">All-time submissions</span>
                    </div>
                </div>
            </article>

            <!-- Pending Review -->
            <article class="metric-card warning-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon warning rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" height="24" width="24">
                            <circle cx="128" cy="136" r="88" fill="none" stroke="currentColor" stroke-width="16" />
                            <line x1="128" y1="136" x2="168" y2="96" stroke="currentColor" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">Pending Review</h3>
                        <p class="metric-value pending"><?= number_format($dashboardData['metrics']['pendingFeedback']) ?></p>
                        <span class="metric-trend urgent">Requires attention</span>
                    </div>
                </div>
            </article>

            <!-- Resolved -->
            <article class="metric-card success-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon success rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="24" height="24">
                            <polyline points="40 144 96 200 224 72" fill="none" stroke="currentColor" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">Resolved</h3>
                        <p class="metric-value"><?= number_format($dashboardData['metrics']['resolvedFeedback']) ?></p>
                        <span class="metric-trend positive">
                            <?= number_format($dashboardData['metrics']['resolutionRate'], 1) ?>% resolution rate
                        </span>
                    </div>
                </div>
            </article>

            <!-- Active Users -->
            <article class="metric-card info-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon info rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="24" height="24">
                            <circle cx="84" cy="108" r="52" fill="none" stroke="currentColor" stroke-width="16" />
                            <path d="M10.23,200a88,88,0,0,1,147.54,0" fill="none" stroke="currentColor" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">
                            Active Users
                            <span class="tooltip rounded-sm" title="Based on unique IP addresses">ⓘ</span>
                        </h3>
                        <p class="metric-value"><?= number_format($dashboardData['metrics']['activeUsers']) ?></p>
                        <span class="metric-trend neutral">Unique IPs (30 days)</span>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- ===== Quick Actions & Recent Activity ===== -->
    <div class="dashboard-grid">
        <!-- Quick Actions -->
        <section class="dashboard-card quick-actions-card rounded-sm">
            <div class="card-header">
                <h2 class="card-title">Quick Actions</h2>
            </div>
            <div class="card-content">
                <div class="actions-grid">
                    <a href="/admin/feedback?status=new" class="action-item urgent rounded-sm">
                        <div class="action-icon rounded-sm">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Action Pending</span>
                            <span class="action-count"><?= number_format($dashboardData['quickActions']['newCount']) ?> items</span>
                        </div>
                    </a>

                    <a href="/admin/categories" class="action-item rounded-sm">
                        <div class="action-icon rounded-sm">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                            </svg>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Categories</span>
                            <span class="action-count"><?= number_format($dashboardData['quickActions']['categoryCount']) ?> categories</span>
                        </div>
                    </a>

                    <button type="button" id="export-data-btn" class="action-item rounded-sm">
                        <div class="action-icon rounded-sm">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14,2 14,8 20,8" />
                            </svg>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Export Data</span>
                            <span class="action-count">Download</span>
                        </div>
                    </button>
                </div>
            </div>
        </section>

        <!-- Recent Activity -->
        <section class="dashboard-card recent-activity-card rounded-sm">
            <div class="card-header">
                <h2 class="card-title">Recent Activity</h2>
                <a href="/admin/feedback" class="view-all-link">View All</a>
            </div>
            <div class="card-content">
                <div class="activity-feed">
                    <?php if (empty($dashboardData['recentActivity'])): ?>
                        <p class="no-activity">No recent activity.</p>
                    <?php else: ?>
                        <?php foreach ($dashboardData['recentActivity'] as $activity): ?>
                            <div class="activity-item">
                                <div class="activity-icon new rounded-sm">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">
                                        New feedback: "<?= htmlspecialchars(substr($activity['title'], 0, 50)) ?>..."
                                    </p>
                                    <div class="activity-meta">
                                        <span class="activity-time"><?= \Helpers\StringHelper::time_ago($activity['created_at']) ?></span>
                                        <span class="activity-category rounded-sm text-capitalize"><?= htmlspecialchars($activity['category_name']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>

    <!-- ===== Category Analytics ===== -->
    <section class="dashboard-card category-analytics-card rounded-sm">
        <div class="card-header">
            <h2 class="card-title">Top Categories by Feedback</h2>
            <span class="period-selector">All Time</span>
        </div>
        <div class="card-content">
            <?php if (empty($dashboardData['categoryAnalytics'])): ?>
                <p class="no-activity">No category data to display yet.</p>
            <?php else: ?>
                <ol class="category-rank-list">
                    <?php foreach ($dashboardData['categoryAnalytics'] as $index => $category): ?>
                        <li class="category-rank-item">
                            <div class="category-rank-info">
                                <span class="category-rank-number"><?= $index + 1 ?>.</span>
                                <span class="category-dot rounded-sm" style="background-color: <?= htmlspecialchars($category['color']) ?>"></span>
                                <span class="category-name text-capitalize"><?= htmlspecialchars($category['name']) ?></span>
                            </div>
                            <span class="category-count"><?= number_format($category['feedback_count']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>