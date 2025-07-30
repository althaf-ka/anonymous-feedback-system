<?php
$title = "Submit Feedback | Feedback System";
$additionalHead = '<link rel="stylesheet" href="assets/css/pages/submit-feedback.css">';

ob_start();
?>

<section class="submit-feedback-hero">
    <div class="container">
        <div class="hero-content">
            <div class="section-header">
                <h2 class="section-title">Share Your Feedback</h2>
                <p class="section-subtitle">Your voice matters. Share your thoughts, suggestions, and concerns to help
                    improve our campus experience
                    for everyone.</p>
            </div>
        </div>
    </div>
</section>

<section class="feedback-form-section">
    <div class="container">
        <div class="form-container">
            <form class="feedback-form" id="feedbackForm" method="POST" action="/submit-feedback">
                <div class="form-grid">
                    <!-- Left Column -->
                    <div class="form-column">
                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="title" class="form-label">
                                <span class="label-text">Title</span>
                                <span class="label-required">*</span>
                            </label>
                            <input type="text" id="title" name="title" class="form-input"
                                placeholder="Brief summary of your feedback" required maxlength="80">
                            <div class="form-help">
                                <span class="help-text">Keep it concise and descriptive</span>
                                <span class="char-counter" id="titleCounter">0/80</span>
                            </div>
                        </div>

                        <!-- Message Field -->
                        <div class="form-group">
                            <label for="message" class="form-label">
                                <span class="label-text">Message</span>
                                <span class="label-required">*</span>
                            </label>
                            <textarea id="message" name="message" class="form-textarea"
                                placeholder="Describe your feedback in detail. What happened? What would you like to see changed or improved?"
                                required rows="8" maxlength="600"></textarea>
                            <div class="form-help">
                                <span class="help-text">Be specific and constructive</span>
                                <span class="char-counter" id="messageCounter">0/600</span>
                            </div>
                        </div>

                        <!-- Contact Details (Optional) -->
                        <div class="form-group">
                            <label for="contact" class="form-label">
                                <span class="label-text">Contact Details</span>
                                <span class="label-optional">Optional</span>
                            </label>
                            <input type="email" id="contact" name="contact" class="form-input"
                                placeholder="your.email@gmail.com">
                            <div class="form-help">
                                <span class="help-text">Only if you want a response. Your feedback remains
                                    anonymous.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="form-column">
                        <!-- Category Selection -->
                        <div class="form-group">
                            <label for="category" class="form-label">
                                <span class="label-text">Category</span>
                                <span class="label-required">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select id="category" name="category" class="form-select" required>
                                    <option value="">Select a category</option>
                                    <option value="academics">Academics</option>
                                    <option value="facilities">Facilities</option>
                                    <option value="food">Food Services</option>
                                    <option value="mental-health">Mental Health</option>
                                    <option value="general">General</option>
                                </select>
                                <svg class="select-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </div>
                        </div>

                        <!-- Rating System -->
                        <div class="form-group">
                            <label class="form-label">
                                <span class="label-text">Overall Experience Rating</span>
                            </label>
                            <div class="rating-container">
                                <div class="rating-stars">
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5" class="star-label">
                                        <svg class="star-icon" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4" class="star-label">
                                        <svg class="star-icon" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3" class="star-label">
                                        <svg class="star-icon" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2" class="star-label">
                                        <svg class="star-icon" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1" class="star-label">
                                        <svg class="star-icon" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    </label>
                                </div>
                                <div class="rating-labels">
                                    <span class="rating-label rating-poor">Poor</span>
                                    <span class="rating-label rating-excellent">Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Public Visibility Toggle -->
                        <div class="form-group">
                            <div class="toggle-container">
                                <div class="toggle-header">
                                    <label class="form-label toggle-label">
                                        <span class="label-text">Make Public</span>
                                    </label>
                                    <div class="toggle-switch">
                                        <input type="checkbox" id="allowPublic" name="allow_public"
                                            class="toggle-input">
                                        <label for="allowPublic" class="toggle-slider"></label>
                                    </div>
                                </div>
                                <div class="toggle-description">
                                    <p class="toggle-text">Allow others to see and vote on this feedback to amplify
                                        important issues</p>
                                    <div class="toggle-benefits">
                                        <div class="benefit-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16.972 6.251a2 2 0 0 0-2.72.777l-3.713 6.682-2.125-2.125a2 2 0 1 0-2.828 2.828l4 4c.378.379.888.587 1.414.587l.277-.02a2 2 0 0 0 1.471-1.009l5-9a2 2 0 0 0-.776-2.72" />
                                            </svg>
                                            <span>Still anonymous</span>
                                        </div>
                                        <div class="benefit-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16.972 6.251a2 2 0 0 0-2.72.777l-3.713 6.682-2.125-2.125a2 2 0 1 0-2.828 2.828l4 4c.378.379.888.587 1.414.587l.277-.02a2 2 0 0 0 1.471-1.009l5-9a2 2 0 0 0-.776-2.72" />
                                            </svg>
                                            <span>Helps common issues</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary flex">
                        <span>Submit Feedback</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('feedbackForm');
        const titleInput = document.getElementById('title');
        const messageInput = document.getElementById('message');
        const titleCounter = document.getElementById('titleCounter');
        const messageCounter = document.getElementById('messageCounter');

        // Enhanced character counter with smooth animations
        function updateCounter(input, counter, maxLength) {
            const length = input.value.length;
            counter.textContent = `${length}/${maxLength}`;

            // Enhanced color coding
            counter.classList.remove('warning', 'danger');
            const percentage = length / maxLength;

            if (percentage >= 0.9) {
                counter.classList.add('danger');
            } else if (percentage >= 0.7) {
                counter.classList.add('warning');
            }
        }

        // Set up character counters
        titleInput.addEventListener('input', () => updateCounter(titleInput, titleCounter, 80));
        messageInput.addEventListener('input', () => updateCounter(messageInput, messageCounter, 600));

        // Initialize counters
        updateCounter(titleInput, titleCounter, 80);
        updateCounter(messageInput, messageCounter, 600);

        // Enhanced form submission
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            // Enhanced validation
            let isValid = true;
            const requiredFields = [titleInput, messageInput, document.getElementById('category')];

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = 'var(--color-error, #EF4444)';
                    isValid = false;
                } else {
                    field.style.borderColor = 'var(--color-border)';
                }
            });

            if (isValid) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span>Submitting...</span>';
                submitBtn.disabled = true;

                // Simulate submission
                setTimeout(() => {
                    showToast('Feedback submitted successfully!', 'success');
                    form.reset();
                    updateCounter(titleInput, titleCounter, 80);
                    updateCounter(messageInput, messageCounter, 600);

                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 2000);
            } else {
                showToast('Please fill in all required fields.', 'error');
            }
        });
    });

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `<div class="toast-content"><span>${message}</span></div>`;

        Object.assign(toast.style, {
            position: 'fixed',
            top: '2rem',
            right: '2rem',
            padding: '1rem 1.5rem',
            borderRadius: '12px',
            color: 'white',
            fontWeight: '600',
            zIndex: '9999',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease',
            background: type === 'success' ? 'var(--color-success, #22C55E)' : 'var(--color-error, #EF4444)',
            boxShadow: '0 8px 25px rgba(0,0,0,0.15)'
        });

        document.body.appendChild(toast);

        setTimeout(() => toast.style.transform = 'translateX(0)', 100);
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 3000);
    }

</script>