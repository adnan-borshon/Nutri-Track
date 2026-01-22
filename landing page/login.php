<?php
$page_title = "Login";

// Include authentication logic
include 'auth.php';
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
                    <?php if (isset($_GET['message']) && $_GET['message'] === 'logged_out'): ?>
                        <div class="alert alert-success">
                            <div class="alert-header">
                                <span>✓</span>
                                <span>Logged out successfully</span>
                            </div>
                            <p>You have been logged out of your account.</p>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-error">
                            <div class="alert-header">
                                <span>⚠️</span>
                                <span>Error</span>
                            </div>
                            <p><?php echo $error; ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="form" id="login-form">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" placeholder="john@example.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class="form-input">
                        </div>
                        <div class="form-group">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <label for="password" class="form-label">Password</label>
                                <a href="#" onclick="showForgotPasswordModal()" style="font-size: 0.75rem; color: #16a34a; text-decoration: none;">Forgot password?</a>
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
                        <div style="display: grid; gap: 0.5rem; margin-top: 0.5rem;">
                            <div style="padding: 0.5rem; background: #f0fdf4; border-radius: 0.375rem; border-left: 3px solid #278b63;">
                                <p class="demo-credentials"><strong>👤 User:</strong> <code>user@demo.com</code> / <code>demo123</code></p>
                            </div>
                            <div style="padding: 0.5rem; background: #fef3c7; border-radius: 0.375rem; border-left: 3px solid #f59e0b;">
                                <p class="demo-credentials"><strong>👩‍⚕️ Nutritionist:</strong> <code>nutritionist@demo.com</code> / <code>demo123</code></p>
                            </div>
                            <div style="padding: 0.5rem; background: #fef2f2; border-radius: 0.375rem; border-left: 3px solid #ef4444;">
                                <p class="demo-credentials"><strong>👨‍💼 Admin:</strong> <code>admin@demo.com</code> / <code>demo123</code></p>
                            </div>
                        </div>
                    </div>

                    <div class="auth-footer">
                        Don't have an account? 
                        <a href="register.php">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showForgotPasswordModal() {
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Reset Password</h2>
                        <button onclick="this.closest('.modal-overlay').remove()" class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="forgot-password-form" class="form">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" placeholder="Enter your email" required class="form-input">
                            </div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 1rem 0;">We'll send you a link to reset your password.</p>
                            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                                <button type="button" onclick="this.closest('.modal-overlay').remove()" class="btn btn-outline">Cancel</button>
                                <button type="submit" class="btn btn-primary">Send Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.remove();
                }
            });
            
            document.body.appendChild(modal);
            
            document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
                e.preventDefault();
                showNotification('Password reset link sent to your email!', 'success');
                modal.remove();
            });
        }
        
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `<div style="display: flex; align-items: center; gap: 0.5rem;"><span>${getNotificationIcon(type)}</span><span>${message}</span></div>`;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 5000);
        }
        
        function getNotificationIcon(type) {
            const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
            return icons[type] || icons.info;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('login-form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    formData.append('ajax', '1');
                    
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = 'Signing in...';
                    submitBtn.disabled = true;
                    
                    fetch('auth.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        } else {
                            showNotification(data.message, 'error');
                            submitBtn.innerHTML = 'Sign in';
                            submitBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        showNotification('Login failed. Please try again.', 'error');
                        submitBtn.innerHTML = 'Sign in';
                        submitBtn.disabled = false;
                    });
                });
            }
        });
    </script>
</body>
</html>