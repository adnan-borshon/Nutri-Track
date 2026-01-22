<?php
require_once '../includes/session.php';
checkAuth('admin');
include 'header.php';
?>

<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="text-3xl font-bold">User Management</h1>
            <p class="text-muted-foreground">Manage platform users and their assignments</p>
        </div>
        <button class="btn btn-primary" onclick="showAddUserModal()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> Add User
        </button>
    </div>

    <div class="card">
        <div class="card-header">
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
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Status</th>
                            <th>Goal</th>
                            <th>Nutritionist</th>
                            <th>Join Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">JD</div>
                                    <div class="user-details">
                                        <h4 class="user-name">John Doe</h4>
                                        <p class="user-email">john@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge active">active</span></td>
                            <td>Weight Loss</td>
                            <td>Dr. Smith</td>
                            <td>2024-01-15</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg> View
                                    </button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">JS</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Jane Smith</h4>
                                        <p class="user-email">jane@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge active">active</span></td>
                            <td>Maintain</td>
                            <td>Dr. Chen</td>
                            <td>2024-02-20</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg> View
                                    </button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">MJ</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Mike Johnson</h4>
                                        <p class="user-email">mike@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td>Build Muscle</td>
                            <td class="unassigned">Unassigned</td>
                            <td>2024-03-10</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg> Approve
                                    </button>
                                    <button class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg> Assign
                                    </button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">ED</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Emily Davis</h4>
                                        <p class="user-email">emily@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge active">active</span></td>
                            <td>Weight Loss</td>
                            <td>Dr. Smith</td>
                            <td>2024-03-15</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg> View
                                    </button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">CW</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Chris Wilson</h4>
                                        <p class="user-email">chris@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge inactive">inactive</span></td>
                            <td>Gain Weight</td>
                            <td class="unassigned">Unassigned</td>
                            <td>2024-01-05</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg> View
                                    </button>
                                    <button class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg> Assign
                                    </button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">SB</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Sarah Brown</h4>
                                        <p class="user-email">sarah@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td>Weight Loss</td>
                            <td class="unassigned">Unassigned</td>
                            <td>2024-03-20</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg> Approve
                                    </button>
                                    <button class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg> Assign
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

<?php include 'footer.php'; ?>
<script>
function showAddUserModal() {
    showNotification('Add User feature coming soon!', 'info');
}

function viewUser(button) {
    const row = button.closest('tr');
    const userName = row.querySelector('.user-name').textContent;
    showNotification(`Viewing: ${userName}`, 'info');
}

function approveUser(button) {
    const row = button.closest('tr');
    const userName = row.querySelector('.user-name').textContent;
    showNotification(`${userName} approved successfully!`, 'success');
}

function assignUser(button) {
    const row = button.closest('tr');
    const userName = row.querySelector('.user-name').textContent;
    showNotification(`Assigning nutritionist to ${userName}`, 'info');
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