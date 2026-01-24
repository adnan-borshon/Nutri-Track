<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
$currentUser = getCurrentUser();

$db = getDB();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'add_suggestion') {
        $title = trim($_POST['title'] ?? '');
        $mealType = $_POST['meal_type'] ?? '';
        $calories = intval($_POST['calories'] ?? 0);
        $prepTime = intval($_POST['prep_time'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        
        if (empty($title) || empty($mealType)) {
            echo json_encode(['success' => false, 'message' => 'Title and meal type are required']);
            exit;
        }
        
        try {
            $stmt = $db->prepare("INSERT INTO meal_suggestions (nutritionist_id, title, description, meal_type, calories, prep_time, tags) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$currentUser['id'], $title, $description, $mealType, $calories, $prepTime, $tags]);
            echo json_encode(['success' => true, 'message' => 'Suggestion added successfully']);
        } catch (PDOException $e) {
            error_log("Add suggestion error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error occurred']);
        }
        exit;
    }
    
    if ($_POST['action'] === 'delete_suggestion') {
        $id = intval($_POST['id'] ?? 0);
        try {
            $stmt = $db->prepare("DELETE FROM meal_suggestions WHERE id = ? AND nutritionist_id = ?");
            $stmt->execute([$id, $currentUser['id']]);
            echo json_encode(['success' => true, 'message' => 'Suggestion deleted']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        exit;
    }
}

// Fetch suggestions from database
$stmt = $db->prepare("SELECT * FROM meal_suggestions WHERE nutritionist_id = ? ORDER BY created_at DESC");
$stmt->execute([$currentUser['id']]);
$suggestions = $stmt->fetchAll();

include 'header.php';
?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Meal Suggestions</h1>
            <p class="section-description">Create personalized meal suggestions for your users</p>
        </div>
        <button class="btn btn-primary" onclick="showAddSuggestionModal()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Add Suggestion</button>
    </div>
</div>

<div class="grid grid-3">
    <?php if (empty($suggestions)): ?>
    <div style="grid-column: span 3; text-align: center; padding: 3rem; color: #6b7280;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;margin:0 auto 1rem;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
        </svg>
        <p>No meal suggestions yet. Click "Add Suggestion" to create your first one!</p>
    </div>
    <?php else: ?>
    <?php foreach ($suggestions as $s): ?>
    <div class="recipe-card" data-id="<?php echo $s['id']; ?>">
        <div class="recipe-image">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
</svg>
        </div>
        <div class="recipe-content">
            <span class="recipe-category"><?php echo ucfirst($s['meal_type']); ?></span>
            <h3 class="recipe-title"><?php echo htmlspecialchars($s['title']); ?></h3>
            <p class="recipe-description"><?php echo htmlspecialchars($s['description']); ?></p>
            <div class="recipe-meta">
                <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg> <?php echo $s['prep_time']; ?> min</span>
                <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
</svg> <?php echo $s['calories']; ?> cal</span>
            </div>
            <?php if ($s['tags']): ?>
            <div class="recipe-tags">
                <?php foreach (explode(',', $s['tags']) as $tag): ?>
                <span class="recipe-tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <button class="btn btn-outline btn-sm" style="margin-top: 0.5rem;" onclick="deleteSuggestion(<?php echo $s['id']; ?>)">Delete</button>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function showAddSuggestionModal() {
    const modal = document.createElement('div');
    modal.className = 'admin-modal';
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;';
    
    modal.innerHTML = `
        <div class="admin-modal-content" style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 500px; width: 90%;">
            <div class="admin-modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Add Meal Suggestion</h3>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form id="addSuggestionForm">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Meal Name</label>
                    <input type="text" name="title" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Category</label>
                    <select name="meal_type" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        <option value="">Select Category</option>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Prep Time (min)</label>
                        <input type="number" name="prep_time" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Calories</label>
                        <input type="number" name="calories" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Description</label>
                    <textarea name="description" rows="2" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tags (comma separated)</label>
                    <input type="text" name="tags" placeholder="e.g. High Protein, Quick" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" onclick="closeModal()" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: 0.375rem; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Add Suggestion</button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    document.getElementById('addSuggestionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_suggestion');
        
        fetch('suggestions.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeModal();
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(() => showNotification('An error occurred', 'error'));
    });
}

function deleteSuggestion(id) {
    if (!confirm('Are you sure you want to delete this suggestion?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_suggestion');
    formData.append('id', id);
    
    fetch('suggestions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            document.querySelector(`.recipe-card[data-id="${id}"]`).remove();
        } else {
            showNotification(data.message, 'error');
        }
    });
}

function closeModal() {
    const modal = document.querySelector('.admin-modal');
    if (modal) {
        modal.remove();
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.375rem;
        color: white;
        font-weight: 500;
        z-index: 1001;
        max-width: 300px;
    `;
    
    const colors = {
        success: '#278b63',
        error: '#dc2626',
        info: '#3b82f6'
    };
    
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>