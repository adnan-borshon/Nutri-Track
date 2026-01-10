<?php $page_title = "Diet Plan"; $_SESSION['user_name'] = 'John Doe'; $_SESSION['user_logged_in'] = true; include 'header.php'; ?>
<div class="section">
    <div>
        <h1 class="section-title">Diet Plan</h1>
        <p class="section-description">Your personalized nutrition plan</p>
    </div>
    <div class="cta">
        <div style="font-size: 4rem; margin-bottom: 1rem;">📋</div>
        <h3 class="cta-title">No Diet Plan Yet</h3>
        <p class="cta-description">Schedule a consultation with a nutritionist to get your personalized diet plan.</p>
        <a href="appointments.php" class="btn btn-primary">Book Consultation</a>
    </div>
</div>
<?php include 'footer.php'; ?>