<?php
$page_title = "Appointments";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
include 'header.php';

$appointments = [
    ['id' => '1', 'nutritionist' => 'Dr. Sarah Smith', 'date' => '2024-03-25', 'time' => '14:00', 'status' => 'confirmed'],
    ['id' => '2', 'nutritionist' => 'Dr. Sarah Smith', 'date' => '2024-03-18', 'time' => '10:00', 'status' => 'completed'],
    ['id' => '3', 'nutritionist' => 'Dr. Sarah Smith', 'date' => '2024-04-01', 'time' => '15:30', 'status' => 'pending']
];

$upcoming = array_filter($appointments, fn($a) => $a['status'] !== 'completed');
$past = array_filter($appointments, fn($a) => $a['status'] === 'completed');
?>

<div class="section">
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
        <div>
            <h1 class="section-title">Appointments</h1>
            <p class="section-description">Schedule and manage your consultations</p>
        </div>
        <button class="btn btn-primary">➕ Book Appointment</button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem;">
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card">
                <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 class="card-title">Upcoming Appointments</h3>
                </div>
                <div class="card-content">
                    <?php if (empty($upcoming)): ?>
                        <p class="card-description" style="text-align: center; padding: 2rem;">No upcoming appointments</p>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <?php foreach ($upcoming as $appointment): ?>
                                <div class="card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem;">
                                    <div class="team-avatar" style="width: 3rem; height: 3rem;">
                                        <?php echo strtoupper(substr($appointment['nutritionist'], 4, 1) . substr(explode(' ', $appointment['nutritionist'])[1], 0, 1)); ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <p class="card-title"><?php echo $appointment['nutritionist']; ?></p>
                                        <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: #6b7280;">
                                            <span>📅 <?php echo date('M j, Y', strtotime($appointment['date'])); ?></span>
                                            <span>🕒 <?php echo $appointment['time']; ?></span>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="recipe-category" style="background: <?php echo $appointment['status'] === 'confirmed' ? '#dcfce7' : '#f3f4f6'; ?>; color: <?php echo $appointment['status'] === 'confirmed' ? '#16a34a' : '#6b7280'; ?>; text-transform: capitalize;">
                                            <?php echo $appointment['status']; ?>
                                        </span>
                                        <?php if ($appointment['status'] === 'confirmed'): ?>
                                            <button class="btn btn-outline">📹 Join</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 class="card-title">Past Appointments</h3>
                </div>
                <div class="card-content">
                    <?php if (empty($past)): ?>
                        <p class="card-description" style="text-align: center; padding: 2rem;">No past appointments</p>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <?php foreach ($past as $appointment): ?>
                                <div class="card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; opacity: 0.75;">
                                    <div class="team-avatar" style="width: 3rem; height: 3rem;">
                                        <?php echo strtoupper(substr($appointment['nutritionist'], 4, 1) . substr(explode(' ', $appointment['nutritionist'])[1], 0, 1)); ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <p class="card-title"><?php echo $appointment['nutritionist']; ?></p>
                                        <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: #6b7280;">
                                            <span><?php echo date('M j, Y', strtotime($appointment['date'])); ?></span>
                                            <span><?php echo $appointment['time']; ?></span>
                                        </div>
                                    </div>
                                    <span class="recipe-tag">Completed</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Calendar</h3>
            </div>
            <div class="card-content">
                <div style="text-align: center; padding: 2rem; color: #6b7280;">
                    📅<br>
                    Calendar View<br>
                    <small>Select a date to view availability</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>