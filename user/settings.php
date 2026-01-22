<?php
$page_title = "Settings";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
include 'header.php';
?>

<div class="section">
    <div>
        <h1 class="section-title">Settings</h1>
        <p class="section-description">Manage your account and preferences</p>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Profile Information</h3>
            </div>
            <div class="card-content">
                <div class="form">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" value="+1 (555) 123-4567" class="form-input">
                    </div>
                    <button class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Health Goals</h3>
            </div>
            <div class="card-content">
                <div class="form">
                    <div class="form-group">
                        <label class="form-label">Daily Calorie Goal</label>
                        <input type="number" value="1800" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Water Goal (glasses)</label>
                        <input type="number" value="8" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sleep Goal (hours)</label>
                        <input type="number" step="0.5" value="8" class="form-input">
                    </div>
                    <button class="btn btn-primary" id="saveGoalsBtn">Save Goals</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
            <h3 class="card-title">Notifications</h3>
        </div>
        <div class="card-content">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p class="card-title" style="font-size: 1rem;">Meal Reminders</p>
                        <p class="card-description">Get reminded to log your meals</p>
                    </div>
                    <input type="checkbox" checked>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p class="card-title" style="font-size: 1rem;">Water Reminders</p>
                        <p class="card-description">Stay hydrated with regular reminders</p>
                    </div>
                    <input type="checkbox" checked>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p class="card-title" style="font-size: 1rem;">Appointment Reminders</p>
                        <p class="card-description">Get notified about upcoming appointments</p>
                    </div>
                    <input type="checkbox" checked>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
            <h3 class="card-title">Account Actions</h3>
        </div>
        <div class="card-content">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <button class="btn btn-outline">Change Password</button>
                <button class="btn btn-outline">Export Data</button>
                <button class="btn btn-outline" style="color: #ef4444; border-color: #ef4444;">Delete Account</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('updateProfileBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const form = this.closest('.card');
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#dc2626';
            isValid = false;
        } else {
            input.style.borderColor = '#d1d5db';
        }
    });
    
    if (isValid) {
        showNotification('Profile updated successfully!', 'success');
    } else {
        showNotification('Please fill in all required fields', 'error');
    }
});

document.getElementById('saveGoalsBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const form = this.closest('.card');
    const inputs = form.querySelectorAll('input');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim() || isNaN(input.value) || input.value <= 0) {
            input.style.borderColor = '#dc2626';
            isValid = false;
        } else {
            input.style.borderColor = '#d1d5db';
        }
    });
    
    if (isValid) {
        showNotification('Goals saved successfully!', 'success');
    } else {
        showNotification('Please enter valid values for all goals', 'error');
    }
});

document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const settingName = this.closest('div').querySelector('.card-title').textContent;
        const isEnabled = this.checked;
        showNotification(`${settingName} ${isEnabled ? 'enabled' : 'disabled'}`, 'info');
    });
});

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
        border-radius: 0.375rem; color: white; font-weight: 500; z-index: 1000;
        background: ${type === 'success' ? '#278b63' : type === 'error' ? '#dc2626' : '#3b82f6'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>