<?php
// session_start();
// if (!isset($_SESSION['user_logged_in'])) {
//     header('Location: ../landing page/login.php');
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - NutriTrack' : 'NutriTrack Dashboard'; ?></title>
    <link rel="stylesheet" href="http://localhost/Health%20DIet/style.css">
</head>
<body>
    <div class="user-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="dashboard.php" class="logo">
                    <div class="logo-icon">🌿</div>
                    <div>
                        <div class="logo-text">NutriTrack</div>
                        <div class="team-role">Your Health</div>
                    </div>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    📊 Dashboard
                </a>
                <a href="meals.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'meals.php' ? 'active' : ''; ?>">
                    🍽️ Meal Log
                </a>
                <a href="water.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'water.php' ? 'active' : ''; ?>">
                    💧 Water
                </a>
                <a href="sleep.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'sleep.php' ? 'active' : ''; ?>">
                    🌙 Sleep
                </a>
                <a href="appointments.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
                    📅 Appointments
                </a>
                <a href="diet-plan.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'diet-plan.php' ? 'active' : ''; ?>">
                    📋 Diet Plan
                </a>
                <a href="recipes.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'recipes.php' ? 'active' : ''; ?>">
                    👨🍳 Recipes
                </a>
                <a href="trends.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'trends.php' ? 'active' : ''; ?>">
                    📈 Trends
                </a>
                <a href="chat.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'chat.php' ? 'active' : ''; ?>">
                    💬 Chat
                </a>
                <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                    ⚙️ Settings
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?></div>
                    <div>
                        <div class="team-name"><?php echo $_SESSION['user_name'] ?? 'User'; ?></div>
                        <div class="team-role">Member</div>
                    </div>
                </div>
                <a href="../landing page/login.php?logout=1" class="btn btn-outline">
                    🚪 Log out
                </a>
            </div>
        </aside>
        
        <div class="main-content">
            <header class="top-bar">
                <div></div>
                <div class="header-actions">
                    <div class="user-info">
                        <button class="btn btn-outline">🔔</button>
                        <div class="notification-dot"></div>
                    </div>
                    <div class="user-info">
                        <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?></div>
                        <span class="team-role"><?php echo $_SESSION['user_name'] ?? 'User'; ?></span>
                    </div>
                </div>
            </header>
            
            <main class="content-area">