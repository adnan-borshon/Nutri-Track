// User Panel JavaScript Functionality
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all functionality
    initializeModals();
    initializeButtons();
    initializeChat();
    initializeForms();
    initializeWaterTracking();
    initializeMealLogging();

    // Modal Functions
    function initializeModals() {
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

    window.closeModal = closeModal;

    // Button Event Handlers
    function initializeButtons() {
        // Add Water buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Add Water') || btn.textContent.includes('Add Glass')) {
                btn.addEventListener('click', addWater);
            }
        });

        // Quick add water buttons (+1, +2, etc.)
        document.querySelectorAll('button').forEach(btn => {
            const text = btn.textContent.trim();
            if (text.match(/^\+\d+$/)) {
                btn.addEventListener('click', function() {
                    const amount = parseInt(text.substring(1));
                    addWater(amount);
                });
            }
        });

        // Remove water button
        document.querySelectorAll('button').forEach(btn => {
            if (btn.innerHTML.includes('M5 12h14')) {
                btn.addEventListener('click', removeWater);
            }
        });

        // Log Sleep button
        document.querySelectorAll('a, button').forEach(btn => {
            if (btn.textContent.includes('Log Sleep')) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    showSleepModal();
                });
            }
        });

        // Log a Meal button - Skip if on dashboard.php (let it redirect normally)
        if (!window.location.pathname.includes('dashboard.php')) {
            document.querySelectorAll('a, button').forEach(btn => {
                if (btn.textContent.includes('Log a Meal')) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        showMealModal();
                    });
                }
            });
        }

        // Add meal buttons (+ icons in meal cards) - Skip if on meals.php
        if (!window.location.pathname.includes('meals.php')) {
            document.querySelectorAll('.btn-add-meal').forEach(btn => {
                btn.addEventListener('click', function() {
                    const mealType = this.closest('.card').querySelector('.meal-type').textContent.toLowerCase();
                    showAddFoodModal(mealType);
                });
            });
        }

        // Remove meal buttons
        document.querySelectorAll('.btn-remove-meal').forEach(btn => {
            btn.addEventListener('click', function() {
                const mealItem = this.closest('.logged-meal-item');
                removeMealItem(mealItem);
            });
        });

        // Food item buttons
        document.querySelectorAll('.food-item-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const foodName = this.querySelector('.food-name').textContent;
                const calories = parseInt(this.querySelector('.food-calories').textContent);
                showAddToMealModal(foodName, calories);
            });
        });

        // Book Appointment button - Skip if on appointments.php
        if (!window.location.pathname.includes('appointments.php')) {
            document.querySelectorAll('button').forEach(btn => {
                if (btn.textContent.includes('Book Appointment')) {
                    btn.addEventListener('click', showBookAppointmentModal);
                }
            });
        }

        // Join appointment buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Join')) {
                btn.addEventListener('click', joinAppointment);
            }
        });

        // Update Profile button
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Update Profile')) {
                btn.addEventListener('click', updateProfile);
            }
        });

        // Save Goals button
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Save Goals')) {
                btn.addEventListener('click', saveGoals);
            }
        });

        // Account action buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Change Password')) {
                btn.addEventListener('click', showChangePasswordModal);
            } else if (btn.textContent.includes('Export Data')) {
                btn.addEventListener('click', exportData);
            } else if (btn.textContent.includes('Delete Account')) {
                btn.addEventListener('click', showDeleteAccountModal);
            }
        });

        // Notification button
        const notificationBtn = document.querySelector('.header-actions button');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', showNotifications);
        }
    }

    // Water Tracking Functions
    function initializeWaterTracking() {
        let currentGlasses = 5; // Default value
        
        window.addWater = function(amount = 1) {
            currentGlasses += amount;
            updateWaterDisplay(currentGlasses);
            showNotification(`Added ${amount} glass${amount > 1 ? 'es' : ''} of water!`, 'success');
        };

        window.removeWater = function() {
            if (currentGlasses > 0) {
                currentGlasses--;
                updateWaterDisplay(currentGlasses);
                showNotification('Removed 1 glass of water', 'info');
            }
        };

        function updateWaterDisplay(glasses) {
            const target = 8;
            const percentage = (glasses / target) * 100;
            
            // Update progress ring
            const progressCircle = document.querySelector('circle[stroke="#06b6d4"]');
            if (progressCircle) {
                const circumference = 2 * Math.PI * 40;
                progressCircle.style.strokeDashoffset = circumference * (1 - glasses / target);
            }
            
            // Update text displays
            document.querySelectorAll('.progress-ring-value').forEach(el => {
                el.textContent = glasses;
            });
            
            // Update stats
            const statsElements = document.querySelectorAll('.stat-value');
            if (statsElements.length >= 3) {
                statsElements[0].textContent = glasses;
                statsElements[1].textContent = glasses * 250;
                statsElements[2].textContent = Math.round(percentage) + '%';
            }
        }
    }

    // Meal Logging Functions
    function initializeMealLogging() {
        window.removeMealItem = function(mealItem) {
            const mealName = mealItem.querySelector('.logged-meal-name').textContent;
            mealItem.remove();
            showNotification(`Removed ${mealName} from meal log`, 'info');
            updateCaloriesSummary();
        };

        function updateCaloriesSummary() {
            let totalCalories = 0;
            document.querySelectorAll('.logged-meal-item').forEach(item => {
                const calorieText = item.querySelector('.logged-meal-info').textContent;
                const calories = parseInt(calorieText.match(/(\d+) cal/)?.[1] || 0);
                totalCalories += calories;
            });
            
            const summaryValue = document.querySelector('.summary-value');
            if (summaryValue) {
                summaryValue.textContent = totalCalories;
            }
        }
    }

    // Modal Content Functions
    function showSleepModal() {
        const modalContent = `
            <form id="sleepForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Bedtime</label>
                    <input type="time" class="admin-form-input" name="bedtime" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Wake Time</label>
                    <input type="time" class="admin-form-input" name="wakeTime" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Sleep Quality</label>
                    <select class="admin-form-select" name="quality" required>
                        <option value="">Select Quality</option>
                        <option value="poor">Poor</option>
                        <option value="fair">Fair</option>
                        <option value="good">Good</option>
                        <option value="excellent">Excellent</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Notes (optional)</label>
                    <textarea class="admin-form-textarea" name="notes" rows="3"></textarea>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('sleepModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitSleep()">Log Sleep</button>
        `;

        const modalHTML = createModal('sleepModal', 'Log Sleep', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('sleepModal');
    }

    function showMealModal() {
        const modalContent = `
            <div class="admin-grid admin-grid-2">
                <button class="btn btn-outline" onclick="showAddFoodModal('breakfast')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z"/>
                    </svg>
                    Add to Breakfast
                </button>
                <button class="btn btn-outline" onclick="showAddFoodModal('lunch')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z"/>
                    </svg>
                    Add to Lunch
                </button>
                <button class="btn btn-outline" onclick="showAddFoodModal('dinner')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z"/>
                    </svg>
                    Add to Dinner
                </button>
                <button class="btn btn-outline" onclick="showAddFoodModal('snack')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;">
                        <path d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z"/>
                    </svg>
                    Add to Snack
                </button>
            </div>
        `;

        const modalHTML = createModal('mealModal', 'Log a Meal', modalContent);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('mealModal');
    }

    function showAddFoodModal(mealType) {
        const foods = [
            {name: 'Chicken Breast', calories: 165, protein: 31, carbs: 0, fat: 3.6},
            {name: 'Brown Rice', calories: 216, protein: 5, carbs: 45, fat: 1.8},
            {name: 'Broccoli', calories: 55, protein: 3.7, carbs: 11, fat: 0.6},
            {name: 'Greek Yogurt', calories: 100, protein: 17, carbs: 6, fat: 0.7},
            {name: 'Salmon', calories: 208, protein: 20, carbs: 0, fat: 13},
            {name: 'Oatmeal', calories: 150, protein: 5, carbs: 27, fat: 2.5}
        ];

        const modalContent = `
            <div class="admin-form-group">
                <label class="admin-form-label">Adding to: ${mealType.charAt(0).toUpperCase() + mealType.slice(1)}</label>
            </div>
            <div class="admin-grid admin-grid-2">
                ${foods.map(food => `
                    <button class="food-item-btn" onclick="addFoodToMeal('${food.name}', ${food.calories}, '${mealType}')">
                        <div class="food-item-header">
                            <span class="food-name">${food.name}</span>
                            <span class="food-calories">${food.calories} cal</span>
                        </div>
                        <p class="food-macros">P: ${food.protein}g • C: ${food.carbs}g • F: ${food.fat}g</p>
                    </button>
                `).join('')}
            </div>
        `;

        const modalHTML = createModal('addFoodModal', 'Add Food', modalContent);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('addFoodModal');
    }

    function showAddToMealModal(foodName, calories) {
        const modalContent = `
            <form id="addToMealForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Food: ${foodName}</label>
                    <p class="admin-form-label" style="color: #6b7280;">${calories} calories per serving</p>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Meal Type</label>
                    <select class="admin-form-select" name="mealType" required>
                        <option value="">Select Meal</option>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Servings</label>
                    <input type="number" class="admin-form-input" name="servings" value="1" min="0.5" step="0.5" required>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('addToMealModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitAddToMeal('${foodName}', ${calories})">Add to Meal</button>
        `;

        const modalHTML = createModal('addToMealModal', 'Add to Meal Log', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('addToMealModal');
    }



    function showChangePasswordModal() {
        const modalContent = `
            <form id="changePasswordForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Current Password</label>
                    <input type="password" class="admin-form-input" name="currentPassword" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">New Password</label>
                    <input type="password" class="admin-form-input" name="newPassword" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Confirm New Password</label>
                    <input type="password" class="admin-form-input" name="confirmPassword" required>
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('changePasswordModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitChangePassword()">Change Password</button>
        `;

        const modalHTML = createModal('changePasswordModal', 'Change Password', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('changePasswordModal');
    }

    function showDeleteAccountModal() {
        const modalContent = `
            <div class="admin-form-group">
                <p style="color: #dc2626; margin-bottom: 1rem;">⚠️ This action cannot be undone!</p>
                <p>Are you sure you want to delete your account? All your data will be permanently removed.</p>
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Type "DELETE" to confirm</label>
                <input type="text" class="admin-form-input" id="deleteConfirmation" required>
            </div>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('deleteAccountModal')">Cancel</button>
            <button class="btn btn-danger" onclick="confirmDeleteAccount()">Delete Account</button>
        `;

        const modalHTML = createModal('deleteAccountModal', 'Delete Account', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('deleteAccountModal');
    }

    function showNotifications() {
        // This function is no longer needed - notifications are handled by the header dropdown
        console.log('Notifications are handled by the header dropdown');
    }

    // Form Submission Functions
    window.submitSleep = function() {
        const form = document.getElementById('sleepForm');
        const formData = new FormData(form);
        
        showNotification('Sleep logged successfully!', 'success');
        closeModal('sleepModal');
        
        console.log('Sleep data:', Object.fromEntries(formData));
    };

    window.addFoodToMeal = function(foodName, calories, mealType) {
        showNotification(`Added ${foodName} to ${mealType}!`, 'success');
        closeModal('addFoodModal');
        closeModal('mealModal');
    };

    window.submitAddToMeal = function(foodName, calories) {
        const form = document.getElementById('addToMealForm');
        const formData = new FormData(form);
        const mealType = formData.get('mealType');
        const servings = formData.get('servings');
        
        if (!mealType) {
            showNotification('Please select a meal type', 'error');
            return;
        }
        
        showNotification(`Added ${servings} serving(s) of ${foodName} to ${mealType}!`, 'success');
        closeModal('addToMealModal');
    };



    window.submitChangePassword = function() {
        const form = document.getElementById('changePasswordForm');
        const formData = new FormData(form);
        const newPassword = formData.get('newPassword');
        const confirmPassword = formData.get('confirmPassword');
        
        if (newPassword !== confirmPassword) {
            showNotification('Passwords do not match', 'error');
            return;
        }
        
        if (newPassword.length < 8) {
            showNotification('Password must be at least 8 characters long', 'error');
            return;
        }
        
        showNotification('Password changed successfully!', 'success');
        closeModal('changePasswordModal');
    };

    window.confirmDeleteAccount = function() {
        const confirmation = document.getElementById('deleteConfirmation').value;
        
        if (confirmation !== 'DELETE') {
            showNotification('Please type "DELETE" to confirm', 'error');
            return;
        }
        
        showNotification('Account deletion initiated. You will be logged out shortly.', 'warning');
        closeModal('deleteAccountModal');
    };

    // Action Functions
    function joinAppointment() {
        showNotification('Joining appointment...', 'info');
        setTimeout(() => {
            showNotification('Connected to video call!', 'success');
        }, 2000);
    }

    function updateProfile() {
        const form = this.closest('.card');
        const inputs = form.querySelectorAll('input');
        
        let isValid = true;
        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value.trim()) {
                input.style.borderColor = '#dc2626';
                isValid = false;
            } else {
                input.style.borderColor = '#d1d5db';
            }
        });
        
        if (!isValid) {
            showNotification('Please fill in all required fields', 'error');
            return;
        }
        
        showNotification('Profile updated successfully!', 'success');
    }

    function saveGoals() {
        const form = this.closest('.card');
        const inputs = form.querySelectorAll('input');
        
        let isValid = true;
        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value.trim()) {
                input.style.borderColor = '#dc2626';
                isValid = false;
            } else {
                input.style.borderColor = '#d1d5db';
            }
        });
        
        if (!isValid) {
            showNotification('Please fill in all required fields', 'error');
            return;
        }
        
        showNotification('Goals saved successfully!', 'success');
    }

    function exportData() {
        showNotification('Preparing data export...', 'info');
        setTimeout(() => {
            showNotification('Data export ready for download!', 'success');
        }, 3000);
    }

    // Chat Functions
    function initializeChat() {
        const sendBtn = document.querySelector('button[type="submit"], button:has(svg[d*="M6 12"])');
        if (sendBtn && sendBtn.textContent.includes('Send')) {
            sendBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const input = this.previousElementSibling || document.querySelector('input[placeholder*="message"]');
                if (input && input.value.trim()) {
                    sendMessage(input.value.trim());
                    input.value = '';
                }
            });
        }

        // Enter key to send message
        const chatInput = document.querySelector('input[placeholder*="message"]');
        if (chatInput) {
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const sendBtn = this.nextElementSibling;
                    if (sendBtn) {
                        sendBtn.click();
                    }
                }
            });
        }
    }

    function sendMessage(message) {
        const messagesContainer = document.querySelector('[style*="flex-direction: column; gap: 1rem"]');
        if (messagesContainer) {
            const messageDiv = document.createElement('div');
            messageDiv.style.cssText = 'display: flex; justify-content: flex-end;';
            messageDiv.innerHTML = `
                <div style="max-width: 70%; display: flex; flex-direction: column; gap: 0.25rem;">
                    <div style="background: #16a34a; color: white; padding: 0.75rem 1rem; border-radius: 1rem; border-bottom-right-radius: 0.25rem;">
                        ${message}
                    </div>
                    <p class="stat-label" style="text-align: right;">Just now</p>
                </div>
            `;
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        showNotification('Message sent!', 'success');
    }

    // Form Functions
    function initializeForms() {
        // Notification checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const settingName = this.closest('div').querySelector('.card-title').textContent;
                const isEnabled = this.checked;
                showNotification(`${settingName} ${isEnabled ? 'enabled' : 'disabled'}`, 'info');
            });
        });

        // Form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
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
        
        const colors = {
            success: '#278b63',
            error: '#dc2626',
            info: '#3b82f6',
            warning: '#f59e0b'
        };
        
        notification.style.backgroundColor = colors[type] || colors.info;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

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
        }
    });

    console.log('User panel functionality initialized successfully!');
});