<?php
require_once '../includes/session.php';
checkAuth('nutritionist');

$db = getDB();
$nutritionistId = $_SESSION['user_id'];

// Fetch diet plans for this nutritionist
$stmt = $db->prepare("SELECT dp.*, u.name as user_name 
                      FROM diet_plans dp 
                      JOIN users u ON dp.user_id = u.id 
                      WHERE dp.nutritionist_id = ? 
                      ORDER BY dp.created_at DESC");
$stmt->execute([$nutritionistId]);
$dietPlans = $stmt->fetchAll();

// Fetch assigned users for the dropdown
$stmt = $db->prepare("SELECT id, name, email FROM users WHERE nutritionist_id = ? AND role = 'user' ORDER BY name");
$stmt->execute([$nutritionistId]);
$assignedUsers = $stmt->fetchAll();

include 'header.php';
?>

<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="text-3xl font-bold">Diet Plans</h1>
            <p class="text-muted-foreground">Create and manage personalized diet plans</p>
        </div>
        <button class="btn btn-primary" onclick="showCreatePlanModal()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#fff;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Create New Plan</button>
    </div>

    <div id="dietPlansContainer" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($dietPlans)): ?>
        <div class="col-span-2 text-center py-12">
            <p class="text-muted-foreground">No diet plans yet. Click "Create New Plan" to get started.</p>
        </div>
        <?php else: ?>
        <?php foreach ($dietPlans as $plan): ?>
        <div class="diet-plan-card" data-plan-id="<?= $plan['id'] ?>">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
                    </svg>
                </div>
                <h3 class="diet-plan-title"><?= htmlspecialchars($plan['name']) ?></h3>
                <p class="diet-plan-description"><?= number_format($plan['daily_calories']) ?> calories/day • <?= htmlspecialchars($plan['user_name']) ?></p>
                <div class="diet-plan-meta">
                    <span class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;"><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /></svg>
                        Created: <?= date('M d, Y', strtotime($plan['created_at'])) ?>
                    </span>
                    <span class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                        Duration: <?= $plan['duration_weeks'] ?> weeks
                    </span>
                    <span class="meta-item status-<?= $plan['status'] ?>">
                        <?= ucfirst($plan['status']) ?>
                    </span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm" onclick="editPlan(<?= $plan['id'] ?>, '<?= htmlspecialchars(addslashes($plan['name'])) ?>', <?= $plan['daily_calories'] ?>, <?= $plan['duration_weeks'] ?>, '<?= htmlspecialchars(addslashes($plan['description'] ?? '')) ?>', '<?= $plan['status'] ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;"><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deletePlan(<?= $plan['id'] ?>, '<?= htmlspecialchars(addslashes($plan['name'])) ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;"><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Assigned users data for the create modal dropdown
const assignedUsers = <?= json_encode($assignedUsers) ?>;

class DietPlanModal {
    constructor() {
        this.modal = null;
    }

    create() {
        this.close(); // Close any existing modal
        
        this.modal = document.createElement('div');
        this.modal.className = 'diet-modal';
        this.modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;';
        
        document.body.style.overflow = 'hidden';
        
        // Close on backdrop click
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.close();
        });
        
        return this.modal;
    }

    close() {
        if (this.modal) {
            this.modal.remove();
            this.modal = null;
            document.body.style.overflow = 'auto';
        }
    }

    addCloseListeners(selectors) {
        selectors.forEach(selector => {
            const btn = this.modal.querySelector(selector);
            if (btn) btn.addEventListener('click', () => this.close());
        });
    }
}

const modalManager = new DietPlanModal();

function showCreatePlanModal() {
    const modal = modalManager.create();
    
    let userOptions = '<option value="">Select User</option>';
    assignedUsers.forEach(user => {
        userOptions += `<option value="${user.id}">${user.name} (${user.email})</option>`;
    });
    
    modal.innerHTML = `
        <div class="modal-content" style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Create New Diet Plan</h3>
                <button class="close-btn" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280;">×</button>
            </div>
            <form class="plan-form">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Plan Name *</label>
                    <input type="text" name="planName" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">User *</label>
                    <select name="userId" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                        ${userOptions}
                    </select>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Daily Calories *</label>
                        <input type="number" name="calories" required min="500" max="5000" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Duration (weeks) *</label>
                        <input type="number" name="duration" required min="1" max="52" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Description</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box; resize: vertical;"></textarea>
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" class="cancel-btn btn btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Plan</button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modalManager.addCloseListeners(['.close-btn', '.cancel-btn']);
    
    modal.querySelector('.plan-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'create_diet_plan');
        
        try {
            const response = await fetch('nutritionist_handler.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message, 'success');
                modalManager.close();
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        } catch (error) {
            showNotification('An error occurred', 'error');
        }
    });
}

function editPlan(planId, planName, calories, duration, description, status) {
    const modal = modalManager.create();
    
    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    const mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
    
    let mealPlanHTML = '';
    days.forEach(day => {
        mealPlanHTML += `
            <div class="day-section" style="margin-bottom: 1.5rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem;">
                <h4 style="margin: 0 0 1rem 0; text-transform: capitalize; color: #278b63;">${day}</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem;">`;
        
        mealTypes.forEach(meal => {
            mealPlanHTML += `
                <div>
                    <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500; text-transform: capitalize;">${meal}</label>
                    <textarea name="meal_${day}_${meal}" placeholder="e.g., Oatmeal with berries" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box; resize: vertical; min-height: 60px; font-size: 0.875rem;"></textarea>
                </div>`;
        });
        
        mealPlanHTML += `</div></div>`;
    });
    
    modal.innerHTML = `
        <div class="modal-content" style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 900px; width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Edit Diet Plan</h3>
                <button class="close-btn" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280;">×</button>
            </div>
            <form class="plan-form">
                <input type="hidden" name="planId" value="${planId}">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Plan Name *</label>
                        <input type="text" name="planName" value="${planName}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Status</label>
                        <select name="status" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                            <option value="active" ${status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="completed" ${status === 'completed' ? 'selected' : ''}>Completed</option>
                            <option value="cancelled" ${status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Daily Calories *</label>
                        <input type="number" name="calories" value="${calories}" required min="500" max="5000" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Duration (weeks) *</label>
                        <input type="number" name="duration" value="${duration}" required min="1" max="52" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Description</label>
                    <textarea name="description" rows="2" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box; resize: vertical;">${description}</textarea>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <h4 style="margin: 0 0 1rem 0; color: #111827; border-bottom: 2px solid #278b63; padding-bottom: 0.5rem;">Weekly Meal Plan</h4>
                    ${mealPlanHTML}
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" class="cancel-btn btn btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Plan</button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modalManager.addCloseListeners(['.close-btn', '.cancel-btn']);
    
    // Load existing meal data
    loadMealData(planId);
    
    modal.querySelector('.plan-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'edit_diet_plan');
        
        try {
            const response = await fetch('nutritionist_handler.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message, 'success');
                modalManager.close();
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        } catch (error) {
            showNotification('An error occurred', 'error');
        }
    });
}

async function loadMealData(planId) {
    try {
        const response = await fetch(`nutritionist_handler.php?action=get_meal_plan&planId=${planId}`);
        const data = await response.json();
        
        if (data.success && data.data && data.data.meals) {
            data.data.meals.forEach(meal => {
                const textarea = document.querySelector(`textarea[name="meal_${meal.day_of_week}_${meal.meal_type}"]`);
                if (textarea) {
                    textarea.value = meal.meal_items || '';
                }
            });
        }
    } catch (error) {
        console.error('Error loading meal data:', error);
    }
}

function deletePlan(planId, planName) {
    if (!confirm(`Are you sure you want to delete "${planName}"? This action cannot be undone.`)) {
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'delete_diet_plan');
    formData.append('planId', planId);
    
    fetch('nutritionist_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            const card = document.querySelector(`[data-plan-id="${planId}"]`);
            if (card) card.remove();
            
            // Check if no plans left
            const container = document.getElementById('dietPlansContainer');
            if (container.querySelectorAll('.diet-plan-card').length === 0) {
                container.innerHTML = '<div class="col-span-2 text-center py-12"><p class="text-muted-foreground">No diet plans yet. Click "Create New Plan" to get started.</p></div>';
            }
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('An error occurred', 'error');
    });
}

function closeModal() {
    modalManager.close();
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
        z-index: 1001;
        max-width: 300px;
        animation: slideIn 0.3s ease;
    `;
    
    const colors = { success: '#278b63', error: '#dc2626', info: '#3b82f6' };
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<style>
.status-active { color: #059669; font-weight: 500; }
.status-completed { color: #3b82f6; font-weight: 500; }
.status-cancelled { color: #dc2626; font-weight: 500; }
.btn-danger { background: #dc2626; color: white; border: none; }
.btn-danger:hover { background: #b91c1c; }
</style>

<?php include 'footer.php'; ?>