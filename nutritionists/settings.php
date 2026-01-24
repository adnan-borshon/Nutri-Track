<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Profile</h1>
        <p class="text-muted-foreground">Manage your profile information</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Profile Information</h3>
        </div>
        <div class="card-content">
            <div class="form-grid">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-input" value="Dr. Sarah Smith">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" value="sarah@nutritrack.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Specialty</label>
                        <select class="form-input">
                            <option value="weight-management">Weight Management</option>
                            <option value="sports-nutrition">Sports Nutrition</option>
                            <option value="clinical-nutrition">Clinical Nutrition</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" class="form-input" value="+1 (555) 123-4567">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea class="form-textarea" placeholder="Tell users about yourself...">Certified nutritionist with 8+ years of experience in weight management and healthy lifestyle coaching.</textarea>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" onclick="updateProfile()">Update Profile</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Change Password</h3>
        </div>
        <div class="card-content">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-input">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-input">
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" onclick="updatePassword()">Update Password</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateProfile() {
    const inputs = document.querySelectorAll('.form-input, .form-textarea');
    let isValid = true;
    
    inputs.forEach(input => {
        if (input.hasAttribute('required') && !input.value.trim()) {
            input.style.borderColor = '#dc2626';
            isValid = false;
        } else {
            input.style.borderColor = '#d1d5db';
        }
    });
    
    if (!isValid) {
        showNotification('Please fill in all required fields', 'error');
        return;
    }
    
    showNotification('Profile updated successfully!', 'success');
}

function updatePassword() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    const currentPassword = passwordInputs[0].value;
    const newPassword = passwordInputs[1].value;
    const confirmPassword = passwordInputs[2].value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        showNotification('Please fill in all password fields', 'error');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        showNotification('New passwords do not match', 'error');
        return;
    }
    
    if (newPassword.length < 8) {
        showNotification('Password must be at least 8 characters long', 'error');
        return;
    }
    
    showNotification('Password updated successfully!', 'success');
    passwordInputs.forEach(input => input.value = '');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.375rem;
        color: white;
        font-weight: 500;
        z-index: 1000;
        max-width: 300px;
    `;
    
    const colors = {
        success: '#278b63',
        error: '#dc2626',
        info: '#3b82f6'
    };
    
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>