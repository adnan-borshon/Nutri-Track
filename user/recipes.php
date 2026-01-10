<?php
$page_title = "Recipes";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
include 'header.php';

$recipes = [
    ['title' => 'Protein Smoothie Bowl', 'calories' => 320, 'time' => 10, 'difficulty' => 'Easy'],
    ['title' => 'Quinoa Power Salad', 'calories' => 420, 'time' => 15, 'difficulty' => 'Easy'],
    ['title' => 'Grilled Salmon', 'calories' => 380, 'time' => 25, 'difficulty' => 'Medium'],
    ['title' => 'Veggie Stir Fry', 'calories' => 280, 'time' => 20, 'difficulty' => 'Easy']
];
?>

<div class="section">
    <div>
        <h1 class="section-title">Recipes</h1>
        <p class="section-description">Healthy recipes tailored to your goals</p>
    </div>

    <div class="grid grid-2">
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-card">
                <div class="recipe-image">🍽️</div>
                <div class="recipe-content">
                    <h3 class="recipe-title"><?php echo $recipe['title']; ?></h3>
                    <div class="recipe-meta">
                        <span>🔥 <?php echo $recipe['calories']; ?> cal</span>
                        <span>⏱️ <?php echo $recipe['time']; ?> min</span>
                        <span>📊 <?php echo $recipe['difficulty']; ?></span>
                    </div>
                    <button class="btn btn-outline" style="width: 100%;">View Recipe</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>