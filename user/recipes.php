<?php
$page_title = "Recipes";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
require_once '../includes/image_helper.php';

$db = getDB();

// Fetch meal suggestions from nutritionists (recipes shared with users)
$recipes = [];

// Get suggestions from the user's assigned nutritionist, or all nutritionists if none assigned
if ($user['nutritionist_id']) {
    $stmt = $db->prepare("SELECT ms.*, u.name as author_name 
                          FROM meal_suggestions ms 
                          JOIN users u ON ms.nutritionist_id = u.id 
                          WHERE ms.nutritionist_id = ? 
                          ORDER BY ms.created_at DESC");
    $stmt->execute([$user['nutritionist_id']]);
} else {
    $stmt = $db->query("SELECT ms.*, u.name as author_name 
                        FROM meal_suggestions ms 
                        JOIN users u ON ms.nutritionist_id = u.id 
                        ORDER BY ms.created_at DESC 
                        LIMIT 20");
}
$suggestions = $stmt->fetchAll();

// Convert to recipe format for display
foreach ($suggestions as $s) {
    $recipes[] = [
        'id' => $s['id'],
        'title' => $s['title'],
        'calories' => $s['calories'],
        'time' => $s['prep_time'],
        'difficulty' => ucfirst($s['meal_type']),
        'description' => $s['description'],
        'ingredients' => $s['ingredients'] ? explode("\n", $s['ingredients']) : [],
        'instructions' => $s['instructions'] ? explode("\n", $s['instructions']) : [],
        'tags' => $s['tags'],
        'author' => $s['author_name'],
        'image_path' => $s['image_path']
    ];
}

// If no suggestions from nutritionists, show foods from database as recipe ideas
if (empty($recipes)) {
    $stmt = $db->query("SELECT f.*, fc.name as category_name 
                        FROM foods f 
                        LEFT JOIN food_categories fc ON f.category_id = fc.id 
                        ORDER BY f.name 
                        LIMIT 12");
    $foods = $stmt->fetchAll();
    
    foreach ($foods as $f) {
        $recipes[] = [
            'id' => $f['id'],
            'title' => $f['name'],
            'calories' => $f['calories'],
            'time' => 10,
            'difficulty' => $f['category_name'] ?: 'General',
            'description' => $f['description'] ?: 'A nutritious food option',
            'ingredients' => [$f['name'] . ' - ' . ($f['serving_size'] ?? '1 serving')],
            'instructions' => ['Prepare according to your preference'],
            'tags' => '',
            'author' => 'NutriTrack'
        ];
    }
}

include 'header.php';
?>

<div class="page-header">
    <div>
        <h1 class="section-title">Healthy Recipes</h1>
        <p class="section-description">Nutritious recipes tailored to your dietary goals</p>
    </div>
</div>

<div class="grid grid-3" style="gap: 1.5rem;">
    <?php if (empty($recipes)): ?>
    <div style="grid-column: span 3; text-align: center; padding: 3rem; color: #6b7280;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:48px;height:48px;stroke-width:1.5;color:#278b63;margin:0 auto 1rem;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
        </svg>
        <p>No recipes available yet. Check back later for meal suggestions from your nutritionist!</p>
    </div>
    <?php else: ?>
    <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card" onclick="openRecipeModal(<?php echo htmlspecialchars(json_encode($recipe)); ?>)">
            <div class="recipe-image">
                <?php 
                $imageSrc = getImageSrc($recipe['image_path'] ?? '');
                if ($imageSrc): ?>
                    <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 0.5rem;">
                <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:32px;height:32px;stroke-width:1.5;color:#278b63;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
                </svg>
                <?php endif; ?>
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
    <?php endif; ?>
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
    const imageSrc = recipe.image_path ? (recipe.image_path.startsWith('http') ? recipe.image_path : `../${recipe.image_path}`) : null;
    const imageHtml = imageSrc ? `<img src="${imageSrc}" alt="${recipe.title}" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1.5rem;">` : '';
    
    document.getElementById('modalTitle').textContent = recipe.title;
    document.getElementById('modalContent').innerHTML = `
        ${imageHtml}
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