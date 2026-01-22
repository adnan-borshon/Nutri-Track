<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Chat</h1>
        <p class="text-muted-foreground">Communicate with your users</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Active Conversations</h3>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    <div class="conversation-item active">
                        <div class="conversation-info">
                            <div class="user-avatar">JD</div>
                            <div class="conversation-details">
                                <p class="conversation-name">John Doe</p>
                                <p class="conversation-message">Thanks for the meal suggestions!</p>
                                <p class="conversation-time">2 min ago</p>
                            </div>
                        </div>
                        <span class="status-badge new">New</span>
                    </div>
                
                    <div class="conversation-item">
                        <div class="conversation-info">
                            <div class="user-avatar">SW</div>
                            <div class="conversation-details">
                                <p class="conversation-name">Sarah Wilson</p>
                                <p class="conversation-message">Hi, I have a question about my meal plan...</p>
                                <p class="conversation-time">10 min ago</p>
                            </div>
                        </div>
                        <span class="status-badge new">New</span>
                    </div>
                
                    <div class="conversation-item">
                        <div class="conversation-info">
                            <div class="user-avatar">CB</div>
                            <div class="conversation-details">
                                <p class="conversation-name">Chris Brown</p>
                                <p class="conversation-message">Thank you for the new diet plan!</p>
                                <p class="conversation-time">1 hour ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="conversation-item">
                        <div class="conversation-info">
                            <div class="user-avatar">LT</div>
                            <div class="conversation-details">
                                <p class="conversation-name">Lisa Thompson</p>
                                <p class="conversation-message">When is our next appointment?</p>
                                <p class="conversation-time">2 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card lg:col-span-2">
            <div class="card-header">
                <div class="chat-header">
                    <div class="chat-user-info">
                        <div class="user-avatar">JD</div>
                        <div>
                            <h3 class="chat-user-name">John Doe</h3>
                            <span class="status-badge online">Online</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="chat-container">
                    <div class="chat-messages">
                        <div class="message nutritionist">
                            <div class="message-bubble">
                                Hi John! How are you feeling with your new meal plan?
                            </div>
                            <div class="message-time">2:30 PM</div>
                        </div>
                    
                        <div class="message user">
                            <div class="message-bubble">
                                Hi Dr. Smith! I'm feeling great. The portions are perfect and I'm not feeling hungry between meals.
                            </div>
                            <div class="message-time">2:32 PM</div>
                        </div>
                    
                        <div class="message nutritionist">
                            <div class="message-bubble">
                                That's wonderful to hear! How's your energy level throughout the day?
                            </div>
                            <div class="message-time">2:33 PM</div>
                        </div>
                    
                        <div class="message user">
                            <div class="message-bubble">
                                Much better than before. I don't have those afternoon crashes anymore. Thanks for the meal suggestions!
                            </div>
                            <div class="message-time">2:35 PM</div>
                        </div>
                    </div>
                    
                    <div class="chat-input-container">
                        <div class="chat-input-wrapper">
                            <input type="text" class="chat-input" placeholder="Type your message...">
                            <button class="btn btn-primary btn-sm" onclick="sendChatMessage()">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sendChatMessage() {
    const input = document.querySelector('.chat-input');
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
            if (e.key === 'Enter') {
                sendChatMessage();
            }
        });
    }
});
</script>

<?php include 'footer.php'; ?>