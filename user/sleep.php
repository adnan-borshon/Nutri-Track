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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
</svg>
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
                    <button class="btn btn-primary" style="">
<!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
</svg>  -->
Log Sleep</button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-3">
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>
            </div>
            <p class="stat-value"><?php echo number_format($weeklyAverage, 1); ?>h</p>
            <p class="stat-label">Weekly Average</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
</svg>
            </div>
            <p class="stat-value">+0.5h</p>
            <p class="stat-label">vs Last Week</p>
        </div>
        <div class="stat-card">
            <div style="font-size: 2rem; margin-bottom: 0.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
</svg>
            </div>
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