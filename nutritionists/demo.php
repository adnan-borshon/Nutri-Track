<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
include 'header.php';
?>

<div class="space-y-6">
    <div class="admin-header">
        <h1 class="admin-title">Nutritionist Panel Demo</h1>
        <p class="admin-subtitle">Interactive demonstration of all nutritionist features</p>
    </div>

    <!-- Feature Showcase Cards -->
    <div class="admin-grid admin-grid-3">
        <div class="card hover-elevate">
            <div class="card-content">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                    </svg>
                </div>
                <h3 class="card-title">Diet Plan Management</h3>
                <p class="card-description">Create, edit, and manage personalized diet plans for your clients.</p>
                <div class="admin-action-buttons">
                    <button class="btn btn-primary" onclick="showCreatePlanModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        Create Plan
                    </button>
                </div>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                </div>
                <h3 class="card-title">Client Management</h3>
                <p class="card-description">Monitor client progress, view details, and communicate effectively.</p>
                <div class="admin-action-buttons">
                    <button class="btn btn-primary" onclick="showUserDetailModal('1')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                        </svg>
                        View Client
                    </button>
                </div>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                    </svg>
                </div>
                <h3 class="card-title">Meal Suggestions</h3>
                <p class="card-description">Create and manage meal suggestions and recipes for clients.</p>
                <div class="admin-action-buttons">
                    <button class="btn btn-primary" onclick="showAddSuggestionModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        Add Suggestion
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
                <button class="btn btn-outline" onclick="showChatModal('1')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                    </svg>
                    Start Chat
                </button>
                
                <button class="btn btn-outline" onclick="showNotifications()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                    </svg>
                    View Notifications
                </button>
                
                <button class="btn btn-outline" onclick="demoNotification('success')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12l5 5l10 -10"/>
                    </svg>
                    Success Toast
                </button>
                
                <button class="btn btn-outline" onclick="demoNotification('info')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4"/>
                        <path d="M12 8h.01"/>
                    </svg>
                    Info Toast
                </button>
            </div>
        </div>
    </div>

    <!-- Sample Client Cards -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sample Client Cards</h3>
        </div>
        <div class="card-content">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">JD</div>
                        <h3 class="user-card-name">John Doe</h3>
                        <p class="user-card-goal">Weight Loss Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 75%</span>
                            <span class="activity-text">Last active: 2 hours ago</span>
                        </div>
                        <div class="user-card-actions">
                            <button class="btn btn-primary btn-sm" onclick="showUserDetailModal('1')">View Details</button>
                            <button class="btn btn-outline btn-sm" onclick="showChatModal('1')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                                </svg>
                                Chat
                            </button>
                        </div>
                    </div>
                </div>

                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">JS</div>
                        <h3 class="user-card-name">Jane Smith</h3>
                        <p class="user-card-goal">Build Muscle Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 45%</span>
                            <span class="activity-text">Last active: 1 day ago</span>
                        </div>
                        <div class="user-card-actions">
                            <button class="btn btn-primary btn-sm" onclick="showUserDetailModal('2')">View Details</button>
                            <button class="btn btn-outline btn-sm" onclick="showChatModal('2')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                                </svg>
                                Chat
                            </button>
                        </div>
                    </div>
                </div>

                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">MJ</div>
                        <h3 class="user-card-name">Mike Johnson</h3>
                        <p class="user-card-goal">Maintain Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 90%</span>
                            <span class="activity-text">Last active: 30 min ago</span>
                        </div>
                        <div class="user-card-actions">
                            <button class="btn btn-primary btn-sm" onclick="showUserDetailModal('3')">View Details</button>
                            <button class="btn btn-outline btn-sm" onclick="showChatModal('3')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                                </svg>
                                Chat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Demo -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Settings Demo</h3>
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
window.showCreatePlanModal = showCreatePlanModal;
window.showAddSuggestionModal = showAddSuggestionModal;
window.showUserDetailModal = showUserDetailModal;
window.showChatModal = showChatModal;
window.showNotifications = showNotifications;
window.demoNotification = demoNotification;
</script>

<?php include 'footer.php'; ?>