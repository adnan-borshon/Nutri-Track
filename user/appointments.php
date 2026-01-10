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
        <button class="btn btn-primary">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Book Appointment</button>
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
                                            <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg> <?php echo date('M j, Y', strtotime($appointment['date'])); ?></span>
                                            <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg> <?php echo $appointment['time']; ?></span>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="recipe-category" style="background: <?php echo $appointment['status'] === 'confirmed' ? '#dcfce7' : '#f3f4f6'; ?>; color: <?php echo $appointment['status'] === 'confirmed' ? '#16a34a' : '#6b7280'; ?>; text-transform: capitalize;">
                                            <?php echo $appointment['status']; ?>
                                        </span>
                                        <?php if ($appointment['status'] === 'confirmed'): ?>
                                            <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
</svg> Join</button>
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;margin:0 auto 1rem;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg><br>
                    Calendar View<br>
                    <small>Select a date to view availability</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>