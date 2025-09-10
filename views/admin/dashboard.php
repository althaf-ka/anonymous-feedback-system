<?php
$title = "Dashboard | Admin Panel";
$headAssets = [
    '<link rel="stylesheet" href="/assets/css/pages/dashboard.css">'
];
$showSidebar = true;
$showHeader = true;

ob_start();
?>

<div class="">
    <header class="dashboard-header">
        <h1 class="page-title">Dashboard</h1>
    </header>

    <section class="metrics-section">
        <div class="metrics-grid">
            <article class="metric-card primary-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon primary rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="24" height="24">
                            <rect width="24" height="24" fill="none" />
                            <path d="M45.15,230.11A8,8,0,0,1,32,224V64a8,8,0,0,1,8-8H216a8,8,0,0,1,8,8V192a8,8,0,0,1-8,8H80Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">Total Feedback</h3>
                        <p class="metric-value">1,247</p>
                        <span class="metric-trend positive">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                            </svg>
                            +12% this month
                        </span>
                    </div>
                </div>
            </article>

            <article class="metric-card warning-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon warning rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" height="24" width="24">
                            <rect width="24" height="24" fill="none" />
                            <circle cx="128" cy="136" r="88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <line x1="128" y1="136" x2="168" y2="96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <line x1="104" y1="16" x2="152" y2="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">Pending Review</h3>
                        <p class="metric-value pending">23</p>
                        <span class="metric-trend urgent">Requires attention</span>
                    </div>
                </div>
            </article>

            <article class="metric-card success-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon success rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="24" height="24">
                            <rect width="24" height="24" fill="none" />
                            <polyline points="40 144 96 200 224 72" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">Resolved</h3>
                        <p class="metric-value">1,156</p>
                        <span class="metric-trend positive">92.7% resolution rate</span>
                    </div>
                </div>
            </article>

            <article class="metric-card info-card rounded-sm">
                <div class="metric-header">
                    <div class="metric-icon info rounded-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="24" height="24">
                            <rect width="24" height="24" fill="none" />
                            <circle cx="84" cy="108" r="52" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <path d="M10.23,200a88,88,0,0,1,147.54,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <path d="M172,160a87.93,87.93,0,0,1,73.77,40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <path d="M152.69,59.7A52,52,0,1,1,172,160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        </svg>
                    </div>
                    <div class="metric-info">
                        <h3 class="metric-title">
                            Active Users
                            <span class="tooltip rounded-sm" title="Based on unique IP addresses">ⓘ</span>
                        </h3>
                        <p class="metric-value">614</p>
                        <span class="metric-trend neutral">Unique IPs (30 days)</span>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <div class="dashboard-grid">
        <section class="dashboard-card quick-actions-card rounded-sm">
            <div class="card-header">
                <h2 class="card-title">Quick Actions</h2>
            </div>
            <div class="card-content">
                <div class="actions-grid">
                    <a href="/admin/feedback?status=pending" class="action-item urgent rounded-sm">
                        <div class="action-icon rounded-sm">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Review Pending</span>
                            <span class="action-count">23 items</span>
                        </div>
                    </a>

                    <a href="/admin/suggestions" class="action-item rounded-sm">
                        <div class="action-icon rounded-sm">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11l3 3L22 4" />
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                            </svg>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Manage Suggestions</span>
                            <span class="action-count">View board</span>
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
                            <span class="action-count">8 categories</span>
                        </div>
                    </a>

                    <a href="/admin/export" class="action-item rounded-sm">
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
                    </a>
                </div>
            </div>
        </section>

        <section class="dashboard-card recent-activity-card rounded-sm">
            <div class="card-header">
                <h2 class="card-title">Recent Activity</h2>
                <a href="/admin/feedback" class="view-all-link">View All</a>
            </div>
            <div class="card-content">
                <div class="activity-feed">
                    <div class="activity-item">
                        <div class="activity-icon new rounded-sm">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">New feedback about library study spaces</p>
                            <div class="activity-meta">
                                <span class="activity-time">3 minutes ago</span>
                                <span class="activity-category rounded-sm">Facilities</span>
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon resolved rounded-sm">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11l3 3L22 4" />
                            </svg>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">Feedback #1024 marked as resolved</p>
                            <div class="activity-meta">
                                <span class="activity-time">15 minutes ago</span>
                                <span class="activity-category rounded-sm">IT Support</span>
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon comment rounded-sm">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7" />
                            </svg>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">Admin response added to cafeteria feedback</p>
                            <div class="activity-meta">
                                <span class="activity-time">1 hour ago</span>
                                <span class="activity-category rounded-sm">Food Services</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="dashboard-card category-analytics-card rounded-sm">
        <div class="card-header">
            <h2 class="card-title">Category Analytics</h2>
            <span class="period-selector">Last 30 days</span>
        </div>
        <div class="card-content">
            <div class="category-grid">
                <div class="category-item rounded-sm">
                    <div class="category-info">
                        <div class="category-name">
                            <span class="category-dot academics rounded-sm"></span>
                            Academics
                        </div>
                        <span class="category-count">342</span>
                    </div>
                    <div class="category-bar rounded-sm">
                        <div class="category-progress academics" style="width: 75%"></div>
                    </div>
                </div>

                <div class="category-item rounded-sm">
                    <div class="category-info">
                        <div class="category-name">
                            <span class="category-dot facilities rounded-sm"></span>
                            Facilities
                        </div>
                        <span class="category-count">198</span>
                    </div>
                    <div class="category-bar rounded-sm">
                        <div class="category-progress facilities" style="width: 45%"></div>
                    </div>
                </div>

                <div class="category-item rounded-sm">
                    <div class="category-info">
                        <div class="category-name">
                            <span class="category-dot food rounded-sm"></span>
                            Food Services
                        </div>
                        <span class="category-count">156</span>
                    </div>
                    <div class="category-bar rounded-sm">
                        <div class="category-progress food" style="width: 35%"></div>
                    </div>
                </div>

                <div class="category-item rounded-sm">
                    <div class="category-info">
                        <div class="category-name">
                            <span class="category-dot it rounded-sm"></span>
                            IT Support
                        </div>
                        <span class="category-count">89</span>
                    </div>
                    <div class="category-bar rounded-sm">
                        <div class="category-progress it" style="width: 20%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>