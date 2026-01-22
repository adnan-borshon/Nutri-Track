<?php
$page_title = "Trends";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
include 'header.php';

// Sample data - in real app, this would come from database
$weightData = [
    ['day' => 'Mon', 'value' => 82.5, 'date' => '2024-01-15'],
    ['day' => 'Tue', 'value' => 82.3, 'date' => '2024-01-16'],
    ['day' => 'Wed', 'value' => 82.4, 'date' => '2024-01-17'],
    ['day' => 'Thu', 'value' => 82.1, 'date' => '2024-01-18'],
    ['day' => 'Fri', 'value' => 82.0, 'date' => '2024-01-19'],
    ['day' => 'Sat', 'value' => 81.8, 'date' => '2024-01-20'],
    ['day' => 'Sun', 'value' => 81.7, 'date' => '2024-01-21']
];

$calorieData = [
    ['day' => 'Mon', 'value' => 1650, 'target' => 1800],
    ['day' => 'Tue', 'value' => 1720, 'target' => 1800],
    ['day' => 'Wed', 'value' => 1580, 'target' => 1800],
    ['day' => 'Thu', 'value' => 1800, 'target' => 1800],
    ['day' => 'Fri', 'value' => 1650, 'target' => 1800],
    ['day' => 'Sat', 'value' => 1750, 'target' => 1800],
    ['day' => 'Sun', 'value' => 1680, 'target' => 1800]
];

$waterData = [
    ['day' => 'Mon', 'value' => 2.1, 'target' => 2.5],
    ['day' => 'Tue', 'value' => 2.3, 'target' => 2.5],
    ['day' => 'Wed', 'value' => 1.8, 'target' => 2.5],
    ['day' => 'Thu', 'value' => 2.5, 'target' => 2.5],
    ['day' => 'Fri', 'value' => 2.2, 'target' => 2.5],
    ['day' => 'Sat', 'value' => 2.4, 'target' => 2.5],
    ['day' => 'Sun', 'value' => 2.0, 'target' => 2.5]
];

$sleepData = [
    ['day' => 'Mon', 'value' => 7.5, 'target' => 8],
    ['day' => 'Tue', 'value' => 8.2, 'target' => 8],
    ['day' => 'Wed', 'value' => 6.8, 'target' => 8],
    ['day' => 'Thu', 'value' => 8.0, 'target' => 8],
    ['day' => 'Fri', 'value' => 7.2, 'target' => 8],
    ['day' => 'Sat', 'value' => 8.5, 'target' => 8],
    ['day' => 'Sun', 'value' => 7.8, 'target' => 8]
];
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
        <div class="summary-value">81.7 kg</div>
        <div class="summary-label">Current Weight</div>
        <div class="summary-change negative">-0.8 kg this week</div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon calories">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
            </svg>
        </div>
        <div class="summary-value">1,680</div>
        <div class="summary-label">Avg Daily Calories</div>
        <div class="summary-change negative">-120 from target</div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon water">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
            </svg>
        </div>
        <div class="summary-value">2.2L</div>
        <div class="summary-label">Avg Water Intake</div>
        <div class="summary-change negative">-0.3L from target</div>
    </div>
    
    <div class="summary-card">
        <div class="summary-icon sleep">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
        </div>
        <div class="summary-value">7.7h</div>
        <div class="summary-label">Avg Sleep</div>
        <div class="summary-change negative">-0.3h from target</div>
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
                <select class="form-input">
                    <option value="csv">CSV (Excel Compatible)</option>
                    <option value="pdf">PDF Report</option>
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

function saveWeight() {
    const weight = document.getElementById('weightInput').value;
    const date = document.getElementById('weightDate').value;
    const notes = document.getElementById('weightNotes').value;
    
    if (!weight) {
        alert('Please enter your weight');
        return;
    }
    
    // In real app, this would save to database
    alert(`Weight logged: ${weight}kg on ${date}`);
    closeModal('weightModal');
    
    // Clear form
    document.getElementById('weightInput').value = '';
    document.getElementById('weightNotes').value = '';
}

function exportData() {
    const startDate = document.getElementById('exportStartDate').value;
    const endDate = document.getElementById('exportEndDate').value;
    
    if (!startDate || !endDate) {
        alert('Please select date range');
        return;
    }
    
    // In real app, this would generate and download the export
    alert(`Exporting data from ${startDate} to ${endDate}`);
    closeModal('exportModal');
}

function saveGoals() {
    // In real app, this would save goals to database
    alert('Goals updated successfully!');
    closeModal('goalsModal');
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