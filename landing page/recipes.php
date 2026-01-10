<?php
$page_title = "Recipes";
include '../includes/header.php';

$recipes = [
    ['id' => '1', 'title' => 'Mediterranean Quinoa Bowl', 'description' => 'A protein-packed bowl with fresh vegetables, feta, and a lemon herb dressing.', 'category' => 'Lunch', 'time' => 35, 'servings' => 2, 'calories' => 420, 'tags' => ['High Protein', 'Vegetarian']],
    ['id' => '2', 'title' => 'Avocado Toast with Poached Eggs', 'description' => 'Classic avocado toast elevated with perfectly poached eggs and microgreens.', 'category' => 'Breakfast', 'time' => 15, 'servings' => 1, 'calories' => 380, 'tags' => ['Quick', 'Vegetarian']],
    ['id' => '3', 'title' => 'Grilled Salmon with Asparagus', 'description' => 'Omega-3 rich salmon fillet with roasted asparagus and lemon butter sauce.', 'category' => 'Dinner', 'time' => 35, 'servings' => 2, 'calories' => 520, 'tags' => ['High Protein', 'Keto Friendly']],
    ['id' => '4', 'title' => 'Berry Smoothie Bowl', 'description' => 'Refreshing acai bowl topped with fresh berries, granola, and chia seeds.', 'category' => 'Breakfast', 'time' => 10, 'servings' => 1, 'calories' => 320, 'tags' => ['Vegan', 'No Cook']],
    ['id' => '5', 'title' => 'Chicken Stir-Fry', 'description' => 'Quick and flavorful stir-fry with tender chicken and crispy vegetables.', 'category' => 'Dinner', 'time' => 30, 'servings' => 3, 'calories' => 450, 'tags' => ['High Protein', 'Quick']],
    ['id' => '6', 'title' => 'Greek Yogurt Parfait', 'description' => 'Layered parfait with Greek yogurt, honey, and mixed nuts.', 'category' => 'Snacks', 'time' => 5, 'servings' => 1, 'calories' => 280, 'tags' => ['Quick', 'High Protein']],
    ['id' => '7', 'title' => 'Veggie Buddha Bowl', 'description' => 'Colorful plant-based bowl with roasted vegetables and tahini dressing.', 'category' => 'Lunch', 'time' => 50, 'servings' => 2, 'calories' => 380, 'tags' => ['Vegan', 'High Fiber']],
    ['id' => '8', 'title' => 'Protein Energy Balls', 'description' => 'No-bake energy balls packed with oats, peanut butter, and dark chocolate.', 'category' => 'Snacks', 'time' => 15, 'servings' => 12, 'calories' => 120, 'tags' => ['No Cook', 'Vegetarian']]
];
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title" style="font-size: 3rem;">Healthy Recipe Collection</h1>
            <p class="section-description">
                Discover delicious, nutritionist-approved recipes to support your health journey. Sign up to unlock the full library with detailed nutrition information.
            </p>
        </div>

        <div class="grid grid-4" style="margin-bottom: 3rem;">
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <div class="recipe-image">🔥</div>
                    <div class="recipe-content">
                        <span class="recipe-category"><?php echo $recipe['category']; ?></span>
                        <h3 class="recipe-title"><?php echo $recipe['title']; ?></h3>
                        <p class="recipe-description"><?php echo $recipe['description']; ?></p>
                        <div class="recipe-meta">
                            <span>🕒 <?php echo $recipe['time']; ?>m</span>
                            <span>👥 <?php echo $recipe['servings']; ?></span>
                            <span>🔥 <?php echo $recipe['calories']; ?></span>
                        </div>
                        <div class="recipe-tags">
                            <?php foreach ($recipe['tags'] as $tag): ?>
                                <span class="recipe-tag"><?php echo $tag; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

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