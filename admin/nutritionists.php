<?php
require_once '../includes/session.php';
checkAuth('admin');

$db = getDB();
$stmt = $db->prepare("SELECT n.id, n.name, n.email, n.specialty, n.status, COUNT(u.id) AS clients_count
                       FROM users n
                       LEFT JOIN users u ON u.nutritionist_id = n.id AND u.role = 'user'
                       WHERE n.role = 'nutritionist'
                       GROUP BY n.id
                       ORDER BY n.created_at DESC");
$stmt->execute();
$nutritionists = $stmt->fetchAll();

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
        <input type="text" class="form-input" placeholder="Search nutritionists..." onkeyup="searchNutritionists(this.value)">
        
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
                <?php foreach ($nutritionists as $n): ?>
                <tr data-nutritionist-id="<?php echo (int)$n['id']; ?>" data-status="<?php echo htmlspecialchars($n['status'] ?? 'active'); ?>">
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar"><?php echo htmlspecialchars(getUserInitials($n['name'])); ?></div>
                            <div class="admin-user-details">
                                <h4><?php echo htmlspecialchars($n['name']); ?></h4>
                                <p><?php echo htmlspecialchars($n['email']); ?></p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed nutritionist-specialty"><?php echo htmlspecialchars($n['specialty'] ?? ''); ?></span></td>
                    <td><span class="status-badge confirmed nutritionist-status"><?php echo htmlspecialchars($n['status'] ?? 'active'); ?></span></td>
                    <td class="nutritionist-clients" data-clients-count="<?php echo (int)($n['clients_count'] ?? 0); ?>">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg> <?php echo (int)($n['clients_count'] ?? 0); ?></td>
                    <td>-</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="viewNutritionist(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3.6 0 6.6 2.4 9 6" /></svg> View
                            </button>
                            <button class="btn btn-outline btn-sm" onclick="editNutritionist(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                            </button>
                            <button class="btn btn-secondary btn-sm" onclick="deleteNutritionist(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function viewNutritionist(button) {
    const row = button.closest('tr');
    const nutritionistId = row.dataset.nutritionistId;
    const nutritionistName = row.querySelector('h4').textContent;
    const email = row.querySelector('p').textContent;
    const specialty = row.querySelector('.nutritionist-specialty')?.textContent || '';
    const clients = row.querySelector('.nutritionist-clients')?.dataset.clientsCount || '0';
    const rating = row.cells[4].textContent;
    const status = row.dataset.status || '';
    
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; color: #111827; font-size: 1.25rem;">Nutritionist Details</h3>
                <button onclick="closeViewModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; padding: 0.25rem;">&times;</button>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                <div style="width: 4rem; height: 4rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.25rem;">
                    ${nutritionistName.split(' ').map(n => n[0]).join('')}
                </div>
                <div>
                    <h4 style="margin: 0 0 0.25rem 0; font-size: 1.125rem; color: #111827;">${nutritionistName}</h4>
                    <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">${email}</p>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="padding: 1rem; background: #f0fdf4; border-radius: 0.5rem; border-left: 4px solid #278b63;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">SPECIALTY</div>
                    <div style="font-weight: 600; color: #111827;">${specialty}</div>
                </div>
                <div style="padding: 1rem; background: #fef3c7; border-radius: 0.5rem; border-left: 4px solid #f59e0b;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">STATUS</div>
                    <div style="font-weight: 600; color: #111827;">${status}</div>
                </div>
                <div style="padding: 1rem; background: #dbeafe; border-radius: 0.5rem; border-left: 4px solid #3b82f6;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">CLIENTS</div>
                    <div style="font-weight: 600; color: #111827;">${clients} Active</div>
                </div>
                <div style="padding: 1rem; background: #f3e8ff; border-radius: 0.5rem; border-left: 4px solid #8b5cf6;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">RATING</div>
                    <div style="font-weight: 600; color: #111827;">${rating}</div>
                </div>
            </div>
            <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button onclick="closeViewModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Close</button>
                <button onclick="editNutritionistFromView('${nutritionistId}')" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Edit Details</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    window.closeViewModal = function() {
        document.body.removeChild(modal);
    };
    
    window.editNutritionistFromView = function(nutritionistId) {
        closeViewModal();
        const targetRow = document.querySelector(`tbody tr[data-nutritionist-id="${nutritionistId}"]`);
        const editBtn = targetRow?.querySelector('button[onclick*="editNutritionist"]');
        if (editBtn) editBtn.click();
    };
}

function searchNutritionists(query) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const nutritionistName = row.querySelector('h4').textContent.toLowerCase();
        const email = row.querySelector('p').textContent.toLowerCase();
        const isVisible = nutritionistName.includes(query.toLowerCase()) || email.includes(query.toLowerCase());
        row.style.display = isVisible ? '' : 'none';
    });
}

function showAddNutritionistModal() {
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 400px; width: 90%;">
            <h3 style="margin: 0 0 1rem 0;">Add New Nutritionist</h3>
            <form id="addNutritionistForm">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Name:</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Email:</label>
                    <input type="email" name="email" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Specialty:</label>
                    <select name="specialty" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                        <option value="Weight Management">Weight Management</option>
                        <option value="Sports Nutrition">Sports Nutrition</option>
                        <option value="Clinical Nutrition">Clinical Nutrition</option>
                        <option value="Pediatric Nutrition">Pediatric Nutrition</option>
                        <option value="Eating Disorders">Eating Disorders</option>
                    </select>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Status:</label>
                    <select name="status" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                        <option value="active" ${status === 'active' ? 'selected' : ''}>active</option>
                        <option value="pending" ${status === 'pending' ? 'selected' : ''}>pending</option>
                        <option value="inactive" ${status === 'inactive' ? 'selected' : ''}>inactive</option>
                    </select>
                </div>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" onclick="closeNutritionistModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.25rem;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.25rem;">Add Nutritionist</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    
    document.getElementById('addNutritionistForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_nutritionist');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeNutritionistModal();
            } else {
                showNotification(data.message, 'error');
            }
        });
    });
    
    window.closeNutritionistModal = function() {
        document.body.removeChild(modal);
    };
}

function editNutritionist(button) {
    const row = button.closest('tr');
    const nutritionistName = row.querySelector('h4').textContent;
    const email = row.querySelector('p').textContent;
    const specialty = row.querySelector('.nutritionist-specialty')?.textContent || '';
    const status = row.dataset.status || 'active';
    const nutritionistId = row.dataset.nutritionistId;
    if (!nutritionistId) {
        showNotification('Missing nutritionist ID', 'error');
        return;
    }
    
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 400px; width: 90%;">
            <h3 style="margin: 0 0 1rem 0;">Edit Nutritionist</h3>
            <form id="editNutritionistForm">
                <input type="hidden" name="nutritionist_id" value="${nutritionistId}">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Name:</label>
                    <input type="text" name="name" value="${nutritionistName}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Email:</label>
                    <input type="email" name="email" value="${email}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Specialty:</label>
                    <select name="specialty" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                        <option value="Weight Management" ${specialty === 'Weight Management' ? 'selected' : ''}>Weight Management</option>
                        <option value="Sports Nutrition" ${specialty === 'Sports Nutrition' ? 'selected' : ''}>Sports Nutrition</option>
                        <option value="Clinical Nutrition" ${specialty === 'Clinical Nutrition' ? 'selected' : ''}>Clinical Nutrition</option>
                        <option value="Pediatric Nutrition" ${specialty === 'Pediatric Nutrition' ? 'selected' : ''}>Pediatric Nutrition</option>
                        <option value="Eating Disorders" ${specialty === 'Eating Disorders' ? 'selected' : ''}>Eating Disorders</option>
                    </select>
                </div>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" onclick="closeEditModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.25rem;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.25rem;">Update</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    
    document.getElementById('editNutritionistForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'edit_nutritionist');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeEditModal();
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        });
    });
    
    window.closeEditModal = function() {
        document.body.removeChild(modal);
    };
}

function deleteNutritionist(button) {
    const row = button.closest('tr');
    const nutritionistName = row.querySelector('h4').textContent;
    const nutritionistId = row.dataset.nutritionistId;
    if (!nutritionistId) {
        showNotification('Missing nutritionist ID', 'error');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${nutritionistName}?`)) {
        const formData = new FormData();
        formData.append('action', 'delete_nutritionist');
        formData.append('nutritionist_id', nutritionistId);
        formData.append('name', nutritionistName);
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                row.remove();
            } else {
                showNotification(data.message, 'error');
            }
        });
    }
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

<style>
.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.admin-table th {
    background: #f8fafc;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
    vertical-align: middle;
}

.admin-table tr:hover {
    background: #f9fafb;
}

.admin-user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.admin-user-details h4 {
    font-weight: 500;
    margin-bottom: 0.25rem;
    color: #111827;
}

.admin-user-details p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-buttons .btn {
    white-space: nowrap;
}

@media (max-width: 768px) {
    .admin-table {
        font-size: 0.75rem;
    }
    
    .admin-table th,
    .admin-table td {
        padding: 0.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-buttons .btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>

<?php include 'footer.php'; ?>