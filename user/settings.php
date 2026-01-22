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

    <!-- Profile Information and Account Actions - Two Columns -->
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
                <h3 class="card-title">Account Actions</h3>
            </div>
            <div class="card-content">
                <div class="form">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <button class="btn btn-outline">Change Password</button>
                        <button class="btn btn-outline">Export Data</button>
                        <button class="btn btn-outline" style="color: #ef4444; border-color: #ef4444;">Delete Account</button>
                    </div>
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
                        <input type="number" id="weight" step="0.1" placeholder="70.5" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" id="height" placeholder="175" class="form-input">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Age</label>
                    <input type="number" id="age" min="1" max="120" placeholder="25" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Health Conditions</label>
                    <div class="health-conditions">
                        <label class="condition-checkbox">
                            <input type="checkbox" value="diabetes">
                            <span>Diabetes</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="hypertension">
                            <span>Hypertension</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="heart_disease">
                            <span>Heart Disease</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="obesity">
                            <span>Obesity</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="thyroid">
                            <span>Thyroid Issues</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="allergies">
                            <span>Food Allergies</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="digestive">
                            <span>Digestive Issues</span>
                        </label>
                        <label class="condition-checkbox">
                            <input type="checkbox" value="kidney">
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
let selectedConditions = [];

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
        tag.innerHTML = `
            <span>${condition.name}</span>
            <button onclick="removeCondition('${condition.value}')">&times;</button>
        `;
        container.appendChild(tag);
    });
}

function removeCondition(conditionValue) {
    // Uncheck the checkbox
    const checkbox = document.querySelector(`input[value="${conditionValue}"]`);
    if (checkbox) checkbox.checked = false;
    
    // Remove from selected conditions
    selectedConditions = selectedConditions.filter(c => c.value !== conditionValue);
    updateSelectedConditions();
}

document.getElementById('saveHealthBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const weight = document.getElementById('weight').value;
    const height = document.getElementById('height').value;
    const age = document.getElementById('age').value;
    const otherConditions = document.getElementById('otherConditions').value;
    
    let isValid = true;
    
    // Basic validation
    if (weight && (isNaN(weight) || weight <= 0 || weight > 500)) {
        document.getElementById('weight').style.borderColor = '#dc2626';
        isValid = false;
    } else {
        document.getElementById('weight').style.borderColor = '#d1d5db';
    }
    
    if (height && (isNaN(height) || height <= 0 || height > 300)) {
        document.getElementById('height').style.borderColor = '#dc2626';
        isValid = false;
    } else {
        document.getElementById('height').style.borderColor = '#d1d5db';
    }
    
    if (age && (isNaN(age) || age <= 0 || age > 120)) {
        document.getElementById('age').style.borderColor = '#dc2626';
        isValid = false;
    } else {
        document.getElementById('age').style.borderColor = '#d1d5db';
    }
    
    if (isValid) {
        const healthData = {
            weight: weight,
            height: height,
            age: age,
            conditions: selectedConditions,
            otherConditions: otherConditions
        };
        
        console.log('Health data to save:', healthData);
        showNotification('Health information saved successfully!', 'success');
    } else {
        showNotification('Please enter valid health information', 'error');
    }
});

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