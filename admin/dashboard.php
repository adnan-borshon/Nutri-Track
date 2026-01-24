<?php
$page_title = "Admin Dashboard";
require_once '../includes/session.php';
checkAuth('admin');
$user = getCurrentUser();

$db = getDB();

// Get real stats from database
$stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
$totalUsers = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'nutritionist'");
$totalNutritionists = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(*) FROM diet_plans WHERE status = 'active'");
$activePlans = $stmt->fetchColumn();

// Daily active users (users who logged something today)
$today = date('Y-m-d');
$stmt = $db->prepare("SELECT COUNT(DISTINCT user_id) FROM (
    SELECT user_id FROM meal_logs WHERE log_date = ?
    UNION SELECT user_id FROM water_logs WHERE log_date = ?
    UNION SELECT user_id FROM sleep_logs WHERE log_date = ?
) as active_users");
$stmt->execute([$today, $today, $today]);
$dailyActiveUsers = $stmt->fetchColumn();

// Get user growth data for last 6 months
$userGrowth = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $monthName = date('M', strtotime("-$i months"));
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') <= ?");
    $stmt->execute([$month]);
    $userGrowth[] = ['month' => $monthName, 'count' => $stmt->fetchColumn()];
}
$maxUsers = max(array_column($userGrowth, 'count')) ?: 1;

// Get weekly activity data
$weeklyActivity = [];
$days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
foreach ($days as $i => $day) {
    $date = date('Y-m-d', strtotime("last monday +$i days"));
    $stmt = $db->prepare("SELECT COUNT(*) FROM meal_logs WHERE log_date = ?");
    $stmt->execute([$date]);
    $meals = $stmt->fetchColumn();
    $stmt = $db->prepare("SELECT COUNT(*) FROM water_logs WHERE log_date = ?");
    $stmt->execute([$date]);
    $water = $stmt->fetchColumn();
    $stmt = $db->prepare("SELECT COUNT(*) FROM sleep_logs WHERE log_date = ?");
    $stmt->execute([$date]);
    $sleep = $stmt->fetchColumn();
    $weeklyActivity[] = ['day' => $day, 'meals' => $meals, 'water' => $water, 'sleep' => $sleep];
}
$maxActivity = max(array_merge(array_column($weeklyActivity, 'meals'), array_column($weeklyActivity, 'water'), array_column($weeklyActivity, 'sleep'))) ?: 1;

// Get recent activity
$recentActivity = [];
$stmt = $db->query("SELECT name, role, created_at FROM users ORDER BY created_at DESC LIMIT 5");
while ($row = $stmt->fetch()) {
    $recentActivity[] = [
        'title' => 'New ' . $row['role'] . ' registered',
        'subtitle' => $row['name'],
        'type' => $row['role'],
        'time' => $row['created_at']
    ];
}

// Get goal distribution
$goalCounts = ['weight_loss' => 0, 'maintain' => 0, 'gain_weight' => 0, 'build_muscle' => 0, 'other' => 0];
$stmt = $db->query("SELECT goal FROM users WHERE role = 'user' AND goal IS NOT NULL AND goal != ''");
while ($row = $stmt->fetch()) {
    $goalData = json_decode($row['goal'], true);
    $goalType = is_array($goalData) ? ($goalData['type'] ?? 'other') : $row['goal'];
    $goalType = strtolower(str_replace(' ', '_', $goalType));
    if (isset($goalCounts[$goalType])) {
        $goalCounts[$goalType]++;
    } else {
        $goalCounts['other']++;
    }
}
$totalGoals = array_sum($goalCounts) ?: 1;
$goalPercentages = [];
foreach ($goalCounts as $type => $count) {
    $goalPercentages[$type] = round(($count / $totalGoals) * 100);
}

// Helper function for time ago with proper calculations
function timeAgoAdmin($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 2592000) return floor($diff / 86400) . ' days ago';
    if ($diff < 31536000) return floor($diff / 2592000) . ' months ago';
    return floor($diff / 31536000) . ' years ago';
}

include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <p class="text-muted-foreground">Welcome back, <?php echo $user['name']; ?>! Overview of your platform performance</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Total Users</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                </div>
            </div>
            <div class="stat-value"><?php echo number_format($totalUsers); ?></div>
            <div class="stat-change positive">Total registered</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Nutritionists</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-stethoscope" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" /><path d="M8 15a6 6 0 1 0 12 0v-3" /><path d="M11 3v2" /><path d="M6 3v2" /><circle cx="20" cy="10" r="2" /></svg>
                </div>
            </div>
            <div class="stat-value"><?php echo number_format($totalNutritionists); ?></div>
            <div class="stat-change positive">Active professionals</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Active Diet Plans</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chef-hat" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c1.918 0 3.52 1.35 3.91 3.151a4 4 0 0 1 2.09 7.723l0 7.126h-12v-7.126a4 4 0 1 1 2.092 -7.723a4.002 4.002 0 0 1 3.908 -3.151z" /><path d="M6.161 17.009l11.839 -.009" /></svg>
                </div>
            </div>
            <div class="stat-value"><?php echo number_format($activePlans); ?></div>
            <div class="stat-change positive">Currently active</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Daily Active Users</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
                </div>
            </div>
            <div class="stat-value"><?php echo number_format($dailyActiveUsers); ?></div>
            <div class="stat-change positive">Logged activity today</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <div class="card-header-content">
                    <h3 class="card-title">User Growth</h3>
                    <div class="chart-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <?php foreach ($userGrowth as $data): ?>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: <?php echo round(($data['count'] / $maxUsers) * 100); ?>%; background: #16a34a;"></div>
                        <span class="chart-label"><?php echo $data['month']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #16a34a;"></div>
                        <span class="legend-label">Users</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #3b82f6;"></div>
                        <span class="legend-label">Nutritionists</span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">
                <div class="card-header-content">
                    <h3 class="card-title">Weekly Activity</h3>
                    <div class="chart-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M4 20l14 0" /></svg>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <?php foreach ($weeklyActivity as $data): ?>
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: <?php echo $maxActivity > 0 ? round(($data['meals'] / $maxActivity) * 100) : 0; ?>%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: <?php echo $maxActivity > 0 ? round(($data['water'] / $maxActivity) * 100) : 0; ?>%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: <?php echo $maxActivity > 0 ? round(($data['sleep'] / $maxActivity) * 100) : 0; ?>%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label"><?php echo $data['day']; ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #16a34a;"></div>
                        <span class="legend-label">Meals</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #3b82f6;"></div>
                        <span class="legend-label">Water</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f59e0b;"></div>
                        <span class="legend-label">Sleep</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="card lg:col-span-2">
            <div class="card-header">
                <h3 class="card-title">Recent Activity</h3>
            </div>
            <div class="card-content">
                <?php if (empty($recentActivity)): ?>
                <div style="text-align: center; color: #6b7280; padding: 2rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 1rem; opacity: 0.5;"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <p>No recent activity to display</p>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentActivity as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-dot"></div>
                            <div>
                                <p class="activity-title"><?php echo htmlspecialchars($activity['title']); ?></p>
                                <p class="activity-subtitle"><?php echo htmlspecialchars($activity['subtitle']); ?></p>
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="activity-badge <?php echo $activity['type']; ?>"><?php echo $activity['type']; ?></span>
                            <span class="activity-time"><?php echo timeAgoAdmin($activity['time']); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Goals Distribution</h3>
            </div>
            <div class="card-content">
                <div class="pie-chart">
                    <div class="pie-inner"></div>
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #16a34a;"></div>
                        <span class="legend-label">Weight Loss (<?php echo $goalPercentages['weight_loss']; ?>%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #3b82f6;"></div>
                        <span class="legend-label">Maintain (<?php echo $goalPercentages['maintain']; ?>%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f59e0b;"></div>
                        <span class="legend-label">Gain Weight (<?php echo $goalPercentages['gain_weight']; ?>%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #8b5cf6;"></div>
                        <span class="legend-label">Build Muscle (<?php echo $goalPercentages['build_muscle']; ?>%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>