<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
$user = getCurrentUser();
$nutritionistId = $user['id'];

$db = getDB();

// Get assigned users (clients)
$stmt = $db->prepare("SELECT u.id, u.name, u.email, u.goal, u.profile_image,
                      (SELECT message FROM messages WHERE (sender_id = u.id AND receiver_id = ?) OR (sender_id = ? AND receiver_id = u.id) ORDER BY created_at DESC LIMIT 1) as last_message,
                      (SELECT created_at FROM messages WHERE (sender_id = u.id AND receiver_id = ?) OR (sender_id = ? AND receiver_id = u.id) ORDER BY created_at DESC LIMIT 1) as last_message_time,
                      (SELECT COUNT(*) FROM messages WHERE sender_id = u.id AND receiver_id = ? AND is_read = 0) as unread_count
                      FROM users u 
                      WHERE u.nutritionist_id = ? AND u.role = 'user'
                      ORDER BY last_message_time DESC");
$stmt->execute([$nutritionistId, $nutritionistId, $nutritionistId, $nutritionistId, $nutritionistId, $nutritionistId]);
$clients = $stmt->fetchAll();

// Get selected user for chat (first client or from query param)
$selectedUserId = isset($_GET['user']) ? intval($_GET['user']) : (!empty($clients) ? $clients[0]['id'] : 0);
$selectedUser = null;
$chatMessages = [];

if ($selectedUserId > 0) {
    // Verify user belongs to this nutritionist
    $stmt = $db->prepare("SELECT id, name, email, goal, profile_image FROM users WHERE id = ? AND nutritionist_id = ?");
    $stmt->execute([$selectedUserId, $nutritionistId]);
    $selectedUser = $stmt->fetch();
    
    if ($selectedUser) {
        // Get chat history
        $stmt = $db->prepare("SELECT m.*, 
                              CASE WHEN m.sender_id = ? THEN 'nutritionist' ELSE 'user' END as sender_type
                              FROM messages m
                              WHERE (m.sender_id = ? AND m.receiver_id = ?) 
                                 OR (m.sender_id = ? AND m.receiver_id = ?)
                              ORDER BY m.created_at ASC");
        $stmt->execute([$nutritionistId, $nutritionistId, $selectedUserId, $selectedUserId, $nutritionistId]);
        $chatMessages = $stmt->fetchAll();
        
        // Mark messages as read
        $stmt = $db->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
        $stmt->execute([$selectedUserId, $nutritionistId]);
    }
}

include 'header.php';
?>

<div style="height: calc(100vh - 140px); padding: 1rem;">
    <div class="grid lg:grid-cols-3 gap-4" style="height: 100%;">
        <div class="card" style="display: flex; flex-direction: column; height: 100%;">
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0;">Active Conversations</h3>
            </div>
            <div style="flex: 1; overflow-y: auto; padding: 0.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <?php if (empty($clients)): ?>
                    <div style="padding: 1rem; text-align: center; color: #6b7280;">
                        <p>No clients assigned yet.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($clients as $client): 
                        $initials = strtoupper(substr($client['name'], 0, 1) . substr(strstr($client['name'], ' ') ?: '', 1, 1));
                        $isSelected = $client['id'] == $selectedUserId;
                    ?>
                    <div class="conversation-item <?= $isSelected ? 'active' : '' ?>" data-user-id="<?= $client['id'] ?>" data-user-name="<?= htmlspecialchars($client['name']) ?>" data-user-goal="<?= htmlspecialchars($client['goal'] ?? 'Client') ?>" style="padding: 0.5rem; border-radius: 0.375rem; cursor: pointer; <?= $isSelected ? 'background: #f0fdf4;' : '' ?>" onclick="selectConversation(<?= $client['id'] ?>, '<?= htmlspecialchars($client['name']) ?>', '<?= htmlspecialchars($client['goal'] ?? 'Client') ?>', '<?= $initials ?>')">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                            <?php if (!empty($client['profile_image']) && file_exists(__DIR__ . '/../' . $client['profile_image'])): ?>
                                <img src="../<?php echo htmlspecialchars($client['profile_image']); ?>" alt="Profile" style="width: 2rem; height: 2rem; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                                <div class="user-avatar" style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;"><?= $initials ?></div>
                            <?php endif; ?>
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-weight: 500; font-size: 0.875rem; margin: 0 0 0.25rem 0;">
                                    <?= htmlspecialchars($client['name']) ?>
                                    <?php if ($client['unread_count'] > 0): ?>
                                    <span style="background: #dc2626; color: white; padding: 0.125rem 0.375rem; border-radius: 9999px; font-size: 0.625rem; margin-left: 0.25rem;"><?= $client['unread_count'] ?></span>
                                    <?php endif; ?>
                                </p>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= $client['last_message'] ? htmlspecialchars(substr($client['last_message'], 0, 40)) . '...' : 'No messages yet' ?></p>
                                <?php if ($client['last_message_time']): ?>
                                <p style="font-size: 0.625rem; color: #6b7280; margin: 0.25rem 0 0 0;"><?= date('M j, g:i A', strtotime($client['last_message_time'])) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    
        <div class="card lg:col-span-2" style="display: flex; flex-direction: column; height: 100%; position: relative;">
            <?php if ($selectedUser): ?>
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0; position: relative; z-index: 2; background: white;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <?php 
                    $selectedInitials = strtoupper(substr($selectedUser['name'], 0, 1) . substr(strstr($selectedUser['name'], ' ') ?: '', 1, 1));
                    ?>
                    <?php if (!empty($selectedUser['profile_image']) && file_exists(__DIR__ . '/../' . $selectedUser['profile_image'])): ?>
                        <img id="currentChatAvatar" src="../<?php echo htmlspecialchars($selectedUser['profile_image']); ?>" alt="Profile" style="width: 2.5rem; height: 2.5rem; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                        <div id="currentChatAvatar" style="width: 2.5rem; height: 2.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: bold;"><?= $selectedInitials ?></div>
                    <?php endif; ?>
                    <div>
                        <h3 id="currentChatName" style="font-size: 1rem; font-weight: 600; margin: 0 0 0.25rem 0;"><?= htmlspecialchars($selectedUser['name']) ?></h3>
                        <span id="currentChatStatus" style="background: #dcfce7; color: #278b63; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;"><?= htmlspecialchars($selectedUser['goal'] ?? 'Client') ?></span>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div style="padding: 0.75rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0; position: relative; z-index: 2; background: white;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.5rem; height: 2.5rem; background: #9ca3af; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: bold;">?</div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.25rem 0;">Select a conversation</h3>
                        <span style="background: #f3f4f6; color: #6b7280; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">No selection</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div style="flex: 1; position: relative; overflow: hidden;">
                <div id="chatMessages" style="position: absolute; top: 0; left: 0; right: 0; bottom: 100px; overflow-y: auto; padding: 0.75rem; background: #f9fafb; margin: 0.5rem 0.5rem 0 0.5rem; border-radius: 0.375rem;">
                    <?php if (!$selectedUser): ?>
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <p>Select a client from the list to start chatting.</p>
                    </div>
                    <?php elseif (empty($chatMessages)): ?>
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <p>No messages yet.</p>
                        <p style="font-size: 0.75rem;">Start the conversation with <?= htmlspecialchars($selectedUser['name']) ?>!</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($chatMessages as $msg): ?>
                    <?php if ($msg['sender_type'] === 'nutritionist'): ?>
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-end;">
                        <div style="background: white; color: #374151; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-right-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; border: 1px solid #e5e7eb;"><?= htmlspecialchars($msg['message']) ?></div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;"><?= date('M j, g:i A', strtotime($msg['created_at'])) ?></div>
                    </div>
                    <?php else: ?>
                    <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: flex-start;">
                        <div style="background: #278b63; color: white; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-left-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem;"><?= htmlspecialchars($msg['message']) ?></div>
                        <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;"><?= date('M j, g:i A', strtotime($msg['created_at'])) ?></div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <?php if ($selectedUser): ?>
                <div id="chatInputContainer" style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; padding: 0.75rem; background: white; border-top: 1px solid #e5e7eb; z-index: 2;">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; height: 100%;">
                        <textarea id="chatInput" class="chat-input" placeholder="Type your message..." style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; outline: none; resize: none; height: 2.5rem; font-family: inherit;"></textarea>
                        <button id="sendBtn" onclick="sendChatMessage()" style="align-self: flex-end; padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">Send</button>
                    </div>
                </div>
                <?php else: ?>
                <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; padding: 0.75rem; background: #f3f4f6; border-top: 1px solid #e5e7eb; z-index: 2; display: flex; align-items: center; justify-content: center;">
                    <p style="color: #6b7280; font-size: 0.875rem;">Select a client to start messaging</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
let selectedUserId = <?= $selectedUserId ?: 'null' ?>;

function selectConversation(userId, userName, userGoal, userInitials) {
    // Update active conversation styling
    document.querySelectorAll('.conversation-item').forEach(item => {
        item.classList.remove('active');
        item.style.background = '';
    });
    
    const clickedItem = document.querySelector(`[data-user-id="${userId}"]`);
    if (clickedItem) {
        clickedItem.classList.add('active');
        clickedItem.style.background = '#f0fdf4';
    }
    
    // Update chat header
    document.getElementById('currentChatAvatar').textContent = userInitials;
    document.getElementById('currentChatAvatar').style.background = '#278b63';
    document.getElementById('currentChatName').textContent = userName;
    document.getElementById('currentChatStatus').textContent = userGoal;
    document.getElementById('currentChatStatus').style.background = '#dcfce7';
    document.getElementById('currentChatStatus').style.color = '#278b63';
    
    // Show/hide input area
    document.getElementById('chatInputContainer').style.display = 'block';
    
    // Load chat messages
    selectedUserId = userId;
    loadChatMessages(userId);
}

async function loadChatMessages(userId) {
    try {
        const response = await fetch(`nutritionist_handler.php?action=get_messages&user_id=${userId}`);
        const data = await response.json();
        
        const messagesContainer = document.getElementById('chatMessages');
        
        if (data.success && data.data && data.data.messages) {
            if (data.data.messages.length === 0) {
                messagesContainer.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <p>No messages yet.</p>
                        <p style="font-size: 0.75rem;">Start the conversation!</p>
                    </div>
                `;
            } else {
                messagesContainer.innerHTML = data.data.messages.map(msg => {
                    const isNutritionist = msg.sender_type === 'nutritionist';
                    return `
                        <div style="margin-bottom: 0.75rem; display: flex; flex-direction: column; align-items: ${isNutritionist ? 'flex-end' : 'flex-start'};">
                            <div style="background: ${isNutritionist ? 'white' : '#278b63'}; color: ${isNutritionist ? '#374151' : 'white'}; padding: 0.5rem 0.75rem; border-radius: 0.75rem; border-bottom-${isNutritionist ? 'right' : 'left'}-radius: 0.25rem; max-width: 70%; word-wrap: break-word; font-size: 0.875rem; ${isNutritionist ? 'border: 1px solid #e5e7eb;' : ''}">${escapeHtml(msg.message)}</div>
                            <div style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem; padding: 0 0.25rem;">${formatTime(msg.created_at)}</div>
                        </div>
                    `;
                }).join('');
            }
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        } else {
            console.error('Failed to load messages:', data.message);
            messagesContainer.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: #dc2626;">
                    <p>Failed to load messages</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading messages:', error);
        const messagesContainer = document.getElementById('chatMessages');
        messagesContainer.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #dc2626;">
                <p>Error loading messages</p>
            </div>
        `;
    }
}

function formatTime(timestamp) {
    const date = new Date(timestamp);
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit' });
}

async function sendChatMessage() {
    if (!selectedUserId) {
        showNotification('Please select a client first', 'error');
        return;
    }
    
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
        formData.append('user_id', selectedUserId);
        formData.append('message', message);
        
        const response = await fetch('nutritionist_handler.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
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
        position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
        border-radius: 0.375rem; color: white; font-weight: 500; z-index: 1000;
        max-width: 300px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    `;
    const colors = { success: '#278b63', error: '#dc2626', info: '#3b82f6' };
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

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
    
    const messagesContainer = document.getElementById('chatMessages');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>

<?php include 'footer.php'; ?>