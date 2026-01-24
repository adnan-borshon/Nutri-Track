<?php
require_once '../includes/session.php';
checkAuth('admin');
include 'header.php';
?>

<div class="section-header">
    <h1 class="section-title">System Settings</h1>
    <p class="section-description">Configure platform settings and preferences</p>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Profile Settings</h3>
        <div class="form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-input" value="System Administrator">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" value="admin@nutritrack.com">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select class="form-input">
                    <option value="admin">System Administrator</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Notification Settings</h3>
        <div class="settings-section">
            <div class="settings-info">
                <h4>Email Notifications</h4>
                <p>Receive email notifications for important events</p>
            </div>
            <div class="admin-toggle active" onclick="toggleSetting(this)">
                <div class="admin-toggle-handle"></div>
            </div>
        </div>
        
        <div class="settings-section">
            <div class="settings-info">
                <h4>User Registration Alerts</h4>
                <p>Get notified when new users register</p>
            </div>
            <div class="admin-toggle active" onclick="toggleSetting(this)">
                <div class="admin-toggle-handle"></div>
            </div>
        </div>
        
        <div class="settings-section">
            <div class="settings-info">
                <h4>System Maintenance Alerts</h4>
                <p>Receive alerts about system maintenance</p>
            </div>
            <div class="admin-toggle" onclick="toggleSetting(this)">
                <div class="admin-toggle-handle"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Security Settings</h3>
        <div class="form">
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
            <button class="btn btn-primary" onclick="updatePassword()">Update Password</button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">System Actions</h3>
        <div class="grid grid-2">
            <button class="btn btn-outline" onclick="generateReport()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M4 20l14 0" /></svg> Generate Report</button>
            <button class="btn btn-outline" onclick="backupDatabase()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg> Backup Database</button>
            <button class="btn btn-outline" onclick="clearCache()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Clear Cache</button>
            <button class="btn btn-secondary" onclick="toggleMaintenanceMode()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg> Maintenance Mode</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
function toggleSetting(toggle) {
    toggle.classList.toggle('active');
    const settingName = toggle.closest('.settings-section').querySelector('h4').textContent;
    const isActive = toggle.classList.contains('active');
    showNotification(`${settingName} ${isActive ? 'enabled' : 'disabled'}`, 'info');
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
    
    const formData = new FormData();
    formData.append('action', 'update_password');
    formData.append('current_password', currentPassword);
    formData.append('new_password', newPassword);
    formData.append('confirm_password', confirmPassword);
    
    fetch('admin_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            passwordInputs.forEach(input => input.value = '');
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function generateReport() {
    const formData = new FormData();
    formData.append('action', 'generate_report');
    
    fetch('admin_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            if (data.data) {
                console.log('Report Data:', data.data);
            }
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function backupDatabase() {
    const formData = new FormData();
    formData.append('action', 'backup_database');
    
    fetch('admin_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showNotification(data.message, data.success ? 'success' : 'error');
    });
}

function clearCache() {
    const formData = new FormData();
    formData.append('action', 'clear_cache');
    
    fetch('admin_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showNotification(data.message, data.success ? 'success' : 'error');
    });
}

function toggleMaintenanceMode() {
    const formData = new FormData();
    formData.append('action', 'toggle_maintenance');
    
    fetch('admin_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showNotification(data.message, data.success ? 'success' : 'error');
    });
}

function showNotifications() {
    showNotification('Notifications feature coming soon!', 'info');
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