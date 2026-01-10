<?php
$page_title = "Sleep Tracking";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
include 'header.php';

$lastNight = ['hours' => 7.5, 'quality' => 'good'];
$target = 8;
$weeklyData = [7, 6.5, 8, 7.5, 6, 9, 8.5];
$weeklyAverage = array_sum($weeklyData) / count($weeklyData);
?>

<div class="section">
    <div>
        <h1 class="section-title">Sleep Tracking</h1>
        <p class="section-description">Monitor your sleep patterns and quality</p>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div class="card-content" style="padding: 2rem; text-align: center;">
                <h3 class="card-title" style="margin-bottom: 1rem;">Last Night's Sleep</h3>
                <div style="width: 160px; height: 160px; margin: 0 auto 1rem; position: relative;">
                    <svg width="160" height="160" style="transform: rotate(-90deg);">
                        <circle cx="80" cy="80" r="60" stroke="#f3f4f6" stroke-width="10" fill="none"/>
                        <circle cx="80" cy="80" r="60" stroke="#8b5cf6" stroke-width="10" fill="none" 
                                stroke-dasharray="<?php echo 2 * pi() * 60; ?>" 
                                stroke-dashoffset="<?php echo 2 * pi() * 60 * (1 - $lastNight['hours'] / $target); ?>"/>
                    </svg>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                        <div class="stat-value"><?php echo $lastNight['hours']; ?></div>
                        <div class="stat-label">hours</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span>🌙</span>
                    <span class="card-title"><?php echo $lastNight['hours']; ?> hours</span>
                </div>
                <p class="card-title" style="text-transform: capitalize; color: #16a34a;"><?php echo $lastNight['quality']; ?> quality</p>
                <p class="card-description">
                    <?php echo $lastNight['hours'] >= $target ? 'You got enough sleep!' : number_format($target - $lastNight['hours'], 1) . ' hours below target'; ?>
                </p>
            </div>
        </div>

        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Log Sleep</h3>
            </div>
            <div class="card-content">
                <div class="form">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Hours of Sleep</label>
                            <input type="number" step="0.5" min="0" max="24" placeholder="7.5" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sleep Quality</label>
                            <select class="form-input">
                                <option value="">Select</option>
                                <option value="excellent">Excellent</option>
                                <option value="good">Good</option>
                                <option value="fair">Fair</option>
                                <option value="poor">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Bedtime</label>
                            <input type="time" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wake Time</label>
                            <input type="time" class="form-input">
                        </div>
                    </div>
                    <button class="btn btn-primary" style="width: 100%;">🌙 Log Sleep</button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-3">
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🕒</div>
            <p class="stat-value"><?php echo number_format($weeklyAverage, 1); ?>h</p>
            <p class="stat-label">Weekly Average</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📈</div>
            <p class="stat-value">+0.5h</p>
            <p class="stat-label">vs Last Week</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">☀️</div>
            <p class="stat-value">7 days</p>
            <p class="stat-label">Tracking Streak</p>
        </div>
    </div>

    <div class="card">
        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
            <h3 class="card-title">Weekly Sleep Pattern</h3>
        </div>
        <div class="card-content">
            <div style="height: 250px; display: flex; align-items: end; justify-content: space-between; gap: 1rem;">
                <?php foreach ($weeklyData as $i => $hours): ?>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1;">
                        <div style="width: 100%; height: <?php echo $hours * 25; ?>px; background: #8b5cf6; border-radius: 4px 4px 0 0; min-height: 4px;"></div>
                        <span class="stat-label"><?php echo ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$i]; ?></span>
                        <span class="recipe-tag"><?php echo $hours; ?>h</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>