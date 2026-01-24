<?php
require_once '../includes/session.php';
checkAuth('admin');
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
                <option value="fruits">Fruits</option>
                <option value="vegetables">Vegetables</option>
                <option value="grains">Grains</option>
                <option value="proteins">Proteins</option>
                <option value="dairy">Dairy</option>
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
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-apple" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 14m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M12 11v-6a2 2 0 0 1 2 -2h2v1a2 2 0 0 1 -2 2h-2" /><path d="M10 10.5c-.667 -.667 -2.5 0 -2.5 2.5s1.833 3.167 2.5 2.5" /><path d="M16 10.5c.667 -.667 2.5 0 2.5 2.5s-1.833 3.167 -2.5 2.5" /></svg>
                            </div>
                            <div class="admin-user-details">
                                <h4>Apple</h4>
                                <p>Fresh red apple</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Fruits</span></td>
                    <td>52</td>
                    <td>0.3g</td>
                    <td>14g</td>
                    <td>0.2g</td>
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
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-carrot" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21s9.834 -3.489 12.684 -6.34a4.487 4.487 0 0 0 0 -6.344a4.483 4.483 0 0 0 -6.342 0c-2.86 2.861 -6.347 12.689 -6.342 12.684z" /><path d="M9 13l-1.5 -1.5" /><path d="M16 14l-2 -2" /><path d="M22 8s-1.14 -2 -3 -2c-1.406 0 -3 2 -3 2s1.14 2 3 2s3 -2 3 -2z" /><path d="M16 2s-2 1.14 -2 3s2 3 2 3s2 -1.577 2 -3c0 -1.86 -2 -3 -2 -3z" /></svg>
                            </div>
                            <div class="admin-user-details">
                                <h4>Carrot</h4>
                                <p>Fresh orange carrot</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Vegetables</span></td>
                    <td>41</td>
                    <td>0.9g</td>
                    <td>10g</td>
                    <td>0.2g</td>
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
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-meat" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.62 8.382l1.966 -1.967a2 2 0 1 1 2.828 2.828l-1.966 1.967" /><path d="M10.5 11.5l-3.5 -3.5a2 2 0 1 1 2.828 -2.828l3.5 3.5" /><path d="M8 16l2 2" /><path d="M10.5 16.5l4.5 -4.5" /><path d="M12 18l2 2" /><path d="M16 12l-4.5 4.5" /><path d="M18 10l2 2" /><path d="M20 8l-8 8" /></svg>
                            </div>
                            <div class="admin-user-details">
                                <h4>Chicken Breast</h4>
                                <p>Skinless, boneless</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Proteins</span></td>
                    <td>165</td>
                    <td>31g</td>
                    <td>0g</td>
                    <td>3.6g</td>
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
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-bowl" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8h16a1 1 0 0 1 1 1v.5c0 1.5 -2.517 5.573 -4 6.5v1a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-1c-1.687 -1.054 -4 -5 -4 -6.5v-.5a1 1 0 0 1 1 -1z" /></svg>
                            </div>
                            <div class="admin-user-details">
                                <h4>Brown Rice</h4>
                                <p>Cooked brown rice</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Grains</span></td>
                    <td>111</td>
                    <td>2.6g</td>
                    <td>23g</td>
                    <td>0.9g</td>
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
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-glass" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21l8 0" /><path d="M12 15l0 6" /><path d="M17 3l1 7c0 3.012 -2.686 5 -6 5s-6 -1.988 -6 -5l1 -7h10z" /><path d="M6 3l12 0" /></svg>
                            </div>
                            <div class="admin-user-details">
                                <h4>Milk</h4>
                                <p>Whole milk</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Dairy</span></td>
                    <td>61</td>
                    <td>3.2g</td>
                    <td>4.8g</td>
                    <td>3.3g</td>
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
            </tbody>
        </table>
    </div>
</div>

<script>
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
        const foodCategory = row.querySelector('.status-badge').textContent.toLowerCase();
        const isVisible = category === 'all' || foodCategory === category.toLowerCase();
        row.style.display = isVisible ? '' : 'none';
    });
}

function showAddFoodModal() {
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
                        <select name="category" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                            <option value="Fruits">Fruits</option>
                            <option value="Vegetables">Vegetables</option>
                            <option value="Proteins">Proteins</option>
                            <option value="Grains">Grains</option>
                            <option value="Dairy">Dairy</option>
                        </select>
                    </div>
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
    const description = row.querySelector('p').textContent;
    const category = row.querySelector('.status-badge').textContent;
    const calories = row.cells[2].textContent;
    const protein = row.cells[3].textContent.replace('g', '');
    const carbs = row.cells[4].textContent.replace('g', '');
    const fat = row.cells[5].textContent.replace('g', '');
    
    const modal = document.createElement('div');
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;';
    modal.innerHTML = `
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 500px; width: 90%;">
            <h3 style="margin: 0 0 1rem 0;">Edit Food Item</h3>
            <form id="editFoodForm">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Name:</label>
                        <input type="text" name="name" value="${foodName}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem;">Category:</label>
                        <select name="category" required style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                            <option value="Fruits" ${category === 'Fruits' ? 'selected' : ''}>Fruits</option>
                            <option value="Vegetables" ${category === 'Vegetables' ? 'selected' : ''}>Vegetables</option>
                            <option value="Proteins" ${category === 'Proteins' ? 'selected' : ''}>Proteins</option>
                            <option value="Grains" ${category === 'Grains' ? 'selected' : ''}>Grains</option>
                            <option value="Dairy" ${category === 'Dairy' ? 'selected' : ''}>Dairy</option>
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
        formData.append('food_id', row.dataset.foodId || Math.floor(Math.random() * 1000));
        
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
    const foodId = row.dataset.foodId || Math.floor(Math.random() * 1000);
    
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