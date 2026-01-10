<?php
$page_title = "Login";

$login_success = false;
$login_error = '';

if ($_POST && isset($_POST['email']) && isset($_POST['password'])) {
    if ($_POST['email'] === 'user@demo.com' && $_POST['password'] === 'demo123') {
        $login_success = true;
    } else {
        $login_error = 'Invalid email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - NutriTrack</title>
    <link rel="stylesheet" href="http://localhost/Health%20DIet/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <a href="index.php" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #6b7280; text-decoration: none; margin-bottom: 2rem;">
                ← Back to home
            </a>

            <div class="card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <div class="logo-icon">🌿</div>
                        <span class="logo-text">NutriTrack</span>
                    </div>
                    <h1 class="auth-title">Welcome back</h1>
                    <p class="auth-description">Enter your credentials to access your account</p>
                </div>
                <div class="auth-content">
                    <?php if ($login_success): ?>
                        <div class="alert alert-success">
                            <div class="alert-header">
                                <span>✓</span>
                                <span>Welcome back!</span>
                            </div>
                            <p>You have successfully logged in.</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($login_error): ?>
                        <div class="alert alert-error">
                            <div class="alert-header">
                                <span>⚠️</span>
                                <span>Error</span>
                            </div>
                            <p><?php echo $login_error; ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="form">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" placeholder="john@example.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class="form-input">
                        </div>
                        <div class="form-group">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <label for="password" class="form-label">Password</label>
                                <a href="#" style="font-size: 0.75rem; color: #16a34a; text-decoration: none;">Forgot password?</a>
                            </div>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required class="form-input">
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" style="font-size: 0.875rem; color: #6b7280;">Remember me for 30 days</label>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            Sign in
                        </button>
                    </form>

                    <div class="demo-box">
                        <p class="demo-title">Demo Credentials:</p>
                        <p class="demo-credentials">Email: <code>user@demo.com</code></p>
                        <p class="demo-credentials">Password: <code>demo123</code></p>
                    </div>

                    <div class="auth-footer">
                        Don't have an account? 
                        <a href="register.php">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>