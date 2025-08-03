<?php
$title = "Login | Admin Panel";
$additionalHead = '<link rel="stylesheet" href="../assets/css/pages/login.css">';
ob_start();
?>

<div class="login-wrapper container">
    <div class="login-container rounded-sm">
        <div class="login-header">
            <h1 class="login-title">Admin Login</h1>
        </div>

        <form method="POST" action="/controllers/auth/login.php" class="login-form">
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

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>