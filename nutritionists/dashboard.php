<?php
$page_title = "Dashboard";
require_once '../includes/session.php';
checkAuth('nutritionist');
$user = getCurrentUser();

$db = getDB();
$nutritionistId = $user['id'];

// Get assigned users count
$stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE nutritionist_id = ? AND role = 'user'");
$stmt->execute([$nutritionistId]);
$assignedUsersCount = $stmt->fetch()['count'] ?? 0;

// Get active diet plans count
$stmt = $db->prepare("SELECT COUNT(*) as count FROM diet_plans WHERE nutritionist_id = ? AND status = 'active'");
$stmt->execute([$nutritionistId]);
$activePlansCount = $stmt->fetch()['count'] ?? 0;

// Get unread messages count
$stmt = $db->prepare("SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = 0");
$stmt->execute([$nutritionistId]);
$unreadMessages = $stmt->fetch()['count'] ?? 0;

// Get today's appointments count
$stmt = $db->prepare("SELECT COUNT(*) as count FROM appointments WHERE nutritionist_id = ? AND DATE(appointment_date) = CURDATE()");
$stmt->execute([$nutritionistId]);
$todayAppointments = $stmt->fetch()['count'] ?? 0;

// Get assigned users list (limit 4)
$stmt = $db->prepare("SELECT id, name, email, goal, updated_at FROM users WHERE nutritionist_id = ? AND role = 'user' ORDER BY updated_at DESC LIMIT 4");
$stmt->execute([$nutritionistId]);
$assignedUsers = $stmt->fetchAll();

// Get recent messages (pending chats)
$stmt = $db->prepare("SELECT m.*, u.name as sender_name 
                      FROM messages m 
                      JOIN users u ON m.sender_id = u.id 
                      WHERE m.receiver_id = ? 
                      ORDER BY m.created_at DESC LIMIT 3");
$stmt->execute([$nutritionistId]);
$recentMessages = $stmt->fetchAll();

// Helper function for time ago
function timeAgo($datetime) {
    if (!$datetime) return 'Never';
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    return floor($diff / 86400) . ' days ago';
}

include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Welcome back, Dr. <?php echo explode(' ', $user['name'])[1]; ?>!</h1>
        <p class="text-muted-foreground">Here's your client overview for today.</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
</svg> Assigned Users</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
</svg>
                </div>
            </div>
            <div class="stat-value"><?php echo $assignedUsersCount; ?></div>
            <div class="stat-change positive">Active clients</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
</svg> Active Diet Plans</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
</svg>
                </div>
            </div>
            <div class="stat-value"><?php echo $activePlansCount; ?></div>
            <div class="stat-change positive">Active plans</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Pending Chats</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg>
                </div>
            </div>
            <div class="stat-value"><?php echo $unreadMessages; ?></div>
            <div class="stat-subtitle"><?php echo $unreadMessages; ?> unread</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg> Appointments Today</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg>
                </div>
            </div>
            <div class="stat-value"><?php echo $todayAppointments; ?></div>
            <div class="stat-subtitle">Today's appointments</div>
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
                    <?php if (empty($assignedUsers)): ?>
                    <div style="text-align: center; padding: 2rem; color: #6b7280;">
                        <p>No users assigned yet.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($assignedUsers as $u): 
                        $initials = strtoupper(substr($u['name'], 0, 1) . (strpos($u['name'], ' ') ? substr($u['name'], strpos($u['name'], ' ') + 1, 1) : ''));
                        $goalText = $u['goal'] ? ucwords(str_replace('_', ' ', $u['goal'])) : 'No goal set';
                        $lastActive = $u['updated_at'] ? timeAgo($u['updated_at']) : 'Never';
                    ?>
                    <div class="user-row">
                        <div class="user-info">
                            <div class="user-avatar"><?php echo $initials; ?></div>
                            <div>
                                <p class="user-name"><?php echo htmlspecialchars($u['name']); ?></p>
                                <p class="user-goal"><?php echo $goalText; ?></p>
                            </div>
                        </div>
                        <div class="user-meta">
                            <div class="user-progress">
                                <p class="progress-value">Active</p>
                                <p class="last-active"><?php echo $lastActive; ?></p>
                            </div>
                            <a href="user-detail.php?id=<?php echo $u['id']; ?>" class="btn btn-outline btn-sm" onclick="event.stopPropagation(); window.location.href=this.href; return false;">View</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
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