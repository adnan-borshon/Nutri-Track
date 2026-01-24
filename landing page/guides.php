<?php
$page_title = "Guides";
include '../includes/header.php';
require_once '../config/db.php';
require_once '../includes/image_helper.php';

$db = getDB();

// Get featured guides (first 3)
$stmt = $db->query("SELECT * FROM nutrition_guides ORDER BY created_at DESC LIMIT 3");
$featuredGuides = $stmt->fetchAll();

// Get all other guides
$stmt = $db->query("SELECT * FROM nutrition_guides ORDER BY created_at DESC LIMIT 8 OFFSET 3");
$otherGuides = $stmt->fetchAll();

function getInitials($name) {
    $parts = explode(' ', $name);
    return strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
}
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title" style="font-size: 3rem;">Nutrition Guides</h1>
            <p class="section-description">
                Expert-written guides to help you understand nutrition, make better food choices, and achieve your health goals.
            </p>
        </div>

        <?php if (!empty($featuredGuides)): ?>
        <div style="margin-bottom: 4rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Featured Guides</h2>
            <div class="grid grid-3">
                <?php foreach ($featuredGuides as $guide): ?>
                    <div class="guide-card">
                        <div class="guide-image">
                            <?php 
                            $imageSrc = getImageSrc($guide['image_path']);
                            if ($imageSrc): ?>
                                <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo htmlspecialchars($guide['title']); ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 0.5rem;">
                            <?php else: ?>
                                📖
                            <?php endif; ?>
                        </div>
                        <div class="guide-content">
                            <span class="guide-category">Nutrition</span>
                            <h3 class="guide-title"><?php echo htmlspecialchars($guide['title']); ?></h3>
                            <p class="guide-description"><?php echo htmlspecialchars(substr($guide['content'], 0, 120)) . '...'; ?></p>
                            <div class="guide-meta">
                                <div class="guide-author">
                                    <div class="guide-avatar">NT</div>
                                    <span class="guide-author-name">NutriTrack Team</span>
                                </div>
                                <div class="guide-time">
                                    <span>🕒</span>
                                    <span>5 min</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($otherGuides)): ?>
        <div style="margin-bottom: 4rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">All Guides</h2>
            <div class="grid grid-4">
                <?php foreach ($otherGuides as $guide): ?>
                    <div class="card">
                        <div class="card-content">
                            <span style="display: inline-block; padding: 0.25rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.75rem; margin-bottom: 0.75rem;">Nutrition</span>
                            <h3 style="font-weight: 600; margin-bottom: 0.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($guide['title']); ?></h3>
                            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars(substr($guide['content'], 0, 100)) . '...'; ?></p>
                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.875rem; color: #6b7280;">
                                <span>NutriTrack Team</span>
                                <div style="display: flex; align-items: center; gap: 0.25rem;">
                                    <span>🕒</span>
                                    <span>5m</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (empty($featuredGuides) && empty($otherGuides)): ?>
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p>No guides available at the moment. Check back soon!</p>
        </div>
        <?php endif; ?>

        <div class="cta">
            <h2 class="cta-title">Access Premium Content</h2>
            <p class="cta-description">
                Sign up to unlock full guide content, downloadable resources, and personalized recommendations from our nutrition experts.
            </p>
            <a href="register.php" class="btn btn-secondary">
                Join NutriTrack →
            </a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>