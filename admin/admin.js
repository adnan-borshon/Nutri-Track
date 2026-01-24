// Admin Panel JavaScript Functionality

// Profile Popup Functions - Available immediately
window.showProfilePopup = function() {
    console.log('showProfilePopup called');
    const popup = document.getElementById('profilePopup');
    if (popup) {
        popup.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('Profile popup shown');
    } else {
        console.error('Profile popup element not found');
    }
};

window.closeProfilePopup = function() {
    console.log('closeProfilePopup called');
    const popup = document.getElementById('profilePopup');
    if (popup) {
        popup.style.display = 'none';
        document.body.style.overflow = 'auto';
        console.log('Profile popup closed');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    
    // Modal Management
    const modals = {
        addUser: null,
        addNutritionist: null,
        addFood: null,
        addCategory: null,
        editUser: null,
        editNutritionist: null,
        editFood: null,
        editCategory: null,
        viewUser: null,
        viewNutritionist: null,
        assignNutritionist: null,
        confirmDelete: null
    };

    // Initialize all functionality
    initializeModals();
    initializeButtons();
    initializeSearch();
    initializeFilters();
    initializeToggles();
    initializeForms();

    // Modal Functions
    function initializeModals() {
        // Create modal container if it doesn't exist
        if (!document.getElementById('modal-container')) {
            const modalContainer = document.createElement('div');
            modalContainer.id = 'modal-container';
            document.body.appendChild(modalContainer);
        }
    }

    function createModal(id, title, content, actions = '') {
        return `
            <div id="${id}" class="admin-modal" style="display: none;">
                <div class="admin-modal-content">
                    <div class="admin-modal-header">
                        <h3 class="admin-modal-title">${title}</h3>
                        <button class="admin-modal-close" onclick="closeModal('${id}')">&times;</button>
                    </div>
                    <div class="admin-modal-body">
                        ${content}
                    </div>
                    ${actions ? `<div class="admin-modal-footer">${actions}</div>` : ''}
                </div>
            </div>
        `;
    }

    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Make closeModal globally available
    window.closeModal = closeModal;

    // Button Event Handlers
    function initializeButtons() {
        // Add User Button
        const addUserBtn = document.querySelector('button:contains("Add User")') || 
                          document.querySelector('[onclick*="addUser"]') ||
                          Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Add User'));
        
        if (addUserBtn) {
            addUserBtn.addEventListener('click', showAddUserModal);
        }

        // Add Nutritionist Button
        const addNutritionistBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Add Nutritionist'));
        if (addNutritionistBtn) {
            addNutritionistBtn.addEventListener('click', showAddNutritionistModal);
        }

        // Add Food Item Button
        const addFoodBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Add Food'));
        if (addFoodBtn) {
            addFoodBtn.addEventListener('click', showAddFoodModal);
        }

        // Add Category Button
        const addCategoryBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Add Category'));
        if (addCategoryBtn) {
            addCategoryBtn.addEventListener('click', showAddCategoryModal);
        }

        // View buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('View')) {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    if (row) {
                        const userName = row.querySelector('.user-name, h4')?.textContent;
                        if (userName) {
                            showViewModal(userName, row);
                        }
                    }
                });
            }
        });

        // Edit buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Edit')) {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr') || this.closest('.card');
                    if (row) {
                        showEditModal(row);
                    }
                });
            }
        });

        // Delete buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Delete')) {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr') || this.closest('.card');
                    if (row) {
                        showDeleteConfirmation(row);
                    }
                });
            }
        });

        // Approve buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Approve')) {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    if (row) {
                        approveUser(row);
                    }
                });
            }
        });

        // Assign buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Assign')) {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    if (row) {
                        showAssignModal(row);
                    }
                });
            }
        });

        // System action buttons
        const systemButtons = document.querySelectorAll('.card button');
        systemButtons.forEach(btn => {
            if (btn.textContent.includes('Generate Report')) {
                btn.addEventListener('click', generateReport);
            } else if (btn.textContent.includes('Backup Database')) {
                btn.addEventListener('click', backupDatabase);
            } else if (btn.textContent.includes('Clear Cache')) {
                btn.addEventListener('click', clearCache);
            } else if (btn.textContent.includes('Maintenance Mode')) {
                btn.addEventListener('click', toggleMaintenanceMode);
            } else if (btn.textContent.includes('Update Password')) {
                btn.addEventListener('click', updatePassword);
            }
        });
    }

    // Modal Content Functions
    function showAddUserModal() {
        const modalContent = `
            <form id="addUserForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Full Name</label>
                    <input type="text" class="admin-form-input" name="fullName" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Email</label>
                    <input type="email" class="admin-form-input" name="email" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Goal</label>
                    <select class="admin-form-select" name="goal" required>
                        <option value="">Select Goal</option>
                        <option value="weight_loss">Weight Loss</option>
                        <option value="maintain">Maintain</option>
                        <option value="gain_weight">Gain Weight</option>
                        <option value="build_muscle">Build Muscle</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Nutritionist</label>
                    <select class="admin-form-select" name="nutritionist">
                        <option value="">Unassigned</option>
                        <option value="dr_smith">Dr. Smith</option>
                        <option value="dr_chen">Dr. Chen</option>
                        <option value="dr_wilson">Dr. Wilson</option>
                    </select>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('addUserModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitAddUser()">Add User</button>
        `;

        const modalHTML = createModal('addUserModal', 'Add New User', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('addUserModal');
    }

    function showAddNutritionistModal() {
        const modalContent = `
            <form id="addNutritionistForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Full Name</label>
                    <input type="text" class="admin-form-input" name="fullName" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Email</label>
                    <input type="email" class="admin-form-input" name="email" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Specialty</label>
                    <select class="admin-form-select" name="specialty" required>
                        <option value="">Select Specialty</option>
                        <option value="weight_management">Weight Management</option>
                        <option value="sports_nutrition">Sports Nutrition</option>
                        <option value="clinical_nutrition">Clinical Nutrition</option>
                        <option value="pediatric_nutrition">Pediatric Nutrition</option>
                        <option value="eating_disorders">Eating Disorders</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">License Number</label>
                    <input type="text" class="admin-form-input" name="license" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Bio</label>
                    <textarea class="admin-form-textarea" name="bio" rows="4"></textarea>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('addNutritionistModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitAddNutritionist()">Add Nutritionist</button>
        `;

        const modalHTML = createModal('addNutritionistModal', 'Add New Nutritionist', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('addNutritionistModal');
    }

    function showAddFoodModal() {
        const modalContent = `
            <form id="addFoodForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Food Name</label>
                    <input type="text" class="admin-form-input" name="foodName" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Description</label>
                    <input type="text" class="admin-form-input" name="description">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Category</label>
                    <select class="admin-form-select" name="category" required>
                        <option value="">Select Category</option>
                        <option value="fruits">Fruits</option>
                        <option value="vegetables">Vegetables</option>
                        <option value="grains">Grains</option>
                        <option value="proteins">Proteins</option>
                        <option value="dairy">Dairy</option>
                        <option value="nuts_seeds">Nuts & Seeds</option>
                    </select>
                </div>
                <div class="admin-grid admin-grid-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Calories (per 100g)</label>
                        <input type="number" class="admin-form-input" name="calories" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Protein (g)</label>
                        <input type="number" step="0.1" class="admin-form-input" name="protein" required>
                    </div>
                </div>
                <div class="admin-grid admin-grid-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Carbs (g)</label>
                        <input type="number" step="0.1" class="admin-form-input" name="carbs" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Fat (g)</label>
                        <input type="number" step="0.1" class="admin-form-input" name="fat" required>
                    </div>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('addFoodModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitAddFood()">Add Food Item</button>
        `;

        const modalHTML = createModal('addFoodModal', 'Add New Food Item', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('addFoodModal');
    }

    function showAddCategoryModal() {
        const modalContent = `
            <form id="addCategoryForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Category Name</label>
                    <input type="text" class="admin-form-input" name="categoryName" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Description</label>
                    <input type="text" class="admin-form-input" name="description" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Icon</label>
                    <select class="admin-form-select" name="icon" required>
                        <option value="">Select Icon</option>
                        <option value="apple">Apple (Fruits)</option>
                        <option value="carrot">Carrot (Vegetables)</option>
                        <option value="bread">Bread (Grains)</option>
                        <option value="meat">Meat (Proteins)</option>
                        <option value="glass">Glass (Dairy)</option>
                        <option value="nut">Nut (Nuts & Seeds)</option>
                        <option value="cake">Cake (Desserts)</option>
                        <option value="cup">Cup (Beverages)</option>
                    </select>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('addCategoryModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitAddCategory()">Add Category</button>
        `;

        const modalHTML = createModal('addCategoryModal', 'Add New Category', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('addCategoryModal');
    }

    function showViewModal(name, row) {
        const email = row.querySelector('.user-email, p')?.textContent || 'N/A';
        const goal = row.cells ? row.cells[2]?.textContent || 'N/A' : 'N/A';
        const status = row.querySelector('.status-badge')?.textContent || 'N/A';
        
        const modalContent = `
            <div class="admin-user-info" style="margin-bottom: 1rem;">
                <div class="admin-user-avatar">${name.split(' ').map(n => n[0]).join('')}</div>
                <div class="admin-user-details">
                    <h4>${name}</h4>
                    <p>${email}</p>
                </div>
            </div>
            <div class="admin-grid admin-grid-2">
                <div>
                    <strong>Status:</strong> <span class="status-badge ${status.toLowerCase()}">${status}</span>
                </div>
                <div>
                    <strong>Goal:</strong> ${goal}
                </div>
            </div>
        `;

        const modalHTML = createModal('viewModal', `View ${name}`, modalContent);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('viewModal');
    }

    function showEditModal(element) {
        const name = element.querySelector('.user-name, h4, .card-title')?.textContent || '';
        const email = element.querySelector('.user-email, p')?.textContent || '';
        
        const modalContent = `
            <form id="editForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Name</label>
                    <input type="text" class="admin-form-input" name="name" value="${name}" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Email</label>
                    <input type="email" class="admin-form-input" name="email" value="${email}">
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitEdit()">Save Changes</button>
        `;

        const modalHTML = createModal('editModal', `Edit ${name}`, modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('editModal');
    }

    function showDeleteConfirmation(element) {
        const name = element.querySelector('.user-name, h4, .card-title')?.textContent || 'this item';
        
        const modalContent = `
            <p>Are you sure you want to delete <strong>${name}</strong>? This action cannot be undone.</p>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
            <button class="btn btn-danger" onclick="confirmDelete()">Delete</button>
        `;

        const modalHTML = createModal('deleteModal', 'Confirm Delete', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('deleteModal');
        
        // Store element reference for deletion
        window.elementToDelete = element;
    }

    function showAssignModal(row) {
        const userName = row.querySelector('.user-name')?.textContent || '';
        
        const modalContent = `
            <form id="assignForm" class="form">
                <p>Assign nutritionist to <strong>${userName}</strong></p>
                <div class="admin-form-group">
                    <label class="admin-form-label">Select Nutritionist</label>
                    <select class="admin-form-select" name="nutritionist" required>
                        <option value="">Select Nutritionist</option>
                        <option value="dr_smith">Dr. Sarah Smith - Weight Management</option>
                        <option value="dr_chen">Dr. Michael Chen - Sports Nutrition</option>
                        <option value="dr_wilson">Dr. Emily Wilson - Clinical Nutrition</option>
                        <option value="dr_martinez">Dr. James Martinez - Pediatric Nutrition</option>
                        <option value="dr_thompson">Dr. Lisa Thompson - Eating Disorders</option>
                    </select>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('assignModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitAssignment()">Assign</button>
        `;

        const modalHTML = createModal('assignModal', 'Assign Nutritionist', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('assignModal');
        
        // Store row reference for assignment
        window.rowToAssign = row;
    }

    // Form Submission Functions
    window.submitAddUser = function() {
        const form = document.getElementById('addUserForm');
        const formData = new FormData(form);
        formData.append('action', 'add_user');
        
        submitForm(formData, 'User added successfully!');
    };

    window.submitAddNutritionist = function() {
        const form = document.getElementById('addNutritionistForm');
        const formData = new FormData(form);
        formData.append('action', 'add_nutritionist');
        
        submitForm(formData, 'Nutritionist added successfully!');
    };

    window.submitAddFood = function() {
        const form = document.getElementById('addFoodForm');
        const formData = new FormData(form);
        formData.append('action', 'add_food');
        
        submitForm(formData, 'Food item added successfully!');
    };

    window.submitAddCategory = function() {
        const form = document.getElementById('addCategoryForm');
        const formData = new FormData(form);
        formData.append('action', 'add_category');
        
        submitForm(formData, 'Category added successfully!');
    };

    window.submitEdit = function() {
        const form = document.getElementById('editForm');
        const formData = new FormData(form);
        formData.append('action', 'edit_item');
        
        submitForm(formData, 'Changes saved successfully!');
    };

    // Generic form submission function
    function submitForm(formData, successMessage) {
        const submitBtn = document.querySelector('.admin-modal-footer .btn-primary');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || successMessage, 'success');
                closeAllModals();
                
                // Refresh page data if needed
                if (typeof refreshPageData === 'function') {
                    refreshPageData();
                }
            } else {
                showNotification(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error occurred', 'error');
        })
        .finally(() => {
            // Reset button state
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    }
    
    function closeAllModals() {
        const openModals = document.querySelectorAll('.admin-modal[style*="flex"]');
        openModals.forEach(modal => {
            closeModal(modal.id);
        });
    }

    window.confirmDelete = function() {
        if (window.elementToDelete) {
            window.elementToDelete.remove();
            showNotification('Item deleted successfully!', 'success');
            closeModal('deleteModal');
            window.elementToDelete = null;
        }
    };

    window.submitAssignment = function() {
        const form = document.getElementById('assignForm');
        const formData = new FormData(form);
        const nutritionist = formData.get('nutritionist');
        
        if (window.rowToAssign && nutritionist) {
            const nutritionistCell = window.rowToAssign.cells[3];
            const statusCell = window.rowToAssign.cells[1];
            
            // Update the nutritionist assignment
            nutritionistCell.textContent = nutritionist.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
            nutritionistCell.classList.remove('unassigned');
            
            // Update status to active
            const statusBadge = statusCell.querySelector('.status-badge');
            statusBadge.textContent = 'active';
            statusBadge.className = 'status-badge active';
            
            showNotification('Nutritionist assigned successfully!', 'success');
            closeModal('assignModal');
            window.rowToAssign = null;
        }
    };

    // Action Functions
    function approveUser(row) {
        const statusCell = row.cells[1];
        const statusBadge = statusCell.querySelector('.status-badge');
        
        // Send approval request to backend
        const formData = new FormData();
        formData.append('action', 'approve_user');
        formData.append('userId', row.dataset.userId || Math.floor(Math.random() * 1000));
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusBadge.textContent = 'active';
                statusBadge.className = 'status-badge active';
                
                // Update action buttons
                const actionCell = row.cells[5];
                actionCell.innerHTML = `
                    <div class="action-buttons">
                        <button class="btn btn-outline btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;color:#278b63;">
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg> View
                        </button>
                    </div>
                `;
                
                showNotification(data.message, 'success');
                initializeButtons(); // Re-initialize button events
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to approve user', 'error');
        });
    }

    function generateReport() {
        const btn = event.target;
        const originalText = btn.innerHTML;
        
        btn.classList.add('loading');
        btn.disabled = true;
        
        showNotification('Generating report...', 'info');
        
        const formData = new FormData();
        formData.append('action', 'generate_report');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                console.log('Report data:', data.data);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to generate report', 'error');
        })
        .finally(() => {
            btn.classList.remove('loading');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    function backupDatabase() {
        const btn = event.target;
        const originalText = btn.innerHTML;
        
        btn.classList.add('loading');
        btn.disabled = true;
        
        showNotification('Starting database backup...', 'info');
        
        const formData = new FormData();
        formData.append('action', 'backup_database');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                console.log('Backup info:', data.data);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to backup database', 'error');
        })
        .finally(() => {
            btn.classList.remove('loading');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    function clearCache() {
        const btn = event.target;
        const originalText = btn.innerHTML;
        
        btn.classList.add('loading');
        btn.disabled = true;
        
        showNotification('Clearing cache...', 'info');
        
        const formData = new FormData();
        formData.append('action', 'clear_cache');
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                console.log('Cache info:', data.data);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to clear cache', 'error');
        })
        .finally(() => {
            btn.classList.remove('loading');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    function toggleMaintenanceMode() {
        const btn = event.target;
        const isMaintenanceMode = btn.textContent.includes('Maintenance Mode');
        
        if (isMaintenanceMode) {
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;">
                    <path d="M9 12l2 2 4-4"/>
                    <path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"/>
                    <path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"/>
                </svg> Exit Maintenance
            `;
            btn.className = 'btn btn-primary';
            showNotification('Maintenance mode enabled', 'info');
        } else {
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px;">
                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                </svg> Maintenance Mode
            `;
            btn.className = 'btn btn-secondary';
            showNotification('Maintenance mode disabled', 'info');
        }
    }

    function updatePassword() {
        const currentPassword = document.querySelector('input[type="password"]').value;
        const newPassword = document.querySelectorAll('input[type="password"]')[1].value;
        const confirmPassword = document.querySelectorAll('input[type="password"]')[2].value;
        
        if (!currentPassword || !newPassword || !confirmPassword) {
            showNotification('Please fill in all password fields', 'error');
            return;
        }
        
        if (newPassword !== confirmPassword) {
            showNotification('New passwords do not match', 'error');
            return;
        }
        
        if (newPassword.length < 8) {
            showNotification('Password must be at least 8 characters long', 'error');
            return;
        }
        
        const btn = event.target;
        const originalText = btn.innerHTML;
        
        btn.classList.add('loading');
        btn.disabled = true;
        
        const formData = new FormData();
        formData.append('action', 'update_password');
        formData.append('currentPassword', currentPassword);
        formData.append('newPassword', newPassword);
        formData.append('confirmPassword', confirmPassword);
        
        fetch('admin_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                
                // Clear password fields
                document.querySelectorAll('input[type="password"]').forEach(input => {
                    input.value = '';
                });
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update password', 'error');
        })
        .finally(() => {
            btn.classList.remove('loading');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    // Search and Filter Functions
    function initializeSearch() {
        const searchInputs = document.querySelectorAll('.search-input, input[placeholder*="Search"]');
        
        searchInputs.forEach(input => {
            input.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const table = this.closest('.card').querySelector('table');
                
                if (table) {
                    const rows = table.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                }
            });
        });
    }

    function initializeFilters() {
        const filterSelects = document.querySelectorAll('.filter-select, select');
        
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                const filterValue = this.value.toLowerCase();
                const table = this.closest('.card').querySelector('table');
                
                if (table && filterValue !== 'all' && filterValue !== '') {
                    const rows = table.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const statusBadge = row.querySelector('.status-badge');
                        if (statusBadge) {
                            const status = statusBadge.textContent.toLowerCase();
                            row.style.display = status.includes(filterValue) ? '' : 'none';
                        }
                    });
                } else if (table) {
                    // Show all rows
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        row.style.display = '';
                    });
                }
            });
        });
    }

    // Toggle Functions
    function initializeToggles() {
        const toggles = document.querySelectorAll('.admin-toggle, .toggle-switch');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                this.classList.toggle('active');
                
                const settingName = this.closest('.settings-section, .admin-settings-item')
                                      ?.querySelector('h4')?.textContent || 'Setting';
                
                const isActive = this.classList.contains('active');
                showNotification(`${settingName} ${isActive ? 'enabled' : 'disabled'}`, 'info');
            });
        });
    }

    // Form Functions
    function initializeForms() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Basic form validation
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.style.borderColor = '#dc2626';
                        isValid = false;
                    } else {
                        field.style.borderColor = '#d1d5db';
                    }
                });
                
                if (!isValid) {
                    showNotification('Please fill in all required fields', 'error');
                    return;
                }
                
                showNotification('Form submitted successfully!', 'success');
            });
        });
    }

    // Notification System
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease-out;
        `;
        
        // Set background color based on type
        const colors = {
            success: '#278b63',
            error: '#dc2626',
            info: '#3b82f6',
            warning: '#f59e0b'
        };
        
        notification.style.backgroundColor = colors[type] || colors.info;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .admin-modal {
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .notification {
            transition: all 0.3s ease;
        }
        
        .admin-modal-content {
            animation: slideUp 0.3s ease-out;
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    `;
    
    document.head.appendChild(style);

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('admin-modal')) {
            const modalId = e.target.id;
            closeModal(modalId);
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.admin-modal[style*="flex"]');
            if (openModal) {
                closeModal(openModal.id);
            }
            // Also close profile popup
            const profilePopup = document.getElementById('profilePopup');
            if (profilePopup && profilePopup.style.display === 'flex') {
                closeProfilePopup();
            }
        }
    });

    // Close profile popup when clicking outside
    document.addEventListener('click', function(e) {
        const profilePopup = document.getElementById('profilePopup');
        if (e.target === profilePopup) {
            closeProfilePopup();
        }
    });

    console.log('Admin panel functionality initialized successfully!');
});