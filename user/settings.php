<?php
$page_title = "Settings";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $db = getDB();
    
    if ($_POST['action'] === 'update_profile') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        
        if (empty($name) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Name and email are required']);
            exit;
        }
        
        // Check if email exists for another user
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
        
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, phone = ?, profile_image = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $imagePath, $user['id']]);
        $_SESSION['user_name'] = $name;
        
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        exit;
    }
    
    if ($_POST['action'] === 'update_health') {
        $weight = floatval($_POST['weight'] ?? 0);
        $height = floatval($_POST['height'] ?? 0);
        $age = intval($_POST['age'] ?? 0);
        $conditions = $_POST['conditions'] ?? '';
        
        $stmt = $db->prepare("UPDATE users SET weight = ?, height = ?, age = ?, health_conditions = ? WHERE id = ?");
        $stmt->execute([$weight ?: null, $height ?: null, $age ?: null, $conditions, $user['id']]);
        
        echo json_encode(['success' => true, 'message' => 'Health information saved']);
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
    
    if ($_POST['action'] === 'delete_account') {
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user['id']]);
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Account deleted', 'redirect' => '../landing page/login.php']);
        exit;
    }
}

include 'header.php';
?>

<div class="section">
    <div>
        <h1 class="section-title">Settings</h1>
        <p class="section-description">Manage your account and preferences</p>
    </div>

    <!-- Profile Information and Account Actions - Two Columns -->
    <div class="grid grid-2">
        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Profile Information</h3>
            </div>
            <div class="card-content">
                <form id="profileForm" enctype="multipart/form-data" class="form">
                    <div class="form-group" style="text-align: center; margin-bottom: 1.5rem;">
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
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" id="profileName" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" id="profileEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" id="profilePhone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="form-input">
                    </div>
                    <button type="submit" class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Change Password</h3>
            </div>
            <div class="card-content">
                <div class="form">
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" id="currentPassword" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" id="newPassword" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-input">
                    </div>
                    <button class="btn btn-primary" id="updatePasswordBtn">Update Password</button>
                    <hr style="margin: 1rem 0; border: none; border-top: 1px solid #e5e7eb;">
                    <button class="btn btn-outline" id="deleteAccountBtn" style="color: #ef4444; border-color: #ef4444; width: 100%;">Delete Account</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Health Information - Full Width -->
    <div class="card">
        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
            <h3 class="card-title">Health Information</h3>
        </div>
        <div class="card-content">
            <div class="form">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" id="weight" step="0.1" placeholder="70.5" class="form-input" value="<?php echo htmlspecialchars($user['weight'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" id="height" placeholder="175" class="form-input" value="<?php echo htmlspecialchars($user['height'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Age</label>
                    <input type="number" id="age" min="1" max="120" placeholder="25" class="form-input" value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>">
                </div>
                <?php
                $savedConditions = explode(',', $user['health_conditions'] ?? '');
                ?>
                <div class="form-group">
                    <label class="form-label">Health Conditions</label>
                    <div class="health-conditions">
                        <label class="condition-checkbox">
                            <input type="checkbox" value="diabetes" <?php echo in_array('diabetes', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Diabetes</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="hypertension" <?php echo in_array('hypertension', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Hypertension</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="heart_disease" <?php echo in_array('heart_disease', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Heart Disease</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="obesity" <?php echo in_array('obesity', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Obesity</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="thyroid" <?php echo in_array('thyroid', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Thyroid Issues</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="allergies" <?php echo in_array('allergies', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Food Allergies</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="digestive" <?php echo in_array('digestive', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Digestive Issues</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="kidney" <?php echo in_array('kidney', $savedConditions) ? 'checked' : ''; ?>>
                            <span>Kidney Disease</span>
                        </label>
                    </div>
                    <div class="selected-conditions" id="selectedConditions"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Other Health Issues</label>
                    <textarea id="otherConditions" class="form-textarea" placeholder="Please describe any other health conditions or concerns not listed above..."></textarea>
                </div>
                <button class="btn btn-primary" id="saveHealthBtn">Save Health Information</button>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize selected conditions from saved data
let selectedConditions = [];
<?php if (!empty($user['health_conditions'])): ?>
<?php foreach ($savedConditions as $cond): ?>
<?php if (!empty($cond)): ?>
selectedConditions.push({ value: '<?php echo $cond; ?>', name: document.querySelector('input[value="<?php echo $cond; ?>"]')?.nextElementSibling?.textContent || '<?php echo $cond; ?>' });
<?php endif; ?>
<?php endforeach; ?>
updateSelectedConditions();
<?php endif; ?>

// Health conditions functionality
document.querySelectorAll('.condition-checkbox input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const condition = this.value;
        const conditionName = this.nextElementSibling.textContent;
        if (this.checked) {
            if (!selectedConditions.find(c => c.value === condition)) {
                selectedConditions.push({ value: condition, name: conditionName });
            }
        } else {
            selectedConditions = selectedConditions.filter(c => c.value !== condition);
        }
        updateSelectedConditions();
    });
});

function updateSelectedConditions() {
    const container = document.getElementById('selectedConditions');
    container.innerHTML = '';
    selectedConditions.forEach(condition => {
        const tag = document.createElement('div');
        tag.className = 'condition-tag';
        tag.innerHTML = `<span>${condition.name}</span><button onclick="removeCondition('${condition.value}')">&times;</button>`;
        container.appendChild(tag);
    });
}

function removeCondition(conditionValue) {
    const checkbox = document.querySelector(`input[value="${conditionValue}"]`);
    if (checkbox) checkbox.checked = false;
    selectedConditions = selectedConditions.filter(c => c.value !== conditionValue);
    updateSelectedConditions();
}

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

// Update Profile
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('action', 'update_profile');
    
    try {
        const response = await fetch('settings.php', { method: 'POST', body: formData });
        const data = await response.json();
        showNotification(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            // Update all avatar displays on the page
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
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

// Save Health Information
document.getElementById('saveHealthBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    const weight = document.getElementById('weight').value;
    const height = document.getElementById('height').value;
    const age = document.getElementById('age').value;
    const conditions = selectedConditions.map(c => c.value).join(',');
    
    const formData = new FormData();
    formData.append('action', 'update_health');
    formData.append('weight', weight);
    formData.append('height', height);
    formData.append('age', age);
    formData.append('conditions', conditions);
    
    try {
        const response = await fetch('settings.php', { method: 'POST', body: formData });
        const data = await response.json();
        showNotification(data.message, data.success ? 'success' : 'error');
    } catch (error) {
        showNotification('Failed to save health information', 'error');
    }
});

// Delete Account
document.getElementById('deleteAccountBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    if (!confirm('Are you sure you want to delete your account? This action cannot be undone.')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_account');
    
    try {
        const response = await fetch('settings.php', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.success && data.redirect) {
            window.location.href = data.redirect;
        } else {
            showNotification(data.message, 'error');
        }
    } catch (error) {
        showNotification('Failed to delete account', 'error');
    }
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