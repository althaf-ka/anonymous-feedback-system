<?php

$seo = [
    'title' => 'Admin Login | Anonymous Feedback System',
    'description' => 'Log in to the administrator dashboard to manage feedback and categories.'
];

$headAssets = [
    '<link rel="stylesheet" href="/assets/css/pages/login.css">'
];

ob_start();
?>

<div class="login-wrapper">
    <div class="login-container rounded-sm">
        <div class="login-header">
            <h1 class="login-title">Admin Login</h1>
        </div>

        <form method="POST" class="login-form">
            <div class="form-fields-login">
                <div class="form-group">
                    <label for="email" class="form-label">
                        <span class="label-text">Email Address</span>
                    </label>
                    <input type="email" id="email" name="email" class="form-input login-input" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" id="password" name="password" class="form-input login-input" placeholder="Enter your password" required>
                </div>

                <div class="form-actions-login">
                    <button type="submit" class="btn btn-primary login-btn">
                        Sign In
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.querySelector(".login-form");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch("/admin/login", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "Accept": "application/json"
                    }
                });

                const result = await response.json();

                if (result.success) {
                    showToast(result.message, "success");

                    setTimeout(() => {
                        window.location.href = result.data.redirect;
                    }, 800);
                } else {
                    showToast(result.message, "error");
                }
            } catch (err) {
                showToast("An unexpected error occurred. Try again.", "error");
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
