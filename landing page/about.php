<?php
$page_title = "About";
include '../includes/header.php';
require_once '../config/db.php';

$db = getDB();

// Get real stats from database
$stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
$totalUsers = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'nutritionist'");
$totalNutritionists = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(*) FROM meal_logs");
$totalMeals = $stmt->fetchColumn();

// Calculate satisfaction rate (users with recent activity)
$stmt = $db->prepare("SELECT COUNT(DISTINCT user_id) FROM meal_logs WHERE log_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
$stmt->execute();
$activeUsers = $stmt->fetchColumn();
$satisfactionRate = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 95;
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title" style="font-size: 3rem;">About NutriTrack</h1>
            <p class="section-description">
                We're on a mission to revolutionize how people approach their nutrition and health, making personalized wellness guidance accessible to everyone.
            </p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <p class="stat-value"><?php echo number_format($totalUsers); ?>+</p>
                <p class="stat-label">Active Users</p>
            </div>
            <div class="stat-card">
                <p class="stat-value"><?php echo number_format($totalNutritionists); ?>+</p>
                <p class="stat-label">Certified Nutritionists</p>
            </div>
            <div class="stat-card">
                <p class="stat-value"><?php echo number_format($totalMeals); ?>+</p>
                <p class="stat-label">Meals Tracked</p>
            </div>
            <div class="stat-card">
                <p class="stat-value"><?php echo $satisfactionRate; ?>%</p>
                <p class="stat-label">User Satisfaction</p>
            </div>
        </div>

        <div class="feature-grid" style="margin-bottom: 5rem;">
            <div>
                <h2 style="font-size: 2.25rem; font-weight: bold; margin-bottom: 1.5rem;">Our Story</h2>
                <div style="display: flex; flex-direction: column; gap: 1rem; color: #6b7280;">
                    <p>
                        NutriTrack was born from a simple observation: despite the abundance of nutrition information available, most people still struggle to maintain healthy eating habits. The problem wasn't lack of knowledge—it was lack of personalized, accessible guidance.
                    </p>
                    <p>
                        Founded in 2020, our platform bridges the gap between users and certified nutritionists, providing the tools and support needed for lasting health transformation. We combine cutting-edge technology with human expertise to deliver personalized nutrition plans that actually work.
                    </p>
                    <p>
                        Today, we serve over <?php echo number_format($totalUsers); ?> active users worldwide, partnering with <?php echo $totalNutritionists; ?>+ certified nutritionists to make healthy living achievable for everyone.
                    </p>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #dcfce7, #f0fdf4); border-radius: 1rem; aspect-ratio: 1; display: flex; align-items: center; justify-content: center;">
                <div style="text-align: center; padding: 2rem;">
                    <div style="width: 6rem; height: 6rem; border-radius: 50%; background: #16a34a; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 3rem;">
                        ❤️
                    </div>
                    <p style="font-size: 1.5rem; font-weight: bold;">Health First</p>
                    <p style="color: #6b7280;">Always our priority</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-gray">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Values</h2>
            <p class="section-description">The principles that guide everything we do</p>
        </div>
        <div class="grid grid-4">
            <div class="card">
                <div class="card-content" style="text-align: center;">
                    <div class="card-icon">🎯</div>
                    <h3 class="card-title">Mission-Driven</h3>
                    <p class="card-description">We're committed to making healthy living accessible to everyone through technology and expert guidance.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-content" style="text-align: center;">
                    <div class="card-icon">❤️</div>
                    <h3 class="card-title">User-Centric</h3>
                    <p class="card-description">Every feature we build is designed with our users' health and happiness as the top priority.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-content" style="text-align: center;">
                    <div class="card-icon">👥</div>
                    <h3 class="card-title">Community</h3>
                    <p class="card-description">We foster a supportive community where users and nutritionists work together toward better health.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-content" style="text-align: center;">
                    <div class="card-icon">🏆</div>
                    <h3 class="card-title">Excellence</h3>
                    <p class="card-description">We partner with certified nutritionists and use evidence-based approaches to deliver the best outcomes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Meet Our Team</h2>
            <p class="section-description">Experts dedicated to your health and wellbeing</p>
        </div>
        <div class="grid grid-4">
            <div class="team-member">
                <div class="team-avatar">SM</div>
                <h3 class="team-name">Dr. Sarah Mitchell</h3>
                <p class="team-role">Chief Medical Officer</p>
                <p class="team-bio">Board-certified nutritionist with 15+ years of clinical experience.</p>
            </div>
            <div class="team-member">
                <div class="team-avatar">JC</div>
                <h3 class="team-name">James Chen</h3>
                <p class="team-role">CEO & Founder</p>
                <p class="team-bio">Former health tech executive passionate about preventive healthcare.</p>
            </div>
            <div class="team-member">
                <div class="team-avatar">ER</div>
                <h3 class="team-name">Dr. Emily Rodriguez</h3>
                <p class="team-role">Head of Nutrition Science</p>
                <p class="team-bio">PhD in Nutritional Sciences, specializing in metabolic health.</p>
            </div>
            <div class="team-member">
                <div class="team-avatar">MT</div>
                <h3 class="team-name">Michael Thompson</h3>
                <p class="team-role">Chief Technology Officer</p>
                <p class="team-bio">Tech veteran with expertise in health data analytics and AI.</p>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>