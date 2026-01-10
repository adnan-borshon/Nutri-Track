<?php
$page_title = "Settings";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
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
                        <input type="text" value="John Doe" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" value="john@example.com" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="tel" value="+1 (555) 123-4567" class="form-input">
                    </div>
                    <button class="btn btn-primary">Update Profile</button>
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
                    <button class="btn btn-primary">Save Goals</button>
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

<?php include 'footer.php'; ?>