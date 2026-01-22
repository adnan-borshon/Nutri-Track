<?php
$page_title = "Recipes";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
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
                <div class="recipe-image">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
</svg>
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title"><?php echo $recipe['title']; ?></h3>
                    <div class="recipe-meta">
                        <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
</svg> <?php echo $recipe['calories']; ?> cal</span>
                        <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg> <?php echo $recipe['time']; ?> min</span>
                        <span>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
</svg> <?php echo $recipe['difficulty']; ?></span>
                    </div>
                    <button class="btn btn-outline" style="width: 100%;">View Recipe</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>