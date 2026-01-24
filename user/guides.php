<?php
require_once '../includes/session.php';
checkAuth('user');
$currentUser = getCurrentUser();

$db = getDB();

// Get all guides from user's nutritionist
$stmt = $db->prepare("SELECT g.*, u.name as author_name 
                      FROM nutrition_guides g 
                      JOIN users u ON g.nutritionist_id = u.id 
                      WHERE g.nutritionist_id = ? 
                      ORDER BY g.created_at DESC");
$stmt->execute([$currentUser['nutritionist_id']]);
$guides = $stmt->fetchAll();

// Category colors
$categoryColors = [
    'General' => ['bg' => '#dcfce7', 'text' => '#278b63'],
    'Meal Planning' => ['bg' => '#fef3c7', 'text' => '#d97706'],
    'Hydration' => ['bg' => '#dbeafe', 'text' => '#3b82f6'],
    'Exercise' => ['bg' => '#fce7f3', 'text' => '#ec4899'],
    'Shopping' => ['bg' => '#f3e8ff', 'text' => '#8b5cf6'],
    'Weight Management' => ['bg' => '#fef2f2', 'text' => '#ef4444'],
];

include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Nutrition Guides</h1>
        <p class="text-muted-foreground">Educational articles from your nutritionist</p>
    </div>

    <?php if (empty($guides)): ?>
    <div class="card">
        <div class="card-content" style="text-align: center; padding: 3rem; color: #6b7280;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;margin:0 auto 1rem;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            <p>No guides available yet. Your nutritionist will add educational content here.</p>
        </div>
    </div>
    <?php else: ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($guides as $guide): 
            $colors = $categoryColors[$guide['category']] ?? $categoryColors['General'];
        ?>
        <div class="card guide-card" onclick="viewGuide(<?= $guide['id'] ?>, '<?= htmlspecialchars(addslashes($guide['title'])) ?>', '<?= htmlspecialchars(addslashes($guide['content'])) ?>', '<?= $guide['image_path'] ?>', '<?= $guide['author_name'] ?>', '<?= $guide['read_time'] ?>', '<?= $guide['difficulty'] ?>')">
            <div class="card-content">
                <?php if ($guide['image_path']): ?>
                <div style="width: 100%; height: 150px; background-image: url('../<?= htmlspecialchars($guide['image_path']) ?>'); background-size: cover; background-position: center; border-radius: 0.5rem; margin-bottom: 1rem;"></div>
                <?php endif; ?>
                
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <span style="background: <?= $colors['bg'] ?>; color: <?= $colors['text'] ?>; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;"><?= htmlspecialchars($guide['category']) ?></span>
                    <span style="font-size: 0.75rem; color: #6b7280; text-transform: capitalize;"><?= htmlspecialchars($guide['difficulty']) ?></span>
                </div>
                
                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: #111827;"><?= htmlspecialchars($guide['title']) ?></h3>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5;"><?= htmlspecialchars(substr($guide['content'], 0, 100)) . (strlen($guide['content']) > 100 ? '...' : '') ?></p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #6b7280;">
                    <span>By <?= htmlspecialchars($guide['author_name']) ?></span>
                    <span><?= $guide['read_time'] ?> min read</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
function viewGuide(id, title, content, imagePath, author, readTime, difficulty) {
    const modal = document.createElement('div');
    modal.className = 'guide-modal';
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; padding: 1rem;';
    
    const imageHtml = imagePath ? `<img src="../${imagePath}" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1.5rem;">` : '';
    
    modal.innerHTML = `
        <div style="background: white; padding: 2rem; border-radius: 0.75rem; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="margin: 0; font-size: 1.5rem; font-weight: 600;">${title}</h2>
                <button class="close-guide-btn" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280;">&times;</button>
            </div>
            
            ${imageHtml}
            
            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.875rem; color: #6b7280;">
                <span>By ${author}</span>
                <span>${readTime} min read</span>
                <span style="text-transform: capitalize;">${difficulty}</span>
            </div>
            
            <div style="line-height: 1.6; color: #374151; white-space: pre-wrap;">${content}</div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
    
    // Close button event
    modal.querySelector('.close-guide-btn').addEventListener('click', function() {
        modal.remove();
        document.body.style.overflow = 'auto';
    });
    
    // Click outside to close
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
            document.body.style.overflow = 'auto';
        }
    });
}
</script>

<style>
.guide-card {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.guide-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
</style>

<?php include 'footer.php'; ?>