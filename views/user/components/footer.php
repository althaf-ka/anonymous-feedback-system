<footer class="site-footer">
    <div class="container">
        <div class="footer-content">

            <div class="footer-brand">
                <div class="footer-logo">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                    <h3>Feedback System</h3>
                </div>
                <p class="footer-description">
                    A secure platform for students to share anonymous feedback and drive positive change on campus.
                </p>
                <div class="project-badges">
                    <span class="tech-badge">PHP</span>
                    <span class="tech-badge">MySQL</span>
                    <span class="tech-badge">JavaScript</span>
                    <span class="tech-badge">CSS3</span>
                </div>
            </div>


            <div class="social-links">
                <a href="https://github.com/yourusername" class="social-link" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                </a>
                <a href="https://linkedin.com/in/yourusername" class="social-link" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                    </svg>
                </a>
                <a href="https://twitter.com/yourusername" class="social-link" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">
                © <?= date('Y') ?> Anonymous Feedback System. Built with ❤️
            </p>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background: linear-gradient(135deg,
                var(--color-text) 0%,
                #1e293b 100%);
        color: #e2e8f0;
        padding: 2.5rem 1.5rem 1.5rem;
        margin-top: 6rem;
        position: relative;
        overflow: hidden;
    }

    .site-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg,
                var(--color-primary),
                var(--color-secondary),
                var(--color-primary));
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.6s ease forwards;
    }

    .footer-brand {
        flex: 1;
        max-width: 400px;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.75rem;
    }

    .footer-logo svg {
        color: var(--color-secondary);
        padding: 0.4rem;
        border-radius: 8px;
    }

    .footer-logo h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .footer-description {
        color: #94a3b8;
        line-height: 1.6;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .project-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }

    .tech-badge {
        background: rgba(74, 222, 128, 0.1);
        color: var(--color-secondary);
        border: 1px solid rgba(74, 222, 128, 0.2);
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .social-links {
        display: flex;
        gap: 0.5rem;
        align-items: flex-start;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        text-decoration: none;
        padding: 0.5rem;
        border: 1px solid rgba(74, 222, 128, 0.2);
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(74, 222, 128, 0.05);
        width: 28px;
        height: 28px;
    }

    .social-link:hover {
        color: var(--color-secondary);
        border-color: var(--color-secondary);
        background: rgba(74, 222, 128, 0.1);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(74, 222, 128, 0.15);
    }

    .footer-bottom {
        border-top: 1px solid rgba(74, 222, 128, 0.1);
        padding-top: 1rem;
        text-align: center;
        animation: fadeInUp 0.6s ease forwards;
    }

    .copyright {
        color: #64748b;
        font-size: 0.8rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .site-footer {
            padding: 2rem 1rem 1.25rem;
            margin-top: 3rem;
        }

        .footer-content {
            flex-direction: column;
            gap: 1.5rem;
            text-align: center;
            align-items: center
        }

        .footer-brand {
            max-width: 100%;
        }

        .social-links {
            justify-content: center;
        }

        .project-badges {
            justify-content: center;
        }

        .social-link {
            width: 24px;
            height: 24px;
        }
    }

    @media (max-width: 480px) {
        .site-footer {
            padding: 1.5rem 0.75rem 1rem;
        }

        .footer-content {
            gap: 1.25rem;
        }

        .footer-logo {
            justify-content: center;
        }

        .social-links {
            gap: 0.4rem;
        }

        .social-link {
            width: 32px;
            height: 32px;
            padding: 0.4rem;
        }

        .social-link svg {
            width: 14px;
            height: 14px;
        }

        .copyright {
            font-size: 0.75rem;
        }
    }
</style>