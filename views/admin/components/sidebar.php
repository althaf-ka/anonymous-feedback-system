<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
            </svg>
            <h2 class="header-title">Admin Panel</h2>
        </div>
        <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Close sidebar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    <span class="nav-text">Feedback</span>
                </a>
            </li>

            <!-- <li class="nav-item">
                <a href="/admin/suggestions" class="nav-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    <span class="nav-text">Suggestions</span>
                </a>
            </li> -->

            <li class="nav-item">
                <a href="/admin/categories" class="nav-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                    <span class="nav-text">Categories</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/analytics" class="nav-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 3v18h18" />
                        <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3" />
                    </svg>
                    <span class="nav-text">Analytics</span>
                </a>
            </li>

            <!-- <li class="nav-item">
                <a href="/admin/settings" class="nav-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33" />
                    </svg>
                    <span class="nav-text">Settings</span>
                </a>
            </li> -->
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
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16,17 21,12 16,7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            <span>Logout</span>
        </a>
    </div>
</aside>


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (window.innerWidth <= 1024) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('sidebarOverlay');
        const sidebar = document.getElementById('sidebar');


        const navLinks = document.querySelectorAll('.nav-link');
        const currentPath = window.location.pathname;

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });


        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    });
</script>