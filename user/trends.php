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
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">⚖️</div>
            <p class="stat-value">-0.8 kg</p>
            <p class="stat-label">This Week</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔥</div>
            <p class="stat-value">1,680</p>
            <p class="stat-label">Avg Calories</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📈</div>
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