<?php
$page_title = "Trends";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
include 'header.php';

$weightData = [82.5, 82.3, 82.4, 82.1, 82.0, 81.8, 81.7];
$calorieData = [1650, 1720, 1580, 1800, 1650, 1750, 1680];
?>

<div class="section">
    <div>
        <h1 class="section-title">Health Trends</h1>
        <p class="section-description">Track your progress over time</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75L6 21l1.815-.75C8.118 20.015 9.528 19.75 11 19.75h2c1.472 0 2.882.265 4.185.75L19 21l-1.815-.75A11.448 11.448 0 0 0 13 20.25V3m-1 0h2m-2 0h-2m2 0V1.5a.75.75 0 0 1 1.5 0V3m-3 0V1.5a.75.75 0 0 0-1.5 0V3" />
</svg>
            </div>
            <p class="stat-value">-0.8 kg</p>
            <p class="stat-label">This Week</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
</svg>
            </div>
            <p class="stat-value">1,680</p>
            <p class="stat-label">Avg Calories</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
</svg>
            </div>
            <p class="stat-value">85%</p>
            <p class="stat-label">Goal Achievement</p>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Weight Progress</h3>
            </div>
            <div class="card-content">
                <div style="height: 200px; display: flex; align-items: end; justify-content: space-between; gap: 0.5rem;">
                    <?php foreach ($weightData as $i => $weight): ?>
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                            <div style="width: 20px; height: <?php echo ($weight - 81) * 50; ?>px; background: #16a34a; border-radius: 2px;"></div>
                            <span class="stat-label"><?php echo ['M','T','W','T','F','S','S'][$i]; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Calorie Intake</h3>
            </div>
            <div class="card-content">
                <div style="height: 200px; display: flex; align-items: end; justify-content: space-between; gap: 0.5rem;">
                    <?php foreach ($calorieData as $i => $calories): ?>
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                            <div style="width: 20px; height: <?php echo $calories / 10; ?>px; background: #f59e0b; border-radius: 2px;"></div>
                            <span class="stat-label"><?php echo ['M','T','W','T','F','S','S'][$i]; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>