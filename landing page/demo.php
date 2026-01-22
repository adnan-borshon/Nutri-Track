<?php
$page_title = "Interactive Demo";
include '../includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title">Interactive Demo</h1>
            <p class="section-description">
                Test all the interactive features of the NutriTrack landing page
            </p>
        </div>

        <div class="grid grid-2" style="margin-bottom: 3rem;">
            <div class="card">
                <div class="card-content">
                    <h3 class="card-title">🍽️ Recipe Modal Demo</h3>
                    <p class="card-description">Click to see how recipe cards open detailed modals</p>
                    <button onclick="showRecipeModal('Mediterranean Quinoa Bowl', 'A protein-packed bowl with fresh vegetables, feta, and a lemon herb dressing.', 'Lunch')" class="btn btn-primary">
                        View Recipe Modal
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3 class="card-title">📖 Guide Modal Demo</h3>
                    <p class="card-description">Click to see how guide cards open preview modals</p>
                    <button onclick="showGuideModal('Complete Guide to Macronutrients', 'Learn about proteins, carbohydrates, and fats - how much you need and the best sources for each.')" class="btn btn-primary">
                        View Guide Modal
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3 class="card-title">📝 Quick Registration</h3>
                    <p class="card-description">Test the quick registration modal</p>
                    <button onclick="showRegistrationModal()" class="btn btn-primary">
                        Open Registration
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3 class="card-title">💬 Quick Contact</h3>
                    <p class="card-description">Test the quick contact modal</p>
                    <button onclick="showContactModal()" class="btn btn-primary">
                        Open Contact Form
                    </button>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 3rem;">
            <div class="card-content">
                <h3 class="card-title">🔔 Notification System Demo</h3>
                <p class="card-description">Test different types of notifications</p>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 1rem;">
                    <button onclick="showNotification('This is a success message!', 'success')" class="btn btn-outline">Success</button>
                    <button onclick="showNotification('This is an error message!', 'error')" class="btn btn-outline">Error</button>
                    <button onclick="showNotification('This is a warning message!', 'warning')" class="btn btn-outline">Warning</button>
                    <button onclick="showNotification('This is an info message!', 'info')" class="btn btn-outline">Info</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <h3 class="card-title">📱 Mobile Menu Demo</h3>
                <p class="card-description">
                    Resize your browser window to less than 768px width or view on mobile to see the hamburger menu in action.
                    The mobile menu includes all navigation links and action buttons.
                </p>
                <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; margin-top: 1rem;">
                    <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">
                        <strong>Mobile Features:</strong><br>
                        • Hamburger menu button<br>
                        • Collapsible navigation<br>
                        • Touch-friendly buttons<br>
                        • Responsive design
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-gray">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Form Validation Demo</h2>
            <p class="section-description">Test the enhanced form validation features</p>
        </div>

        <div class="grid grid-2">
            <div class="card">
                <div class="card-content">
                    <h3 class="card-title">Login Form</h3>
                    <p class="card-description">Try the demo credentials: user@demo.com / demo123</p>
                    <a href="login.php" class="btn btn-primary">Test Login Form</a>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3 class="card-title">Registration Form</h3>
                    <p class="card-description">Test password strength indicator and validation</p>
                    <a href="register.php" class="btn btn-primary">Test Registration Form</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="cta">
            <h2 class="cta-title">All Features Are Now Functional!</h2>
            <p class="cta-description">
                The landing page now includes interactive modals, form validation, mobile menu, notifications, and smooth user experience enhancements.
            </p>
            <div class="cta-actions">
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
                <a href="register.php" class="btn btn-secondary">Start Using NutriTrack</a>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>