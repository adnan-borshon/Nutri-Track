<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
include 'header.php';
?>

<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="text-3xl font-bold">Diet Plans</h1>
            <p class="text-muted-foreground">Create and manage personalized diet plans</p>
        </div>
        <button class="btn btn-primary" onclick="showCreatePlanModal()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Create New Plan</button>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
</svg>
                </div>
                <h3 class="diet-plan-title">Weight Loss Plan - John Doe</h3>
                <p class="diet-plan-description">1,800 calories/day • High protein, low carb</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg> Created: Mar 15, 2024</span>
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg> Duration: 12 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm" onclick="editPlan(this)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit</button>
                    <button class="btn btn-outline btn-sm" onclick="viewPlan(this)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                </div>
            </div>
        </div>
    
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>
                </div>
                <h3 class="diet-plan-title">Muscle Building - Jane Smith</h3>
                <p class="diet-plan-description">2,400 calories/day • High protein, balanced carbs</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /></svg> Created: Mar 10, 2024</span>
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg> Duration: 16 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm" onclick="editPlan(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit</button>
                    <button class="btn btn-outline btn-sm" onclick="viewPlan(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                </div>
            </div>
        </div>
    
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75L6 21l1.815-.75C8.118 20.015 9.528 19.75 11 19.75h2c1.472 0 2.882.265 4.185.75L19 21l-1.815-.75A11.448 11.448 0 0 0 13 20.25V3m-1 0h2m-2 0h-2m2 0V1.5a.75.75 0 0 1 1.5 0V3m-3 0V1.5a.75.75 0 0 0-1.5 0V3" />
</svg>
                </div>
                <h3 class="diet-plan-title">Maintenance Plan - Mike Johnson</h3>
                <p class="diet-plan-description">2,000 calories/day • Balanced macros</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /></svg> Created: Mar 8, 2024</span>
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg> Duration: 8 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm" onclick="editPlan(this)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit</button>
                    <button class="btn btn-outline btn-sm" onclick="viewPlan(this)"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                </div>
            </div>
        </div>
    
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
</svg>
                </div>
                <h3 class="diet-plan-title">Weight Loss Plan - Emily Davis</h3>
                <p class="diet-plan-description">1,600 calories/day • Low carb, high fiber</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /></svg> Created: Mar 5, 2024</span>
                    <span class="meta-item">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg> Duration: 10 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm" onclick="editPlan(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit</button>
                    <button class="btn btn-outline btn-sm" onclick="viewPlan(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 3.6 -6 6 -9 6c-3 0 -6.6 -2.4 -9 -6c2.4 -3.6 6 -6 9 -6c3 0 6.6 2.4 9 6" /></svg> View</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showCreatePlanModal() {
    const modal = document.createElement('div');
    modal.className = 'admin-modal';
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;';
    
    modal.innerHTML = `
        <div class="admin-modal-content" style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 500px; width: 90%;">
            <div class="admin-modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Create New Diet Plan</h3>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form id="createPlanForm">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Plan Name</label>
                    <input type="text" name="planName" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">User</label>
                    <select name="userId" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        <option value="">Select User</option>
                        <option value="1">John Doe</option>
                        <option value="2">Jane Smith</option>
                        <option value="3">Mike Johnson</option>
                    </select>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Calories</label>
                        <input type="number" name="calories" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Duration (weeks)</label>
                        <input type="number" name="duration" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    </div>
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" onclick="closeModal()" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: 0.375rem; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Create Plan</button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    document.getElementById('createPlanForm').addEventListener('submit', function(e) {
        e.preventDefault();
        showNotification('Diet plan created successfully!', 'success');
        closeModal();
    });
}

function editPlan(button) {
    const card = button.closest('.diet-plan-card');
    const title = card.querySelector('.diet-plan-title').textContent;
    showNotification(`Editing: ${title}`, 'info');
}

function viewPlan(button) {
    const card = button.closest('.diet-plan-card');
    const title = card.querySelector('.diet-plan-title').textContent;
    showNotification(`Viewing: ${title}`, 'info');
}

function closeModal() {
    const modal = document.querySelector('.admin-modal');
    if (modal) {
        modal.remove();
    }
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