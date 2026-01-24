<?php
require_once '../includes/session.php';
checkAuth('admin');

$db = getDB();

// Get all users for selection
$stmt = $db->query("SELECT id, name, email FROM users WHERE role = 'user' ORDER BY name ASC");
$allUsers = $stmt->fetchAll();

// Check if a specific user is selected
$selectedUserId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$selectedUser = null;
$userReport = null;

if ($selectedUserId > 0) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ? AND role = 'user'");
    $stmt->execute([$selectedUserId]);
    $selectedUser = $stmt->fetch();
    
    if ($selectedUser) {
        // Get user-specific report data
        $stmt = $db->prepare("SELECT COUNT(*) FROM meal_logs WHERE user_id = ?");
        $stmt->execute([$selectedUserId]);
        $userMealLogs = $stmt->fetchColumn();
        
        $stmt = $db->prepare("SELECT COUNT(*) FROM water_logs WHERE user_id = ?");
        $stmt->execute([$selectedUserId]);
        $userWaterLogs = $stmt->fetchColumn();
        
        $stmt = $db->prepare("SELECT COUNT(*) FROM sleep_logs WHERE user_id = ?");
        $stmt->execute([$selectedUserId]);
        $userSleepLogs = $stmt->fetchColumn();
        
        $stmt = $db->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ?");
        $stmt->execute([$selectedUserId]);
        $userAppointments = $stmt->fetchColumn();
        
        $stmt = $db->prepare("SELECT AVG(calories) as avg_cal FROM (SELECT SUM(f.calories * ml.servings) as calories FROM meal_logs ml JOIN foods f ON ml.food_id = f.id WHERE ml.user_id = ? GROUP BY ml.log_date) as daily");
        $stmt->execute([$selectedUserId]);
        $avgCalories = round($stmt->fetchColumn() ?: 0);
        
        $userReport = [
            'meal_logs' => $userMealLogs,
            'water_logs' => $userWaterLogs,
            'sleep_logs' => $userSleepLogs,
            'appointments' => $userAppointments,
            'avg_calories' => $avgCalories
        ];
    }
}

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

<div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 class="section-title">Reports & Analytics</h1>
        <p class="section-description">Platform insights and performance metrics</p>
    </div>
    <div style="display: flex; gap: 0.75rem; align-items: center;">
        <select id="userSelect" onchange="window.location.href='reports.php' + (this.value ? '?user_id=' + this.value : '')" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; min-width: 200px;">
            <option value="">All Users Report</option>
            <?php foreach ($allUsers as $u): ?>
            <option value="<?php echo $u['id']; ?>" <?php echo $selectedUserId == $u['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($u['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button onclick="generatePDFReport()" class="btn btn-primary" style="white-space: nowrap;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;margin-right:4px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export PDF
        </button>
    </div>
</div>

<?php if ($selectedUser && $userReport): ?>
<div class="card" style="margin-bottom: 1.5rem; border-left: 4px solid #278b63;">
    <div class="card-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600;">Individual Report: <?php echo htmlspecialchars($selectedUser['name']); ?></h3>
            <a href="reports.php" style="color: #278b63; font-size: 0.875rem;">← Back to All Users</a>
        </div>
        <div class="stats" style="margin: 0;">
            <div class="stat-card" style="background: #f0fdf4;">
                <div class="stat-value" style="color: #278b63;"><?php echo $userReport['meal_logs']; ?></div>
                <div class="stat-label">Meal Logs</div>
            </div>
            <div class="stat-card" style="background: #eff6ff;">
                <div class="stat-value" style="color: #3b82f6;"><?php echo $userReport['water_logs']; ?></div>
                <div class="stat-label">Water Logs</div>
            </div>
            <div class="stat-card" style="background: #faf5ff;">
                <div class="stat-value" style="color: #8b5cf6;"><?php echo $userReport['sleep_logs']; ?></div>
                <div class="stat-label">Sleep Logs</div>
            </div>
            <div class="stat-card" style="background: #fef3c7;">
                <div class="stat-value" style="color: #f59e0b;"><?php echo $userReport['appointments']; ?></div>
                <div class="stat-label">Appointments</div>
            </div>
            <div class="stat-card" style="background: #fce7f3;">
                <div class="stat-value" style="color: #ec4899;"><?php echo number_format($userReport['avg_calories']); ?></div>
                <div class="stat-label">Avg Daily Cal</div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

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

<script>
function generatePDFReport() {
    const selectedUser = document.getElementById('userSelect').value;
    const userName = selectedUser ? document.getElementById('userSelect').options[document.getElementById('userSelect').selectedIndex].text : 'All Users';
    
    const printWindow = window.open('', '_blank');
    
    let individualUserSection = '';
    <?php if ($selectedUser && $userReport): ?>
    individualUserSection = `
        <h2>Individual User Report: <?php echo htmlspecialchars($selectedUser['name']); ?></h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($selectedUser['email']); ?></p>
        <p><strong>Registration Date:</strong> <?php echo date('M j, Y', strtotime($selectedUser['created_at'])); ?></p>
        <p><strong>Status:</strong> <?php echo ucfirst($selectedUser['status']); ?></p>
        <div class="stats">
            <div class="stat-box">
                <div class="stat-value"><?php echo $userReport['meal_logs']; ?></div>
                <div class="stat-label">Meal Logs</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?php echo $userReport['water_logs']; ?></div>
                <div class="stat-label">Water Logs</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?php echo $userReport['sleep_logs']; ?></div>
                <div class="stat-label">Sleep Logs</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?php echo $userReport['appointments']; ?></div>
                <div class="stat-label">Appointments</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?php echo number_format($userReport['avg_calories']); ?></div>
                <div class="stat-label">Avg Daily Calories</div>
            </div>
        </div>
    `;
    <?php endif; ?>
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>NutriTrack Admin Report</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 40px; color: #333; }
                h1 { color: #278b63; border-bottom: 2px solid #278b63; padding-bottom: 10px; }
                h2 { color: #278b63; margin-top: 30px; }
                .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
                .stats { display: flex; gap: 20px; margin: 20px 0; flex-wrap: wrap; }
                .stat-box { flex: 1; min-width: 120px; background: #f0fdf4; padding: 20px; border-radius: 8px; text-align: center; }
                .stat-value { font-size: 28px; font-weight: bold; color: #278b63; }
                .stat-label { font-size: 12px; color: #666; margin-top: 5px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background: #278b63; color: white; }
                tr:nth-child(even) { background: #f9f9f9; }
                .footer { margin-top: 40px; text-align: center; color: #888; font-size: 12px; border-top: 1px solid #ddd; padding-top: 20px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>NutriTrack Admin Report</h1>
                <div style="text-align: right;">
                    <p><strong>Report For:</strong> ${userName}</p>
                    <p><strong>Generated:</strong> ${new Date().toLocaleDateString()}</p>
                </div>
            </div>
            
            ${individualUserSection}
            
            ${individualUserSection ? '' : `
            <h2>Platform Statistics</h2>
            <div class="stats">
                <div class="stat-box">
                    <div class="stat-value"><?php echo $totalUsers; ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?php echo $totalNutritionists; ?></div>
                    <div class="stat-label">Nutritionists</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?php echo $activePlans; ?></div>
                    <div class="stat-label">Active Plans</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?php echo $successRate; ?>%</div>
                    <div class="stat-label">Weekly Active Rate</div>
                </div>
            </div>
            
            <h2>Goal Distribution</h2>
            <table>
                <thead><tr><th>Goal Type</th><th>Users</th><th>Percentage</th></tr></thead>
                <tbody>
                    <?php foreach ($defaultGoals as $key => $label): ?>
                    <tr>
                        <td><?php echo $label; ?></td>
                        <td><?php echo $goalDistribution[$key] ?? 0; ?></td>
                        <td><?php echo round((($goalDistribution[$key] ?? 0) / $totalWithGoals) * 100); ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <h2>Recent Registrations</h2>
            <table>
                <thead><tr><th>Name</th><th>Role</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach ($recentUsers as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['name']); ?></td>
                        <td><?php echo ucfirst($u['role']); ?></td>
                        <td><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            `}
            
            <div class="footer">
                <p>Generated by NutriTrack Admin Panel</p>
                <p>© <?php echo date('Y'); ?> NutriTrack - All Rights Reserved</p>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>

<?php include 'footer.php'; ?>