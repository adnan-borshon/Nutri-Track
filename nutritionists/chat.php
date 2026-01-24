<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
include 'header.php';
?>

<div style="height: calc(100vh - 100px); overflow: hidden; padding: 1rem;">
    <div class="grid lg:grid-cols-3 gap-4" style="height: 100%;">
        <div class="card" style="display: flex; flex-direction: column; height: 100%;">
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0;">Active Conversations</h3>
            </div>
            <div style="flex: 1; overflow-y: auto; padding: 0.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div class="conversation-item active" data-user-id="1" data-user-name="John Doe" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">JD</div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">John Doe</p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Thanks for the meal suggestions!</p>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;">2 min ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="conversation-item" data-user-id="2" data-user-name="Sarah Wilson" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">SW</div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Sarah Wilson</p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Hi, I have a question about my meal plan...</p>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;">10 min ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="conversation-item" data-user-id="3" data-user-name="Chris Brown" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">CB</div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Chris Brown</p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Thank you for the new diet plan!</p>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;">1 hour ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="conversation-item" data-user-id="4" data-user-name="Lisa Thompson" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">LT</div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Lisa Thompson</p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">When is our next appointment?</p>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;">2 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card lg:col-span-2" style="display: flex; flex-direction: column; height: 100%; position: relative;">
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0; position: relative; z-index: 2; background: white;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div id="currentChatAvatar" style="width: 2.5rem; height: 2.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: bold;">JD</div>
                    <div>
                        <h3 id="currentChatName" style="font-size: 1rem; font-weight: 600; margin: 0 0 0.25rem 0;">John Doe</h3>
                        <span style="background: #dcfce7; color: #278b63; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Online</span>
                    </div>
                </div>
            </div>
            <div style="flex: 1; position: relative; overflow: hidden;">
                <div id="chatMessages" style="position: absolute; top: 0; left: 0; right: 0; bottom: 100px; overflow-y: auto; padding: 0.75rem; background: #f9fafb; margin: 0.5rem; border-radius: 0.375rem;">
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;">
                        <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;">Hi John! How are you feeling with your new meal plan?</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">2:30 PM</div>
                    </div>
                
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;">
                        <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;">Hi Dr. Smith! I'm feeling great. The portions are perfect and I'm not feeling hungry between meals.</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">2:32 PM</div>
                    </div>
                
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;">
                        <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;">That's wonderful to hear! How's your energy level throughout the day?</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">2:33 PM</div>
                    </div>
                
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;">
                        <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;">Much better than before. I don't have those afternoon crashes anymore. Thanks for the meal suggestions!</div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">2:35 PM</div>
                    </div>
                </div>
                
                <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; padding: 0.5rem; border-top: 1px solid #e5e7eb; background: white; z-index: 2;">
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; height: 100%;">
                        <textarea class="chat-input" placeholder="Type your message..." style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; outline: none; resize: none; height: 2.5rem; font-family: inherit;"></textarea>
                        <button onclick="sendChatMessage()" style="align-self: flex-end; padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chat data for different users
const chatData = {
    '1': {
        name: 'John Doe',
        avatar: 'JD',
        messages: [
            { type: 'nutritionist', text: 'Hi John! How are you feeling with your new meal plan?', time: '2:30 PM' },
            { type: 'user', text: 'Hi Dr. Smith! I\'m feeling great. The portions are perfect and I\'m not feeling hungry between meals.', time: '2:32 PM' },
            { type: 'nutritionist', text: 'That\'s wonderful to hear! How\'s your energy level throughout the day?', time: '2:33 PM' },
            { type: 'user', text: 'Much better than before. I don\'t have those afternoon crashes anymore. Thanks for the meal suggestions!', time: '2:35 PM' }
        ]
    },
    '2': {
        name: 'Sarah Wilson',
        avatar: 'SW',
        messages: [
            { type: 'user', text: 'Hi, I have a question about my meal plan...', time: '1:45 PM' },
            { type: 'nutritionist', text: 'Hi Sarah! I\'d be happy to help. What\'s your question?', time: '1:46 PM' },
            { type: 'user', text: 'Can I substitute the chicken with fish in my lunch meals?', time: '1:47 PM' },
            { type: 'nutritionist', text: 'Absolutely! Fish is a great protein source. Salmon, tuna, or cod would work perfectly.', time: '1:48 PM' }
        ]
    },
    '3': {
        name: 'Chris Brown',
        avatar: 'CB',
        messages: [
            { type: 'user', text: 'Thank you for the new diet plan!', time: '12:30 PM' },
            { type: 'nutritionist', text: 'You\'re welcome, Chris! How are you finding it so far?', time: '12:32 PM' },
            { type: 'user', text: 'It\'s great! The variety keeps me motivated.', time: '12:35 PM' },
            { type: 'nutritionist', text: 'That\'s exactly what we want to hear. Keep up the good work!', time: '12:36 PM' }
        ]
    },
    '4': {
        name: 'Lisa Thompson',
        avatar: 'LT',
        messages: [
            { type: 'user', text: 'When is our next appointment?', time: '11:15 AM' },
            { type: 'nutritionist', text: 'Hi Lisa! Let me check the schedule for you.', time: '11:16 AM' },
            { type: 'nutritionist', text: 'Your next appointment is scheduled for Friday at 2:00 PM.', time: '11:17 AM' },
            { type: 'user', text: 'Perfect, thank you!', time: '11:18 AM' }
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
            const userData = chatData[userId];
            
            if (userData) {
                // Update chat header
                document.getElementById('currentChatAvatar').textContent = userData.avatar;
                document.getElementById('currentChatName').textContent = userData.name;
                
                // Update chat messages
                updateChatMessages(userData.messages);
                
                showNotification(`Switched to chat with ${userData.name}`, 'info');
            }
        });
    });
});

function updateChatMessages(messages) {
    const messagesContainer = document.getElementById('chatMessages');
    messagesContainer.innerHTML = '';
    
    messages.forEach(message => {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${message.type}`;
        messageDiv.innerHTML = `
            <div class="message-bubble">
                ${message.text}
            </div>
            <div class="message-time">${message.time}</div>
        `;
        messagesContainer.appendChild(messageDiv);
    });
    
    // Scroll to bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function sendChatMessage() {
    const input = document.querySelector('.chat-input');
    const message = input.value.trim();
    
    if (message) {
        const messagesContainer = document.getElementById('chatMessages');
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = 'margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;';
        messageDiv.innerHTML = `
            <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;">${message}</div>
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