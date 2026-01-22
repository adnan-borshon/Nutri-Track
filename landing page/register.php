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
    <script>
        function showTermsModal() {
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Terms of Service</h2>
                        <button onclick="this.closest('.modal-overlay').remove()" class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="max-height: 400px; overflow-y: auto; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                            <h3>1. Acceptance of Terms</h3>
                            <p>By using NutriTrack, you agree to these terms and conditions.</p>
                            <h3>2. Service Description</h3>
                            <p>NutriTrack provides nutrition tracking and health management tools.</p>
                            <h3>3. User Responsibilities</h3>
                            <p>Users are responsible for providing accurate health information.</p>
                            <h3>4. Privacy</h3>
                            <p>We protect your personal health data according to our Privacy Policy.</p>
                        </div>
                        <button onclick="this.closest('.modal-overlay').remove()" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">I Understand</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        function showPrivacyModal() {
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Privacy Policy</h2>
                        <button onclick="this.closest('.modal-overlay').remove()" class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="max-height: 400px; overflow-y: auto; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                            <h3>Data Collection</h3>
                            <p>We collect health and nutrition data to provide personalized recommendations.</p>
                            <h3>Data Usage</h3>
                            <p>Your data is used to improve your health tracking experience.</p>
                            <h3>Data Protection</h3>
                            <p>All data is encrypted and stored securely.</p>
                            <h3>Data Sharing</h3>
                            <p>We never share your personal health data with third parties.</p>
                        </div>
                        <button onclick="this.closest('.modal-overlay').remove()" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">I Understand</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const strengthIndicator = document.getElementById('password-strength');
            const registerForm = document.getElementById('register-form');
            
            if (passwordInput && strengthIndicator) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    const strength = getPasswordStrength(password);
                    strengthIndicator.innerHTML = `<span style="color: ${strength.color};">Password strength: ${strength.text}</span>`;
                });
            }
            
            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', function() {
                    const password = passwordInput.value;
                    const confirmPassword = this.value;
                    
                    if (confirmPassword && password !== confirmPassword) {
                        this.style.borderColor = '#ef4444';
                    } else {
                        this.style.borderColor = '';
                    }
                });
            }
            
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const password = passwordInput.value;
                    const confirmPassword = confirmPasswordInput.value;
                    
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        const notification = document.createElement('div');
                        notification.className = 'notification notification-error';
                        notification.innerHTML = '<div style="display: flex; align-items: center; gap: 0.5rem;"><span>❌</span><span>Passwords do not match!</span></div>';
                        document.body.appendChild(notification);
                        setTimeout(() => notification.remove(), 5000);
                        return;
                    }
                    
                    e.preventDefault();
                    const notification = document.createElement('div');
                    notification.className = 'notification notification-success';
                    notification.innerHTML = '<div style="display: flex; align-items: center; gap: 0.5rem;"><span>✅</span><span>Account created successfully! Welcome to NutriTrack!</span></div>';
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        window.location.href = '../user/dashboard.php';
                    }, 2000);
                });
            }
        });
        
        function getPasswordStrength(password) {
            let score = 0;
            if (password.length >= 8) score++;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;
            
            const strengths = [
                { text: 'Very Weak', color: '#ef4444' },
                { text: 'Weak', color: '#f59e0b' },
                { text: 'Fair', color: '#eab308' },
                { text: 'Good', color: '#22c55e' },
                { text: 'Strong', color: '#16a34a' },
                { text: 'Very Strong', color: '#15803d' }
            ];
            
            return strengths[score] || strengths[0];
        }
    </script>
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

                    <form method="POST" class="form" id="register-form">
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
                            <div id="password-strength" style="margin-top: 0.5rem; font-size: 0.75rem;"></div>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required class="form-input">
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin: 1rem 0;">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms" style="font-size: 0.875rem; color: #6b7280;">I agree to the <a href="#" onclick="showTermsModal()" style="color: #278b63;">Terms of Service</a> and <a href="#" onclick="showPrivacyModal()" style="color: #278b63;">Privacy Policy</a></label>
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