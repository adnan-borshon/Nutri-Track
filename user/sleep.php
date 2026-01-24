<?php
$page_title = "Sleep Tracking";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();

$db = getDB();
$today = date('Y-m-d');

// Get last night's sleep data
$stmt = $db->prepare("SELECT hours, quality FROM sleep_logs WHERE user_id = ? AND log_date = ?");
$stmt->execute([$user['id'], date('Y-m-d', strtotime('-1 day'))]);
$lastNightData = $stmt->fetch();
$lastNight = $lastNightData ? ['hours' => $lastNightData['hours'], 'quality' => $lastNightData['quality'] ?? 'good'] : ['hours' => 0, 'quality' => 'none'];

$target = 8;

// Get weekly data
$weeklyData = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $stmt = $db->prepare("SELECT hours FROM sleep_logs WHERE user_id = ? AND log_date = ?");
    $stmt->execute([$user['id'], $date]);
    $dayData = $stmt->fetch();
    $weeklyData[] = $dayData ? floatval($dayData['hours']) : 0;
}
$weeklyAverage = count(array_filter($weeklyData)) > 0 ? array_sum($weeklyData) / count(array_filter($weeklyData)) : 0;

include 'header.php';
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
                            <input type="number" id="sleepHours" step="0.5" min="0" max="24" placeholder="7.5" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sleep Quality</label>
                            <select id="sleepQuality" class="form-input">
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
                            <input type="time" id="bedtime" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Wake Time</label>
                            <input type="time" id="wakeTime" class="form-input">
                        </div>
                    </div>
                    <button class="btn btn-primary" id="logSleepBtn">Log Sleep</button>
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

<script>
document.getElementById('logSleepBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    const hours = document.getElementById('sleepHours').value;
    const quality = document.getElementById('sleepQuality').value;
    const bedtime = document.getElementById('bedtime').value;
    const wakeTime = document.getElementById('wakeTime').value;
    
    if (!hours) {
        showNotification('Please enter hours of sleep', 'error');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'log_sleep');
    formData.append('hours', hours);
    formData.append('quality', quality || 'good');
    formData.append('bedtime', bedtime);
    formData.append('wake_time', wakeTime);
    formData.append('log_date', new Date().toISOString().split('T')[0]);
    
    try {
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.success) {
            showNotification('Sleep logged successfully!', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to log sleep', 'error');
        }
    } catch (error) {
        showNotification('Failed to log sleep', 'error');
    }
});

function showNotification(message, type = 'info') {
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
</script>

<?php include 'footer.php'; ?>