<?php
$page_title = "Dashboard";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
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
        <h1 class="text-3xl font-bold">Welcome back, <?php echo explode(' ', $user['name'])[0]; ?>!</h1>
        <p class="text-muted-foreground">Here's your health summary for today</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card hover-elevate">
            <div class="card-content">
                <div class="metric-header">
                    <div class="metric-icon calories">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
</svg>
                    </div>
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
                <a href="water.php" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Add Water</a>
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
                <a href="sleep.php" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
</svg> Log Sleep</a>
            </div>
        </div>

        <div class="card hover-elevate">
            <div class="card-content">
                <div class="metric-header">
                    <div class="metric-icon weight">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75L6 21l1.815-.75C8.118 20.015 9.528 19.75 11 19.75h2c1.472 0 2.882.265 4.185.75L19 21l-1.815-.75A11.448 11.448 0 0 0 13 20.25V3m-1 0h2m-2 0h-2m2 0V1.5a.75.75 0 0 1 1.5 0V3m-3 0V1.5a.75.75 0 0 0-1.5 0V3" />
</svg>
                    </div>
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
                            <div class="meal-icon">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
</svg>
                            </div>
                            <div class="meal-details">
                                <div class="meal-header">
                                    <p class="meal-name"><?php echo $meal['name']; ?></p>
                                    <span class="meal-calories"><?php echo $meal['calories']; ?> cal</span>
                                </div>
                                <p class="meal-meta"><?php echo $meal['type']; ?> • <?php echo $meal['time']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <a href="meals.php" class="btn btn-primary ">
<!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> -->
 Log a Meal</a>
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