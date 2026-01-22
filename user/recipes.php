<?php
$page_title = "Recipes";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
include 'header.php';

$recipes = [
    [
        'id' => 1,
        'title' => 'Protein Smoothie Bowl', 
        'calories' => 320, 
        'time' => 10, 
        'difficulty' => 'Easy',
        'ingredients' => ['1 banana', '1 cup berries', '1 scoop protein powder', '1/2 cup almond milk'],
        'instructions' => ['Blend all ingredients until smooth', 'Pour into bowl', 'Top with granola and fresh fruits']
    ],
    [
        'id' => 2,
        'title' => 'Quinoa Power Salad', 
        'calories' => 420, 
        'time' => 15, 
        'difficulty' => 'Easy',
        'ingredients' => ['1 cup cooked quinoa', 'Mixed greens', 'Cherry tomatoes', 'Avocado', 'Olive oil'],
        'instructions' => ['Cook quinoa according to package', 'Mix with vegetables', 'Drizzle with olive oil']
    ],
    [
        'id' => 3,
        'title' => 'Grilled Salmon', 
        'calories' => 380, 
        'time' => 25, 
        'difficulty' => 'Medium',
        'ingredients' => ['Salmon fillet', 'Lemon', 'Herbs', 'Olive oil'],
        'instructions' => ['Season salmon with herbs', 'Grill for 12-15 minutes', 'Serve with lemon']
    ],
    [
        'id' => 4,
        'title' => 'Veggie Stir Fry', 
        'calories' => 280, 
        'time' => 20, 
        'difficulty' => 'Easy',
        'ingredients' => ['Mixed vegetables', 'Soy sauce', 'Garlic', 'Ginger', 'Sesame oil'],
        'instructions' => ['Heat oil in pan', 'Add vegetables and stir fry', 'Season with soy sauce']
    ]
];
?>

<div class="page-header">
    <div>
        <h1 class="section-title">Healthy Recipes</h1>
        <p class="section-description">Nutritious recipes tailored to your dietary goals</p>
    </div>
</div>

<div class="grid grid-3" style="gap: 1.5rem;">
    <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card" onclick="openRecipeModal(<?php echo htmlspecialchars(json_encode($recipe)); ?>)">
            <div class="recipe-image">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
                </svg>
            </div>
            <div class="recipe-content">
                <h3 class="recipe-title"><?php echo $recipe['title']; ?></h3>
                <div class="recipe-meta">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px;stroke-width:1.5;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                        </svg>
                        <?php echo $recipe['calories']; ?> cal
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px;stroke-width:1.5;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <?php echo $recipe['time']; ?> min
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px;stroke-width:1.5;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        <?php echo $recipe['difficulty']; ?>
                    </span>
                </div>
                <button class="btn btn-primary" style="width: 100%; font-size: 0.875rem;" onclick="event.stopPropagation(); openRecipeModal(<?php echo htmlspecialchars(json_encode($recipe)); ?>)">
                    View Recipe
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Recipe Modal -->
<div id="recipeModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Recipe Details</h2>
            <button class="modal-close" onclick="closeRecipeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div id="modalContent"></div>
        </div>
    </div>
</div>

<script>
function openRecipeModal(recipe) {
    document.getElementById('modalTitle').textContent = recipe.title;
    document.getElementById('modalContent').innerHTML = `
        <div style="margin-bottom: 1.5rem;">
            <div class="recipe-meta" style="margin-bottom: 1rem;">
                <span><strong>${recipe.calories}</strong> calories</span>
                <span><strong>${recipe.time}</strong> minutes</span>
                <span><strong>${recipe.difficulty}</strong> difficulty</span>
            </div>
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-weight: 600; margin-bottom: 0.75rem; color: #278b63;">Ingredients:</h3>
            <ul style="list-style: disc; margin-left: 1.5rem; line-height: 1.6;">
                ${recipe.ingredients.map(ingredient => `<li>${ingredient}</li>`).join('')}
            </ul>
        </div>
        
        <div>
            <h3 style="font-weight: 600; margin-bottom: 0.75rem; color: #278b63;">Instructions:</h3>
            <ol style="list-style: decimal; margin-left: 1.5rem; line-height: 1.6;">
                ${recipe.instructions.map(instruction => `<li style="margin-bottom: 0.5rem;">${instruction}</li>`).join('')}
            </ol>
        </div>
    `;
    document.getElementById('recipeModal').style.display = 'flex';
}

function closeRecipeModal() {
    document.getElementById('recipeModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('recipeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRecipeModal();
    }
});
</script>

<?php include 'footer.php'; ?>