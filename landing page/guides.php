<?php
$page_title = "Guides";
include '../includes/header.php';

$featuredGuides = [
    ['title' => 'Complete Guide to Macronutrients', 'description' => 'Learn about proteins, carbohydrates, and fats - how much you need and the best sources for each.', 'author' => 'Dr. Sarah Mitchell', 'category' => 'Nutrition Basics', 'readTime' => 12],
    ['title' => 'Meal Prep 101: Save Time & Eat Healthy', 'description' => 'Master the art of meal preparation with tips, techniques, and storage guidelines.', 'author' => 'Chef Emma Wilson', 'category' => 'Meal Planning', 'readTime' => 8],
    ['title' => 'Mindful Eating Practices', 'description' => 'Develop a healthier relationship with food through mindfulness techniques.', 'author' => 'Dr. Lisa Thompson', 'category' => 'Wellness', 'readTime' => 10]
];

$otherGuides = [
    ['title' => 'Understanding Food Labels', 'description' => 'Decode nutrition labels to make informed choices at the grocery store.', 'author' => 'Dr. Emily Rodriguez', 'category' => 'Nutrition Basics', 'readTime' => 6],
    ['title' => 'Hydration: More Than Just Water', 'description' => 'Explore the science of hydration and learn optimal fluid intake strategies.', 'author' => 'Dr. Michael Chen', 'category' => 'Wellness', 'readTime' => 7],
    ['title' => 'Sports Nutrition Fundamentals', 'description' => 'Fuel your workouts and optimize recovery with proper nutrition strategies.', 'author' => 'Coach James Martinez', 'category' => 'Fitness', 'readTime' => 15],
    ['title' => 'Plant-Based Eating Guide', 'description' => 'Everything you need to know about transitioning to a plant-based diet.', 'author' => 'Dr. Sarah Mitchell', 'category' => 'Diets', 'readTime' => 11],
    ['title' => 'Sleep and Nutrition Connection', 'description' => 'Discover how what you eat affects your sleep quality and vice versa.', 'author' => 'Dr. Emily Rodriguez', 'category' => 'Wellness', 'readTime' => 9]
];

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

        <div style="margin-bottom: 4rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Featured Guides</h2>
            <div class="grid grid-3">
                <?php foreach ($featuredGuides as $guide): ?>
                    <div class="guide-card">
                        <div class="guide-image">📖</div>
                        <div class="guide-content">
                            <span class="guide-category"><?php echo $guide['category']; ?></span>
                            <h3 class="guide-title"><?php echo $guide['title']; ?></h3>
                            <p class="guide-description"><?php echo $guide['description']; ?></p>
                            <div class="guide-meta">
                                <div class="guide-author">
                                    <div class="guide-avatar"><?php echo getInitials($guide['author']); ?></div>
                                    <span class="guide-author-name"><?php echo $guide['author']; ?></span>
                                </div>
                                <div class="guide-time">
                                    <span>🕒</span>
                                    <span><?php echo $guide['readTime']; ?> min</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-bottom: 4rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">All Guides</h2>
            <div class="grid grid-4">
                <?php foreach ($otherGuides as $guide): ?>
                    <div class="card">
                        <div class="card-content">
                            <span style="display: inline-block; padding: 0.25rem 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.75rem; margin-bottom: 0.75rem;"><?php echo $guide['category']; ?></span>
                            <h3 style="font-weight: 600; margin-bottom: 0.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $guide['title']; ?></h3>
                            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo $guide['description']; ?></p>
                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.875rem; color: #6b7280;">
                                <span><?php echo $guide['author']; ?></span>
                                <div style="display: flex; align-items: center; gap: 0.25rem;">
                                    <span>🕒</span>
                                    <span><?php echo $guide['readTime']; ?>m</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

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