<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - NutriTrack' : 'NutriTrack - Smart Health Diet Tracking Platform'; ?></title>
    <link rel="stylesheet" href="http://localhost/Health%20DIet/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <div class="logo-icon">🌿</div>
                    <span class="logo-text">NutriTrack</span>
                </a>

                <nav class="nav">
                    <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a>
                    <a href="about.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a>
                    <a href="features.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'features.php' ? 'active' : ''; ?>">Features</a>
                    <a href="recipes.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'recipes.php' ? 'active' : ''; ?>">Recipes</a>
                    <a href="guides.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'guides.php' ? 'active' : ''; ?>">Guides</a>
                    <a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a>
                </nav>

                <div class="header-actions">
                    <a href="login.php" class="btn btn-outline">Log in</a>
                    <a href="register.php" class="btn btn-primary">Get Started</a>
                </div>
            </div>
        </div>
    </header>

    <main>