<?php include 'header.php'; ?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-muted-foreground">Welcome back! Here's your overview.</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">👥 Assigned Users</div>
                <div class="stat-icon">👥</div>
            </div>
            <div class="stat-value">24</div>
            <div class="stat-change positive">+4 this week</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">📋 Active Diet Plans</div>
                <div class="stat-icon">📋</div>
            </div>
            <div class="stat-value">18</div>
            <div class="stat-change positive">+8 this week</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">💬 Pending Chats</div>
                <div class="stat-icon">💬</div>
            </div>
            <div class="stat-value">5</div>
            <div class="stat-subtitle">2 unread</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">📅 Appointments Today</div>
                <div class="stat-icon">📅</div>
            </div>
            <div class="stat-value">3</div>
            <div class="stat-subtitle">Next at 2:00 PM</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="card lg:col-span-2">
            <div class="card-header">
                <div class="card-header-content">
                    <h3 class="card-title">Assigned Users</h3>
                    <a href="users.php" class="btn btn-ghost btn-sm gap-1">View all →</a>
                </div>
            </div>
            <div class="card-content">
            
                <div class="space-y-4">
                    <div class="user-row">
                        <div class="user-info">
                            <div class="user-avatar">JD</div>
                            <div>
                                <p class="user-name">John Doe</p>
                                <p class="user-goal">Weight Loss</p>
                            </div>
                        </div>
                        <div class="user-meta">
                            <div class="user-progress">
                                <p class="progress-value">75%</p>
                                <p class="last-active">2 hours ago</p>
                            </div>
                            <a href="user-detail.php?id=1" class="btn btn-outline btn-sm">View</a>
                        </div>
                    </div>
                
                    <div class="user-row">
                        <div class="user-info">
                            <div class="user-avatar">JS</div>
                            <div>
                                <p class="user-name">Jane Smith</p>
                                <p class="user-goal">Build Muscle</p>
                            </div>
                        </div>
                        <div class="user-meta">
                            <div class="user-progress">
                                <p class="progress-value">45%</p>
                                <p class="last-active">1 day ago</p>
                            </div>
                            <a href="user-detail.php?id=2" class="btn btn-outline btn-sm">View</a>
                        </div>
                    </div>
                
                    <div class="user-row">
                        <div class="user-info">
                            <div class="user-avatar">MJ</div>
                            <div>
                                <p class="user-name">Mike Johnson</p>
                                <p class="user-goal">Maintain</p>
                            </div>
                        </div>
                        <div class="user-meta">
                            <div class="user-progress">
                                <p class="progress-value">90%</p>
                                <p class="last-active">30 min ago</p>
                            </div>
                            <a href="user-detail.php?id=3" class="btn btn-outline btn-sm">View</a>
                        </div>
                    </div>
                
                    <div class="user-row">
                        <div class="user-info">
                            <div class="user-avatar">ED</div>
                            <div>
                                <p class="user-name">Emily Davis</p>
                                <p class="user-goal">Weight Loss</p>
                            </div>
                        </div>
                        <div class="user-meta">
                            <div class="user-progress">
                                <p class="progress-value">60%</p>
                                <p class="last-active">5 hours ago</p>
                            </div>
                            <a href="user-detail.php?id=4" class="btn btn-outline btn-sm">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">
                <div class="card-header-content">
                    <h3 class="card-title">Pending Chats</h3>
                    <a href="chat.php" class="btn btn-ghost btn-sm gap-1">View all →</a>
                </div>
            </div>
            <div class="card-content">
            
                <div class="space-y-4">
                    <div class="chat-item">
                        <div class="chat-info">
                            <div class="user-avatar">SW</div>
                            <div class="chat-details">
                                <div class="chat-header">
                                    <p class="chat-name">Sarah Wilson</p>
                                    <span class="status-badge new">New</span>
                                </div>
                                <p class="chat-message">Hi, I have a question about my meal plan...</p>
                                <p class="chat-time">10 min ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="chat-item">
                        <div class="chat-info">
                            <div class="user-avatar">CB</div>
                            <div class="chat-details">
                                <div class="chat-header">
                                    <p class="chat-name">Chris Brown</p>
                                    <span class="status-badge new">New</span>
                                </div>
                                <p class="chat-message">Thank you for the new diet plan!</p>
                                <p class="chat-time">1 hour ago</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="chat-item">
                        <div class="chat-info">
                            <div class="user-avatar">LT</div>
                            <div class="chat-details">
                                <p class="chat-name">Lisa Thompson</p>
                                <p class="chat-message">When is our next appointment?</p>
                                <p class="chat-time">2 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Client Progress Summary</h3>
        </div>
        <div class="card-content">
            <div class="chart-container">
                <div class="chart-bar">
                    <div class="chart-bar-fill" style="height: 60%; background: #16a34a;"></div>
                    <span class="chart-label">W1</span>
                </div>
                <div class="chart-bar">
                    <div class="chart-bar-fill" style="height: 45%; background: #16a34a;"></div>
                    <span class="chart-label">W2</span>
                </div>
                <div class="chart-bar">
                    <div class="chart-bar-fill" style="height: 35%; background: #16a34a;"></div>
                    <span class="chart-label">W3</span>
                </div>
                <div class="chart-bar">
                    <div class="chart-bar-fill" style="height: 40%; background: #16a34a;"></div>
                    <span class="chart-label">W4</span>
                </div>
            </div>
            
            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-dot" style="background: #16a34a;"></div>
                    <span class="legend-label">Avg Daily Calories</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background: #3b82f6;"></div>
                    <span class="legend-label">Avg Weight (lbs)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>