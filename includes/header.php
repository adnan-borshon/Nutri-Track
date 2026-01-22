<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - NutriTrack' : 'NutriTrack - Smart Health Diet Tracking Platform'; ?></title>
    <link rel="stylesheet" href="../style.css">
    <script src="assets/js/main.js" defer></script>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <div style="display:flex; justify-self: center;">
                    <img style="width:30px;height:30px" src="../assets/images/nutritrak_logo-removebg-preview.png" alt="NutriTrack Logo">

                    </div>
                    <span class="logo-text"><span style="color:#278b63;">

                        Nutri
</span>
                Track
                </span>
                </a>

                <nav class="nav">
                    <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a>
                    <a href="about.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a>
                    <a href="features.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'features.php' ? 'active' : ''; ?>">Features</a>
                    <a href="recipes.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'recipes.php' ? 'active' : ''; ?>">Recipes</a>
                    <a href="guides.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'guides.php' ? 'active' : ''; ?>">Guides</a>
                    <a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a>
                    <a href="demo.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'demo.php' ? 'active' : ''; ?>" style="background: #dcfce7; color: #278b63; border-radius: 0.375rem;">Demo</a>
                </nav>

                <div class="header-actions">
                    <a href="login.php" class="btn btn-outline">Log in</a>
                    <a href="register.php" class="btn btn-primary">Get Started</a>
                </div>
                
                <button class="mobile-menu-btn">
                    <span style="display: block; width: 1.5rem; height: 2px; background: #374151; margin: 0.25rem 0;"></span>
                    <span style="display: block; width: 1.5rem; height: 2px; background: #374151; margin: 0.25rem 0;"></span>
                    <span style="display: block; width: 1.5rem; height: 2px; background: #374151; margin: 0.25rem 0;"></span>
                </button>
            </div>
            
            <div class="mobile-menu">
                <nav class="mobile-nav">
                    <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a>
                    <a href="about.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a>
                    <a href="features.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'features.php' ? 'active' : ''; ?>">Features</a>
                    <a href="recipes.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'recipes.php' ? 'active' : ''; ?>">Recipes</a>
                    <a href="guides.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'guides.php' ? 'active' : ''; ?>">Guides</a>
                    <a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a>
                    <a href="demo.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'demo.php' ? 'active' : ''; ?>" style="background: #dcfce7; color: #278b63;">🎮 Interactive Demo</a>
                </nav>
                <div class="mobile-actions">
                    <a href="login.php" class="btn btn-outline">Log in</a>
                    <a href="register.php" class="btn btn-primary">Get Started</a>
                </div>
            </div>
        </div>
    </header>

    <main>