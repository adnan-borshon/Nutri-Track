<?php
require_once '../includes/session.php';
checkAuth('admin');

$db = getDB();

$stmt = $db->prepare("SELECT id, name FROM food_categories ORDER BY name ASC");
$stmt->execute();
$categories = $stmt->fetchAll();

$stmt = $db->prepare("SELECT f.*, c.name AS category_name
                       FROM foods f
                       LEFT JOIN food_categories c ON f.category_id = c.id
                       ORDER BY f.name ASC");
$stmt->execute();
$foods = $stmt->fetchAll();

include 'header.php';
?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Food Database</h1>
            <p class="section-description">Manage food items and nutritional information</p>
        </div>
        <button class="btn btn-primary" onclick="showAddFoodModal()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> Add Food Item
        </button>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <div class="form-row">
            <input type="text" class="form-input" placeholder="Search foods..." onkeyup="searchFoods(this.value)">
            <select class="form-input" onchange="filterFoods(this.value)">
                <option value="all">All Categories</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?php echo (int)$c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Food Item</th>
                    <th>Category</th>
                    <th>Calories (per 100g)</th>
                    <th>Protein</th>
                    <th>Carbs</th>
                    <th>Fat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foods as $f): ?>
                <tr data-food-id="<?php echo (int)$f['id']; ?>" data-category-id="<?php echo (int)($f['category_id'] ?? 0); ?>">
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-apple" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 14m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M12 11v-6a2 2 0 0 1 2 -2h2v1a2 2 0 0 1 -2 2h-2" /><path d="M10 10.5c-.667 -.667 -2.5 0 -2.5 2.5s1.833 3.167 2.5 2.5" /><path d="M16 10.5c.667 -.667 2.5 0 2.5 2.5s-1.833 3.167 -2.5 2.5" /></svg>
                            </div>
                            <div class="admin-user-details">
                                <h4><?php echo htmlspecialchars($f['name']); ?></h4>
                                <p class="food-description"><?php echo htmlspecialchars($f['description'] ?? ''); ?></p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed food-category"><?php echo htmlspecialchars($f['category_name'] ?? 'Uncategorized'); ?></span></td>
                    <td><?php echo (int)($f['calories'] ?? 0); ?></td>
                    <td><?php echo htmlspecialchars(rtrim(rtrim(number_format((float)($f['protein'] ?? 0), 1), '0'), '.')); ?>g</td>
                    <td><?php echo htmlspecialchars(rtrim(rtrim(number_format((float)($f['carbs'] ?? 0), 1), '0'), '.')); ?>g</td>
                    <td><?php echo htmlspecialchars(rtrim(rtrim(number_format((float)($f['fat'] ?? 0), 1), '0'), '.')); ?>g</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-outline btn-sm" onclick="editFood(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                            </button>
                            <button class="btn btn-outline btn-sm" onclick="deleteFood(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;color:#dc2626;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
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
const categories = <?php echo json_encode($categories); ?>;

function searchFoods(query) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const foodName = row.querySelector('h4').textContent.toLowerCase();
        const isVisible = foodName.includes(query.toLowerCase());
        row.style.display = isVisible ? '' : 'none';
    });
}

function filterFoods(category) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const rowCategoryId = row.dataset.categoryId;
        const isVisible = category === 'all' || String(rowCategoryId) === String(category);
        row.style.display = isVisible ? '' : 'none';
    });
}

function showAddFoodModal() {
    const categoryOptions = categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 500px; width: 90%;">
            <h3 style="margin: 0 0 1rem 0;">Add New Food Item</h3>
            <form id="addFoodForm">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Name:</label>
                        <input type="text" name="name" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Category:</label>
                        <select name="category_id" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                            ${categoryOptions}
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Description:</label>
                    <input type="text" name="description" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Calories:</label>
                        <input type="number" name="calories" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Protein (g):</label>
                        <input type="number" step="0.1" name="protein" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Carbs (g):</label>
                        <input type="number" step="0.1" name="carbs" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Fat (g):</label>
                        <input type="number" step="0.1" name="fat" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                </div>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" onclick="closeFoodModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.25rem;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.25rem;">Add Food</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    
    document.getElementById('addFoodForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_food');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeFoodModal();
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        });
    });
    
    window.closeFoodModal = function() {
        document.body.removeChild(modal);
    };
}

function editFood(button) {
    const row = button.closest('tr');
    const foodName = row.querySelector('h4').textContent;
    const description = row.querySelector('.food-description')?.textContent || '';
    const categoryId = row.dataset.categoryId;
    const calories = row.cells[2].textContent;
    const protein = row.cells[3].textContent.replace('g', '');
    const carbs = row.cells[4].textContent.replace('g', '');
    const fat = row.cells[5].textContent.replace('g', '');

    const foodId = row.dataset.foodId;
    if (!foodId) {
        showNotification('Missing food ID', 'error');
        return;
    }

    const categoryOptions = categories
        .map(c => `<option value="${c.id}" ${String(c.id) === String(categoryId) ? 'selected' : ''}>${c.name}</option>`)
        .join('');
    
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 500px; width: 90%;">
            <h3 style="margin: 0 0 1rem 0;">Edit Food Item</h3>
            <form id="editFoodForm">
                <input type="hidden" name="food_id" value="${foodId}">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Name:</label>
                        <input type="text" name="name" value="${foodName}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Category:</label>
                        <select name="category_id" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                            ${categoryOptions}
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Description:</label>
                    <input type="text" name="description" value="${description}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Calories:</label>
                        <input type="number" name="calories" value="${calories}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Protein (g):</label>
                        <input type="number" step="0.1" name="protein" value="${protein}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Carbs (g):</label>
                        <input type="number" step="0.1" name="carbs" value="${carbs}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Fat (g):</label>
                        <input type="number" step="0.1" name="fat" value="${fat}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                </div>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" onclick="closeEditModal()" style="padding: 0.5rem 1rem; background: #6b7280; color: white; border: none; border-radius: 0.25rem;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.25rem;">Update Food</button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    
    document.getElementById('editFoodForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'edit_food');
        
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

function deleteFood(button) {
    const row = button.closest('tr');
    const foodName = row.querySelector('h4').textContent;
    const foodId = row.dataset.foodId;
    if (!foodId) {
        showNotification('Missing food ID', 'error');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${foodName}?`)) {
        const formData = new FormData();
        formData.append('action', 'delete_food');
        formData.append('food_id', foodId);
        formData.append('name', foodName);
        
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

<?php include 'footer.php'; ?>