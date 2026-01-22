<?php
$page_title = "Meal Log";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
include 'header.php';

$mockFoods = [
    ['id' => '1', 'name' => 'Chicken Breast', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fat' => 3.6],
    ['id' => '2', 'name' => 'Brown Rice', 'calories' => 216, 'protein' => 5, 'carbs' => 45, 'fat' => 1.8],
    ['id' => '3', 'name' => 'Broccoli', 'calories' => 55, 'protein' => 3.7, 'carbs' => 11, 'fat' => 0.6],
    ['id' => '4', 'name' => 'Greek Yogurt', 'calories' => 100, 'protein' => 17, 'carbs' => 6, 'fat' => 0.7],
    ['id' => '5', 'name' => 'Salmon', 'calories' => 208, 'protein' => 20, 'carbs' => 0, 'fat' => 13],
    ['id' => '6', 'name' => 'Oatmeal', 'calories' => 150, 'protein' => 5, 'carbs' => 27, 'fat' => 2.5],
    ['id' => '7', 'name' => 'Eggs (2)', 'calories' => 155, 'protein' => 13, 'carbs' => 1, 'fat' => 11],
    ['id' => '8', 'name' => 'Banana', 'calories' => 105, 'protein' => 1.3, 'carbs' => 27, 'fat' => 0.4]
];

$meals = [
    'breakfast' => [['name' => 'Oatmeal', 'calories' => 150, 'servings' => 1]],
    'lunch' => [['name' => 'Chicken Breast', 'calories' => 165, 'servings' => 1], ['name' => 'Broccoli', 'calories' => 55, 'servings' => 1]],
    'dinner' => [],
    'snack' => [['name' => 'Greek Yogurt', 'calories' => 100, 'servings' => 1]]
];

$totalCalories = 0;
foreach ($meals as $mealType => $items) {
    foreach ($items as $item) {
        $totalCalories += $item['calories'] * $item['servings'];
    }
}

function getMealCalories($mealItems) {
    $total = 0;
    foreach ($mealItems as $item) {
        $total += $item['calories'] * $item['servings'];
    }
    return $total;
}
?>

<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="text-3xl font-bold">Meal Log</h1>
            <p class="text-muted-foreground">Track your daily food intake</p>
        </div>
        <div class="calories-summary">
            <div class="summary-item">
                <p class="summary-value"><?php echo $totalCalories; ?></p>
                <p class="summary-label">calories today</p>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-item">
                <p class="summary-value positive"><?php echo 1800 - $totalCalories; ?></p>
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
                            <button class="btn-add-meal">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="meal-items">
                        <?php if (empty($items)): ?>
                            <p class="empty-meal">No items logged</p>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <div class="logged-meal-item">
                                    <span class="meal-emoji">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
</svg>
                                    </span>
                                    <div class="logged-meal-details">
                                        <p class="logged-meal-name"><?php echo $item['name']; ?></p>
                                        <p class="logged-meal-info">
                                            <?php echo $item['servings']; ?> serving<?php echo $item['servings'] > 1 ? 's' : ''; ?> • <?php echo $item['calories'] * $item['servings']; ?> cal
                                        </p>
                                    </div>
                                    <button class="btn-remove-meal">
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
        </div>
        <div class="card-content">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach (array_slice($mockFoods, 0, 8) as $food): ?>
                    <button class="food-item-btn">
                        <div class="food-item-header">
                            <span class="food-name"><?php echo $food['name']; ?></span>
                            <span class="food-calories"><?php echo $food['calories']; ?> cal</span>
                        </div>
                        <p class="food-macros">
                            P: <?php echo $food['protein']; ?>g • C: <?php echo $food['carbs']; ?>g • F: <?php echo $food['fat']; ?>g
                        </p>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>