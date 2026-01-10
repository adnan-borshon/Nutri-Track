<?php include 'header.php'; ?>

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
            <div class="admin-toggle active">
                <div class="admin-toggle-handle"></div>
            </div>
        </div>
        
        <div class="settings-section">
            <div class="settings-info">
                <h4>User Registration Alerts</h4>
                <p>Get notified when new users register</p>
            </div>
            <div class="admin-toggle active">
                <div class="admin-toggle-handle"></div>
            </div>
        </div>
        
        <div class="settings-section">
            <div class="settings-info">
                <h4>System Maintenance Alerts</h4>
                <p>Receive alerts about system maintenance</p>
            </div>
            <div class="admin-toggle">
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
            <button class="btn btn-primary">Update Password</button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">System Actions</h3>
        <div class="grid grid-2">
            <button class="btn btn-outline">📊 Generate Report</button>
            <button class="btn btn-outline">🔄 Backup Database</button>
            <button class="btn btn-outline">🧹 Clear Cache</button>
            <button class="btn btn-secondary">🔧 Maintenance Mode</button>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>