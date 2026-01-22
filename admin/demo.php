<?php include 'header.php'; ?>

<div class="space-y-6">
    <div class="admin-header">
        <h1 class="admin-title">Admin Panel Demo</h1>
        <p class="admin-subtitle">Interactive demonstration of all admin features</p>
    </div>

    <!-- Feature Showcase Cards -->
    <div class="admin-grid admin-grid-3">
        <div class="card hover-elevate">
            <div class="card-content">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="m22 21-3-3m0 0a5.5 5.5 0 1 0-7.78-7.78 5.5 5.5 0 0 0 7.78 7.78Z"/>
                    </svg>
                </div>
                <h3 class="card-title">User Management</h3>
                <p class="card-description">Add, edit, approve, and assign users to nutritionists with full CRUD operations.</p>
                <div class="admin-action-buttons">
                    <button class="btn btn-primary" onclick="showAddUserModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        Add User
                    </button>
                </div>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1"/>
                        <path d="M8 15a6 6 0 1 0 12 0v-3"/>
                        <path d="M11 3v2"/>
                        <path d="M6 3v2"/>
                        <circle cx="20" cy="10" r="2"/>
                    </svg>
                </div>
                <h3 class="card-title">Nutritionist Management</h3>
                <p class="card-description">Manage nutritionist profiles, specialties, and client assignments.</p>
                <div class="admin-action-buttons">
                    <button class="btn btn-primary" onclick="showAddNutritionistModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        Add Nutritionist
                    </button>
                </div>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                    </svg>
                </div>
                <h3 class="card-title">Food Database</h3>
                <p class="card-description">Comprehensive food database with nutritional information and categories.</p>
                <div class="admin-action-buttons">
                    <button class="btn btn-primary" onclick="showAddFoodModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        Add Food
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Demo Section -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Interactive Features Demo</h3>
        </div>
        <div class="card-content">
            <div class="admin-grid admin-grid-4">
                <button class="btn btn-outline" onclick="demoNotification('success')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12l5 5l10 -10"/>
                    </svg>
                    Success Notification
                </button>
                
                <button class="btn btn-outline" onclick="demoNotification('error')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6L6 18"/>
                        <path d="M6 6l12 12"/>
                    </svg>
                    Error Notification
                </button>
                
                <button class="btn btn-outline" onclick="demoNotification('info')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4"/>
                        <path d="M12 8h.01"/>
                    </svg>
                    Info Notification
                </button>
                
                <button class="btn btn-outline" onclick="demoNotification('warning')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    Warning Notification
                </button>
            </div>
        </div>
    </div>

    <!-- System Actions Demo -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">System Actions</h3>
        </div>
        <div class="card-content">
            <div class="admin-grid admin-grid-2">
                <button class="btn btn-outline" onclick="generateReport()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                        <path d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                        <path d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"/>
                        <path d="M4 20l14 0"/>
                    </svg>
                    Generate Report
                </button>
                
                <button class="btn btn-outline" onclick="backupDatabase()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/>
                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/>
                    </svg>
                    Backup Database
                </button>
                
                <button class="btn btn-outline" onclick="clearCache()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7l16 0"/>
                        <path d="M10 11l0 6"/>
                        <path d="M14 11l0 6"/>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                    </svg>
                    Clear Cache
                </button>
                
                <button class="btn btn-secondary" onclick="toggleMaintenanceMode()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"/>
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                    </svg>
                    Maintenance Mode
                </button>
            </div>
        </div>
    </div>

    <!-- Sample Data Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sample User Data</h3>
            <div class="table-filters">
                <input type="text" class="search-input" placeholder="Search users...">
                <select class="filter-select">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="card-content">
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Status</th>
                            <th>Goal</th>
                            <th>Nutritionist</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-user-id="1">
                            <td>
                                <div class="admin-user-info">
                                    <div class="admin-user-avatar">JD</div>
                                    <div class="admin-user-details">
                                        <h4>John Doe</h4>
                                        <p>john@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge active">active</span></td>
                            <td>Weight Loss</td>
                            <td>Dr. Smith</td>
                            <td>
                                <div class="admin-action-buttons">
                                    <button class="btn btn-outline btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                        </svg>
                                        View
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                            <path d="M16 5l3 3"/>
                                        </svg>
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr data-user-id="2">
                            <td>
                                <div class="admin-user-info">
                                    <div class="admin-user-avatar">MJ</div>
                                    <div class="admin-user-details">
                                        <h4>Mike Johnson</h4>
                                        <p>mike@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td>Build Muscle</td>
                            <td class="unassigned">Unassigned</td>
                            <td>
                                <div class="admin-action-buttons">
                                    <button class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12l5 5l10 -10"/>
                                        </svg>
                                        Approve
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
                                            <path d="M16 19h6"/>
                                            <path d="M19 16v6"/>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4"/>
                                        </svg>
                                        Assign
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Demo-specific functions
function demoNotification(type) {
    const messages = {
        success: 'Operation completed successfully!',
        error: 'An error occurred during the operation.',
        info: 'This is an informational message.',
        warning: 'Please review this warning message.'
    };
    
    showNotification(messages[type], type);
}

// Make functions globally available for demo
window.showAddUserModal = showAddUserModal;
window.showAddNutritionistModal = showAddNutritionistModal;
window.showAddFoodModal = showAddFoodModal;
window.generateReport = generateReport;
window.backupDatabase = backupDatabase;
window.clearCache = clearCache;
window.toggleMaintenanceMode = toggleMaintenanceMode;
window.demoNotification = demoNotification;
</script>

<?php include 'footer.php'; ?>