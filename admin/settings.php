<?php
require_once '../includes/session.php';
checkAuth('admin');
$user = getCurrentUser();

// Load system settings from DB
$db = getDB();
function getSetting($db, $key, $default = '0') {
    $stmt = $db->prepare('SELECT setting_value FROM system_settings WHERE setting_key = ?');
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? $row['setting_value'] : $default;
}
$emailNotifications = getSetting($db, 'email_notifications', '1');
$registrationAlerts = getSetting($db, 'registration_alerts', '1');
$maintenanceAlerts = getSetting($db, 'maintenance_alerts', '0');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $db = getDB();
    
    if ($_POST['action'] === 'update_profile') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        
        if (empty($name) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Name and email are required']);
            exit;
        }
        
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user['id']]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            exit;
        }
        
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $user['id']]);
        $_SESSION['user_name'] = $name;
        
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        exit;
    }
    
    if ($_POST['action'] === 'update_password') {
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        
        if ($new !== $confirm) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            exit;
        }
        
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user['id']]);
        $userData = $stmt->fetch();
        
        if (!password_verify($current, $userData['password'])) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
            exit;
        }
        
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([password_hash($new, PASSWORD_DEFAULT), $user['id']]);
        
        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
        exit;
    }
}

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
                    <input type="text" id="profileName" class="form-input" value="<?php echo htmlspecialchars($user['name']); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" id="profileEmail" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <input type="text" class="form-input" value="<?php echo ucfirst($user['role']); ?>" disabled>
            </div>
            <button class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
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
            <div class="admin-toggle<?php echo $emailNotifications === '1' ? ' active' : ''; ?>" data-setting="email_notifications" onclick="toggleSetting(this)">
                <div class="admin-toggle-handle"></div>
            </div>
        </div>
        
        <div class="settings-section">
            <div class="settings-info">
                <h4>User Registration Alerts</h4>
                <p>Get notified when new users register</p>
            </div>
            <div class="admin-toggle<?php echo $registrationAlerts === '1' ? ' active' : ''; ?>" data-setting="registration_alerts" onclick="toggleSetting(this)">
                <div class="admin-toggle-handle"></div>
            </div>
        </div>
        
        <div class="settings-section">
            <div class="settings-info">
                <h4>System Maintenance Alerts</h4>
                <p>Receive alerts about system maintenance</p>
            </div>
            <div class="admin-toggle<?php echo $maintenanceAlerts === '1' ? ' active' : ''; ?>" data-setting="maintenance_alerts" onclick="toggleSetting(this)">
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
                <input type="password" id="currentPassword" class="form-input">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" id="newPassword" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" id="confirmPassword" class="form-input">
                </div>
            </div>
            <button class="btn btn-primary" id="updatePasswordBtn">Update Password</button>
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
    const settingKey = toggle.dataset.setting;
    const isActive = toggle.classList.contains('active');
    const settingName = toggle.closest('.settings-section').querySelector('h4').textContent;

    if (settingKey) {
        const formData = new FormData();
        formData.append('action', 'update_system_setting');
        formData.append('key', settingKey);
        formData.append('value', isActive ? '1' : '0');

        fetch('admin_handler.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showNotification(`${settingName} ${isActive ? 'enabled' : 'disabled'}`, 'success');
                } else {
                    showNotification(data.message || 'Failed to save setting', 'error');
                    toggle.classList.toggle('active'); // revert
                }
            })
            .catch(() => {
                showNotification('Failed to save setting', 'error');
                toggle.classList.toggle('active'); // revert
            });
    } else {
        showNotification(`${settingName} ${isActive ? 'enabled' : 'disabled'}`, 'info');
    }
}

// Update Profile
document.getElementById('updateProfileBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    const name = document.getElementById('profileName').value.trim();
    const email = document.getElementById('profileEmail').value.trim();
    
    if (!name || !email) {
        showNotification('Name and email are required', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'update_profile');
    formData.append('name', name);
    formData.append('email', email);
    
    try {
        const response = await fetch('settings.php', { method: 'POST', body: formData });
        const data = await response.json();
        showNotification(data.message, data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1000);
    } catch (error) {
        showNotification('Failed to update profile', 'error');
    }
});

// Update Password
document.getElementById('updatePasswordBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    const current = document.getElementById('currentPassword').value;
    const newPass = document.getElementById('newPassword').value;
    const confirm = document.getElementById('confirmPassword').value;
    
    if (!current || !newPass || !confirm) {
        showNotification('All password fields are required', 'error');
        return;
    }
    if (newPass !== confirm) {
        showNotification('Passwords do not match', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'update_password');
    formData.append('current_password', current);
    formData.append('new_password', newPass);
    formData.append('confirm_password', confirm);
    
    try {
        const response = await fetch('settings.php', { method: 'POST', body: formData });
        const data = await response.json();
        showNotification(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        }
    } catch (error) {
        showNotification('Failed to update password', 'error');
    }
});

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