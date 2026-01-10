<?php
$page_title = "Meal Log";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
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
                            <button class="btn-add-meal">➕</button>
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
                                    <span class="meal-emoji">🍽️</span>
                                    <div class="logged-meal-details">
                                        <p class="logged-meal-name"><?php echo $item['name']; ?></p>
                                        <p class="logged-meal-info">
                                            <?php echo $item['servings']; ?> serving<?php echo $item['servings'] > 1 ? 's' : ''; ?> • <?php echo $item['calories'] * $item['servings']; ?> cal
                                        </p>
                                    </div>
                                    <button class="btn-remove-meal">🗑️</button>
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