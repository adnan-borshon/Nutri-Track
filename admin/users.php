<?php
require_once '../includes/session.php';
checkAuth('admin');

$db = getDB();

$stmt = $db->prepare("SELECT u.*, n.name AS nutritionist_name FROM users u LEFT JOIN users n ON u.nutritionist_id = n.id WHERE u.role = 'user' ORDER BY u.created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll();

$stmt = $db->prepare("SELECT id, name FROM users WHERE role = 'nutritionist' AND status = 'active' ORDER BY name ASC");
$stmt->execute();
$nutritionists = $stmt->fetchAll();

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
                <input type="text" class="search-input" placeholder="Search users..." onkeyup="searchUsers(this.value)">
                <select class="filter-select" onchange="filterUsers(this.value)">
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
                        <?php foreach ($users as $u): ?>
                        <tr class="table-row" data-user-id="<?php echo (int)$u['id']; ?>" data-nutritionist-id="<?php echo (int)($u['nutritionist_id'] ?? 0); ?>" data-weight="<?php echo htmlspecialchars((string)($u['weight'] ?? '')); ?>" data-height="<?php echo htmlspecialchars((string)($u['height'] ?? '')); ?>" data-age="<?php echo htmlspecialchars((string)($u['age'] ?? '')); ?>" data-health-conditions="<?php echo htmlspecialchars((string)($u['health_conditions'] ?? '')); ?>">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar" onclick="showUserProfile(this)" style="cursor: pointer;"><?php echo htmlspecialchars(getUserInitials($u['name'])); ?></div>
                                    <div class="user-details">
                                        <h4 class="user-name"><?php echo htmlspecialchars($u['name']); ?></h4>
                                        <p class="user-email"><?php echo htmlspecialchars($u['email']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge <?php echo htmlspecialchars($u['status']); ?>"><?php echo htmlspecialchars($u['status']); ?></span></td>
                            <td><?php echo htmlspecialchars($u['goal'] ?? ''); ?></td>
                            <td class="<?php echo empty($u['nutritionist_name']) ? 'unassigned' : ''; ?>"><?php echo htmlspecialchars($u['nutritionist_name'] ?? 'Unassigned'); ?></td>
                            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($u['created_at']))); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm" onclick="viewUser(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg> View
                                    </button>
                                    <?php if (($u['status'] ?? '') === 'pending'): ?>
                                    <button class="btn btn-primary btn-sm" onclick="approveUser(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg> Approve
                                    </button>
                                    <?php endif; ?>
                                    <button class="btn btn-outline btn-sm" onclick="assignUser(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg> Assign
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
const nutritionists = <?php echo json_encode($nutritionists); ?>;

function showUserProfile(avatar) {
    const row = avatar.closest('tr');
    const userName = row.querySelector('.user-name').textContent;
    const userEmail = row.querySelector('.user-email').textContent;
    const goal = row.cells[2].textContent;
    const nutritionist = row.cells[3].textContent;
    const joinDate = row.cells[4].textContent;
    const status = row.querySelector('.status-badge').textContent;
    const userId = row.dataset.userId;
    const nutritionistId = row.dataset.nutritionistId || '';
    const weight = row.dataset.weight || '';
    const height = row.dataset.height || '';
    const age = row.dataset.age || '';
    const healthConditions = row.dataset.healthConditions || '';
    
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center; overflow-y: auto;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; margin: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">User Profile</h3>
                <button onclick="closeUserProfile()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; padding: 0.25rem;">&times;</button>
            </div>
            
            <div style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                            <h4 style="margin: 0; font-size: 1rem; font-weight: 600;">Profile Information</h4>
                        </div>
                        <div style="padding: 1.5rem;">
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div>
                                    <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Full Name</label>
                                    <input type="text" value="${userName}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Email</label>
                                    <input type="email" value="${userEmail}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Goal</label>
                                    <input type="text" value="${goal}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                            <h4 style="margin: 0; font-size: 1rem; font-weight: 600;">Account Status</h4>
                        </div>
                        <div style="padding: 1.5rem;">
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <div>
                                    <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Status</label>
                                    <span class="status-badge ${status}" style="display: inline-block;">${status}</span>
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Nutritionist</label>
                                    <input type="text" value="${nutritionist}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                                </div>
                                <div>
                                    <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Join Date</label>
                                    <input type="text" value="${joinDate}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                    <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                        <h4 style="margin: 0; font-size: 1rem; font-weight: 600;">Health Information</h4>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Weight (kg)</label>
                                <input type="text" value="${weight || '-'}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Height (cm)</label>
                                <input type="text" value="${height || '-'}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                            </div>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Age</label>
                            <input type="text" value="${age || '-'}" readonly style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background: #f9fafb;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Health Conditions</label>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <div style="padding: 0.25rem 0.75rem; background: #dcfce7; color: #278b63; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">${healthConditions || 'None reported'}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="padding: 1rem 1.5rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button onclick="closeUserProfile()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Close</button>
                <button onclick="editUserFromProfile()" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Edit User</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    window.closeUserProfile = function() {
        document.body.removeChild(modal);
    };
    
    window.editUserFromProfile = function() {
        closeUserProfile();
        showEditUserModal(userId, userName, userEmail, goal, nutritionistId, status);
    };
}

function searchUsers(query) {
    const rows = document.querySelectorAll('.table-row');
    rows.forEach(row => {
        const userName = row.querySelector('.user-name').textContent.toLowerCase();
        const userEmail = row.querySelector('.user-email').textContent.toLowerCase();
        const isVisible = userName.includes(query.toLowerCase()) || userEmail.includes(query.toLowerCase());
        row.style.display = isVisible ? '' : 'none';
    });
}

function filterUsers(status) {
    const rows = document.querySelectorAll('.table-row');
    rows.forEach(row => {
        const statusBadge = row.querySelector('.status-badge');
        const userStatus = statusBadge.textContent.toLowerCase();
        const isVisible = status === 'all' || userStatus === status;
        row.style.display = isVisible ? '' : 'none';
    });
}

function showAddUserModal() {
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 400px; width: 90%;">
            <h3 style="margin: 0 0 1rem 0;">Add New User</h3>
            <form id="addUserForm">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Name:</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Email:</label>
                    <input type="email" name="email" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Goal:</label>
                    <select name="goal" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                        <option value="Weight Loss">Weight Loss</option>
                        <option value="Maintain">Maintain</option>
                        <option value="Gain Weight">Gain Weight</option>
                        <option value="Build Muscle">Build Muscle</option>
                    </select>
                </div>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.25rem;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.25rem;">Add User</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_user');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeModal();
            } else {
                showNotification(data.message, 'error');
            }
        });
    });
    
    window.closeModal = function() {
        document.body.removeChild(modal);
    };
}

function viewUser(button) {
    const row = button.closest('tr');
    const userName = row.querySelector('.user-name').textContent;
    showUserProfile(row.querySelector('.user-avatar'));
}

function approveUser(button) {
    const row = button.closest('tr');
    const userId = row.dataset.userId;
    if (!userId) {
        showNotification('Missing user ID', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'approve_user');
    formData.append('user_id', userId);
    
    fetch('admin_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            const statusBadge = row.querySelector('.status-badge');
            statusBadge.textContent = 'active';
            statusBadge.className = 'status-badge active';
            button.style.display = 'none';
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function assignUser(button) {
    const row = button.closest('tr');
    const userId = row.dataset.userId;
    const currentNutritionistId = row.dataset.nutritionistId || '';
    if (!userId) {
        showNotification('Missing user ID', 'error');
        return;
    }

    const nutritionistOptions = ['<option value="">Unassigned</option>']
        .concat(nutritionists.map(n => `<option value="${n.id}" ${String(n.id) === String(currentNutritionistId) ? 'selected' : ''}>${n.name}</option>`))
        .join('');
    
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 400px; width: 90%;">
            <h3 style="margin: 0 0 1rem 0;">Assign Nutritionist</h3>
            <form id="assignForm">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Select Nutritionist:</label>
                    <select name="nutritionist_id" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                        ${nutritionistOptions}
                    </select>
                </div>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" onclick="closeAssignModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.25rem;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.25rem;">Assign</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    
    document.getElementById('assignForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'assign_nutritionist');
        formData.append('user_id', userId);
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeAssignModal();
                const nutritionistCell = row.cells[3];
                const selectedId = formData.get('nutritionist_id');
                const selectedNutritionist = nutritionists.find(n => String(n.id) === String(selectedId));
                if (selectedNutritionist) {
                    nutritionistCell.textContent = selectedNutritionist.name;
                    nutritionistCell.classList.remove('unassigned');
                    row.dataset.nutritionistId = selectedId;
                } else {
                    nutritionistCell.textContent = 'Unassigned';
                    nutritionistCell.classList.add('unassigned');
                    row.dataset.nutritionistId = '';
                }
            } else {
                showNotification(data.message, 'error');
            }
        });
    });
    
    window.closeAssignModal = function() {
        document.body.removeChild(modal);
    };
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

function showEditUserModal(userId, name, email, goal, nutritionistId, status) {
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center; overflow-y: auto;';

    const nutritionistOptions = ['<option value="">Unassigned</option>']
        .concat(nutritionists.map(n => `<option value="${n.id}" ${String(n.id) === String(nutritionistId) ? 'selected' : ''}>${n.name}</option>`))
        .join('');

    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; max-width: 500px; width: 90%; margin: 2rem;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Edit User</h3>
                <button onclick="closeEditModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; padding: 0.25rem;">&times;</button>
            </div>
            
            <form id="editUserForm" style="padding: 1.5rem;">
                <input type="hidden" name="user_id" value="${userId}">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Full Name</label>
                        <input type="text" name="name" value="${name}" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Email</label>
                        <input type="email" name="email" value="${email}" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Goal</label>
                        <select name="goal" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                            <option value="Weight Loss" ${goal === 'Weight Loss' ? 'selected' : ''}>Weight Loss</option>
                            <option value="Maintain" ${goal === 'Maintain' ? 'selected' : ''}>Maintain</option>
                            <option value="Gain Weight" ${goal === 'Gain Weight' ? 'selected' : ''}>Gain Weight</option>
                            <option value="Build Muscle" ${goal === 'Build Muscle' ? 'selected' : ''}>Build Muscle</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Status</label>
                        <select name="status" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                            <option value="active" ${status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="pending" ${status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="inactive" ${status === 'inactive' ? 'selected' : ''}>Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 500; font-size: 0.875rem; margin-bottom: 0.5rem; color: #374151;">Assigned Nutritionist</label>
                    <select name="nutritionist_id" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                        ${nutritionistOptions}
                    </select>
                </div>
                
                <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" onclick="closeEditModal()" style="padding: 0.75rem 1.5rem; background: #6b7280; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 500;">Cancel</button>
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: #278b63; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 500;">Save Changes</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'edit_user');
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || 'User updated successfully!', 'success');
                closeEditModal();
                // Update the table row with new data
                updateUserRow(userId, formData);
            } else {
                showNotification(data.message || 'Failed to update user', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error occurred', 'error');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });
    
    window.closeEditModal = function() {
        document.body.removeChild(modal);
    };
}

function updateUserRow(userId, formData) {
    const rows = document.querySelectorAll('.table-row');
    rows.forEach(row => {
        if (String(row.dataset.userId) === String(userId)) {
            // Update user name and email
            row.querySelector('.user-name').textContent = formData.get('name');
            row.querySelector('.user-email').textContent = formData.get('email');
            
            // Update goal
            row.cells[2].textContent = formData.get('goal');
            
            // Update nutritionist
            const selectedId = formData.get('nutritionist_id');
            const selectedNutritionist = nutritionists.find(n => String(n.id) === String(selectedId));
            if (selectedNutritionist) {
                row.cells[3].textContent = selectedNutritionist.name;
                row.cells[3].classList.remove('unassigned');
                row.dataset.nutritionistId = selectedId;
            } else {
                row.cells[3].textContent = 'Unassigned';
                row.cells[3].classList.add('unassigned');
                row.dataset.nutritionistId = '';
            }
            
            // Update status
            const statusBadge = row.querySelector('.status-badge');
            const newStatus = formData.get('status');
            statusBadge.textContent = newStatus;
            statusBadge.className = `status-badge ${newStatus}`;
            
            // Update avatar initials if name changed
            const newName = formData.get('name');
            const initials = newName.split(' ').map(n => n[0]).join('').toUpperCase();
            row.querySelector('.user-avatar').textContent = initials;
        }
    });
}
</script>