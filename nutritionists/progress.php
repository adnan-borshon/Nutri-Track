<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
$user = getCurrentUser();
$nutritionistId = $user['id'];

$db = getDB();

// Get stats from database
$stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE nutritionist_id = ? AND role = 'user'");
$stmt->execute([$nutritionistId]);
$totalUsers = $stmt->fetch()['count'];

$stmt = $db->prepare("SELECT COUNT(*) as count FROM diet_plans WHERE nutritionist_id = ? AND status = 'active'");
$stmt->execute([$nutritionistId]);
$activePlans = $stmt->fetch()['count'];

$stmt = $db->prepare("SELECT COUNT(*) as count FROM appointments WHERE nutritionist_id = ?");
$stmt->execute([$nutritionistId]);
$totalSessions = $stmt->fetch()['count'];

// Calculate success rate based on completed plans
$stmt = $db->prepare("SELECT 
    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed,
    COUNT(*) as total 
    FROM diet_plans WHERE nutritionist_id = ?");
$stmt->execute([$nutritionistId]);
$planStats = $stmt->fetch();
$successRate = $planStats['total'] > 0 ? round(($planStats['completed'] / $planStats['total']) * 100) : 0;

// Get client progress data
$stmt = $db->prepare("SELECT u.id, u.name, 
    (SELECT COUNT(*) FROM meal_logs WHERE user_id = u.id AND log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)) as meal_logs,
    (SELECT COUNT(*) FROM water_logs WHERE user_id = u.id AND log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)) as water_logs,
    (SELECT COUNT(*) FROM sleep_logs WHERE user_id = u.id AND log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)) as sleep_logs
    FROM users u WHERE u.nutritionist_id = ? AND u.role = 'user' LIMIT 10");
$stmt->execute([$nutritionistId]);
$clientProgress = $stmt->fetchAll();

// Calculate progress percentage for each client (based on activity in last 7 days, max 21 activities)
foreach ($clientProgress as &$client) {
    $totalActivity = $client['meal_logs'] + $client['water_logs'] + $client['sleep_logs'];
    $client['progress'] = min(100, round(($totalActivity / 21) * 100));
    $client['color'] = $client['progress'] >= 70 ? '#16a34a' : ($client['progress'] >= 40 ? '#f59e0b' : '#dc2626');
}

// Get recent progress updates from various sources
$recentUpdates = [];

// Recent weight logs
$stmt = $db->prepare("SELECT wl.*, u.name as user_name, wl.created_at as activity_time
    FROM weight_logs wl 
    JOIN users u ON wl.user_id = u.id 
    WHERE u.nutritionist_id = ? 
    ORDER BY wl.created_at DESC LIMIT 5");
$stmt->execute([$nutritionistId]);
$weightLogs = $stmt->fetchAll();
foreach ($weightLogs as $log) {
    $recentUpdates[] = [
        'type' => 'weight',
        'user_name' => $log['user_name'],
        'title' => $log['user_name'] . ' logged weight update',
        'subtitle' => 'Weight: ' . $log['weight'] . ' kg' . ($log['notes'] ? ' • ' . $log['notes'] : ''),
        'status' => 'Weight Update',
        'status_class' => 'confirmed',
        'time' => $log['activity_time']
    ];
}

// Recent completed appointments
$stmt = $db->prepare("SELECT a.*, u.name as user_name, a.created_at as activity_time
    FROM appointments a 
    JOIN users u ON a.user_id = u.id 
    WHERE a.nutritionist_id = ? AND a.status = 'completed'
    ORDER BY a.created_at DESC LIMIT 3");
$stmt->execute([$nutritionistId]);
$appointments = $stmt->fetchAll();
foreach ($appointments as $apt) {
    $recentUpdates[] = [
        'type' => 'appointment',
        'user_name' => $apt['user_name'],
        'title' => $apt['user_name'] . ' completed session',
        'subtitle' => 'Session on ' . date('M j', strtotime($apt['appointment_date'])) . ' • ' . $apt['reason'],
        'status' => 'Session Complete',
        'status_class' => 'confirmed',
        'time' => $apt['activity_time']
    ];
}

// Recent diet plan completions
$stmt = $db->prepare("SELECT dp.*, u.name as user_name, dp.created_at as activity_time
    FROM diet_plans dp 
    JOIN users u ON dp.user_id = u.id 
    WHERE dp.nutritionist_id = ? AND dp.status = 'completed'
    ORDER BY dp.created_at DESC LIMIT 2");
$stmt->execute([$nutritionistId]);
$completedPlans = $stmt->fetchAll();
foreach ($completedPlans as $plan) {
    $recentUpdates[] = [
        'type' => 'plan',
        'user_name' => $plan['user_name'],
        'title' => $plan['user_name'] . ' completed diet plan',
        'subtitle' => $plan['name'] . ' • ' . $plan['duration_weeks'] . ' weeks completed',
        'status' => 'Plan Complete',
        'status_class' => 'confirmed',
        'time' => $plan['activity_time']
    ];
}

// Recent high activity days (users with 3+ logs in a day)
$stmt = $db->prepare("SELECT u.name as user_name, 
    COUNT(DISTINCT ml.id) + COUNT(DISTINCT wl.id) + COUNT(DISTINCT sl.id) as daily_logs,
    GREATEST(COALESCE(MAX(ml.created_at), '1970-01-01'), COALESCE(MAX(wl.created_at), '1970-01-01'), COALESCE(MAX(sl.created_at), '1970-01-01')) as activity_time
    FROM users u
    LEFT JOIN meal_logs ml ON u.id = ml.user_id AND ml.log_date >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    LEFT JOIN water_logs wl ON u.id = wl.user_id AND wl.log_date >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    LEFT JOIN sleep_logs sl ON u.id = sl.user_id AND sl.log_date >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    WHERE u.nutritionist_id = ? AND u.role = 'user'
    GROUP BY u.id, u.name
    HAVING daily_logs >= 3
    ORDER BY activity_time DESC LIMIT 3");
$stmt->execute([$nutritionistId]);
$activeUsers = $stmt->fetchAll();
foreach ($activeUsers as $user) {
    $recentUpdates[] = [
        'type' => 'activity',
        'user_name' => $user['user_name'],
        'title' => $user['user_name'] . ' high activity day',
        'subtitle' => $user['daily_logs'] . ' logs completed • Great progress!',
        'status' => 'Active',
        'status_class' => 'confirmed',
        'time' => $user['activity_time']
    ];
}

// Sort all updates by time and limit to 4 most recent
usort($recentUpdates, function($a, $b) {
    return strtotime($b['time']) - strtotime($a['time']);
});
$recentUpdates = array_slice($recentUpdates, 0, 4);

// Helper function to format time ago
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    if ($time < 60) return 'Just now';
    if ($time < 3600) return floor($time/60) . ' minutes ago';
    if ($time < 86400) return floor($time/3600) . ' hours ago';
    if ($time < 604800) return floor($time/86400) . ' days ago';
    return date('M j', strtotime($datetime));
}

include 'header.php';
?>

<div class="section-header">
    <h1 class="section-title">Progress Log</h1>
    <p class="section-description">Track your users' progress and achievements</p>
</div>

<div class="stats">
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
        </div>
        <div class="stat-value"><?php echo $totalUsers; ?></div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg>
        </div>
        <div class="stat-value"><?php echo $activePlans; ?></div>
        <div class="stat-label">Active Plans</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trophy" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21l8 0" /><path d="M12 17l0 4" /><path d="M7 4l10 0" /><path d="M17 4v8a5 5 0 0 1 -10 0v-8" /><path d="M5 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>
        </div>
        <div class="stat-value"><?php echo $successRate; ?>%</div>
        <div class="stat-label">Success Rate</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-stats" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /></svg>
        </div>
        <div class="stat-value"><?php echo $totalSessions; ?></div>
        <div class="stat-label">Total Sessions</div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">User Progress Overview (Last 7 Days)</h3>
        
        <?php if (empty($clientProgress)): ?>
        <p style="text-align: center; color: #6b7280; padding: 2rem;">No clients assigned yet.</p>
        <?php else: ?>
        <div class="chart-container">
            <?php foreach ($clientProgress as $client): ?>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: <?php echo $client['progress']; ?>%; background: <?php echo $client['color']; ?>;"></div>
                <span class="faq-answer"><?php echo htmlspecialchars(explode(' ', $client['name'])[0]); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="admin-chart-legend">
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #16a34a;"></div>
                <span class="admin-legend-label">On Track (>70%)</span>
            </div>
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #f59e0b;"></div>
                <span class="admin-legend-label">Needs Attention (40-70%)</span>
            </div>
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #dc2626;"></div>
                <span class="admin-legend-label">At Risk (<40%)</span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Recent Progress Updates</h3>
        
        <?php if (empty($recentUpdates)): ?>
        <p style="text-align: center; color: #6b7280; padding: 2rem;">No recent progress updates.</p>
        <?php else: ?>
        <div class="admin-activity-list">
            <?php foreach ($recentUpdates as $update): ?>
            <div class="admin-activity-item">
                <div class="admin-activity-info">
                    <div class="admin-activity-dot"></div>
                    <div>
                        <p class="admin-activity-title"><?php echo htmlspecialchars($update['title']); ?></p>
                        <p class="admin-activity-subtitle"><?php echo htmlspecialchars($update['subtitle']); ?></p>
                    </div>
                </div>
                <div class="admin-activity-meta">
                    <span class="status-badge <?php echo $update['status_class']; ?>"><?php echo htmlspecialchars($update['status']); ?></span>
                    <span class="admin-activity-time"><?php echo timeAgo($update['time']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>