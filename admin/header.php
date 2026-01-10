<?php
// session_start();
// if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
//     header('Location: ../login.php');
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriTrack - Admin Panel</title>
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
                        <div class="team-role">Admin Panel</div>
                    </div>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    📊 Dashboard
                </a>
                <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                    👥 Users
                </a>
                <a href="nutritionists.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'nutritionists.php' ? 'active' : ''; ?>">
                    👨‍⚕️ Nutritionists
                </a>
                <a href="foods.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'foods.php' ? 'active' : ''; ?>">
                    🗄️ Food Database
                </a>
                <a href="categories.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>">
                    📁 Categories
                </a>
                <a href="reports.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
                    📈 Reports
                </a>
                <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                    ⚙️ Settings
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">SA</div>
                    <div>
                        <div class="team-name">System Admin</div>
                        <div class="team-role">Administrator</div>
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
                        <div class="user-avatar">SA</div>
                        <span class="team-role">System Admin</span>
                    </div>
                </div>
            </header>
            
            <main class="content-area">