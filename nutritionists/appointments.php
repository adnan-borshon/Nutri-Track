<?php
$page_title = "Appointments";
require_once '../includes/session.php';
checkAuth('nutritionist');
$user = getCurrentUser();

$db = getDB();
$nutritionistId = $user['id'];

// Get all appointments for this nutritionist
$stmt = $db->prepare("SELECT a.*, u.name as user_name, u.email as user_email, u.phone as user_phone 
                      FROM appointments a 
                      JOIN users u ON a.user_id = u.id 
                      WHERE a.nutritionist_id = ? 
                      ORDER BY a.appointment_date DESC, a.appointment_time DESC");
$stmt->execute([$nutritionistId]);
$allAppointments = $stmt->fetchAll();

// Separate appointments by status
$today = date('Y-m-d');
$pending = array_filter($allAppointments, fn($a) => $a['status'] === 'pending');
$upcoming = array_filter($allAppointments, fn($a) => $a['appointment_date'] >= $today && $a['status'] === 'confirmed');
$past = array_filter($allAppointments, fn($a) => $a['appointment_date'] < $today || in_array($a['status'], ['completed', 'cancelled']));

// Debug
echo "<!-- DEBUG: Total appointments: " . count($allAppointments) . " -->";
foreach ($allAppointments as $apt) {
    echo "<!-- DEBUG: ID={$apt['id']}, Status={$apt['status']}, Date={$apt['appointment_date']} -->";
}
echo "<!-- DEBUG: Pending: " . count($pending) . ", Upcoming: " . count($upcoming) . ", Past: " . count($past) . " -->";

// Get appointments for calendar (current month)
$currentMonth = date('Y-m');
$stmt = $db->prepare("SELECT appointment_date, COUNT(*) as count FROM appointments WHERE nutritionist_id = ? AND appointment_date LIKE ? GROUP BY appointment_date");
$stmt->execute([$nutritionistId, $currentMonth . '%']);
$calendarAppointments = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

include 'header.php';
?>

<div class="section">
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
        <div>
            <h1 class="section-title">Appointments</h1>
            <p class="section-description">Manage appointment requests and scheduled consultations</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem;">
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Pending Requests -->
            <div class="card">
                <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 class="card-title">Pending Requests (<?php echo count($pending); ?>)</h3>
                </div>
                <div class="card-content">
                    <?php if (empty($pending)): ?>
                        <p class="card-description" style="text-align: center; padding: 2rem;">No pending requests</p>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <?php foreach ($pending as $appointment): ?>
                                <div class="card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 2px solid #fbbf24;">
                                    <div class="team-avatar" style="width: 3rem; height: 3rem;">
                                        <?php echo strtoupper(substr($appointment['user_name'], 0, 1) . (strpos($appointment['user_name'], ' ') ? substr($appointment['user_name'], strpos($appointment['user_name'], ' ') + 1, 1) : '')); ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <p class="card-title"><?php echo htmlspecialchars($appointment['user_name']); ?></p>
                                        <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: #6b7280;">
                                            <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg> <?php echo date('M j, Y', strtotime($appointment['appointment_date'])); ?></span>
                                            <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg> <?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?></span>
                                        </div>
                                        <?php if ($appointment['reason']): ?>
                                            <p style="font-size: 0.875rem; color: #374151; margin-top: 0.5rem;"><strong>Reason:</strong> <?php echo htmlspecialchars($appointment['reason']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                        <button class="btn btn-primary" onclick="acceptAppointment(<?php echo $appointment['id']; ?>)" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Accept</button>
                                        <button class="btn btn-outline" onclick="rejectAppointment(<?php echo $appointment['id']; ?>)" style="color: #ef4444; border-color: #ef4444; padding: 0.25rem 0.5rem; font-size: 0.75rem;">Reject</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Upcoming Appointments -->
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
                                        <?php echo strtoupper(substr($appointment['user_name'], 0, 1) . (strpos($appointment['user_name'], ' ') ? substr($appointment['user_name'], strpos($appointment['user_name'], ' ') + 1, 1) : '')); ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <p class="card-title"><?php echo htmlspecialchars($appointment['user_name']); ?></p>
                                        <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: #6b7280;">
                                            <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg> <?php echo date('M j, Y', strtotime($appointment['appointment_date'])); ?></span>
                                            <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg> <?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?></span>
                                        </div>
                                        <?php if ($appointment['reason']): ?>
                                            <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;"><?php echo htmlspecialchars($appointment['reason']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="recipe-category" style="background: #dcfce7; color: #16a34a; text-transform: capitalize;">
                                            <?php echo $appointment['status']; ?>
                                        </span>
                                        <button class="btn btn-primary" onclick="completeAppointment(<?php echo $appointment['id']; ?>)" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Complete</button>
                                        <button class="btn btn-outline" onclick="cancelAppointment(<?php echo $appointment['id']; ?>)" style="color: #ef4444; border-color: #ef4444; padding: 0.25rem 0.5rem; font-size: 0.75rem;">Cancel</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Past Appointments -->
            <div class="card">
                <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 class="card-title">Past Appointments</h3>
                </div>
                <div class="card-content">
                    <?php if (empty($past)): ?>
                        <p class="card-description" style="text-align: center; padding: 2rem;">No past appointments</p>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <?php foreach (array_slice($past, 0, 5) as $appointment): ?>
                                <div class="card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; opacity: 0.75;">
                                    <div class="team-avatar" style="width: 3rem; height: 3rem;">
                                        <?php echo strtoupper(substr($appointment['user_name'], 0, 1) . (strpos($appointment['user_name'], ' ') ? substr($appointment['user_name'], strpos($appointment['user_name'], ' ') + 1, 1) : '')); ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <p class="card-title"><?php echo htmlspecialchars($appointment['user_name']); ?></p>
                                        <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: #6b7280;">
                                            <span><?php echo date('M j, Y', strtotime($appointment['appointment_date'])); ?></span>
                                            <span><?php echo date('g:i A', strtotime($appointment['appointment_time'])); ?></span>
                                        </div>
                                    </div>
                                    <span class="recipe-tag"><?php echo ucfirst($appointment['status']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="card">
            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                <h3 class="card-title">Calendar - <?php echo date('F Y'); ?></h3>
            </div>
            <div class="card-content">
                <div id="calendarGrid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; text-align: center;">
                    <?php
                    $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    foreach ($daysOfWeek as $day) {
                        echo "<div style='padding: 0.5rem; font-weight: 600; font-size: 0.75rem; color: #6b7280;'>$day</div>";
                    }
                    
                    $firstDay = date('w', strtotime(date('Y-m-01')));
                    $daysInMonth = date('t');
                    $currentDay = date('j');
                    
                    for ($i = 0; $i < $firstDay; $i++) {
                        echo "<div style='padding: 0.5rem;'></div>";
                    }
                    
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $dateStr = date('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
                        $hasAppointment = isset($calendarAppointments[$dateStr]);
                        $isToday = $day == $currentDay;
                        $bgColor = $isToday ? '#278b63' : ($hasAppointment ? '#dcfce7' : 'transparent');
                        $textColor = $isToday ? 'white' : '#374151';
                        echo "<div style='padding: 0.5rem; border-radius: 0.25rem; background: $bgColor; color: $textColor; font-size: 0.875rem; cursor: pointer;' onclick=\"selectDate('$dateStr')\">$day" . ($hasAppointment ? '<span style="display:block;font-size:0.6rem;color:#16a34a;">•</span>' : '') . "</div>";
                    }
                    ?>
                </div>
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb; font-size: 0.75rem; color: #6b7280;">
                    <span style="display: inline-block; width: 10px; height: 10px; background: #278b63; border-radius: 50%; margin-right: 4px;"></span> Today
                    <span style="display: inline-block; width: 10px; height: 10px; background: #dcfce7; border-radius: 50%; margin-left: 1rem; margin-right: 4px;"></span> Has Appointment
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function acceptAppointment(appointmentId) {
    if (!confirm('Accept this appointment request?')) return;
    
    const formData = new FormData();
    formData.append('action', 'update_appointment_status');
    formData.append('appointment_id', appointmentId);
    formData.append('status', 'confirmed');
    
    try {
        const response = await fetch('nutritionist_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        console.log('Response:', data); // Debug
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to accept appointment', 'error');
        }
    } catch (error) {
        console.error('Error:', error); // Debug
        showNotification('Failed to accept appointment', 'error');
    }
}

async function rejectAppointment(appointmentId) {
    if (!confirm('Reject this appointment request?')) return;
    
    const formData = new FormData();
    formData.append('action', 'update_appointment_status');
    formData.append('appointment_id', appointmentId);
    formData.append('status', 'cancelled');
    
    try {
        const response = await fetch('nutritionist_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to reject appointment', 'error');
        }
    } catch (error) {
        showNotification('Failed to reject appointment', 'error');
    }
}

async function completeAppointment(appointmentId) {
    if (!confirm('Mark this appointment as completed?')) return;
    
    const formData = new FormData();
    formData.append('action', 'update_appointment_status');
    formData.append('appointment_id', appointmentId);
    formData.append('status', 'completed');
    
    try {
        const response = await fetch('nutritionist_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to update appointment', 'error');
        }
    } catch (error) {
        showNotification('Failed to update appointment', 'error');
    }
}

async function cancelAppointment(appointmentId) {
    if (!confirm('Are you sure you want to cancel this appointment?')) return;
    
    const formData = new FormData();
    formData.append('action', 'update_appointment_status');
    formData.append('appointment_id', appointmentId);
    formData.append('status', 'cancelled');
    
    try {
        const response = await fetch('nutritionist_handler.php', { method: 'POST', body: formData });
        const data = await response.json();
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to cancel appointment', 'error');
        }
    } catch (error) {
        showNotification('Failed to cancel appointment', 'error');
    }
}

function selectDate(dateStr) {
    console.log('Selected date:', dateStr);
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
        border-radius: 0.375rem; color: white; font-weight: 500; z-index: 1000;
        background: ${type === 'success' ? '#278b63' : '#ef4444'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>