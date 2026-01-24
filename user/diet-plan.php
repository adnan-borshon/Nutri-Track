<?php
$page_title = "Diet Plan";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();

$db = getDB();

// Get active diet plan from database
$stmt = $db->prepare("SELECT dp.*, u.name as nutritionist_name 
                      FROM diet_plans dp 
                      JOIN users u ON dp.nutritionist_id = u.id 
                      WHERE dp.user_id = ? AND dp.status = 'active' 
                      ORDER BY dp.created_at DESC LIMIT 1");
$stmt->execute([$user['id']]);
$plan = $stmt->fetch();

$hasPlan = !empty($plan);

if ($hasPlan) {
    // Get meal suggestions for this plan - check if table exists first
    $planMeals = [];
    try {
        $stmt = $db->prepare("SELECT dpm.*, f.name as food_name 
                              FROM diet_plan_meals dpm 
                              LEFT JOIN foods f ON dpm.food_id = f.id 
                              WHERE dpm.diet_plan_id = ? 
                              ORDER BY FIELD(dpm.meal_type, 'breakfast', 'lunch', 'snack', 'dinner')");
        $stmt->execute([$plan['id']]);
        $planMeals = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Table might not exist yet, continue with empty meals
        $planMeals = [];
    }
    
    // Organize meals by type
    $mealsByType = ['breakfast' => [], 'lunch' => [], 'snack' => [], 'dinner' => []];
    foreach ($planMeals as $meal) {
        $mealsByType[$meal['meal_type']][] = $meal['food_name'] ?: $meal['custom_food_name'];
    }
    
    $dietPlan = [
        'id' => $plan['id'],
        'name' => $plan['name'],
        'duration' => $plan['duration_weeks'] . ' weeks',
        'startDate' => $plan['start_date'],
        'nutritionist' => $plan['nutritionist_name'],
        'goals' => [
            ['label' => 'Daily Calories', 'value' => number_format($plan['daily_calories']), 'unit' => 'kcal'],
            ['label' => 'Protein', 'value' => $plan['protein_goal'], 'unit' => 'g'],
            ['label' => 'Carbs', 'value' => $plan['carbs_goal'], 'unit' => 'g'],
            ['label' => 'Fat', 'value' => $plan['fat_goal'], 'unit' => 'g']
        ],
        'meals' => [
            ['time' => 'Breakfast', 'icon' => '🌅', 'items' => $mealsByType['breakfast'] ?: ['No items specified']],
            ['time' => 'Lunch', 'icon' => '☀️', 'items' => $mealsByType['lunch'] ?: ['No items specified']],
            ['time' => 'Snack', 'icon' => '🍎', 'items' => $mealsByType['snack'] ?: ['No items specified']],
            ['time' => 'Dinner', 'icon' => '🌙', 'items' => $mealsByType['dinner'] ?: ['No items specified']]
        ]
    ];
}

include 'header.php';
?>

<div class="page-header">
    <div>
        <h1 class="section-title">My Diet Plan</h1>
        <p class="section-description">Your personalized nutrition roadmap to success</p>
    </div>
    <?php if ($hasPlan): ?>
    <div>
        <button class="btn btn-outline" onclick="requestChanges()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
            </svg>
            Request Changes
        </button>
        <button class="btn btn-primary" onclick="generateShoppingList()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            Shopping List
        </button>
    </div>
    <?php endif; ?>
</div>

<?php if ($hasPlan): ?>
    <!-- Current Plan Overview -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-content">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <div class="diet-plan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;stroke-width:1.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="diet-plan-title"><?php echo $dietPlan['name']; ?></h2>
                    <p class="diet-plan-description">Created by <?php echo $dietPlan['nutritionist']; ?> • <?php echo $dietPlan['duration']; ?> program</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Nutrition Goals -->
    <div style="margin-bottom: 2rem;">
        <h3 style="font-weight: 600; margin-bottom: 1rem; color: #374151;">Daily Nutrition Goals</h3>
        <div class="nutrition-goals">
            <?php foreach ($dietPlan['goals'] as $goal): ?>
                <div class="goal-card">
                    <div class="goal-value"><?php echo $goal['value']; ?></div>
                    <div class="goal-label"><?php echo $goal['label']; ?> (<?php echo $goal['unit']; ?>)</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Daily Meal Schedule -->
    <div style="margin-bottom: 2rem;">
        <h3 style="font-weight: 600; margin-bottom: 1rem; color: #374151;">Today's Meal Schedule</h3>
        <div class="meal-schedule">
            <?php foreach ($dietPlan['meals'] as $meal): ?>
                <div class="meal-time-card">
                    <div class="meal-time-header">
                        <div class="meal-time-icon"><?php echo $meal['icon']; ?></div>
                        <div class="meal-time-title"><?php echo $meal['time']; ?></div>
                    </div>
                    <div class="meal-items">
                        <?php foreach ($meal['items'] as $item): ?>
                            <div class="meal-item"><?php echo $item; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-3" style="gap: 1rem;">
        <div class="diet-plan-card" onclick="viewAlternatives()">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;stroke-width:1.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                </div>
                <h4 class="diet-plan-title">Meal Alternatives</h4>
                <p class="diet-plan-description">View alternative meal options for variety</p>
            </div>
        </div>
        
        <div class="diet-plan-card" onclick="viewProgress()">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;stroke-width:1.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
                <h4 class="diet-plan-title">Track Progress</h4>
                <p class="diet-plan-description">Monitor your adherence to the plan</p>
            </div>
        </div>
        
        <div class="diet-plan-card" onclick="viewHistory()">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;stroke-width:1.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h4 class="diet-plan-title">Plan History</h4>
                <p class="diet-plan-description">View your previous diet plans</p>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- No Plan State -->
    <div class="cta">
        <div style="font-size: 4rem; margin-bottom: 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:64px;height:64px;stroke-width:1.5;color:#278b63;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
            </svg>
        </div>
        <h3 class="cta-title">No Diet Plan Yet</h3>
        <p class="cta-description">Schedule a consultation with a nutritionist to get your personalized diet plan.</p>
        <a href="appointments.php" class="btn btn-primary">Book Consultation</a>
    </div>
<?php endif; ?>

<script>
async function generateShoppingList() {
    try {
        const formData = new FormData();
        formData.append('action', 'get_shopping_list');
        
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        if (data.success && data.data && data.data.length > 0) {
            showShoppingListModal(data.data);
        } else {
            showNotification(data.message || 'No items in shopping list', 'error');
        }
    } catch (error) {
        showNotification('Failed to generate shopping list', 'error');
    }
}

function showShoppingListModal(items) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Shopping List</h2>
                <button onclick="this.closest('.modal-overlay').remove()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <ul style="list-style: none; padding: 0;">
                    ${items.map(item => `<li style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" style="width: 18px; height: 18px;">
                        <span>${item}</span>
                    </li>`).join('')}
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="this.closest('.modal-overlay').remove()">Close</button>
                <button class="btn btn-primary" onclick="printShoppingList()">Print List</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function printShoppingList() {
    window.print();
}

async function requestChanges() {
    const message = prompt('What changes would you like to request for your diet plan?');
    if (message === null) return;
    
    try {
        const formData = new FormData();
        formData.append('action', 'request_plan_change');
        formData.append('message', message);
        
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || 'Failed to send request', 'error');
        }
    } catch (error) {
        showNotification('Failed to send request', 'error');
    }
}

function showNotification(message, type) {
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

function viewAlternatives() {
    alert('Meal alternatives feature coming soon! This will show you alternative meal options.');
}

function viewProgress() {
    window.location.href = 'trends.php';
}

function viewHistory() {
    alert('Plan history feature coming soon! This will show your previous diet plans.');
}
</script>

<?php include 'footer.php'; ?>