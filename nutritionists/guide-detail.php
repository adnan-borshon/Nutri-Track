<?php
require_once '../includes/session.php';
checkAuth('nutritionist');

$guide_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$guides = [
    1 => [
        'title' => 'Understanding Macronutrients',
        'category' => 'Beginner',
        'author' => 'Dr. Sarah Smith',
        'read_time' => '5 min read',
        'content' => 'Macronutrients are the nutrients your body needs in large amounts to function properly. They include proteins, carbohydrates, and fats. Each plays a crucial role in maintaining your health and providing energy for daily activities.',
        'color' => '#278b63'
    ],
    2 => [
        'title' => 'Portion Control Guide',
        'category' => 'Meal Planning',
        'author' => 'Dr. Sarah Smith',
        'read_time' => '8 min read',
        'content' => 'Portion control is key to maintaining a healthy weight and proper nutrition. Learn practical strategies to manage your portions without feeling deprived.',
        'color' => '#d97706'
    ],
    3 => [
        'title' => 'Hydration and Health',
        'category' => 'Hydration',
        'author' => 'Dr. Sarah Smith',
        'read_time' => '6 min read',
        'content' => 'Proper hydration is essential for optimal health and performance. Discover how much water you need and the best ways to stay hydrated throughout the day.',
        'color' => '#3b82f6'
    ],
    4 => [
        'title' => 'Nutrition for Active Lifestyles',
        'category' => 'Exercise',
        'author' => 'Dr. Sarah Smith',
        'read_time' => '10 min read',
        'content' => 'Fuel your workouts with proper nutrition. Learn what to eat before, during, and after exercise to maximize your performance and recovery.',
        'color' => '#ec4899'
    ],
    5 => [
        'title' => 'Healthy Grocery Shopping',
        'category' => 'Shopping',
        'author' => 'Dr. Sarah Smith',
        'read_time' => '7 min read',
        'content' => 'Navigate the grocery store like a pro with these healthy shopping strategies. Learn how to make smart choices and avoid common pitfalls.',
        'color' => '#8b5cf6'
    ],
    6 => [
        'title' => 'Sustainable Weight Loss',
        'category' => 'Weight Management',
        'author' => 'Dr. Sarah Smith',
        'read_time' => '12 min read',
        'content' => 'Achieve lasting weight loss with evidence-based strategies and mindful eating. Learn sustainable approaches that work long-term.',
        'color' => '#ef4444'
    ]
];

$guide = $guides[$guide_id] ?? $guides[1];

include 'header.php';
?>

<div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <div style="margin-bottom: 2rem;">
        <a href="guides.php" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #278b63; text-decoration: none; font-size: 0.875rem; margin-bottom: 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Back to Guides
        </a>
        
        <div style="margin-bottom: 1rem;">
            <span style="background: <?php echo $guide['color']; ?>20; color: <?php echo $guide['color']; ?>; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;"><?php echo $guide['category']; ?></span>
        </div>
        
        <h1 style="font-size: 2rem; font-weight: 700; margin: 0 0 1rem 0; color: #111827;"><?php echo $guide['title']; ?></h1>
        
        <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 2rem; height: 2rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">DS</div>
                <span><?php echo $guide['author']; ?></span>
            </div>
            <span><?php echo $guide['read_time']; ?></span>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb;">
        <div style="line-height: 1.7; color: #374151; font-size: 1rem;">
            <p><?php echo $guide['content']; ?></p>
            
            <h2 style="font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem 0; color: #111827;">Key Points</h2>
            <ul style="margin: 1rem 0; padding-left: 1.5rem;">
                <li style="margin-bottom: 0.5rem;">Understanding the basics is crucial for long-term success</li>
                <li style="margin-bottom: 0.5rem;">Consistency is more important than perfection</li>
                <li style="margin-bottom: 0.5rem;">Small changes can lead to significant results over time</li>
                <li style="margin-bottom: 0.5rem;">Always consult with healthcare professionals for personalized advice</li>
            </ul>
            
            <h2 style="font-size: 1.5rem; font-weight: 600; margin: 2rem 0 1rem 0; color: #111827;">Getting Started</h2>
            <p>Begin by implementing one small change at a time. This approach helps build sustainable habits that will serve you well in the long run. Remember, the goal is progress, not perfection.</p>
            
            <div style="background: #f9fafb; border-left: 4px solid <?php echo $guide['color']; ?>; padding: 1rem; margin: 2rem 0; border-radius: 0 0.375rem 0.375rem 0;">
                <p style="margin: 0; font-style: italic; color: #374151;"><strong>Pro Tip:</strong> Keep a journal to track your progress and note what works best for you. This will help you stay motivated and make adjustments as needed.</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="guides.php" style="display: inline-block; padding: 0.75rem 1.5rem; background: #278b63; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 500;">View More Guides</a>
    </div>
</div>

<?php include 'footer.php'; ?>