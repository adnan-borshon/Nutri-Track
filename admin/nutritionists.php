<?php
require_once '../includes/session.php';
checkAuth('admin');
include 'header.php';
?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Nutritionist Management</h1>
            <p class="section-description">Manage nutritionists and their profiles</p>
        </div>
        <button class="btn btn-primary" onclick="showAddNutritionistModal()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> Add Nutritionist
        </button>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <input type="text" class="form-input" placeholder="Search nutritionists...">
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nutritionist</th>
                    <th>Specialty</th>
                    <th>Status</th>
                    <th>Clients</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">SS</div>
                            <div class="admin-user-details">
                                <h4>Dr. Sarah Smith</h4>
                                <p>sarah@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Weight Management</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg> 24</td>
                    <td>4.9/5</td>
                    <td>
                        <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">MC</div>
                            <div class="admin-user-details">
                                <h4>Dr. Michael Chen</h4>
                                <p>michael@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Sports Nutrition</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg> 18</td>
                    <td>4.8/5</td>
                    <td>
                        <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">EW</div>
                            <div class="admin-user-details">
                                <h4>Dr. Emily Wilson</h4>
                                <p>emily@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Clinical Nutrition</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg> 31</td>
                    <td>4.95/5</td>
                    <td>
                        <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">JM</div>
                            <div class="admin-user-details">
                                <h4>Dr. James Martinez</h4>
                                <p>james@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Pediatric Nutrition</span></td>
                    <td><span class="status-badge pending">pending</span></td>
                    <td>
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg> 0</td>
                    <td>-</td>
                    <td>
                        <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">LT</div>
                            <div class="admin-user-details">
                                <h4>Dr. Lisa Thompson</h4>
                                <p>lisa@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Eating Disorders</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg> 15</td>
                    <td>4.7/5</td>
                    <td>
                        <button class="btn btn-outline" onclick="viewNutritionist(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
function showAddNutritionistModal() {
    showNotification('Add Nutritionist feature coming soon!', 'info');
}

function viewNutritionist(button) {
    const row = button.closest('tr');
    const nutritionistName = row.querySelector('h4').textContent;
    showNotification(`Viewing: ${nutritionistName}`, 'info');
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

<?php include 'footer.php'; ?>