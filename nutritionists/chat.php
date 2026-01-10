<?php include 'header.php'; ?>

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
                            <button class="btn btn-primary btn-sm">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>