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

// Get diet plan meals organized by day and meal type
$planMeals = [];
if ($dietPlan) {
    // First try with day_of_week column
    $stmt = $db->prepare("SELECT * FROM diet_plan_meals WHERE diet_plan_id = ? ORDER BY id");
    $stmt->execute([$dietPlan['id']]);
    $planMeals = $stmt->fetchAll();
}

// Organize meals by day and type - handle different column structures
$mealsByDay = [];
$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
foreach ($days as $day) {
    $mealsByDay[$day] = ['breakfast' => [], 'lunch' => [], 'dinner' => [], 'snack' => []];
}

// Debug: Check what columns exist in the data
if (!empty($planMeals)) {
    $sampleMeal = $planMeals[0];
    // Handle different possible column names
    foreach ($planMeals as $meal) {
        // Try different day column names
        $day = strtolower($meal['day_of_week'] ?? $meal['day'] ?? 'monday');
        // Try different meal type column names  
        $type = strtolower($meal['meal_type'] ?? $meal['type'] ?? 'breakfast');
        
        // Ensure day and type are valid
        if (!in_array($day, $days)) $day = 'monday';
        if (!in_array($type, ['breakfast', 'lunch', 'dinner', 'snack'])) $type = 'breakfast';
        
        $mealsByDay[$day][$type][] = $meal;
    }
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
            <div class="recipe-meta" style="margin-bottom: 1rem;">
                <span>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-flame" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12c2 -2.96 0 -7 -1 -8c0 3.038 -1.773 4.741 -3 6c-1.226 1.26 -2 3.24 -2 5a6 6 0 1 0 12 0c0 -1.532 -1.056 -3.94 -2 -5c-1.786 2 -3.544 1.844 -4 2z" /></svg> <?php echo number_format($dietPlan['daily_calories'] ?? 0); ?> calories/day
                </span>
                <span>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-meat" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.62 8.382l1.966 -1.967a2 2 0 1 1 2.828 2.828l-1.966 1.967" /><path d="M10.5 11.5l-3.5 -3.5a2 2 0 1 1 2.828 -2.828l3.5 3.5" /><path d="M8 16l2 2" /><path d="M10.5 16.5l4.5 -4.5" /><path d="M12 18l2 2" /><path d="M16 12l-4.5 4.5" /><path d="M18 10l2 2" /><path d="M20 8l-8 8" /></svg> <?php echo htmlspecialchars($dietPlan['name'] ?? 'Diet Plan'); ?>
                </span>
            </div>
            
            <!-- Day Selection Tabs -->
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <?php 
                $dayLabels = [
                    'monday' => 'Mon',
                    'tuesday' => 'Tue', 
                    'wednesday' => 'Wed',
                    'thursday' => 'Thu',
                    'friday' => 'Fri',
                    'saturday' => 'Sat',
                    'sunday' => 'Sun'
                ];
                $firstDay = true;
                foreach ($dayLabels as $day => $dayLabel):
                    $hasAnyMeals = array_sum(array_map('count', $mealsByDay[$day])) > 0;
                    if ($hasAnyMeals):
                ?>
                <button onclick="showDay('<?php echo $day; ?>')" class="day-tab <?php echo $firstDay ? 'active' : ''; ?>" data-day="<?php echo $day; ?>" style="padding: 0.5rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; background: <?php echo $firstDay ? '#278b63' : 'white'; ?>; color: <?php echo $firstDay ? 'white' : '#374151'; ?>; cursor: pointer; font-size: 0.875rem; font-weight: 500;"><?php echo $dayLabel; ?></button>
                <?php $firstDay = false; endif; endforeach; ?>
            </div>
            
            <!-- Day Content -->
            <div id="dayContent">
                <?php 
                $mealLabels = [
                    'breakfast' => 'Breakfast',
                    'lunch' => 'Lunch',
                    'dinner' => 'Dinner',
                    'snack' => 'Snacks'
                ];
                $firstDayContent = true;
                foreach ($dayLabels as $day => $dayLabel):
                    $dayMeals = $mealsByDay[$day];
                    $hasAnyMeals = array_sum(array_map('count', $dayMeals)) > 0;
                    if ($hasAnyMeals):
                ?>
                <div class="day-content" data-day="<?php echo $day; ?>" style="display: <?php echo $firstDayContent ? 'block' : 'none'; ?>;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <?php foreach ($mealLabels as $type => $label):
                            $items = $dayMeals[$type];
                            if (!empty($items)):
                                $itemNames = array_map(function($m) {
                                    // The meal_items field contains the actual meal description
                                    return $m['meal_items'] ?? $m['food_name'] ?? $m['custom_food_name'] ?? $m['name'] ?? $m['item_name'] ?? $m['description'] ?? 'No meal specified';
                                }, $items);
                                $totalCal = array_sum(array_map(function($m) {
                                    return $m['calories'] ?? $m['calorie'] ?? $m['cal'] ?? 0;
                                }, $items));
                        ?>
                        <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; background: #f9fafb;">
                            <h5 style="margin: 0 0 0.5rem 0; color: #278b63; font-weight: 600; font-size: 0.875rem;"><?php echo $label; ?></h5>
                            <div style="font-size: 0.75rem; color: #6b7280; line-height: 1.4;">
                                <?php foreach ($itemNames as $item): ?>
                                <div style="margin-bottom: 0.25rem;">• <?php echo htmlspecialchars($item ?: 'No meal specified'); ?></div>
                                <?php endforeach; ?>
                                <?php if ($totalCal): ?>
                                <div style="margin-top: 0.5rem; font-weight: 500; color: #278b63;"><?php echo $totalCal; ?> calories</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; endforeach; ?>
                    </div>
                </div>
                <?php $firstDayContent = false; endif; endforeach; ?>
                <?php if (!array_sum(array_map(fn($day) => array_sum(array_map('count', $day)), $mealsByDay))): ?>
                <p style="color: #6b7280; text-align: center; padding: 1rem;">No meals planned yet.</p>
                <?php endif; ?>
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
function showDay(day) {
    // Hide all day contents
    document.querySelectorAll('.day-content').forEach(content => {
        content.style.display = 'none';
    });
    
    // Show selected day content
    const selectedContent = document.querySelector(`.day-content[data-day="${day}"]`);
    if (selectedContent) {
        selectedContent.style.display = 'block';
    }
    
    // Update tab styles
    document.querySelectorAll('.day-tab').forEach(tab => {
        tab.style.background = 'white';
        tab.style.color = '#374151';
        tab.classList.remove('active');
    });
    
    const selectedTab = document.querySelector(`.day-tab[data-day="${day}"]`);
    if (selectedTab) {
        selectedTab.style.background = '#278b63';
        selectedTab.style.color = 'white';
        selectedTab.classList.add('active');
    }
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