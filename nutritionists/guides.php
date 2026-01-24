<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
$currentUser = getCurrentUser();

$db = getDB();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'add_guide') {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $category = trim($_POST['category'] ?? 'General');
        $difficulty = $_POST['difficulty'] ?? 'beginner';
        $readTime = intval($_POST['read_time'] ?? 5);
        
        if (empty($title) || empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Title and content are required']);
            exit;
        }
        
        $imagePath = null;
        $imageUrl = trim($_POST['image_url'] ?? '');
        
        // Check if URL is provided first
        if (!empty($imageUrl) && filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            $imagePath = $imageUrl;
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/guides/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = uniqid() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $imagePath = 'uploads/guides/' . $fileName;
                }
            }
        }
        
        try {
            $stmt = $db->prepare("INSERT INTO nutrition_guides (nutritionist_id, title, content, image_path, category, difficulty, read_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$currentUser['id'], $title, $content, $imagePath, $category, $difficulty, $readTime]);
            echo json_encode(['success' => true, 'message' => 'Guide created successfully']);
        } catch (PDOException $e) {
            error_log("Add guide error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error occurred']);
        }
        exit;
    }
    
    if ($_POST['action'] === 'delete_guide') {
        $id = intval($_POST['id'] ?? 0);
        try {
            $stmt = $db->prepare("DELETE FROM nutrition_guides WHERE id = ? AND nutritionist_id = ?");
            $stmt->execute([$id, $currentUser['id']]);
            echo json_encode(['success' => true, 'message' => 'Guide deleted']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        exit;
    }
}

// Fetch guides from database
$stmt = $db->prepare("SELECT g.*, u.name as author_name FROM nutrition_guides g JOIN users u ON g.nutritionist_id = u.id WHERE g.nutritionist_id = ? ORDER BY g.created_at DESC");
$stmt->execute([$currentUser['id']]);
$guides = $stmt->fetchAll();

// Helper to get initials
function getGuideInitials($name) {
    $parts = explode(' ', $name);
    $initials = '';
    foreach ($parts as $part) {
        $initials .= strtoupper(substr($part, 0, 1));
    }
    return substr($initials, 0, 2);
}

// Category colors
$categoryColors = [
    'General' => ['bg' => '#dcfce7', 'text' => '#278b63'],
    'Beginner' => ['bg' => '#dcfce7', 'text' => '#278b63'],
    'Meal Planning' => ['bg' => '#fef3c7', 'text' => '#d97706'],
    'Hydration' => ['bg' => '#dbeafe', 'text' => '#3b82f6'],
    'Exercise' => ['bg' => '#fce7f3', 'text' => '#ec4899'],
    'Shopping' => ['bg' => '#f3e8ff', 'text' => '#8b5cf6'],
    'Weight Management' => ['bg' => '#fef2f2', 'text' => '#ef4444'],
];

include 'header.php';
?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Nutrition Guides</h1>
            <p class="section-description">Educational resources for your users</p>
        </div>
        <button class="btn btn-primary" onclick="showCreateGuideModal()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Create Guide</button>
    </div>
</div>

<div class="card" style="margin: 1rem;">
    <div class="card-content" style="padding: 0;">
        <?php if (empty($guides)): ?>
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;margin:0 auto 1rem;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            <p>No guides created yet. Click "Create Guide" to add your first one!</p>
        </div>
        <?php else: ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #374151;">Title</th>
                    <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #374151;">Category</th>
                    <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #374151;">Difficulty</th>
                    <th style="padding: 0.75rem 1rem; text-align: center; font-weight: 600; font-size: 0.875rem; color: #374151;">Read Time</th>
                    <th style="padding: 0.75rem 1rem; text-align: center; font-weight: 600; font-size: 0.875rem; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guides as $g): 
                    $colors = $categoryColors[$g['category']] ?? $categoryColors['General'];
                ?>
                <tr style="border-bottom: 1px solid #e5e7eb;" data-id="<?php echo $g['id']; ?>">
                    <td style="padding: 1rem;">
                        <div style="font-weight: 500; color: #111827;"><?php echo htmlspecialchars($g['title']); ?></div>
                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;"><?php echo htmlspecialchars(substr($g['content'], 0, 60)) . (strlen($g['content']) > 60 ? '...' : ''); ?></div>
                    </td>
                    <td style="padding: 1rem;">
                        <span style="background: <?php echo $colors['bg']; ?>; color: <?php echo $colors['text']; ?>; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;"><?php echo htmlspecialchars($g['category']); ?></span>
                    </td>
                    <td style="padding: 1rem; font-size: 0.875rem; color: #374151; text-transform: capitalize;"><?php echo htmlspecialchars($g['difficulty']); ?></td>
                    <td style="padding: 1rem; text-align: center; font-size: 0.875rem; color: #374151;"><?php echo $g['read_time']; ?> min</td>
                    <td style="padding: 1rem; text-align: center;">
                        <button onclick="deleteGuide(<?php echo $g['id']; ?>)" style="padding: 0.375rem 0.75rem; font-size: 0.75rem; background: #fef2f2; color: #dc2626; border: none; border-radius: 0.25rem; cursor: pointer;">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<script>
function showCreateGuideModal() {
    const modal = document.createElement('div');
    modal.className = 'admin-modal';
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;';
    
    modal.innerHTML = `
        <div style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Create Nutrition Guide</h3>
                <button onclick="closeGuideModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form id="addGuideForm" enctype="multipart/form-data">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Title</label>
                    <input type="text" name="title" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Featured Image</label>
                    <input type="file" name="image" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; margin-bottom: 0.5rem;">
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0.5rem 0;">OR</p>
                    <input type="url" name="image_url" placeholder="https://example.com/image.jpg" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                    <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Upload a file or enter an image URL</p>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Category</label>
                        <select name="category" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="General">General</option>
                            <option value="Meal Planning">Meal Planning</option>
                            <option value="Hydration">Hydration</option>
                            <option value="Exercise">Exercise</option>
                            <option value="Shopping">Shopping</option>
                            <option value="Weight Management">Weight Management</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Difficulty</label>
                        <select name="difficulty" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Read Time (minutes)</label>
                    <input type="number" name="read_time" value="5" min="1" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Content</label>
                    <textarea name="content" rows="8" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"></textarea>
                </div>
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" onclick="closeGuideModal()" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: 0.375rem; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 0.5rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Create Guide</button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    document.getElementById('addGuideForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_guide');
        
        fetch('guides.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeGuideModal();
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(() => showNotification('An error occurred', 'error'));
    });
}

function closeGuideModal() {
    const modal = document.querySelector('.admin-modal');
    if (modal) modal.remove();
}

function deleteGuide(id) {
    if (!confirm('Are you sure you want to delete this guide?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete_guide');
    formData.append('id', id);
    
    fetch('guides.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            document.querySelector(`[data-id="${id}"]`).remove();
        } else {
            showNotification(data.message, 'error');
        }
    });
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