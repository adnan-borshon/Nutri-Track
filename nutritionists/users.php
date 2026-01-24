<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
$currentUser = getCurrentUser();

$db = getDB();

// Get users assigned to this nutritionist
$stmt = $db->prepare("SELECT u.*, 
    (SELECT COUNT(*) FROM meal_logs WHERE user_id = u.id AND log_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)) as recent_activity,
    (SELECT MAX(log_date) FROM meal_logs WHERE user_id = u.id) as last_meal_log
    FROM users u 
    WHERE u.nutritionist_id = ? AND u.role = 'user'
    ORDER BY u.name ASC");
$stmt->execute([$currentUser['id']]);
$assignedUsers = $stmt->fetchAll();

// Helper function to get initials
function getInitials($name) {
    $parts = explode(' ', $name);
    $initials = '';
    foreach ($parts as $part) {
        $initials .= strtoupper(substr($part, 0, 1));
    }
    return substr($initials, 0, 2);
}

// Helper function for time ago
function timeAgo($datetime) {
    if (!$datetime) return 'Never';
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    return floor($diff / 86400) . ' days ago';
}

include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">My Users</h1>
        <p class="text-muted-foreground">Manage your assigned users and their progress</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search users..." id="userSearch" onkeyup="filterUsers()">
            </div>
        </div>
        <div class="card-content">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4" id="usersGrid">
                <?php if (empty($assignedUsers)): ?>
                <div style="grid-column: span 3; text-align: center; padding: 2rem; color: #6b7280;">
                    <p>No users assigned to you yet.</p>
                </div>
                <?php else: ?>
                <?php foreach ($assignedUsers as $u): ?>
                <div class="user-card" data-name="<?php echo strtolower(htmlspecialchars($u['name'])); ?>">
                    <div class="user-card-content">
                        <div class="user-avatar-large">
                            <?php if (!empty($u['profile_image']) && file_exists(__DIR__ . '/../' . $u['profile_image'])): ?>
                                <img src="../<?php echo htmlspecialchars($u['profile_image']); ?>" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                                <?php echo getInitials($u['name']); ?>
                            <?php endif; ?>
                        </div>
                        <h3 class="user-card-name"><?php echo htmlspecialchars($u['name']); ?></h3>
                        <p class="user-card-goal"><?php echo $u['goal'] ? ucwords(str_replace('_', ' ', $u['goal'])) . ' Goal' : 'No goal set'; ?></p>
                        <div class="user-card-stats">
                            <span class="progress-text">Activity: <?php echo $u['recent_activity']; ?> logs this week</span>
                            <span class="activity-text">Last active: <?php echo timeAgo($u['last_meal_log']); ?></span>
                        </div>
                        <div class="user-card-actions">
                            <a href="user-detail.php?id=<?php echo $u['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                            <a href="chat.php?user=<?php echo $u['id']; ?>" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function filterUsers() {
    const search = document.getElementById('userSearch').value.toLowerCase();
    const cards = document.querySelectorAll('.user-card');
    cards.forEach(card => {
        const name = card.dataset.name || '';
        card.style.display = name.includes(search) ? '' : 'none';
    });
}
</script>

<?php include 'footer.php'; ?>