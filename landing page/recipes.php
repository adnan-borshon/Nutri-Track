<?php
$page_title = "Recipes";
include '../includes/header.php';
require_once '../config/db.php';

$db = getDB();

// Get recipes from meal_suggestions table
$stmt = $db->query("SELECT * FROM meal_suggestions ORDER BY created_at DESC LIMIT 12");
$recipes = $stmt->fetchAll();
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title" style="font-size: 3rem;">Healthy Recipe Collection</h1>
            <p class="section-description">
                Discover delicious, nutritionist-approved recipes to support your health journey. Sign up to unlock the full library with detailed nutrition information.
            </p>
        </div>

        <?php if (!empty($recipes)): ?>
        <div class="grid grid-4" style="margin-bottom: 3rem;">
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <div class="recipe-image">🍽️</div>
                    <div class="recipe-content">
                        <span class="recipe-category"><?php echo ucfirst($recipe['meal_type']); ?></span>
                        <h3 class="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h3>
                        <p class="recipe-description"><?php echo htmlspecialchars(substr($recipe['description'], 0, 100)) . '...'; ?></p>
                        <div class="recipe-meta">
                            <span>🕒 30m</span>
                            <span>👥 2</span>
                            <span>🔥 <?php echo $recipe['calories'] ?? 350; ?></span>
                        </div>
                        <div class="recipe-tags">
                            <span class="recipe-tag">Healthy</span>
                            <span class="recipe-tag">Nutritious</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p>No recipes available at the moment. Check back soon!</p>
        </div>
        <?php endif; ?>

        <div class="cta">
            <h2 class="cta-title">Unlock 1000+ Premium Recipes</h2>
            <p class="cta-description">
                Sign up to access our full recipe library with detailed nutrition breakdowns, shopping lists, and personalized recommendations.
            </p>
            <a href="register.php" class="btn btn-secondary">
                Get Full Access →
            </a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>