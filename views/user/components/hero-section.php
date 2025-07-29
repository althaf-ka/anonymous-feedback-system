<section class="hero container">
    <div class="hero-content">
        <div class="hero-badge-wrapper">
            <span class="hero-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                </svg>
                Anonymous & Secure
            </span>
        </div>

        <h1 class="hero-title">
            <span class="title-line">Share Your Voice,</span>
            <span class="title-line title-accent">Shape Your Campus</span>
        </h1>

        <p class="hero-subtitle">
            Transform your college experience through meaningful feedback.
            <span class="subtitle-highlight">Safe, anonymous, and impactful</span> —
            because every voice deserves to be heard.
        </p>

        <div class="hero-actions">
            <a href="/submit-feedback" class="btn btn-primary hero-btn">
                <span>Submit Feedback</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
            <a href="/public-suggestions" class="btn btn-outline hero-btn">
                <span>View Suggestions</span>
            </a>
        </div>
    </div>

    <div class="stats">
        <div class="stat" data-animate="247">
            <span class="stat-number">0</span>
            <span class="stat-label">Total Submissions</span>
        </div>
        <div class="stat" data-animate="89">
            <span class="stat-number">0</span>
            <span class="stat-label">Public Suggestions</span>
        </div>
        <div class="stat" data-animate="34">
            <span class="stat-number">0</span>
            <span class="stat-label">Issues Resolved</span>
        </div>
    </div>
</section>




<style>
    .hero {
        padding: 5rem 1.5rem 4rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto 4rem;
        position: relative;
        z-index: 2;
    }

    .hero-badge-wrapper {
        margin-bottom: 1.5rem;
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--color-surface);
        color: var(--color-primary);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: var(--shadow-md);
        border: 2px solid var(--color-secondary);
        transition: var(--transition-base);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: default;
    }

    .hero-badge:hover {
        transform: translateY(-2px);
        background: var(--color-secondary);
        color: var(--color-primary);
        box-shadow:
            0 8px 20px rgba(74, 222, 128, 0.3),
            0 4px 8px rgba(74, 222, 128, 0.2);
    }


    .hero-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        color: var(--color-text);
        margin-bottom: 1.5rem;
        line-height: 1.1;
        letter-spacing: -0.025em;
        opacity: 0;
        animation: fadeInUp 0.6s ease 0.2s forwards;
    }

    .title-line {
        display: block;
        margin-bottom: 0.25rem;
    }

    .title-accent {
        background: var(--color-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--color-text-muted);
        margin-bottom: 2.5rem;
        line-height: 1.7;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        opacity: 0;
        animation: fadeInUp 0.6s ease 0.4s forwards;
    }

    .subtitle-highlight {
        color: var(--color-primary);
        font-weight: 600;
    }

    .hero-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0;
        animation: fadeInUp 0.6s ease 0.6s forwards;
    }

    .hero-btn {
        font-size: 0.95rem;
        font-weight: 600;
        padding: 1rem 2rem;
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
    }

    .btn-primary.hero-btn {
        gap: 6px;
        border: 2px solid transparent
    }

    .btn-primary.hero-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-primary.hero-btn:hover::before {
        left: 100%;
    }

    .btn-primary.hero-btn:hover {
        transform: translateY(-2px);
        box-shadow:
            0 8px 25px rgba(20, 83, 45, 0.4),
            0 4px 12px rgba(20, 83, 45, 0.3);
    }


    .stats {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 3rem;
        opacity: 0;
        animation: fadeInUp 0.6s ease 0.8s forwards;
    }

    .stat {
        text-align: center;
        padding: 1rem;
        transition: all 0.3s ease;
        min-width: 120px;
    }

    .stat-number {
        display: block;
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--color-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--color-text-muted);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    @media (max-width: 768px) {
        .hero {
            padding: 5rem 1rem 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.10rem;
        }

        .hero-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .hero-btn {
            width: 100%;
            max-width: 280px;
            justify-content: center;
        }

        .stats {
            gap: 1.5rem;
        }
    }
</style>