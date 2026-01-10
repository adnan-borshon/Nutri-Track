<?php
// session_start();
// if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'nutritionist') {
//     header('Location: ../login.php');
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriTrack - Nutritionist Dashboard</title>
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
                        <div class="team-role">Nutritionist</div>
                    </div>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    📊 Dashboard
                </a>
                <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                    👥 My Users
                </a>
                <a href="diet-plans.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'diet-plans.php' ? 'active' : ''; ?>">
                    📋 Diet Plans
                </a>
                <a href="suggestions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'suggestions.php' ? 'active' : ''; ?>">
                    💡 Suggestions
                </a>
                <a href="guides.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'guides.php' ? 'active' : ''; ?>">
                    📖 Guides
                </a>
                <a href="progress.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'progress.php' ? 'active' : ''; ?>">
                    📈 Progress Log
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
                    <div class="user-avatar">DS</div>
                    <div>
                        <div class="team-name">Dr. Sarah Smith</div>
                        <div class="team-role">Nutritionist</div>
                    </div>
                </div>
                <a href="../logout.php" class="btn btn-outline">
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
                        <div class="user-avatar">DS</div>
                        <span class="team-role">Dr. Sarah Smith</span>
                    </div>
                </div>
            </header>
            
            <main class="content-area">