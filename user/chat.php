<?php
$page_title = "Chat";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
include 'header.php';
?>

<div style="height: calc(100vh - 140px); overflow: hidden; padding: 1rem;">
    <div class="grid lg:grid-cols-3 gap-4" style="height: 100%;">
        <div class="card" style="display: flex; flex-direction: column; height: 100%;">
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0;">Nutritionist History</h3>
            </div>
            <div style="flex: 1; overflow-y: auto; padding: 0.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div class="conversation-item active" data-user-id="1" data-user-name="Dr. Sarah Smith" data-is-current="true" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">SS</div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Dr. Sarah Smith <span style="background: #dcfce7; color: #278b63; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.625rem; font-weight: 500;">Current</span></p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Great progress on your weight loss!</p>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;">2 min ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="conversation-item" data-user-id="2" data-user-name="Dr. Mike Johnson" data-is-current="false" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer; opacity: 0.7;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #6b7280; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">MJ</div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Dr. Mike Johnson <span style="background: #f3f4f6; color: #6b7280; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.625rem; font-weight: 500;">Previous</span></p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Remember to drink more water daily.</p>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;">2 days ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="conversation-item" data-user-id="3" data-user-name="Dr. Lisa Chen" data-is-current="false" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer; opacity: 0.7;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #6b7280; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">LC</div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Dr. Lisa Chen <span style="background: #f3f4f6; color: #6b7280; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.625rem; font-weight: 500;">Previous</span></p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Your meal plan looks great!</p>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;">1 week ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card lg:col-span-2" style="display: flex; flex-direction: column; height: 100%; position: relative;">
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0; position: relative; z-index: 2; background: white;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div id="currentChatAvatar" style="width: 2.5rem; height: 2.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: bold;">SS</div>
                    <div>
                        <h3 id="currentChatName" style="font-size: 1rem; font-weight: 600; margin: 0 0 0.25rem 0;">Dr. Sarah Smith</h3>
                        <span id="currentChatStatus" style="background: #dcfce7; color: #278b63; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Current Nutritionist</span>
                    </div>
                </div>
            </div>
            <div style="flex: 1; position: relative; overflow: hidden;">
                <div id="chatMessages" style="position: absolute; top: 0; left: 0; right: 0; bottom: 100px; overflow-y: auto; padding: 0.75rem; background: #f9fafb; margin: 0.5rem 0.5rem 0 0.5rem; border-radius: 0.375rem;">
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;">
                        <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;">Hello! How are you feeling today?</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">10:30 AM</div>
                    </div>
                
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;">
                        <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;">Hi Dr. Smith! I'm doing well, thanks for asking.</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">10:32 AM</div>
                    </div>
                
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;">
                        <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;">Great to hear! I noticed you've been consistent with your meal logging. Keep up the good work!</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">10:35 AM</div>
                    </div>
                
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;">
                        <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;">Thank you! I have a question about portion sizes for dinner.</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">10:37 AM</div>
                    </div>
                
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;">
                        <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;">Great progress on your weight loss!</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">10:40 AM</div>
                    </div>
                </div>
                
                <div id="chatInputContainer" style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; padding: 0.75rem; background: white; border-top: 1px solid #e5e7eb; z-index: 2;">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; height: 100%;">
                        <textarea class="chat-input" placeholder="Type your message..." style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; outline: none; resize: none; height: 2.5rem; font-family: inherit;"></textarea>
                        <button onclick="sendChatMessage()" style="align-self: flex-end; padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chat data for different nutritionists
const chatData = {
    '1': {
        name: 'Dr. Sarah Smith',
        avatar: 'SS',
        isCurrent: true,
        messages: [
            { type: 'nutritionist', text: 'Hello! How are you feeling today?', time: '10:30 AM' },
            { type: 'user', text: 'Hi Dr. Smith! I\'m doing well, thanks for asking.', time: '10:32 AM' },
            { type: 'nutritionist', text: 'Great to hear! I noticed you\'ve been consistent with your meal logging. Keep up the good work!', time: '10:35 AM' },
            { type: 'user', text: 'Thank you! I have a question about portion sizes for dinner.', time: '10:37 AM' },
            { type: 'nutritionist', text: 'Great progress on your weight loss!', time: '10:40 AM' }
        ]
    },
    '2': {
        name: 'Dr. Mike Johnson',
        avatar: 'MJ',
        isCurrent: false,
        messages: [
            { type: 'nutritionist', text: 'Hi! I\'m your new nutritionist. How can I help you today?', time: 'Mon 2:00 PM' },
            { type: 'user', text: 'Hello Dr. Johnson! Nice to meet you.', time: 'Mon 2:05 PM' },
            { type: 'nutritionist', text: 'Let\'s start with your current eating habits. Can you tell me about your typical day?', time: 'Mon 2:10 PM' },
            { type: 'user', text: 'I usually skip breakfast and have a heavy lunch.', time: 'Mon 2:15 PM' },
            { type: 'nutritionist', text: 'Remember to drink more water daily.', time: 'Mon 2:20 PM' }
        ]
    },
    '3': {
        name: 'Dr. Lisa Chen',
        avatar: 'LC',
        isCurrent: false,
        messages: [
            { type: 'nutritionist', text: 'Welcome! I\'m excited to work with you on your health journey.', time: 'Last week' },
            { type: 'user', text: 'Thank you Dr. Chen! I\'m looking forward to it.', time: 'Last week' },
            { type: 'nutritionist', text: 'Your meal plan looks great!', time: 'Last week' },
            { type: 'user', text: 'I appreciate all your help!', time: 'Last week' }
        ]
    }
};

// Initialize chat functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers to conversation items
    document.querySelectorAll('.conversation-item').forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            document.querySelectorAll('.conversation-item').forEach(i => i.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get user data
            const userId = this.getAttribute('data-user-id');
            const isCurrent = this.getAttribute('data-is-current') === 'true';
            const userData = chatData[userId];
            
            if (userData) {
                // Update chat header
                document.getElementById('currentChatAvatar').textContent = userData.avatar;
                document.getElementById('currentChatName').textContent = userData.name;
                
                // Update status badge
                const statusElement = document.getElementById('currentChatStatus');
                if (userData.isCurrent) {
                    statusElement.textContent = 'Current Nutritionist';
                    statusElement.style.background = '#dcfce7';
                    statusElement.style.color = '#278b63';
                } else {
                    statusElement.textContent = 'Previous Nutritionist';
                    statusElement.style.background = '#f3f4f6';
                    statusElement.style.color = '#6b7280';
                }
                
                // Update chat messages
                updateChatMessages(userData.messages);
                
                // Update input container based on current status
                updateInputContainer(userData.isCurrent);
                
                if (userData.isCurrent) {
                    showNotification(`Switched to chat with ${userData.name}`, 'info');
                } else {
                    showNotification(`Viewing conversation history with ${userData.name} (Previous Nutritionist)`, 'info');
                }
            }
        });
    });
});

function updateChatMessages(messages) {
    const messagesContainer = document.getElementById('chatMessages');
    messagesContainer.innerHTML = '';
    
    messages.forEach(message => {
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = 'margin-bottom: 0.75rem; display: flex; flex-direction: column;';
        
        if (message.type === 'nutritionist') {
            messageDiv.style.alignItems = 'flex-start';
            messageDiv.innerHTML = `
                <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;">${message.text}</div>
                <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">${message.time}</div>
            `;
        } else {
            messageDiv.style.alignItems = 'flex-end';
            messageDiv.innerHTML = `
                <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;">${message.text}</div>
                <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">${message.time}</div>
            `;
        }
        
        messagesContainer.appendChild(messageDiv);
    });
    
    // Scroll to bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function updateInputContainer(isCurrent) {
    const inputContainer = document.getElementById('chatInputContainer');
    const textarea = inputContainer.querySelector('textarea');
    const button = inputContainer.querySelector('button');
    
    if (isCurrent) {
        inputContainer.style.opacity = '1';
        textarea.disabled = false;
        button.disabled = false;
        textarea.placeholder = 'Type your message...';
        button.style.background = '#278b63';
        button.style.cursor = 'pointer';
    } else {
        inputContainer.style.opacity = '0.5';
        textarea.disabled = true;
        button.disabled = true;
        textarea.placeholder = 'You can only message your current nutritionist';
        button.style.background = '#9ca3af';
        button.style.cursor = 'not-allowed';
    }
}

function sendChatMessage() {
    const input = document.querySelector('.chat-input');
    const message = input.value.trim();
    
    // Check if current nutritionist is selected
    const activeItem = document.querySelector('.conversation-item.active');
    const isCurrent = activeItem ? activeItem.getAttribute('data-is-current') === 'true' : false;
    
    if (!isCurrent) {
        showNotification('You can only send messages to your current nutritionist', 'error');
        return;
    }
    
    if (message) {
        const messagesContainer = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = 'margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;';
        messageDiv.innerHTML = `
            <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;">${message}</div>
            <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">Just now</div>
        `;
        messagesContainer.appendChild(messageDiv);
        
        input.value = '';
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        showNotification('Message sent!', 'success');
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
        z-index: 1000;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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

// Enter key to send message
document.addEventListener('DOMContentLoaded', function() {
    const chatInput = document.querySelector('.chat-input');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendChatMessage();
            }
        });
    }
});
</script>

<?php include 'footer.php'; ?>