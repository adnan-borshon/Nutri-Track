<?php
$page_title = "Chat";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
include 'header.php';

// Sample conversation history with different nutritionists
$conversations = [
    [
        'id' => 1,
        'nutritionist' => 'Dr. Sarah Smith',
        'initials' => 'SS',
        'lastMessage' => 'Great progress on your weight loss!',
        'time' => '2 min ago',
        'isActive' => true,
        'isOnline' => true,
        'messages' => [
            ['sender' => 'nutritionist', 'message' => 'Hello! How are you feeling today?', 'time' => '10:30 AM'],
            ['sender' => 'user', 'message' => 'Hi Dr. Smith! I\'m doing well, thanks for asking.', 'time' => '10:32 AM'],
            ['sender' => 'nutritionist', 'message' => 'Great to hear! I noticed you\'ve been consistent with your meal logging. Keep up the good work!', 'time' => '10:35 AM'],
            ['sender' => 'user', 'message' => 'Thank you! I have a question about portion sizes for dinner.', 'time' => '10:37 AM'],
            ['sender' => 'nutritionist', 'message' => 'Great progress on your weight loss!', 'time' => '10:40 AM']
        ]
    ],
    [
        'id' => 2,
        'nutritionist' => 'Dr. Mike Johnson',
        'initials' => 'MJ',
        'lastMessage' => 'Remember to drink more water daily.',
        'time' => '2 days ago',
        'isActive' => false,
        'isOnline' => false,
        'messages' => [
            ['sender' => 'nutritionist', 'message' => 'Hi! I\'m your new nutritionist. How can I help you today?', 'time' => 'Mon 2:00 PM'],
            ['sender' => 'user', 'message' => 'Hello Dr. Johnson! Nice to meet you.', 'time' => 'Mon 2:05 PM'],
            ['sender' => 'nutritionist', 'message' => 'Let\'s start with your current eating habits. Can you tell me about your typical day?', 'time' => 'Mon 2:10 PM'],
            ['sender' => 'user', 'message' => 'I usually skip breakfast and have a heavy lunch.', 'time' => 'Mon 2:15 PM'],
            ['sender' => 'nutritionist', 'message' => 'Remember to drink more water daily.', 'time' => 'Mon 2:20 PM']
        ]
    ]
];

$activeConversation = $conversations[0]; // Default to current nutritionist
?>

<div class="page-header">
    <div>
        <h1 class="section-title">Chat with Nutritionist</h1>
        <p class="section-description">Get personalized advice and support from your nutritionist</p>
    </div>
</div>

<div class="chat-layout">
    <!-- Conversations Panel -->
    <div class="conversations-panel">
        <div class="conversations-header">
            <h3 class="card-title">Nutritionist History</h3>
            <p class="card-description">Your conversation history</p>
        </div>
        <div class="conversations-list">
            <?php foreach ($conversations as $conversation): ?>
                <div class="conversation-item <?php echo $conversation['isActive'] ? 'active' : ''; ?>" 
                     onclick="switchConversation(<?php echo $conversation['id']; ?>)">
                    <div class="conversation-info">
                        <div class="user-avatar"><?php echo $conversation['initials']; ?></div>
                        <div class="conversation-details">
                            <p class="conversation-name"><?php echo $conversation['nutritionist']; ?></p>
                            <p class="conversation-message"><?php echo $conversation['lastMessage']; ?></p>
                            <p class="conversation-time"><?php echo $conversation['time']; ?></p>
                        </div>
                    </div>
                    <?php if ($conversation['isActive']): ?>
                        <span class="status-badge new">Current</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Chat Panel -->
    <div class="chat-container">
        <div class="chat-header" id="chatHeader">
            <div class="user-avatar" id="activeAvatar"><?php echo $activeConversation['initials']; ?></div>
            <div>
                <h3 class="card-title" id="activeName"><?php echo $activeConversation['nutritionist']; ?></h3>
                <p class="card-description" id="activeStatus">
                    <?php echo $activeConversation['isOnline'] ? '🟢 Online' : '⚫ Offline'; ?> - 
                    <?php echo $activeConversation['isActive'] ? 'Your Current Nutritionist' : 'Previous Nutritionist'; ?>
                </p>
            </div>
        </div>

        <div class="chat-messages" id="messagesContainer">
            <?php foreach ($activeConversation['messages'] as $message): ?>
                <div class="message <?php echo $message['sender']; ?>">
                    <div>
                        <div class="message-bubble">
                            <?php echo $message['message']; ?>
                        </div>
                        <div class="message-time">
                            <?php echo $message['time']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="chat-input-container" id="inputContainer">
            <div class="chat-input-wrapper">
                <input type="text" id="chatInput" placeholder="Type your message..." class="chat-input">
                <button class="btn btn-primary" id="sendBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Send
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Previous Nutritionist -->
<div id="previousNutritionistModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Previous Nutritionist</h2>
            <button class="modal-close" onclick="closePreviousModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>You are viewing conversation history with a previous nutritionist. You can read the messages but can only send new messages to your current nutritionist.</p>
            <p><strong>Current Nutritionist:</strong> Dr. Sarah Smith</p>
            <p><strong>Previous Nutritionist:</strong> Dr. Mike Johnson</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="closePreviousModal()">Got it</button>
        </div>
    </div>
</div>

<script>
// Conversation data from PHP
const conversations = <?php echo json_encode($conversations); ?>;
let currentConversationId = 1;

document.getElementById('sendBtn').addEventListener('click', sendMessage);
document.getElementById('chatInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Only allow sending to current nutritionist
    const currentConversation = conversations.find(c => c.id === currentConversationId);
    if (!currentConversation.isActive) {
        showModal();
        return;
    }
    
    const messagesContainer = document.getElementById('messagesContainer');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message user';
    messageDiv.innerHTML = `
        <div>
            <div class="message-bubble">${message}</div>
            <div class="message-time">Just now</div>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    input.value = '';
}

function switchConversation(conversationId) {
    // Remove active class from all conversations
    document.querySelectorAll('.conversation-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Add active class to clicked conversation
    event.currentTarget.classList.add('active');
    
    // Update current conversation
    currentConversationId = conversationId;
    const conversation = conversations.find(c => c.id === conversationId);
    
    // Update chat header
    document.getElementById('activeAvatar').textContent = conversation.initials;
    document.getElementById('activeName').textContent = conversation.nutritionist;
    document.getElementById('activeStatus').innerHTML = 
        (conversation.isOnline ? '🟢 Online' : '⚫ Offline') + ' - ' + 
        (conversation.isActive ? 'Your Current Nutritionist' : 'Previous Nutritionist');
    
    // Update messages
    const messagesContainer = document.getElementById('messagesContainer');
    messagesContainer.innerHTML = '';
    
    conversation.messages.forEach(message => {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${message.sender}`;
        messageDiv.innerHTML = `
            <div>
                <div class="message-bubble">${message.message}</div>
                <div class="message-time">${message.time}</div>
            </div>
        `;
        messagesContainer.appendChild(messageDiv);
    });
    
    // Update input container visibility
    const inputContainer = document.getElementById('inputContainer');
    if (!conversation.isActive) {
        inputContainer.style.opacity = '0.5';
        document.getElementById('chatInput').placeholder = 'You can only message your current nutritionist';
        showModal();
    } else {
        inputContainer.style.opacity = '1';
        document.getElementById('chatInput').placeholder = 'Type your message...';
    }
}

function showModal() {
    document.getElementById('previousNutritionistModal').style.display = 'flex';
}

function closePreviousModal() {
    document.getElementById('previousNutritionistModal').style.display = 'none';
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('previousNutritionistModal');
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closePreviousModal();
        }
    });
});
</script>

<?php include 'footer.php'; ?>