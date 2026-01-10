<?php
$page_title = "Dashboard";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
include 'header.php';

$caloriesConsumed = 890;
$caloriesTarget = 1800;
$waterConsumed = 5;
$waterTarget = 8;
$sleepHours = 7.5;
$sleepTarget = 8;
$currentWeight = 81.7;

$todaysMeals = [
    ['type' => 'Breakfast', 'name' => 'Oatmeal with berries', 'calories' => 320, 'time' => '8:00 AM'],
    ['type' => 'Lunch', 'name' => 'Grilled chicken salad', 'calories' => 450, 'time' => '12:30 PM'],
    ['type' => 'Snack', 'name' => 'Greek yogurt', 'calories' => 120, 'time' => '3:00 PM']
];

$weightData = [81.7, 81.8, 82.0, 82.1, 82.4, 82.3, 82.5];
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Welcome back, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>!</h1>
        <p class="text-muted-foreground">Here's your health summary for today</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card hover-elevate">
            <div class="card-content">
                <div class="metric-header">
                    <div class="metric-icon calories">🔥</div>
                    <span class="metric-badge"><?php echo $caloriesTarget; ?> goal</span>
                </div>
                <p class="metric-value"><?php echo $caloriesConsumed; ?></p>
                <p class="metric-label">Calories consumed</p>
                <div class="progress-container">
                    <div class="progress-info">
                        <span><?php echo round(($caloriesConsumed / $caloriesTarget) * 100); ?>%</span>
                        <span><?php echo $caloriesTarget - $caloriesConsumed; ?> remaining</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo min(($caloriesConsumed / $caloriesTarget) * 100, 100); ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content text-center">
                <div class="progress-ring-container">
                    <svg class="progress-ring" width="100" height="100">
                        <circle cx="50" cy="50" r="40" stroke="#f3f4f6" stroke-width="8" fill="none"/>
                        <circle cx="50" cy="50" r="40" stroke="#06b6d4" stroke-width="8" fill="none" 
                                stroke-dasharray="<?php echo 2 * pi() * 40; ?>" 
                                stroke-dashoffset="<?php echo 2 * pi() * 40 * (1 - $waterConsumed / $waterTarget); ?>"/>
                    </svg>
                    <div class="progress-ring-content">
                        <div class="progress-ring-value"><?php echo $waterConsumed; ?></div>
                        <div class="progress-ring-unit">glasses</div>
                    </div>
                </div>
                <p class="metric-title">Water Intake</p>
                <p class="metric-subtitle"><?php echo $waterConsumed; ?> of <?php echo $waterTarget; ?> glasses</p>
                <a href="water.php" class="btn btn-outline btn-sm">➕ Add Water</a>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content text-center">
                <div class="progress-ring-container">
                    <svg class="progress-ring" width="100" height="100">
                        <circle cx="50" cy="50" r="40" stroke="#f3f4f6" stroke-width="8" fill="none"/>
                        <circle cx="50" cy="50" r="40" stroke="#8b5cf6" stroke-width="8" fill="none" 
                                stroke-dasharray="<?php echo 2 * pi() * 40; ?>" 
                                stroke-dashoffset="<?php echo 2 * pi() * 40 * (1 - $sleepHours / $sleepTarget); ?>"/>
                    </svg>
                    <div class="progress-ring-content">
                        <div class="progress-ring-value"><?php echo $sleepHours; ?></div>
                        <div class="progress-ring-unit">hours</div>
                    </div>
                </div>
                <p class="metric-title">Last Night's Sleep</p>
                <p class="metric-subtitle"><?php echo $sleepHours; ?> of <?php echo $sleepTarget; ?> hours</p>
                <a href="sleep.php" class="btn btn-outline btn-sm">🌙 Log Sleep</a>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content">
                <div class="metric-header">
                    <div class="metric-icon weight">⚖️</div>
                </div>
                <p class="metric-value"><?php echo $currentWeight; ?> kg</p>
                <p class="metric-label">Current weight</p>
                <p class="metric-trend positive">-0.8 kg this week</p>
                <a href="trends.php" class="btn btn-outline btn-sm full-width">View Trends</a>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <div class="card-header-content">
                    <h3 class="card-title">Today's Meals</h3>
                    <a href="meals.php" class="btn btn-ghost btn-sm gap-1">View all →</a>
                </div>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    <?php foreach ($todaysMeals as $meal): ?>
                        <div class="meal-item">
                            <div class="meal-icon">🍽️</div>
                            <div class="meal-details">
                                <div class="meal-header">
                                    <p class="meal-name"><?php echo $meal['name']; ?></p>
                                    <span class="meal-calories"><?php echo $meal['calories']; ?> cal</span>
                                </div>
                                <p class="meal-meta"><?php echo $meal['type']; ?> • <?php echo $meal['time']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <a href="meals.php" class="btn btn-primary full-width">➕ Log a Meal</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Weekly Weight Progress</h3>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <?php foreach ($weightData as $i => $weight): ?>
                        <div class="chart-bar">
                            <div class="chart-bar-fill" style="height: <?php echo ($weight - 81) * 50; ?>px; background: #16a34a;"></div>
                            <span class="chart-label"><?php echo ['M','T','W','T','F','S','S'][$i]; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-content">
            <div class="cta-content">
                <div>
                    <h3 class="cta-title">Need personalized guidance?</h3>
                    <p class="cta-description">Chat with your nutritionist for tailored advice</p>
                </div>
                <a href="chat.php" class="btn btn-primary">Chat with Nutritionist →</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>