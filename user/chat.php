<?php
$page_title = "Chat";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();

// Get assigned nutritionist
$db = getDB();
$nutritionist = null;
if ($user['nutritionist_id']) {
    $stmt = $db->prepare("SELECT id, name, email, specialty FROM users WHERE id = ?");
    $stmt->execute([$user['nutritionist_id']]);
    $nutritionist = $stmt->fetch();
}

// Get chat history
$messages = [];
if ($nutritionist) {
    $stmt = $db->prepare("SELECT m.*, 
                          CASE WHEN m.sender_id = ? THEN 'user' ELSE 'nutritionist' END as sender_type,
                          u.name as sender_name
                          FROM messages m
                          JOIN users u ON m.sender_id = u.id
                          WHERE (m.sender_id = ? AND m.receiver_id = ?) 
                             OR (m.sender_id = ? AND m.receiver_id = ?)
                          ORDER BY m.created_at ASC");
    $stmt->execute([$user['id'], $user['id'], $nutritionist['id'], $nutritionist['id'], $user['id']]);
    $messages = $stmt->fetchAll();
    
    // Mark messages as read
    $stmt = $db->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
    $stmt->execute([$nutritionist['id'], $user['id']]);
}

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
                    <?php if ($nutritionist): ?>
                    <?php 
                        $initials = strtoupper(substr($nutritionist['name'], 0, 1) . substr(strstr($nutritionist['name'], ' '), 1, 1));
                    ?>
                    <div class="conversation-item active" data-user-id="<?= $nutritionist['id'] ?>" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer; background: #f0fdf4;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <div class="user-avatar" style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;"><?= $initials ?></div>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;"><?= htmlspecialchars($nutritionist['name']) ?> <span style="background: #dcfce7; color: #278b63; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.625rem; font-weight: 500;">Current</span></p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0;"><?= htmlspecialchars($nutritionist['specialty'] ?? 'Nutritionist') ?></p>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div style="padding: 1rem; text-align: center; color: #6b7280;">
                        <p>No nutritionist assigned yet.</p>
                        <p style="font-size: 0.75rem;">Contact admin to get assigned to a nutritionist.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    
        <div class="card lg:col-span-2" style="display: flex; flex-direction: column; height: 100%; position: relative;">
            <?php if ($nutritionist): ?>
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0; position: relative; z-index: 2; background: white;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div id="currentChatAvatar" style="width: 2.5rem; height: 2.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: bold;"><?= $initials ?></div>
                    <div>
                        <h3 id="currentChatName" style="font-size: 1rem; font-weight: 600; margin: 0 0 0.25rem 0;"><?= htmlspecialchars($nutritionist['name']) ?></h3>
                        <span id="currentChatStatus" style="background: #dcfce7; color: #278b63; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;"><?= htmlspecialchars($nutritionist['specialty'] ?? 'Nutritionist') ?></span>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0; position: relative; z-index: 2; background: white;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.5rem; height: 2.5rem; background: #9ca3af; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: bold;">?</div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.25rem 0;">No Nutritionist</h3>
                        <span style="background: #f3f4f6; color: #6b7280; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">Not assigned</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div style="flex: 1; position: relative; overflow: hidden;">
                <div id="chatMessages" style="position: absolute; top: 0; left: 0; right: 0; bottom: 100px; overflow-y: auto; padding: 0.75rem; background: #f9fafb; margin: 0.5rem 0.5rem 0 0.5rem; border-radius: 0.375rem;">
                    <?php if (empty($messages) && $nutritionist): ?>
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <p>No messages yet.</p>
                        <p style="font-size: 0.75rem;">Start the conversation with your nutritionist!</p>
                    </div>
                    <?php elseif (!$nutritionist): ?>
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <p>You need to be assigned to a nutritionist to chat.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                    <?php if ($msg['sender_type'] === 'nutritionist'): ?>
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;">
                        <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;"><?= htmlspecialchars($msg['message']) ?></div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;"><?= date('M j, g:i A', strtotime($msg['created_at'])) ?></div>
                    </div>
                    <?php else: ?>
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;">
                        <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;"><?= htmlspecialchars($msg['message']) ?></div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;"><?= date('M j, g:i A', strtotime($msg['created_at'])) ?></div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <?php if ($nutritionist): ?>
                <div id="chatInputContainer" style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; padding: 0.75rem; background: white; border-top: 1px solid #e5e7eb; z-index: 2;">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; height: 100%;">
                        <textarea id="chatInput" class="chat-input" placeholder="Type your message..." style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; outline: none; resize: none; height: 2.5rem; font-family: inherit;"></textarea>
                        <button id="sendBtn" onclick="sendChatMessage()" style="align-self: flex-end; padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">Send</button>
                    </div>
                </div>
                <?php else: ?>
                <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; padding: 0.75rem; background: #f3f4f6; border-top: 1px solid #e5e7eb; z-index: 2; display: flex; align-items: center; justify-content: center;">
                    <p style="color: #6b7280; font-size: 0.875rem;">Assign a nutritionist to start chatting</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Send message to backend
async function sendChatMessage() {
    const input = document.getElementById('chatInput');
    if (!input) return;
    
    const message = input.value.trim();
    if (!message) {
        showNotification('Please enter a message', 'error');
        return;
    }
    
    const sendBtn = document.getElementById('sendBtn');
    sendBtn.disabled = true;
    sendBtn.textContent = 'Sending...';
    
    try {
        const formData = new FormData();
        formData.append('action', 'send_message');
        formData.append('message', message);
        
        const response = await fetch('user_handler.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Add message to UI
            const messagesContainer = document.getElementById('chatMessages');
            const emptyMsg = messagesContainer.querySelector('div[style*="text-align: center"]');
            if (emptyMsg) emptyMsg.remove();
            
            const messageDiv = document.createElement('div');
            messageDiv.style.cssText = 'margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;';
            messageDiv.innerHTML = `
                <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;">${escapeHtml(message)}</div>
                <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">Just now</div>
            `;
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            input.value = '';
            showNotification('Message sent!', 'success');
        } else {
            showNotification(data.message || 'Failed to send message', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Failed to send message', 'error');
    } finally {
        sendBtn.disabled = false;
        sendBtn.textContent = 'Send';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
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
    
    const colors = { success: '#278b63', error: '#dc2626', info: '#3b82f6' };
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

// Enter key to send message
document.addEventListener('DOMContentLoaded', function() {
    const chatInput = document.getElementById('chatInput');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendChatMessage();
            }
        });
    }
    
    // Scroll to bottom on load
    const messagesContainer = document.getElementById('chatMessages');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>

<?php include 'footer.php'; ?>