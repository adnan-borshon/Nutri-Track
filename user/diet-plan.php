<?php
$page_title = "Diet Plan";
require_once '../includes/session.php';
checkAuth('user');
$user = getCurrentUser();
include 'header.php';
?>
<div class="section">
    <div>
        <h1 class="section-title">Diet Plan</h1>
        <p class="section-description">Your personalized nutrition plan</p>
    </div>
    <div class="cta">
        <div style="font-size: 4rem; margin-bottom: 1rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:64px;height:64px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
</svg>
        </div>
        <h3 class="cta-title">No Diet Plan Yet</h3>
        <p class="cta-description">Schedule a consultation with a nutritionist to get your personalized diet plan.</p>
        <a href="appointments.php" class="btn btn-primary">Book Consultation</a>
    </div>
</div>
<?php include 'footer.php'; ?>