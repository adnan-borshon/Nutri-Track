// Nutritionist Panel JavaScript Functionality
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all functionality
    initializeModals();
    initializeButtons();
    initializeSearch();
    initializeChat();
    initializeToggles();
    initializeForms();

    // Modal Functions
    function initializeModals() {
        if (!document.getElementById('modal-container')) {
            const modalContainer = document.createElement('div');
            modalContainer.id = 'modal-container';
            document.body.appendChild(modalContainer);
        }
    }

    // Button Event Handlers
    function initializeButtons() {
        // Create New Plan button - Skip if on diet-plans page
        const createPlanBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Create New Plan'));
        if (createPlanBtn && !window.location.pathname.includes('diet-plans.php')) {
            createPlanBtn.addEventListener('click', showCreatePlanModal);
        }

        // Add Suggestion button - Skip if on suggestions page
        const addSuggestionBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Add Suggestion'));
        if (addSuggestionBtn && !window.location.pathname.includes('suggestions.php')) {
            addSuggestionBtn.addEventListener('click', showAddSuggestionModal);
        }

        // Edit buttons - Skip if on diet-plans page
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.includes('Edit') && !window.location.pathname.includes('diet-plans.php')) {
                btn.addEventListener('click', function() {
                    const card = this.closest('.diet-plan-card');
                    if (card) {
                        showEditPlanModal(card);
                    }
                });
            }
        });

        // View buttons - Skip if on diet-plans page
        document.querySelectorAll('button, a').forEach(btn => {
            if ((btn.textContent.includes('View Details') || btn.textContent.includes('View')) && !window.location.pathname.includes('diet-plans.php')) {
                btn.addEventListener('click', function(e) {
                    if (this.href && this.href.includes('user-detail.php')) {
                        e.preventDefault();
                        const userId = new URL(this.href).searchParams.get('id');
                        showUserDetailModal(userId);
                    } else if (this.textContent.includes('View') && this.closest('.diet-plan-card')) {
                        const card = this.closest('.diet-plan-card');
                        showViewPlanModal(card);
                    }
                });
            }
        });

        // Chat buttons - only intercept if not from users page
        document.querySelectorAll('a').forEach(link => {
            if (link.href && link.href.includes('chat.php') && !window.location.pathname.includes('users.php')) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = new URL(this.href).searchParams.get('user');
                    if (userId) {
                        showChatModal(userId);
                    } else {
                        window.location.href = this.href;
                    }
                });
            }
        });

        // Update Profile button
        const updateProfileBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Update Profile'));
        if (updateProfileBtn) {
            updateProfileBtn.addEventListener('click', updateProfile);
        }

        // Update Password button
        const updatePasswordBtn = Array.from(document.querySelectorAll('button')).find(btn => btn.textContent.includes('Update Password'));
        if (updatePasswordBtn) {
            updatePasswordBtn.addEventListener('click', updatePassword);
        }

        // Notification button
        const notificationBtn = document.querySelector('.header-actions button');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', showNotifications);
        }
    }

    // Modal Content Functions
    function showAddSuggestionModal() {
        const modalContent = `
            <form id="addSuggestionForm" class="form">
                <div class="admin-form-group">
                    <label class="admin-form-label">Meal Name</label>
                    <input type="text" class="admin-form-input" name="mealName" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Category</label>
                    <select class="admin-form-select" name="category" required>
                        <option value="">Select Category</option>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>
                <div class="admin-grid admin-grid-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Prep Time (minutes)</label>
                        <input type="number" class="admin-form-input" name="prepTime" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Calories</label>
                        <input type="number" class="admin-form-input" name="calories" required>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Description</label>
                    <textarea class="admin-form-textarea" name="description" rows="3" required></textarea>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Tags (comma separated)</label>
                    <input type="text" class="admin-form-input" name="tags" placeholder="e.g., High Protein, Quick, Low Carb">
                </div>
            </form>
        `;
        
        const actions = `
            <button class="btn btn-secondary" onclick="closeModal('addSuggestionModal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitAddSuggestion()">Add Suggestion</button>
        `;

        const modalHTML = createModal('addSuggestionModal', 'Add Meal Suggestion', modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('addSuggestionModal');
    }

    function showUserDetailModal(userId) {
        const users = {
            '1': { name: 'John Doe', goal: 'Weight Loss', progress: '75%', email: 'john@example.com', phone: '+1 (555) 123-4567', age: 32, height: '5\'10"', weight: '180 lbs' },
            '2': { name: 'Jane Smith', goal: 'Build Muscle', progress: '45%', email: 'jane@example.com', phone: '+1 (555) 234-5678', age: 28, height: '5\'6"', weight: '140 lbs' },
            '3': { name: 'Mike Johnson', goal: 'Maintain', progress: '90%', email: 'mike@example.com', phone: '+1 (555) 345-6789', age: 35, height: '6\'0"', weight: '175 lbs' },
            '4': { name: 'Emily Davis', goal: 'Weight Loss', progress: '60%', email: 'emily@example.com', phone: '+1 (555) 456-7890', age: 29, height: '5\'4"', weight: '155 lbs' }
        };

        const user = users[userId] || users['1'];
        
        const modalContent = `
            <div class="admin-user-info" style="margin-bottom: 1.5rem;">
                <div class="admin-user-avatar">${user.name.split(' ').map(n => n[0]).join('')}</div>
                <div class="admin-user-details">
                    <h4>${user.name}</h4>
                    <p>${user.email}</p>
                </div>
            </div>
            <div class="admin-grid admin-grid-2">
                <div><strong>Goal:</strong> ${user.goal}</div>
                <div><strong>Progress:</strong> ${user.progress}</div>
                <div><strong>Phone:</strong> ${user.phone}</div>
                <div><strong>Age:</strong> ${user.age}</div>
                <div><strong>Height:</strong> ${user.height}</div>
                <div><strong>Weight:</strong> ${user.weight}</div>
            </div>
            <div style="margin-top: 1.5rem;">
                <h4>Recent Activity</h4>
                <div class="admin-activity-list">
                    <div class="admin-activity-item">
                        <div class="admin-activity-info">
                            <div class="admin-activity-dot"></div>
                            <div>
                                <p class="admin-activity-title">Logged breakfast</p>
                                <p class="admin-activity-subtitle">Greek yogurt with berries</p>
                            </div>
                        </div>
                        <span class="admin-activity-time">2 hours ago</span>
                    </div>
                    <div class="admin-activity-item">
                        <div class="admin-activity-info">
                            <div class="admin-activity-dot"></div>
                            <div>
                                <p class="admin-activity-title">Completed workout</p>
                                <p class="admin-activity-subtitle">30 min cardio session</p>
                            </div>
                        </div>
                        <span class="admin-activity-time">1 day ago</span>
                    </div>
                </div>
            </div>
        `;

        const actions = `
            <button class="btn btn-outline" onclick="closeModal('userDetailModal')">Close</button>
            <button class="btn btn-primary" onclick="startChat('${userId}')">Start Chat</button>
        `;

        const modalHTML = createModal('userDetailModal', `${user.name} - Details`, modalContent, actions);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('userDetailModal');
    }

    function showChatModal(userId) {
        const users = {
            '1': 'John Doe',
            '2': 'Jane Smith', 
            '3': 'Mike Johnson',
            '4': 'Emily Davis',
            '5': 'Sarah Wilson',
            '6': 'Chris Brown'
        };

        const userName = users[userId] || 'User';
        
        const modalContent = `
            <div class="chat-container">
                <div class="chat-messages" id="chatMessages">
                    <div class="message nutritionist">
                        <div class="message-bubble">
                            Hi ${userName}! How can I help you today?
                        </div>
                        <div class="message-time">Just now</div>
                    </div>
                </div>
                
                <div class="chat-input-container">
                    <div class="chat-input-wrapper">
                        <input type="text" class="chat-input" id="messageInput" placeholder="Type your message...">
                        <button class="btn btn-primary btn-sm" onclick="sendMessage()">Send</button>
                    </div>
                </div>
            </div>
        `;

        const modalHTML = createModal('chatModal', `Chat with ${userName}`, modalContent);
        document.getElementById('modal-container').innerHTML = modalHTML;
        showModal('chatModal');

        // Focus on input
        setTimeout(() => {
            document.getElementById('messageInput').focus();
        }, 100);
    }

    function showNotifications() {
        // Empty function - notifications are handled by the header dropdown
    }

    // Generic form submission function
    function submitForm(formData, successMessage) {
        const submitBtn = document.querySelector('.admin-modal-footer .btn-primary');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        
        fetch('nutritionist_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || successMessage, 'success');
                closeAllModals();
            } else {
                showNotification(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error occurred', 'error');
        })
        .finally(() => {
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

    window.startChat = function(userId) {
        closeModal('userDetailModal');
        showChatModal(userId);
    };

    window.sendMessage = function() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        
        if (message) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message nutritionist';
            messageDiv.innerHTML = `
                <div class="message-bubble">${message}</div>
                <div class="message-time">Just now</div>
            `;
            messagesContainer.appendChild(messageDiv);
            
            input.value = '';
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            showNotification('Message sent!', 'success');
        }
    };

    // Action Functions
    function updateProfile() {
        const form = this.closest('.card').querySelector('form') || this.closest('.card');
        const inputs = form.querySelectorAll('input, select, textarea');
        
        let isValid = true;
        const formData = new FormData();
        formData.append('action', 'update_profile');
        
        inputs.forEach(input => {
            if (input.hasAttribute('required') && !input.value.trim()) {
                input.style.borderColor = '#dc2626';
                isValid = false;
            } else {
                input.style.borderColor = '#d1d5db';
                if (input.name) {
                    formData.append(input.name, input.value);
                }
            }
        });
        
        if (!isValid) {
            showNotification('Please fill in all required fields', 'error');
            return;
        }
        
        const btn = this;
        const originalText = btn.innerHTML;
        
        btn.classList.add('loading');
        btn.disabled = true;
        
        fetch('nutritionist_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update profile', 'error');
        })
        .finally(() => {
            btn.classList.remove('loading');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    function updatePassword() {
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        const currentPassword = passwordInputs[0].value;
        const newPassword = passwordInputs[1].value;
        const confirmPassword = passwordInputs[2].value;
        
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
        
        fetch('nutritionist_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                passwordInputs.forEach(input => {
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
                const cards = document.querySelectorAll('.user-card, .recipe-card, .diet-plan-card');
                
                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    }

    // Chat Functions
    function initializeChat() {
        // Conversation selection
        document.querySelectorAll('.conversation-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.conversation-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                const userName = this.querySelector('.conversation-name').textContent;
                showNotification(`Switched to chat with ${userName}`, 'info');
            });
        });

        // Send button in chat page
        const sendBtn = document.querySelector('.chat-input-wrapper .btn');
        if (sendBtn) {
            sendBtn.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const message = input.value.trim();
                
                if (message) {
                    const messagesContainer = document.querySelector('.chat-messages');
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message nutritionist';
                    messageDiv.innerHTML = `
                        <div class="message-bubble">${message}</div>
                        <div class="message-time">Just now</div>
                    `;
                    messagesContainer.appendChild(messageDiv);
                    
                    input.value = '';
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    
                    showNotification('Message sent!', 'success');
                }
            });
        }

        // Enter key to send message
        const chatInputs = document.querySelectorAll('.chat-input');
        chatInputs.forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const sendBtn = this.nextElementSibling;
                    if (sendBtn) {
                        sendBtn.click();
                    }
                }
            });
        });
    }

    // Toggle Functions
    function initializeToggles() {
        const toggles = document.querySelectorAll('.toggle-switch');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                this.classList.toggle('active');
                
                const settingName = this.closest('.settings-item')?.querySelector('h4')?.textContent || 'Setting';
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

    console.log('Nutritionist panel functionality initialized successfully!');
});