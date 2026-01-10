<?php include 'header.php'; ?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Settings</h1>
        <p class="text-muted-foreground">Manage your profile and preferences</p>
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
                    <button class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Notification Preferences</h3>
        </div>
        <div class="card-content">
            <div class="settings-list">
                <div class="settings-item">
                    <div class="settings-info">
                        <h4 class="settings-item-title">Email Notifications</h4>
                        <p class="settings-item-description">Receive email notifications for new messages</p>
                    </div>
                    <div class="toggle-switch active">
                        <div class="toggle-handle"></div>
                    </div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-info">
                        <h4 class="settings-item-title">SMS Notifications</h4>
                        <p class="settings-item-description">Get text messages for urgent updates</p>
                    </div>
                    <div class="toggle-switch">
                        <div class="toggle-handle"></div>
                    </div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-info">
                        <h4 class="settings-item-title">Push Notifications</h4>
                        <p class="settings-item-description">Receive push notifications on your device</p>
                    </div>
                    <div class="toggle-switch active">
                        <div class="toggle-handle"></div>
                    </div>
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
                    <button class="btn btn-primary">Update Password</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>