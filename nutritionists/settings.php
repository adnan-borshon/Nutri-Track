<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
$user = getCurrentUser();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $db = getDB();
    
    if ($_POST['action'] === 'update_profile') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $specialty = trim($_POST['specialty'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        
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
        
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, phone = ?, specialty = ?, bio = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $specialty, $bio, $user['id']]);
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
        if (strlen($new) < 8) {
            echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters']);
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
                        <input type="text" id="profileName" class="form-input" value="<?php echo htmlspecialchars($user['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" id="profileEmail" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Specialty</label>
                        <input type="text" id="profileSpecialty" class="form-input" value="<?php echo htmlspecialchars($user['specialty'] ?? ''); ?>" placeholder="e.g., Weight Management">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" id="profilePhone" class="form-input" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea id="profileBio" class="form-textarea" placeholder="Tell users about yourself..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
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
                <div class="form-actions">
                    <button class="btn btn-primary" id="updatePasswordBtn">Update Password</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Update Profile
document.getElementById('updateProfileBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    const name = document.getElementById('profileName').value.trim();
    const email = document.getElementById('profileEmail').value.trim();
    const phone = document.getElementById('profilePhone').value.trim();
    const specialty = document.getElementById('profileSpecialty').value.trim();
    const bio = document.getElementById('profileBio').value.trim();
    
    if (!name || !email) {
        showNotification('Name and email are required', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'update_profile');
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('specialty', specialty);
    formData.append('bio', bio);
    
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
    if (newPass.length < 8) {
        showNotification('Password must be at least 8 characters', 'error');
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

function showNotification(message, type = 'info') {
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