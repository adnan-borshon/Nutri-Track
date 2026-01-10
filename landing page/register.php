<?php
$page_title = "Register";

$registration_success = false;
$registration_error = '';

if ($_POST && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        $registration_error = 'Passwords do not match.';
    } else {
        $registration_success = true;
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
                    <h1 class="auth-title">Create your account</h1>
                    <p class="auth-description">Start your health journey today</p>
                </div>
                <div class="auth-content">
                    <?php if ($registration_success): ?>
                        <div class="alert alert-success">
                            <div class="alert-header">
                                <span>✓</span>
                                <span>Account created!</span>
                            </div>
                            <p>Welcome to NutriTrack. Let's set up your profile.</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($registration_error): ?>
                        <div class="alert alert-error">
                            <div class="alert-header">
                                <span>⚠️</span>
                                <span>Error</span>
                            </div>
                            <p><?php echo $registration_error; ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="form">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" placeholder="john@example.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" placeholder="Create a password" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required class="form-input">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            Create account
                        </button>
                    </form>

                    <p style="margin-top: 1rem; font-size: 0.75rem; text-align: center; color: #6b7280;">
                        By creating an account, you agree to our Terms of Service and Privacy Policy.
                    </p>

                    <div class="auth-footer">
                        Already have an account? 
                        <a href="login.php">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>