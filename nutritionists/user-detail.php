<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
$currentUser = getCurrentUser();

$userId = intval($_GET['id'] ?? 0);
if ($userId <= 0) {
    header('Location: users.php');
    exit;
}

$db = getDB();

// Get user details
$stmt = $db->prepare("SELECT * FROM users WHERE id = ? AND nutritionist_id = ? AND role = 'user'");
$stmt->execute([$userId, $currentUser['id']]);
$viewUser = $stmt->fetch();

if (!$viewUser) {
    header('Location: users.php');
    exit;
}

// Get user's diet plan
$stmt = $db->prepare("SELECT * FROM diet_plans WHERE user_id = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$userId]);
$dietPlan = $stmt->fetch();

// Get diet plan meals if plan exists
$planMeals = [];
if ($dietPlan) {
    $stmt = $db->prepare("SELECT dpm.*, f.name as food_name, f.calories 
                          FROM diet_plan_meals dpm 
                          LEFT JOIN foods f ON dpm.food_id = f.id 
                          WHERE dpm.diet_plan_id = ?");
    $stmt->execute([$dietPlan['id']]);
    $planMeals = $stmt->fetchAll();
}

// Organize meals by type
$mealsByType = ['breakfast' => [], 'lunch' => [], 'dinner' => [], 'snack' => []];
foreach ($planMeals as $meal) {
    $mealsByType[$meal['meal_type']][] = $meal;
}

// Get weight progress (last 8 weeks)
$stmt = $db->prepare("SELECT log_date, weight FROM weight_logs WHERE user_id = ? ORDER BY log_date DESC LIMIT 8");
$stmt->execute([$userId]);
$weightLogs = array_reverse($stmt->fetchAll());

// Calculate stats
$startWeight = $viewUser['weight'] ?: ($weightLogs[0]['weight'] ?? 0);
$currentWeight = end($weightLogs)['weight'] ?? $startWeight;
$weightLost = $startWeight - $currentWeight;
$targetWeight = 0;
if ($viewUser['goal']) {
    $goals = json_decode($viewUser['goal'], true);
    $targetWeight = $goals['target_weight'] ?? 0;
}
$progress = ($startWeight > 0 && $targetWeight > 0 && $startWeight != $targetWeight) 
    ? round((($startWeight - $currentWeight) / ($startWeight - $targetWeight)) * 100) 
    : 0;
$progress = max(0, min(100, $progress));

// Calculate weeks active
$stmt = $db->prepare("SELECT MIN(log_date) as first_log FROM meal_logs WHERE user_id = ?");
$stmt->execute([$userId]);
$firstLog = $stmt->fetch();
$weeksActive = $firstLog && $firstLog['first_log'] 
    ? ceil((time() - strtotime($firstLog['first_log'])) / (7 * 24 * 3600)) 
    : 0;

include 'header.php';
?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title"><?php echo htmlspecialchars($viewUser['name']); ?></h1>
            <p class="section-description"><?php echo $viewUser['goal'] ? ucwords(str_replace('_', ' ', $viewUser['goal'])) : 'No goal set'; ?> • Member since <?php echo date('M j, Y', strtotime($viewUser['created_at'])); ?></p>
        </div>
        <div class="admin-action-buttons">
            <a href="chat.php?user=<?php echo $userId; ?>" class="btn btn-primary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-message" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg> Chat
            </a>
            <button class="btn btn-outline" onclick="editUserPlan()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg> Edit Plan
            </button>
        </div>
    </div>
</div>

<div class="grid grid-3">
    <div class="stat-card">
        <div class="stat-value"><?php echo $progress; ?>%</div>
        <div class="stat-label">Goal Progress</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo $weightLost >= 0 ? '-' : '+'; ?><?php echo abs(round($weightLost, 1)); ?> kg</div>
        <div class="stat-label">Weight Change</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo $weeksActive; ?> weeks</div>
        <div class="stat-label">Time Active</div>
    </div>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-content">
            <h3 class="card-title">Personal Information</h3>
            <div class="contact-info">
                <div class="contact-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </div>
                <div class="contact-details">
                    <h4>Basic Info</h4>
                    <p>Age: <?php echo $viewUser['age'] ?: 'N/A'; ?> • Height: <?php echo $viewUser['height'] ? $viewUser['height'] . ' cm' : 'N/A'; ?> • Starting Weight: <?php echo $startWeight; ?> kg</p>
                    <p class="description">Current Weight: <?php echo $currentWeight; ?> kg • Target: <?php echo $targetWeight ?: 'Not set'; ?><?php echo $targetWeight ? ' kg' : ''; ?></p>
                </div>
            </div>
            
            <div class="contact-info">
                <div class="contact-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                </div>
                <div class="contact-details">
                    <h4>Contact</h4>
                    <p><?php echo htmlspecialchars($viewUser['email']); ?></p>
                    <p class="description"><?php echo $viewUser['phone'] ?: 'No phone provided'; ?></p>
                </div>
            </div>
            
            <div class="contact-info">
                <div class="contact-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-target" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 12m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0" /><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /></svg>
                </div>
                <div class="contact-details">
                    <h4>Goals</h4>
                    <p><?php echo $viewUser['goal'] ? ucwords(str_replace('_', ' ', $viewUser['goal'])) : 'No goal set'; ?></p>
                    <p class="description"><?php echo $viewUser['health_conditions'] ? 'Conditions: ' . htmlspecialchars($viewUser['health_conditions']) : 'No health conditions noted'; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <h3 class="card-title">Current Diet Plan</h3>
            <?php if ($dietPlan): ?>
            <div class="recipe-meta">
                <span>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-flame" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12c2 -2.96 0 -7 -1 -8c0 3.038 -1.773 4.741 -3 6c-1.226 1.26 -2 3.24 -2 5a6 6 0 1 0 12 0c0 -1.532 -1.056 -3.94 -2 -5c-1.786 2 -3.544 1.844 -4 2z" /></svg> <?php echo number_format($dietPlan['daily_calories']); ?> calories/day
                </span>
                <span>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-meat" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.62 8.382l1.966 -1.967a2 2 0 1 1 2.828 2.828l-1.966 1.967" /><path d="M10.5 11.5l-3.5 -3.5a2 2 0 1 1 2.828 -2.828l3.5 3.5" /><path d="M8 16l2 2" /><path d="M10.5 16.5l4.5 -4.5" /><path d="M12 18l2 2" /><path d="M16 12l-4.5 4.5" /><path d="M18 10l2 2" /><path d="M20 8l-8 8" /></svg> <?php echo htmlspecialchars($dietPlan['name']); ?>
                </span>
            </div>
            
            <div class="admin-activity-list">
                <?php 
                $mealIcons = [
                    'breakfast' => 'Breakfast',
                    'lunch' => 'Lunch', 
                    'dinner' => 'Dinner',
                    'snack' => 'Snacks'
                ];
                foreach ($mealIcons as $type => $label):
                    $items = $mealsByType[$type];
                    $itemNames = array_map(fn($m) => $m['food_name'] ?: $m['custom_food_name'], $items);
                    $totalCal = array_sum(array_column($items, 'calories'));
                ?>
                <div class="admin-activity-item">
                    <div class="admin-activity-info">
                        <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9"/></svg>
                        </div>
                        <div>
                            <p class="admin-activity-title"><?php echo $label; ?></p>
                            <p class="admin-activity-subtitle"><?php echo !empty($itemNames) ? implode(', ', $itemNames) : 'Not specified'; ?><?php echo $totalCal ? " • {$totalCal} cal" : ''; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="color: #6b7280; text-align: center; padding: 1rem;">No diet plan assigned yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Progress Chart</h3>
        
        <div class="chart-container">
            <?php 
            if (!empty($weightLogs)):
                $maxWeight = max(array_column($weightLogs, 'weight'));
                $minWeight = min(array_column($weightLogs, 'weight'));
                $range = $maxWeight - $minWeight ?: 1;
                foreach ($weightLogs as $i => $log):
                    $pct = 100 - (($log['weight'] - $minWeight) / $range * 50);
                    $color = $i < count($weightLogs) - 1 && $weightLogs[$i+1]['weight'] < $log['weight'] ? '#16a34a' : '#f59e0b';
            ?>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: <?php echo $pct; ?>%; background: <?php echo $color; ?>;"></div>
                <span class="faq-answer"><?php echo date('M j', strtotime($log['log_date'])); ?></span>
            </div>
            <?php endforeach; else: ?>
            <p style="color: #6b7280; text-align: center; padding: 1rem; grid-column: span 8;">No weight data logged yet.</p>
            <?php endif; ?>
        </div>
        
        <div class="admin-chart-legend">
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #16a34a;"></div>
                <span class="admin-legend-label">Weight (lbs)</span>
            </div>
        </div>
    </div>
</div>

<script>
function editUserPlan() {
    showNotification('Edit plan feature coming soon!', 'info');
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
    `;
    
    const colors = {
        success: '#278b63',
        error: '#dc2626',
        info: '#3b82f6'
    };
    
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>