<?php
require_once '../includes/session.php';
checkAuth('admin');

$db = getDB();

// Get real stats
$stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
$totalUsers = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'nutritionist'");
$totalNutritionists = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(*) FROM diet_plans WHERE status = 'active'");
$activePlans = $stmt->fetchColumn();

// Calculate success rate (users who have logged activity in last 7 days / total users)
$stmt = $db->prepare("SELECT COUNT(DISTINCT user_id) FROM meal_logs WHERE log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$stmt->execute();
$activeUsers = $stmt->fetchColumn();
$successRate = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;

// Goal distribution
$stmt = $db->query("SELECT goal, COUNT(*) as count FROM users WHERE role = 'user' AND goal IS NOT NULL GROUP BY goal");
$goalData = $stmt->fetchAll();
$goalDistribution = [];
foreach ($goalData as $g) {
    $goalDistribution[$g['goal']] = $g['count'];
}
$totalWithGoals = array_sum($goalDistribution) ?: 1;

// User growth for chart
$userGrowth = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $monthName = date('M', strtotime("-$i months"));
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') <= ?");
    $stmt->execute([$month]);
    $userGrowth[] = ['month' => $monthName, 'count' => $stmt->fetchColumn()];
}
$maxUsers = max(array_column($userGrowth, 'count')) ?: 1;

// Recent activity
$stmt = $db->query("SELECT name, role, created_at FROM users ORDER BY created_at DESC LIMIT 5");
$recentUsers = $stmt->fetchAll();

include 'header.php';
?>

<div class="section-header">
    <h1 class="section-title">Reports & Analytics</h1>
    <p class="section-description">Platform insights and performance metrics</p>
</div>

<div class="stats">
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
        </div>
        <div class="stat-value"><?php echo number_format($totalUsers); ?></div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-stethoscope" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" /><path d="M8 15a6 6 0 1 0 12 0v-3" /><path d="M11 3v2" /><path d="M6 3v2" /><circle cx="20" cy="10" r="2" /></svg>
        </div>
        <div class="stat-value"><?php echo number_format($totalNutritionists); ?></div>
        <div class="stat-label">Nutritionists</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg>
        </div>
        <div class="stat-value"><?php echo number_format($activePlans); ?></div>
        <div class="stat-label">Active Plans</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-line" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19l16 0" /><path d="M4 15l4 -6l4 2l4 -5l4 4" /></svg>
        </div>
        <div class="stat-value"><?php echo $successRate; ?>%</div>
        <div class="stat-label">Weekly Active Rate</div>
    </div>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-content">
            <h3 class="card-title">User Growth Trend</h3>
            <div class="chart-container">
                <?php foreach ($userGrowth as $data): ?>
                <div class="chart-bar">
                    <div class="chart-bar-fill" style="height: <?php echo round(($data['count'] / $maxUsers) * 100); ?>%; background: #16a34a;"></div>
                    <span class="faq-answer"><?php echo $data['month']; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <h3 class="card-title">Goal Distribution</h3>
            <div class="grid grid-2">
                <?php
                $defaultGoals = ['weight_loss' => 'Weight Loss', 'maintain' => 'Maintain', 'gain_weight' => 'Gain Weight', 'build_muscle' => 'Build Muscle'];
                foreach ($defaultGoals as $key => $label):
                    $count = $goalDistribution[$key] ?? 0;
                    $pct = round(($count / $totalWithGoals) * 100);
                ?>
                <div class="feature-highlight"><?php echo $label; ?>: <?php echo $pct; ?>%</div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Recent Activity</h3>
        <div class="admin-activity-list">
            <?php foreach ($recentUsers as $u): ?>
            <div class="admin-activity-item">
                <div class="admin-activity-info">
                    <div class="admin-activity-dot"></div>
                    <div>
                        <p class="admin-activity-title">New <?php echo $u['role']; ?> registered</p>
                        <p class="admin-activity-subtitle"><?php echo htmlspecialchars($u['name']); ?></p>
                    </div>
                </div>
                <div class="admin-activity-meta">
                    <span class="status-badge"><?php echo $u['role']; ?></span>
                    <span class="admin-activity-time"><?php echo date('M j, g:i A', strtotime($u['created_at'])); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($recentUsers)): ?>
            <p style="text-align: center; color: #6b7280; padding: 1rem;">No recent activity</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>