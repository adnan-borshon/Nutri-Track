<?php
$page_title = "Trends";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();

$db = getDB();
$days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// Get user goals
$defaultGoals = [
    'target_weight' => 70,
    'daily_calories' => 2000,
    'daily_water' => 2.5,
    'sleep_goal' => 8,
    'weekly_weight_loss' => 0.5
];
$userGoals = $user['goal'] ? json_decode($user['goal'], true) : $defaultGoals;
if (!is_array($userGoals)) {
    $userGoals = $defaultGoals;
}
$userGoals = array_merge($defaultGoals, $userGoals);

// Get weight data for last 7 days
$stmt = $db->prepare("SELECT log_date, weight FROM weight_logs WHERE user_id = ? AND log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY log_date");
$stmt->execute([$user['id']]);
$weightRows = $stmt->fetchAll();
$weightData = [];
$latestWeight = $user['weight'] ?: 0;
foreach ($weightRows as $row) {
    $weightData[] = ['day' => $days[date('w', strtotime($row['log_date']))], 'value' => floatval($row['weight']), 'date' => $row['log_date']];
    $latestWeight = floatval($row['weight']);
}
if (empty($weightData)) {
    $weightData = [['day' => date('D'), 'value' => $latestWeight ?: 70, 'date' => date('Y-m-d')]];
}
$weightChange = count($weightData) > 1 ? round($weightData[count($weightData)-1]['value'] - $weightData[0]['value'], 1) : 0;

// Get calorie data for last 7 days
$stmt = $db->prepare("SELECT ml.log_date, SUM(f.calories * ml.servings) as total FROM meal_logs ml JOIN foods f ON ml.food_id = f.id WHERE ml.user_id = ? AND ml.log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY ml.log_date ORDER BY ml.log_date");
$stmt->execute([$user['id']]);
$calorieRows = $stmt->fetchAll();
$calorieData = [];
$calorieTarget = $userGoals['daily_calories'] ?: 2000;
$totalCalories = 0;
foreach ($calorieRows as $row) {
    $calorieData[] = ['day' => $days[date('w', strtotime($row['log_date']))], 'value' => intval($row['total']), 'target' => $calorieTarget];
    $totalCalories += intval($row['total']);
}
$avgCalories = count($calorieData) > 0 ? round($totalCalories / count($calorieData)) : 0;

// Get water data for last 7 days
$stmt = $db->prepare("SELECT log_date, glasses FROM water_logs WHERE user_id = ? AND log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY log_date");
$stmt->execute([$user['id']]);
$waterRows = $stmt->fetchAll();
$waterData = [];
$waterTarget = $userGoals['daily_water'] ?: 2.5;
$totalWater = 0;
foreach ($waterRows as $row) {
    $liters = round($row['glasses'] * 0.25, 1); // 1 glass = 250ml
    $waterData[] = ['day' => $days[date('w', strtotime($row['log_date']))], 'value' => $liters, 'target' => $waterTarget];
    $totalWater += $liters;
}
$avgWater = count($waterData) > 0 ? round($totalWater / count($waterData), 1) : 0;

// Get sleep data for last 7 days
$stmt = $db->prepare("SELECT log_date, hours FROM sleep_logs WHERE user_id = ? AND log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY log_date");
$stmt->execute([$user['id']]);
$sleepRows = $stmt->fetchAll();
$sleepData = [];
$sleepTarget = $userGoals['sleep_goal'] ?: 8;
$totalSleep = 0;
foreach ($sleepRows as $row) {
    $sleepData[] = ['day' => $days[date('w', strtotime($row['log_date']))], 'value' => floatval($row['hours']), 'target' => $sleepTarget];
    $totalSleep += floatval($row['hours']);
}
$avgSleep = count($sleepData) > 0 ? round($totalSleep / count($sleepData), 1) : 0;

include 'header.php';
?>

<div class="page-header">
    <div>
        <h1 class="section-title">Health Trends</h1>
        <p class="section-description">Track your progress and identify patterns</p>
    </div>
    <div class="trends-filters">
        <button class="filter-btn active" onclick="setTimeRange('week')">7 Days</button>
        <button class="filter-btn" onclick="setTimeRange('month')">30 Days</button>
        <button class="filter-btn" onclick="setTimeRange('quarter')">3 Months</button>
    </div>
</div>

<!-- Progress Summary -->
<div class="progress-summary">
    <div class="summary-card">
        <div class="summary-icon weight">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75L6 21l1.815-.75C8.118 20.015 9.528 19.75 11 19.75h2c1.472 0 2.882.265 4.185.75L19 21l-1.815-.75A11.448 11.448 0 0 0 13 20.25V3m-1 0h2m-2 0h-2m2 0V1.5a.75.75 0 0 1 1.5 0V3m-3 0V1.5a.75.75 0 0 0-1.5 0V3" />
            </svg>
        </div>
        <div class="summary-value"><?php echo $latestWeight; ?> kg</div>
        <div class="summary-label">Current Weight</div>
        <div class="summary-change <?php echo $weightChange <= 0 ? 'negative' : 'positive'; ?>"><?php echo ($weightChange >= 0 ? '+' : '') . $weightChange; ?> kg this week</div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon calories">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
            </svg>
        </div>
        <div class="summary-value"><?php echo number_format($avgCalories); ?></div>
        <div class="summary-label">Avg Daily Calories</div>
        <div class="summary-change <?php echo $avgCalories >= $calorieTarget ? 'positive' : 'negative'; ?>"><?php echo ($avgCalories >= $calorieTarget ? '+' : '') . ($avgCalories - $calorieTarget); ?> from target</div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon water">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
            </svg>
        </div>
        <div class="summary-value"><?php echo $avgWater; ?>L</div>
        <div class="summary-label">Avg Water Intake</div>
        <div class="summary-change <?php echo $avgWater >= $waterTarget ? 'positive' : 'negative'; ?>"><?php echo ($avgWater >= $waterTarget ? '+' : '') . round($avgWater - $waterTarget, 1); ?>L from target</div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon sleep">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
        </div>
        <div class="summary-value"><?php echo $avgSleep; ?>h</div>
        <div class="summary-label">Avg Sleep</div>
        <div class="summary-change <?php echo $avgSleep >= $sleepTarget ? 'positive' : 'negative'; ?>"><?php echo ($avgSleep >= $sleepTarget ? '+' : '') . round($avgSleep - $sleepTarget, 1); ?>h from target</div>
    </div>
</div>

<!-- Charts Grid -->
<div class="grid grid-2" style="gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Weight Chart -->
    <div class="trend-chart">
        <div class="trend-chart-header">
            <h3 class="trend-chart-title">Weight Progress</h3>
            <span class="trend-chart-value">-0.8 kg</span>
        </div>
        <div class="trend-chart-content">
            <div class="chart-bars">
                <?php foreach ($weightData as $data): ?>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" 
                             style="height: <?php echo ($data['value'] - 81) * 100; ?>px; background: #22c55e;" 
                             data-value="<?php echo $data['value']; ?>kg"></div>
                        <span class="chart-label"><?php echo $data['day']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Calories Chart -->
    <div class="trend-chart">
        <div class="trend-chart-header">
            <h3 class="trend-chart-title">Calorie Intake</h3>
            <span class="trend-chart-value">93%</span>
        </div>
        <div class="trend-chart-content">
            <div class="chart-bars">
                <?php foreach ($calorieData as $data): ?>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" 
                             style="height: <?php echo ($data['value'] / $data['target']) * 180; ?>px; background: #f59e0b;" 
                             data-value="<?php echo $data['value']; ?> cal"></div>
                        <span class="chart-label"><?php echo $data['day']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Water Chart -->
    <div class="trend-chart">
        <div class="trend-chart-header">
            <h3 class="trend-chart-title">Water Intake</h3>
            <span class="trend-chart-value">88%</span>
        </div>
        <div class="trend-chart-content">
            <div class="chart-bars">
                <?php foreach ($waterData as $data): ?>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" 
                             style="height: <?php echo ($data['value'] / $data['target']) * 180; ?>px; background: #3b82f6;" 
                             data-value="<?php echo $data['value']; ?>L"></div>
                        <span class="chart-label"><?php echo $data['day']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Sleep Chart -->
    <div class="trend-chart">
        <div class="trend-chart-header">
            <h3 class="trend-chart-title">Sleep Duration</h3>
            <span class="trend-chart-value">96%</span>
        </div>
        <div class="trend-chart-content">
            <div class="chart-bars">
                <?php foreach ($sleepData as $data): ?>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" 
                             style="height: <?php echo ($data['value'] / $data['target']) * 180; ?>px; background: #8b5cf6;" 
                             data-value="<?php echo $data['value']; ?>h"></div>
                        <span class="chart-label"><?php echo $data['day']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Insights Section -->
<div class="insights-grid">
    <div class="insights-card">
        <h3 class="insights-title">Weekly Insights</h3>
        <div class="insight-item">
            <div class="insight-icon success">✓</div>
            <div class="insight-text">Great job! You've been consistent with your weight loss this week.</div>
        </div>
        <div class="insight-item">
            <div class="insight-icon warning">!</div>
            <div class="insight-text">Your calorie intake is slightly below target. Consider adding healthy snacks.</div>
        </div>
        <div class="insight-item">
            <div class="insight-icon warning">!</div>
            <div class="insight-text">Water intake could be improved. Try setting hourly reminders.</div>
        </div>
        <div class="insight-item">
            <div class="insight-icon success">✓</div>
            <div class="insight-text">Sleep pattern is good! Keep maintaining your bedtime routine.</div>
        </div>
    </div>
    
    <div class="insights-card">
        <h3 class="insights-title">Quick Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <button class="btn btn-primary" onclick="openWeightModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Log Today's Weight
            </button>
            <button class="btn btn-outline" onclick="openExportModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Export Data
            </button>
            <button class="btn btn-outline" onclick="openGoalsModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                </svg>
                Update Goals
            </button>
        </div>
    </div>
</div>

<!-- Weight Logging Modal -->
<div id="weightModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Log Your Weight</h2>
            <button class="modal-close" onclick="closeModal('weightModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Current Weight (kg)</label>
                <input type="number" id="weightInput" class="form-input" placeholder="Enter your weight" step="0.1" min="30" max="300">
            </div>
            <div class="form-group">
                <label class="form-label">Date</label>
                <input type="date" id="weightDate" class="form-input" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Notes (Optional)</label>
                <textarea id="weightNotes" class="form-textarea" placeholder="Any notes about your weight today..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('weightModal')">Cancel</button>
            <button class="btn btn-primary" onclick="saveWeight()">Save Weight</button>
        </div>
    </div>
</div>

<!-- Export Data Modal -->
<div id="exportModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Export Health Data</h2>
            <button class="modal-close" onclick="closeModal('exportModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Date Range</label>
                <div class="form-row">
                    <input type="date" id="exportStartDate" class="form-input" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>">
                    <input type="date" id="exportEndDate" class="form-input" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Data to Export</label>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" checked> Weight Progress
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" checked> Calorie Intake
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" checked> Water Intake
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" checked> Sleep Data
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Export Format</label>
                <select class="form-input" id="exportFormat">
                    <option value="pdf">PDF Report</option>
                    <option value="csv">CSV (Excel Compatible)</option>
                    <option value="json">JSON Data</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('exportModal')">Cancel</button>
            <button class="btn btn-primary" onclick="exportData()">Export Data</button>
        </div>
    </div>
</div>

<!-- Goals Setting Modal -->
<div id="goalsModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Update Health Goals</h2>
            <button class="modal-close" onclick="closeModal('goalsModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Target Weight (kg)</label>
                <input type="number" class="form-input" placeholder="75" step="0.1" min="30" max="300">
            </div>
            <div class="form-group">
                <label class="form-label">Daily Calorie Target</label>
                <input type="number" class="form-input" placeholder="1800" step="50" min="1000" max="4000">
            </div>
            <div class="form-group">
                <label class="form-label">Daily Water Goal (Liters)</label>
                <input type="number" class="form-input" placeholder="2.5" step="0.1" min="1" max="5">
            </div>
            <div class="form-group">
                <label class="form-label">Sleep Goal (Hours)</label>
                <input type="number" class="form-input" placeholder="8" step="0.5" min="4" max="12">
            </div>
            <div class="form-group">
                <label class="form-label">Weekly Weight Loss Goal (kg)</label>
                <input type="number" class="form-input" placeholder="0.5" step="0.1" min="0.1" max="2">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('goalsModal')">Cancel</button>
            <button class="btn btn-primary" onclick="saveGoals()">Save Goals</button>
        </div>
    </div>
</div>

<script>
function setTimeRange(range) {
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Time range set to:', range);
}

function openWeightModal() {
    document.getElementById('weightModal').style.display = 'flex';
}

function openExportModal() {
    document.getElementById('exportModal').style.display = 'flex';
}

function openGoalsModal() {
    document.getElementById('goalsModal').style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

async function saveWeight() {
    const weight = document.getElementById('weightInput').value;
    const date = document.getElementById('weightDate').value;
    const notes = document.getElementById('weightNotes').value;
    
    if (!weight) {
        showNotification('Please enter your weight', 'error');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('action', 'log_weight');
        formData.append('weight', weight);
        formData.append('log_date', date);
        formData.append('notes', notes);
        
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
            closeModal('weightModal');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to log weight', 'error');
        }
    } catch (error) {
        showNotification('Failed to log weight', 'error');
    }
}

async function exportData() {
    const startDate = document.getElementById('exportStartDate').value;
    const endDate = document.getElementById('exportEndDate').value;
    
    if (!startDate || !endDate) {
        showNotification('Please select date range', 'error');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('action', 'export_data');
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);
        
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        const format = document.getElementById('exportFormat').value;
        
        if (data.success) {
            const allDates = new Set();
            data.data.weight.forEach(r => allDates.add(r.log_date));
            data.data.calories.forEach(r => allDates.add(r.log_date));
            data.data.water.forEach(r => allDates.add(r.log_date));
            data.data.sleep.forEach(r => allDates.add(r.log_date));
            const sortedDates = Array.from(allDates).sort();
            
            if (format === 'pdf') {
                // Generate PDF report
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>NutriTrack Health Report</title>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 40px; color: #333; }
                            h1 { color: #278b63; border-bottom: 2px solid #278b63; padding-bottom: 10px; }
                            h2 { color: #278b63; margin-top: 30px; }
                            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                            th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                            th { background: #278b63; color: white; }
                            tr:nth-child(even) { background: #f9f9f9; }
                            .summary { display: flex; gap: 20px; margin: 20px 0; }
                            .summary-box { flex: 1; background: #f0fdf4; padding: 15px; border-radius: 8px; text-align: center; }
                            .summary-value { font-size: 24px; font-weight: bold; color: #278b63; }
                            .summary-label { font-size: 12px; color: #666; }
                            .footer { margin-top: 40px; text-align: center; color: #888; font-size: 12px; }
                        </style>
                    </head>
                    <body>
                        <h1>NutriTrack Health Report</h1>
                        <p><strong>Date Range:</strong> ${startDate} to ${endDate}</p>
                        <p><strong>Generated:</strong> ${new Date().toLocaleDateString()}</p>
                        
                        <div class="summary">
                            <div class="summary-box">
                                <div class="summary-value">${data.data.weight.length}</div>
                                <div class="summary-label">Weight Entries</div>
                            </div>
                            <div class="summary-box">
                                <div class="summary-value">${data.data.calories.length}</div>
                                <div class="summary-label">Meal Days</div>
                            </div>
                            <div class="summary-box">
                                <div class="summary-value">${data.data.water.length}</div>
                                <div class="summary-label">Water Logs</div>
                            </div>
                            <div class="summary-box">
                                <div class="summary-value">${data.data.sleep.length}</div>
                                <div class="summary-label">Sleep Logs</div>
                            </div>
                        </div>
                        
                        <h2>Detailed Data</h2>
                        <table>
                            <thead>
                                <tr><th>Date</th><th>Weight (kg)</th><th>Calories</th><th>Water (glasses)</th><th>Sleep (hours)</th></tr>
                            </thead>
                            <tbody>
                                ${sortedDates.map(date => {
                                    const w = data.data.weight.find(r => r.log_date === date);
                                    const c = data.data.calories.find(r => r.log_date === date);
                                    const wa = data.data.water.find(r => r.log_date === date);
                                    const s = data.data.sleep.find(r => r.log_date === date);
                                    return '<tr><td>'+date+'</td><td>'+(w ? w.weight : '-')+'</td><td>'+(c ? c.total_calories : '-')+'</td><td>'+(wa ? wa.glasses : '-')+'</td><td>'+(s ? s.hours : '-')+'</td></tr>';
                                }).join('')}
                            </tbody>
                        </table>
                        
                        <div class="footer">
                            <p>Generated by NutriTrack - Your Personal Health Companion</p>
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
            } else if (format === 'json') {
                const blob = new Blob([JSON.stringify(data.data, null, 2)], { type: 'application/json' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `health_data_${startDate}_to_${endDate}.json`;
                a.click();
                window.URL.revokeObjectURL(url);
            } else {
                // CSV export
                let csv = 'Date,Weight (kg),Calories,Water (glasses),Sleep (hours)\n';
                sortedDates.forEach(date => {
                    const w = data.data.weight.find(r => r.log_date === date);
                    const c = data.data.calories.find(r => r.log_date === date);
                    const wa = data.data.water.find(r => r.log_date === date);
                    const s = data.data.sleep.find(r => r.log_date === date);
                    csv += `${date},${w ? w.weight : ''},${c ? c.total_calories : ''},${wa ? wa.glasses : ''},${s ? s.hours : ''}\n`;
                });
                
                const blob = new Blob([csv], { type: 'text/csv' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `health_data_${startDate}_to_${endDate}.csv`;
                a.click();
                window.URL.revokeObjectURL(url);
            }
            
            showNotification('Data exported successfully', 'success');
            closeModal('exportModal');
        } else {
            showNotification(data.message || 'Failed to export data', 'error');
        }
    } catch (error) {
        showNotification('Failed to export data', 'error');
    }
}

async function saveGoals() {
    const targetWeight = document.querySelector('#goalsModal input[placeholder="75"]').value;
    const dailyCalories = document.querySelector('#goalsModal input[placeholder="1800"]').value;
    const dailyWater = document.querySelector('#goalsModal input[placeholder="2.5"]').value;
    const sleepGoal = document.querySelector('#goalsModal input[placeholder="8"]').value;
    const weeklyWeightLoss = document.querySelector('#goalsModal input[placeholder="0.5"]').value;
    
    try {
        const formData = new FormData();
        formData.append('action', 'update_goals');
        formData.append('target_weight', targetWeight || 70);
        formData.append('daily_calories', dailyCalories || 2000);
        formData.append('daily_water', dailyWater || 2.5);
        formData.append('sleep_goal', sleepGoal || 8);
        formData.append('weekly_weight_loss', weeklyWeightLoss || 0.5);
        
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
            closeModal('goalsModal');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to update goals', 'error');
        }
    } catch (error) {
        showNotification('Failed to update goals', 'error');
    }
}

function showNotification(message, type) {
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

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.style.display = 'none';
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.style.display = 'none';
        });
    }
});
</script>

<?php include 'footer.php'; ?>