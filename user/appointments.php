<?php
$page_title = "Appointments";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();

$db = getDB();

// Get all nutritionists for booking
$stmt = $db->query("SELECT id, name, specialty FROM users WHERE role = 'nutritionist' AND status = 'active' ORDER BY name");
$nutritionists = $stmt->fetchAll();

// Get user's appointments from database
$stmt = $db->prepare("SELECT a.*, u.name as nutritionist_name, u.specialty 
                      FROM appointments a 
                      JOIN users u ON a.nutritionist_id = u.id 
                      WHERE a.user_id = ? 
                      ORDER BY a.appointment_date DESC, a.appointment_time DESC");
$stmt->execute([$user['id']]);
$allAppointments = $stmt->fetchAll();

// Separate upcoming and past
$today = date('Y-m-d');
$upcoming = array_filter($allAppointments, fn($a) => $a['appointment_date'] >= $today && in_array($a['status'], ['confirmed', 'pending']));
$past = array_filter($allAppointments, fn($a) => $a['appointment_date'] < $today || in_array($a['status'], ['completed', 'cancelled']));

// Get appointments for calendar (current month)
$currentMonth = date('Y-m');
$stmt = $db->prepare("SELECT appointment_date, COUNT(*) as count FROM appointments WHERE user_id = ? AND appointment_date LIKE ? GROUP BY appointment_date");
$stmt->execute([$user['id'], $currentMonth . '%']);
$calendarAppointments = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

include 'header.php';
?>

<div class="section">
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
        <div>
            <h1 class="section-title">Appointments</h1>
            <p class="section-description">Schedule and manage your consultations</p>
        </div>
        <button class="btn btn-primary" id="bookAppointmentBtn">
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
                                <div class="card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem;" data-appointment-id="<?php echo $appointment['id']; ?>">
                                    <div class="team-avatar" style="width: 3rem; height: 3rem;">
                                        <?php echo strtoupper(substr($appointment['nutritionist_name'], 0, 1) . (strpos($appointment['nutritionist_name'], ' ') ? substr($appointment['nutritionist_name'], strpos($appointment['nutritionist_name'], ' ') + 1, 1) : '')); ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <p class="card-title"><?php echo htmlspecialchars($appointment['nutritionist_name']); ?></p>
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
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="recipe-category" style="background: <?php echo $appointment['status'] === 'confirmed' ? '#dcfce7' : '#f3f4f6'; ?>; color: <?php echo $appointment['status'] === 'confirmed' ? '#16a34a' : '#6b7280'; ?>; text-transform: capitalize;">
                                            <?php echo $appointment['status']; ?>
                                        </span>
                                        <button class="btn btn-outline" onclick="cancelAppointment(<?php echo $appointment['id']; ?>)" style="color:#ef4444;border-color:#ef4444;padding:0.25rem 0.5rem;font-size:0.75rem;">Cancel</button>
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
                                        <?php echo strtoupper(substr($appointment['nutritionist_name'], 0, 1) . (strpos($appointment['nutritionist_name'], ' ') ? substr($appointment['nutritionist_name'], strpos($appointment['nutritionist_name'], ' ') + 1, 1) : '')); ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <p class="card-title"><?php echo htmlspecialchars($appointment['nutritionist_name']); ?></p>
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
const nutritionists = <?php echo json_encode($nutritionists); ?>;

document.getElementById('bookAppointmentBtn').addEventListener('click', function() {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    
    let nutritionistOptions = '<option value="">Select Nutritionist</option>';
    nutritionists.forEach(n => {
        nutritionistOptions += `<option value="${n.id}">${n.name}${n.specialty ? ' - ' + n.specialty : ''}</option>`;
    });
    
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Book Appointment</h2>
                <button onclick="this.closest('.modal-overlay').remove()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="appointmentForm" class="form">
                    <div class="form-group">
                        <label class="form-label">Nutritionist</label>
                        <select class="form-input" name="nutritionist_id" id="nutritionistSelect" required>
                            ${nutritionistOptions}
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-input" name="date" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Time</label>
                            <select class="form-input" name="time" required>
                                <option value="">Select Time</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="16:00">4:00 PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reason for Visit</label>
                        <textarea class="form-textarea" name="reason" rows="3" placeholder="Brief description..."></textarea>
                    </div>
                    <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                        <button type="button" onclick="this.closest('.modal-overlay').remove()" class="btn btn-outline">Cancel</button>
                        <button type="submit" class="btn btn-primary">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    document.getElementById('appointmentForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'book_appointment');
        
        try {
            const response = await fetch('user_handler.php', { method: 'POST', body: formData });
            const data = await response.json();
            if (data.success) {
                showNotification(data.message, 'success');
                modal.remove();
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message || 'Failed to book appointment', 'error');
            }
        } catch (error) {
            showNotification('Failed to book appointment', 'error');
        }
    });
});

async function cancelAppointment(appointmentId) {
    if (!confirm('Are you sure you want to cancel this appointment?')) return;
    
    const formData = new FormData();
    formData.append('action', 'cancel_appointment');
    formData.append('appointment_id', appointmentId);
    
    try {
        const response = await fetch('user_handler.php', { method: 'POST', body: formData });
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
        background: ${type === 'success' ? '#278b63' : '#3b82f6'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>