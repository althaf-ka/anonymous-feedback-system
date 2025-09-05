<aside class="sidebar" id="sidebar">
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
            </svg>
            <h2 class="brand-title">Admin Panel</h2>
        </div>
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="sidebar-nav" style="margin-top: 3rem;">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/feedback" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    <span class="nav-text">Feedback</span>
                    <span class="nav-badge">12</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/suggestions" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    <span class="nav-text">Suggestions</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/analytics" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3v18h18" />
                        <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3" />
                    </svg>
                    <span class="nav-text">Analytics</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/categories" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                    <span class="nav-text">Categories</span>
                </a>
            </li>


            <li class="nav-item">
                <a href="/admin/users" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span class="nav-text">Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/settings" class="nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile rounded-sm">
            <div class="user-info">
                <span class="user-name">Admin User</span>
                <span class="user-role">Administrator</span>
            </div>
        </div>
        <a href="/logout" class="logout-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16,17 21,12 16,7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            <span>Logout</span>
        </a>
    </div>
</aside>

<style>
    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 280px;
        background: var(--color-surface);
        border-right: 1px solid var(--color-border);
        display: flex;
        flex-direction: column;
        z-index: 50;
        transition: all 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 1.5rem 1.25rem;
        border-bottom: 1px solid var(--color-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sidebar-brand svg {
        color: var(--color-primary);
        flex-shrink: 0;
    }

    .brand-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-text);
        margin: 0;
        line-height: 1;
    }

    .sidebar-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--color-text-muted);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .sidebar-toggle:hover {
        background: var(--color-background);
        color: var(--color-text);
    }

    /* Sidebar Navigation */
    .sidebar-nav {
        flex: 1;
        padding: 1rem 0;
        overflow-y: auto;
    }

    .nav-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        margin: 0 0.75rem 0.25rem 0.75rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        color: var(--color-text-muted);
        text-decoration: none;
        border-radius: 0.125rem;
        font-weight: 500;
        transition: all 0.2s ease;
        position: relative;
    }

    .nav-link:hover {
        background: var(--color-background);
        color: var(--color-text);
        transform: translateX(2px);
    }

    .nav-link.active {
        background: linear-gradient(100deg, var(--color-primary), var(--color-secondary));
        color: white;
        font-weight: 600;
    }

    .nav-link.active:hover {
        transform: translateX(0);
    }

    .nav-text {
        flex: 1;
        font-size: 0.9rem;
    }

    .nav-badge {
        background: #EF4444;
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.15rem 0.4rem;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
        line-height: 1.2;
    }

    .nav-link.active .nav-badge {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Sidebar Footer */
    .sidebar-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid var(--color-border);
        background: rgba(248, 250, 252, 0.5);
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: var(--color-surface);
        border: 1px solid var(--color-border);
    }

    .user-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .user-name {
        font-weight: 600;
        color: var(--color-text);
        font-size: 0.9rem;
        line-height: 1.2;
    }

    .user-role {
        font-size: 0.75rem;
        color: var(--color-text-muted);
        line-height: 1.2;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: #EF4444;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .logout-btn:hover {
        background: rgba(239, 68, 68, 0.05);
        border-color: rgba(239, 68, 68, 0.1);
        transform: translateX(2px);
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar-toggle {
            display: block;
        }

        main {
            margin-left: 0 !important;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100vw;
            max-width: 320px;
        }

        .sidebar-header {
            padding: 1.25rem 1rem;
        }

        .brand-title {
            font-size: 1.1rem;
        }

        .nav-item {
            margin: 0 0.5rem 0.25rem 0.5rem;
        }

        .nav-link {
            padding: 0.75rem 0.875rem;
            font-size: 0.9rem;
        }
    }

    /* Desktop Layout Adjustment */
    @media (min-width: 1025px) {
        .sidebar-header {
            display: none;
        }

        .sidebar-nav {
            padding-top: 2rem;
        }

        main {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }
    }

    @media (max-width: 1024px) {
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-header {
            display: block;
        }

        .sidebar.active+.sidebar-overlay {
            display: block;
        }
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.classList.toggle('active');

        if (window.innerWidth <= 1024) {
            overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        }
    }

    // Close sidebar when clicking overlay
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('sidebarOverlay');
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
    });
</script>