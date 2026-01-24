<?php
require_once '../includes/session.php';
checkAuth('user');
$currentUser = getCurrentUser();

$db = getDB();

// Get current day of week
$currentDay = strtolower(date('l')); // e.g., 'sunday', 'monday', etc.

// Get user's active diet plan
$stmt = $db->prepare("SELECT dp.*, u.name as nutritionist_name 
                      FROM diet_plans dp 
                      JOIN users u ON dp.nutritionist_id = u.id 
                      WHERE dp.user_id = ? AND dp.status = 'active' 
                      ORDER BY dp.created_at DESC LIMIT 1");
$stmt->execute([$currentUser['id']]);
$dietPlan = $stmt->fetch();

$todayMeals = [];
if ($dietPlan) {
    // Debug: Check what we're looking for
    error_log("Diet Plan ID: " . $dietPlan['id']);
    error_log("Current Day: " . $currentDay);
    
    // Get today's meals only
    $stmt = $db->prepare("SELECT meal_type, meal_items 
                          FROM diet_plan_meals 
                          WHERE diet_plan_id = ? AND day_of_week = ?
                          ORDER BY FIELD(meal_type, 'breakfast', 'lunch', 'dinner', 'snack')");
    $stmt->execute([$dietPlan['id'], $currentDay]);
    $meals = $stmt->fetchAll();
    
    // Debug: Check what we found
    error_log("Meals found: " . count($meals));
    
    foreach ($meals as $meal) {
        $todayMeals[$meal['meal_type']] = $meal['meal_items'];
        error_log("Meal: " . $meal['meal_type'] . " = " . $meal['meal_items']);
    }
    
    // If no meals found for today, check if any meals exist at all
    if (empty($meals)) {
        $stmt = $db->prepare("SELECT day_of_week, meal_type, meal_items FROM diet_plan_meals WHERE diet_plan_id = ?");
        $stmt->execute([$dietPlan['id']]);
        $allMeals = $stmt->fetchAll();
        error_log("Total meals in plan: " . count($allMeals));
        foreach ($allMeals as $meal) {
            error_log("Available: " . $meal['day_of_week'] . " - " . $meal['meal_type']);
        }
    }
}

$mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];

include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Today's Meal Plan</h1>
        <p class="text-muted-foreground">Your meal schedule for <?= ucfirst($currentDay) ?></p>
    </div>

    <?php if (!$dietPlan): ?>
    <div class="card">
        <div class="card-content" style="text-align: center; padding: 3rem; color: #6b7280;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;margin:0 auto 1rem;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
            </svg>
            <p>No active meal plan yet. Your nutritionist will create one for you.</p>
        </div>
    </div>
    <?php else: ?>
    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 600;"><?= htmlspecialchars($dietPlan['name']) ?></h2>
            <p style="margin: 0.5rem 0 0; color: #6b7280; font-size: 0.875rem;">
                By <?= htmlspecialchars($dietPlan['nutritionist_name']) ?> • 
                <?= number_format($dietPlan['daily_calories']) ?> calories/day
            </p>
        </div>
        <div class="card-content">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <?php foreach ($mealTypes as $mealType): ?>
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.75rem; border: 1px solid #e5e7eb;">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <div style="width: 3rem; height: 3rem; background: #278b63; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" style="width:20px;height:20px;stroke-width:2;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
                            </svg>
                        </div>
                        <h4 style="margin: 0; text-transform: capitalize; font-weight: 600; color: #111827; font-size: 1.125rem;"><?= $mealType ?></h4>
                    </div>
                    <p style="margin: 0; color: #6b7280; font-size: 0.875rem; line-height: 1.6;">
                        <?= isset($todayMeals[$mealType]) && !empty($todayMeals[$mealType]) ? htmlspecialchars($todayMeals[$mealType]) : 'No meal planned for today' ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>