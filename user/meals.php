<?php
$page_title = "Meal Log";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();

$db = getDB();
$today = date('Y-m-d');

// Get foods from database
$stmt = $db->query("SELECT f.*, c.name as category_name FROM foods f LEFT JOIN food_categories c ON f.category_id = c.id ORDER BY f.name ASC LIMIT 16");
$foods = $stmt->fetchAll();

// Get today's meals from database
$stmt = $db->prepare("SELECT ml.*, f.name as food_name, f.calories, f.protein, f.carbs, f.fat 
                      FROM meal_logs ml 
                      JOIN foods f ON ml.food_id = f.id 
                      WHERE ml.user_id = ? AND ml.log_date = ?
                      ORDER BY FIELD(ml.meal_type, 'breakfast', 'lunch', 'dinner', 'snack'), ml.created_at");
$stmt->execute([$user['id'], $today]);
$mealLogs = $stmt->fetchAll();

// Organize meals by type
$meals = ['breakfast' => [], 'lunch' => [], 'dinner' => [], 'snack' => []];
$totalCalories = 0;
foreach ($mealLogs as $log) {
    $meals[$log['meal_type']][] = $log;
    $totalCalories += $log['calories'] * $log['servings'];
}

// Get user's calorie goal from diet plan
$stmt = $db->prepare("SELECT daily_calories FROM diet_plans WHERE user_id = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$user['id']]);
$plan = $stmt->fetch();
$calorieGoal = $plan ? $plan['daily_calories'] : 2000;

function getMealCalories($mealItems) {
    $total = 0;
    foreach ($mealItems as $item) {
        $total += $item['calories'] * $item['servings'];
    }
    return $total;
}

include 'header.php';
?>

<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="text-3xl font-bold">Meal Log</h1>
            <p class="text-muted-foreground">Track your daily food intake</p>
        </div>
        <div class="calories-summary">
            <div class="summary-item">
                <p class="summary-value" id="totalCalories"><?php echo $totalCalories; ?></p>
                <p class="summary-label">calories today</p>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-item">
                <p class="summary-value positive" id="remainingCalories"><?php echo $calorieGoal - $totalCalories; ?></p>
                <p class="summary-label">remaining</p>
            </div>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-6">
        <?php foreach ($meals as $mealType => $items): ?>
            <div class="card">
                <div class="card-header">
                    <div class="meal-header">
                        <h3 class="meal-type"><?php echo ucfirst($mealType); ?></h3>
                        <div class="meal-actions">
                            <span class="meal-calories-badge"><?php echo getMealCalories($items); ?> cal</span>
                            <button class="btn-add-meal" onclick="quickAddMeal('<?php echo $mealType; ?>')">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="meal-items" id="meal-<?php echo $mealType; ?>">
                        <?php if (empty($items)): ?>
                            <p class="empty-meal">No items logged</p>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <div class="logged-meal-item" data-meal-id="<?php echo $item['id']; ?>">
                                    <span class="meal-emoji">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
</svg>
                                    </span>
                                    <div class="logged-meal-details">
                                        <p class="logged-meal-name"><?php echo htmlspecialchars($item['food_name']); ?></p>
                                        <p class="logged-meal-info">
                                            <?php echo $item['servings']; ?> serving<?php echo $item['servings'] > 1 ? 's' : ''; ?> • <?php echo round($item['calories'] * $item['servings']); ?> cal
                                        </p>
                                    </div>
                                    <button class="btn-remove-meal" onclick="deleteMeal(<?php echo $item['id']; ?>, <?php echo round($item['calories'] * $item['servings']); ?>)">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#ef4444;">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Food</h3>
            <select id="mealTypeSelect" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
                <option value="snack">Snack</option>
            </select>
        </div>
        <div class="card-content">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php if (empty($foods)): ?>
                <p style="grid-column: span 4; text-align: center; color: #6b7280;">No foods in database. Import the schema first.</p>
                <?php else: ?>
                <?php foreach (array_slice($foods, 0, 8) as $food): ?>
                    <button class="food-item-btn" onclick="addMeal(<?php echo $food['id']; ?>, '<?php echo htmlspecialchars($food['name'], ENT_QUOTES); ?>', <?php echo $food['calories']; ?>)">
                        <div class="food-item-header">
                            <span class="food-name"><?php echo htmlspecialchars($food['name']); ?></span>
                            <span class="food-calories"><?php echo $food['calories']; ?> cal</span>
                        </div>
                        <p class="food-macros">
                            P: <?php echo $food['protein']; ?>g • C: <?php echo $food['carbs']; ?>g • F: <?php echo $food['fat']; ?>g
                        </p>
                    </button>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
const calorieGoal = <?php echo $calorieGoal; ?>;
let totalCalories = <?php echo $totalCalories; ?>;

function quickAddMeal(mealType) {
    document.getElementById('mealTypeSelect').value = mealType;
    document.querySelector('.card:has(#mealTypeSelect)').scrollIntoView({ behavior: 'smooth' });
}

async function addMeal(foodId, foodName, calories) {
    const mealType = document.getElementById('mealTypeSelect').value;
    
    try {
        const formData = new FormData();
        formData.append('action', 'log_meal');
        formData.append('food_id', foodId);
        formData.append('meal_type', mealType);
        formData.append('servings', 1);
        formData.append('log_date', new Date().toISOString().split('T')[0]);
        
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        if (data.success) {
            totalCalories += calories;
            document.getElementById('totalCalories').textContent = totalCalories;
            document.getElementById('remainingCalories').textContent = calorieGoal - totalCalories;
            showNotification(`${foodName} added to ${mealType}!`, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to add meal', 'error');
        }
    } catch (error) {
        showNotification('Failed to add meal', 'error');
    }
}

async function deleteMeal(mealId, calories) {
    if (!confirm('Remove this item?')) return;
    
    try {
        const formData = new FormData();
        formData.append('action', 'delete_meal');
        formData.append('meal_id', mealId);
        
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        if (data.success) {
            totalCalories -= calories;
            document.getElementById('totalCalories').textContent = totalCalories;
            document.getElementById('remainingCalories').textContent = calorieGoal - totalCalories;
            document.querySelector(`[data-meal-id="${mealId}"]`).remove();
            showNotification('Meal removed!', 'success');
        } else {
            showNotification(data.message || 'Failed to remove meal', 'error');
        }
    } catch (error) {
        showNotification('Failed to remove meal', 'error');
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
        border-radius: 0.375rem; color: white; font-weight: 500; z-index: 1000;
        background: ${type === 'success' ? '#278b63' : type === 'error' ? '#dc2626' : '#3b82f6'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>