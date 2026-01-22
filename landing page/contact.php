<?php
$page_title = "Contact";
include '../includes/header.php';

$contactInfo = [
    ['icon' => '✉️', 'title' => 'Email', 'value' => 'support@nutritrack.com', 'description' => 'We respond within 24 hours'],
    ['icon' => '📞', 'title' => 'Phone', 'value' => '+1 (555) 123-4567', 'description' => 'Mon-Fri 9am-5pm EST'],
    ['icon' => '📍', 'title' => 'Office', 'value' => '123 Health Street', 'description' => 'San Francisco, CA 94102'],
    ['icon' => '🕒', 'title' => 'Business Hours', 'value' => 'Mon - Fri', 'description' => '9:00 AM - 5:00 PM EST']
];

$faqs = [
    ['question' => 'How do I reset my password?', 'answer' => 'Click the "Forgot Password" link on the login page and follow the instructions sent to your email.'],
    ['question' => 'Can I cancel my subscription anytime?', 'answer' => 'Yes, you can cancel your subscription at any time from your account settings. No cancellation fees apply.'],
    ['question' => 'How do I contact my nutritionist?', 'answer' => 'Use the in-app chat feature to message your assigned nutritionist directly.']
];

$message_sent = false;
if ($_POST && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {
    $message_sent = true;
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    const messageTextarea = document.getElementById('message');
    
    if (messageTextarea) {
        messageTextarea.addEventListener('input', function() {
            const length = this.value.length;
            const minLength = 10;
            const indicator = this.parentNode.querySelector('.char-indicator');
            
            if (!indicator) {
                const div = document.createElement('div');
                div.className = 'char-indicator';
                div.style.cssText = 'font-size: 0.75rem; margin-top: 0.25rem;';
                this.parentNode.appendChild(div);
            }
            
            const indicatorEl = this.parentNode.querySelector('.char-indicator');
            if (length < minLength) {
                indicatorEl.style.color = '#ef4444';
                indicatorEl.textContent = `${length}/${minLength} characters (minimum required)`;
            } else {
                indicatorEl.style.color = '#22c55e';
                indicatorEl.textContent = `${length} characters`;
            }
        });
    }
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            
            if (message.length < 10) {
                const notification = document.createElement('div');
                notification.className = 'notification notification-error';
                notification.innerHTML = '<div style="display: flex; align-items: center; gap: 0.5rem;"><span>❌</span><span>Message must be at least 10 characters long!</span></div>';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 5000);
                return;
            }
            
            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = 'Sending...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                const notification = document.createElement('div');
                notification.className = 'notification notification-success';
                notification.innerHTML = '<div style="display: flex; align-items: center; gap: 0.5rem;"><span>✅</span><span>Message sent successfully! We\'ll get back to you within 24 hours.</span></div>';
                document.body.appendChild(notification);
                
                // Reset form
                this.reset();
                submitBtn.innerHTML = 'Send Message 📤';
                submitBtn.disabled = false;
                
                // Remove character indicator
                const indicator = document.querySelector('.char-indicator');
                if (indicator) indicator.remove();
                
                setTimeout(() => notification.remove(), 5000);
            }, 2000);
        });
    }
    
    // FAQ Toggle Functionality
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        
        if (question && answer) {
            question.style.cursor = 'pointer';
            question.style.userSelect = 'none';
            answer.style.display = 'none';
            
            question.addEventListener('click', function() {
                const isVisible = answer.style.display === 'block';
                
                // Close all other FAQ items
                faqItems.forEach(otherItem => {
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    const otherQuestion = otherItem.querySelector('.faq-question');
                    if (otherAnswer && otherQuestion !== question) {
                        otherAnswer.style.display = 'none';
                        otherQuestion.style.color = '';
                    }
                });
                
                // Toggle current item
                if (isVisible) {
                    answer.style.display = 'none';
                    question.style.color = '';
                } else {
                    answer.style.display = 'block';
                    question.style.color = '#278b63';
                }
            });
        }
    });
});
</script>
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h1 class="section-title" style="font-size: 3rem;">Get in Touch</h1>
            <p class="section-description">
                Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 4rem;">
            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        💬 Send us a Message
                    </h2>
                </div>
                <div style="padding: 1.5rem;">
                    <?php if ($message_sent): ?>
                        <div class="alert alert-success">
                            <div class="alert-header">
                                <span>✓</span>
                                <span>Message Sent!</span>
                            </div>
                            <p>We'll get back to you within 24 hours.</p>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="form" id="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" placeholder="Your name" required class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" placeholder="your@email.com" required class="form-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="form-label">Subject</label>
                            <select id="subject" name="subject" required class="form-input">
                                <option value="">Select a topic</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Technical Support</option>
                                <option value="billing">Billing Question</option>
                                <option value="feature">Feature Request</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="message" placeholder="Tell us more about your inquiry..." required class="form-textarea" rows="5"></textarea>
                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Minimum 10 characters</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Send Message 📤
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600;">Contact Information</h3>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($contactInfo as $info): ?>
                        <div class="contact-info">
                            <div class="contact-icon"><?php echo $info['icon']; ?></div>
                            <div class="contact-details">
                                <h4><?php echo $info['title']; ?></h4>
                                <p><?php echo $info['value']; ?></p>
                                <p class="description"><?php echo $info['description']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                <h2 style="font-size: 1.25rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    ❓ Frequently Asked Questions
                </h2>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <?php foreach ($faqs as $faq): ?>
                        <div class="faq-item">
                            <h4 class="faq-question"><?php echo $faq['question']; ?></h4>
                            <p class="faq-answer"><?php echo $faq['answer']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>