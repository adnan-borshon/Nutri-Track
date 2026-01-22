// Main JavaScript for Landing Page Functionality
document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
        });
    }

    // Recipe Card Click Handlers
    const recipeCards = document.querySelectorAll('.recipe-card');
    recipeCards.forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function() {
            const title = this.querySelector('.recipe-title').textContent;
            const description = this.querySelector('.recipe-description').textContent;
            const category = this.querySelector('.recipe-category').textContent;
            showRecipeModal(title, description, category);
        });
    });

    // Guide Card Click Handlers
    const guideCards = document.querySelectorAll('.guide-card, .card');
    guideCards.forEach(card => {
        if (card.querySelector('.guide-title') || card.querySelector('h3')) {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function() {
                const title = this.querySelector('.guide-title, h3').textContent;
                const description = this.querySelector('.guide-description, p').textContent;
                showGuideModal(title, description);
            });
        }
    });

    // CTA Button Enhancements
    const ctaButtons = document.querySelectorAll('.btn');
    ctaButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.href && this.href.includes('register.php')) {
                e.preventDefault();
                showRegistrationModal();
            } else if (this.href && this.href.includes('contact.php')) {
                e.preventDefault();
                showContactModal();
            }
        });
    });

    // Form Validation Enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
});

// Recipe Modal Function
function showRecipeModal(title, description, category) {
    const modal = createModal('Recipe Details', `
        <div class="recipe-modal-content">
            <div class="recipe-category-badge">${category}</div>
            <h3 style="margin: 1rem 0; color: #111827;">${title}</h3>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">${description}</p>
            <div class="recipe-preview-note">
                <p style="background: #f0fdf4; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #278b63; margin: 1rem 0;">
                    <strong>🔒 Premium Recipe</strong><br>
                    Sign up to access the full recipe with ingredients, instructions, and nutrition facts.
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button onclick="closeModal()" class="btn btn-outline">Close</button>
                <a href="register.php" class="btn btn-primary">Get Full Recipe →</a>
            </div>
        </div>
    `);
    document.body.appendChild(modal);
}

// Guide Modal Function
function showGuideModal(title, description) {
    const modal = createModal('Guide Preview', `
        <div class="guide-modal-content">
            <h3 style="margin: 1rem 0; color: #111827;">${title}</h3>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">${description}</p>
            <div class="guide-preview-note">
                <p style="background: #f0fdf4; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #278b63; margin: 1rem 0;">
                    <strong>📖 Premium Guide</strong><br>
                    This is a preview. Sign up to read the complete guide with expert tips and actionable advice.
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button onclick="closeModal()" class="btn btn-outline">Close</button>
                <a href="register.php" class="btn btn-primary">Read Full Guide →</a>
            </div>
        </div>
    `);
    document.body.appendChild(modal);
}

// Registration Modal Function
function showRegistrationModal() {
    const modal = createModal('Quick Sign Up', `
        <form id="quick-register-form" class="form">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" placeholder="Enter your name" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" placeholder="Enter your email" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" placeholder="Create password" required class="form-input">
            </div>
            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
            <p style="font-size: 0.75rem; color: #6b7280; text-align: center; margin-top: 1rem;">
                Already have an account? <a href="login.php" style="color: #278b63;">Sign in</a>
            </p>
        </form>
    `);
    document.body.appendChild(modal);
    
    // Handle form submission
    document.getElementById('quick-register-form').addEventListener('submit', function(e) {
        e.preventDefault();
        showNotification('Account created successfully! Welcome to NutriTrack!', 'success');
        setTimeout(() => {
            closeModal();
            window.location.href = '../user/dashboard.php';
        }, 2000);
    });
}

// Contact Modal Function
function showContactModal() {
    const modal = createModal('Quick Contact', `
        <form id="quick-contact-form" class="form">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" placeholder="Your name" required class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" placeholder="your@email.com" required class="form-input">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" placeholder="How can we help?" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Message</label>
                <textarea name="message" placeholder="Tell us more..." required class="form-textarea" rows="4"></textarea>
            </div>
            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
        </form>
    `);
    document.body.appendChild(modal);
    
    // Handle form submission
    document.getElementById('quick-contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        showNotification('Message sent successfully! We\'ll get back to you soon.', 'success');
        setTimeout(() => {
            closeModal();
        }, 2000);
    });
}

// Generic Modal Creator
function createModal(title, content) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">${title}</h2>
                <button onclick="closeModal()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                ${content}
            </div>
        </div>
    `;
    
    // Close modal when clicking overlay
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    return modal;
}

// Close Modal Function
function closeModal() {
    const modal = document.querySelector('.modal-overlay');
    if (modal) {
        modal.remove();
    }
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <span>${getNotificationIcon(type)}</span>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

function getNotificationIcon(type) {
    const icons = {
        success: '✅',
        error: '❌',
        warning: '⚠️',
        info: 'ℹ️'
    };
    return icons[type] || icons.info;
}

// Form Validation
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            showFieldError(input, 'This field is required');
            isValid = false;
        } else if (input.type === 'email' && !isValidEmail(input.value)) {
            showFieldError(input, 'Please enter a valid email');
            isValid = false;
        } else {
            clearFieldError(input);
        }
    });
    
    return isValid;
}

function showFieldError(input, message) {
    clearFieldError(input);
    input.style.borderColor = '#ef4444';
    const error = document.createElement('div');
    error.className = 'field-error';
    error.style.cssText = 'color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;';
    error.textContent = message;
    input.parentNode.appendChild(error);
}

function clearFieldError(input) {
    input.style.borderColor = '';
    const error = input.parentNode.querySelector('.field-error');
    if (error) {
        error.remove();
    }
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Scroll to Top Function
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Add scroll to top button if page is long
window.addEventListener('scroll', function() {
    const scrollBtn = document.getElementById('scroll-to-top');
    if (window.pageYOffset > 300) {
        if (!scrollBtn) {
            createScrollToTopButton();
        }
    } else if (scrollBtn) {
        scrollBtn.remove();
    }
});

function createScrollToTopButton() {
    const btn = document.createElement('button');
    btn.id = 'scroll-to-top';
    btn.innerHTML = '↑';
    btn.style.cssText = `
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: #278b63;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 1.25rem;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    `;
    btn.addEventListener('click', scrollToTop);
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.1)';
    });
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
    document.body.appendChild(btn);
}