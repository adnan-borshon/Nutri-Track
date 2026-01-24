<?php
$page_title = "Settings";
require_once '../includes/session.php';
checkAuth('nutritionist');
$user = getCurrentUser();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $db = getDB();
    
if ($_POST['action'] === 'update_profile') {
    // Enhanced debugging
    error_log('=== PROFILE UPDATE DEBUG ===');
    error_log('POST data: ' . print_r($_POST, true));
    error_log('FILES data: ' . print_r($_FILES, true));
    
    // Check if data exists first
    if (!isset($_POST['name']) || !isset($_POST['email'])) {
        error_log('CRITICAL: name or email not in POST array');
        error_log('POST keys: ' . implode(', ', array_keys($_POST)));
        echo json_encode(['success' => false, 'message' => 'Form data not received properly', 'debug' => $_POST]);
        exit;
    }
    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone'] ?? '');
    $specialty = trim($_POST['specialty'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
        
        error_log("Values after trim - Name: '$name', Email: '$email', Phone: '$phone'");
        
        if (empty($name) || empty($email)) {
            error_log('VALIDATION FAILED: Name or email is empty');
            echo json_encode(['success' => false, 'message' => 'Name and email are required', 'debug' => ['name' => $name, 'email' => $email]]);
            exit;
        }
        
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user['id']]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            exit;
        }
        
        // Handle profile image upload
        $imagePath = $user['profile_image']; // Keep existing image by default
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/profiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileExtension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = 'profile_' . $user['id'] . '_' . uniqid() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
                    // Delete old profile image if exists
                    if ($user['profile_image'] && file_exists(__DIR__ . '/../' . $user['profile_image'])) {
                        unlink(__DIR__ . '/../' . $user['profile_image']);
                    }
                    $imagePath = 'uploads/profiles/' . $fileName;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG, and GIF allowed']);
                exit;
            }
        }
        
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, phone = ?, specialty = ?, bio = ?, profile_image = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $specialty, $bio, $imagePath, $user['id']]);
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
            <form id="profileForm" enctype="multipart/form-data" class="form-grid">
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <div style="position: relative; display: inline-block;">
                        <?php if (!empty($user['profile_image']) && file_exists(__DIR__ . '/../' . $user['profile_image'])): ?>
                            <img id="profilePreview" src="../<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #278b63;">
                        <?php else: ?>
                            <div id="profilePreview" style="width: 80px; height: 80px; border-radius: 50%; background: #278b63; color: white; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; border: 3px solid #278b63;">
                                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                        <label for="profileImageInput" style="position: absolute; bottom: -5px; right: -5px; background: #278b63; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;">📷</label>
                        <input type="file" id="profileImageInput" name="profile_image" accept="image/*" style="display: none;">
                    </div>
                    <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">Click camera icon to change photo</p>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" id="profileName" name="name" class="form-input" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" id="profileEmail" name="email" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Specialty</label>
                        <input type="text" id="profileSpecialty" name="specialty" class="form-input" value="<?php echo htmlspecialchars($user['specialty'] ?? ''); ?>" placeholder="e.g., Weight Management">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" id="profilePhone" name="phone" class="form-input" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea id="profileBio" name="bio" class="form-textarea" placeholder="Tell users about yourself..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="testFormValues()" style="margin-right: 10px;">Test Values</button>
                    <button type="button" class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
                </div>
            </form>
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
// Profile image preview
document.getElementById('profileImageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profilePreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
        };
        reader.readAsDataURL(file);
    }
});

// Update Profile - prevent conflict with nutritionist.js
document.getElementById('updateProfileBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    e.stopPropagation(); // Prevent other event handlers
    
    console.log('Update button clicked');
    
    // Client-side validation - get current field values
    const nameField = document.getElementById('profileName');
    const emailField = document.getElementById('profileEmail');
    const name = nameField.value.trim();
    const email = emailField.value.trim();
    
    console.log('Name field value:', name);
    console.log('Email field value:', email);
    
    if (!name || !email) {
        showNotification('Name and email are required', 'error');
        // Highlight empty fields
        if (!name) nameField.style.borderColor = '#dc2626';
        if (!email) emailField.style.borderColor = '#dc2626';
        return;
    } else {
        // Reset border colors if valid
        nameField.style.borderColor = '';
        emailField.style.borderColor = '';
    }
    
    const formData = new FormData(document.getElementById('profileForm'));
    formData.append('action', 'update_profile');
    
    // Debug: log form data
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    try {
        const response = await fetch('settings.php', { method: 'POST', body: formData });
        const text = await response.text();
        console.log('Raw response:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('JSON parse error:', e);
            console.error('Response text:', text);
            showNotification('Server error: Invalid response format', 'error');
            return;
        }
        
        console.log('Parsed response:', data);
        showNotification(data.message, data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1000);
    } catch (error) {
        console.error('Network error:', error);
        showNotification('Failed to update profile', 'error');
    }
});

// Test function to check form values
function testFormValues() {
    const name = document.getElementById('profileName').value;
    const email = document.getElementById('profileEmail').value;
    const phone = document.getElementById('profilePhone').value;
    const specialty = document.getElementById('profileSpecialty').value;
    const bio = document.getElementById('profileBio').value;
    
    console.log('Current form values:');
    console.log('Name:', name);
    console.log('Email:', email);
    console.log('Phone:', phone);
    console.log('Specialty:', specialty);
    console.log('Bio:', bio);
    
    alert(`Name: ${name}\nEmail: ${email}\nPhone: ${phone}\nSpecialty: ${specialty}`);
}

// Prevent nutritionist.js from interfering with profile update
document.getElementById('updateProfileBtn').addEventListener('click', function(e) {
    e.stopPropagation(); // Prevent other event handlers from nutritionist.js
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