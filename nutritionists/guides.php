<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
include 'header.php';
?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Nutrition Guides</h1>
            <p class="section-description">Educational resources for your users</p>
        </div>
        <button class="btn btn-primary" onclick="showCreateGuideModal()">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Create Guide</button>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; padding: 1rem;">
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer;" onclick="window.location.href='guide-detail.php?id=1'" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; background: #dcfce7; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#278b63;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <span style="background: #dcfce7; color: #278b63; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">Beginner</span>
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.5rem 0; color: #111827;">Understanding Macronutrients</h3>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1rem 0; line-height: 1.4;">Learn about proteins, carbohydrates, and fats and their role in your diet.</p>
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #6b7280;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.5rem; height: 1.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem; font-weight: bold;">DS</div>
                <span>Dr. Sarah Smith</span>
            </div>
            <span>5 min read</span>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer;" onclick="window.location.href='guide-detail.php?id=2'" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; background: #fef3c7; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#d97706;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-3.97-3.97a.75.75 0 0 0-1.06 0L12 16.94l-3.97-3.97a.75.75 0 0 0-1.06 0L3 16.94V21a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-4.06Z" />
                </svg>
            </div>
            <span style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">Meal Planning</span>
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.5rem 0; color: #111827;">Portion Control Guide</h3>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1rem 0; line-height: 1.4;">Master the art of portion control with practical tips and visual guides.</p>
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #6b7280;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.5rem; height: 1.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem; font-weight: bold;">DS</div>
                <span>Dr. Sarah Smith</span>
            </div>
            <span>8 min read</span>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer;" onclick="window.location.href='guide-detail.php?id=3'" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; background: #dbeafe; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:20px;height:20px;stroke-width:1.5;color:#3b82f6;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
                </svg>
            </div>
            <span style="background: #dbeafe; color: #3b82f6; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">Hydration</span>
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.5rem 0; color: #111827;">Hydration and Health</h3>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1rem 0; line-height: 1.4;">Discover the importance of proper hydration for optimal health and performance.</p>
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #6b7280;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.5rem; height: 1.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem; font-weight: bold;">DS</div>
                <span>Dr. Sarah Smith</span>
            </div>
            <span>6 min read</span>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer;" onclick="window.location.href='guide-detail.php?id=4'" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; background: #fce7f3; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#ec4899;">
                    <path d="M13 4m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    <path d="M4 17l5 1l.75 -1.5" />
                    <path d="M15 21l0 -4l-4 -3l1 -6" />
                    <path d="M7 12l0 -3l5 -1l3 3l3 1" />
                </svg>
            </div>
            <span style="background: #fce7f3; color: #ec4899; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">Exercise</span>
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.5rem 0; color: #111827;">Nutrition for Active Lifestyles</h3>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1rem 0; line-height: 1.4;">Fuel your workouts with proper nutrition before, during, and after exercise.</p>
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #6b7280;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.5rem; height: 1.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem; font-weight: bold;">DS</div>
                <span>Dr. Sarah Smith</span>
            </div>
            <span>10 min read</span>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer;" onclick="window.location.href='guide-detail.php?id=5'" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; background: #f3e8ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#8b5cf6;">
                    <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17h-11v-14h-2" />
                    <path d="M6 5l14 1l-1 7h-13" />
                </svg>
            </div>
            <span style="background: #f3e8ff; color: #8b5cf6; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">Shopping</span>
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.5rem 0; color: #111827;">Healthy Grocery Shopping</h3>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1rem 0; line-height: 1.4;">Navigate the grocery store like a pro with these healthy shopping strategies.</p>
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #6b7280;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.5rem; height: 1.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem; font-weight: bold;">DS</div>
                <span>Dr. Sarah Smith</span>
            </div>
            <span>7 min read</span>
        </div>
    </div>
    
    <div style="background: white; border-radius: 0.75rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer;" onclick="window.location.href='guide-detail.php?id=6'" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <div style="width: 2.5rem; height: 2.5rem; background: #fef2f2; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#ef4444;">
                    <path d="M7 20l10 0" />
                    <path d="M6 6l6 -1l6 1" />
                    <path d="M12 3l0 17" />
                    <path d="M9 12l-3 -6l-3 6a3 3 0 0 0 6 0" />
                    <path d="M21 12l-3 -6l-3 6a3 3 0 0 0 6 0" />
                </svg>
            </div>
            <span style="background: #fef2f2; color: #ef4444; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">Weight Management</span>
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.5rem 0; color: #111827;">Sustainable Weight Loss</h3>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1rem 0; line-height: 1.4;">Achieve lasting weight loss with evidence-based strategies and mindful eating.</p>
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #6b7280;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.5rem; height: 1.5rem; background: #278b63; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.625rem; font-weight: bold;">DS</div>
                <span>Dr. Sarah Smith</span>
            </div>
            <span>12 min read</span>
        </div>
    </div>
</div>

<script>
function showCreateGuideModal() {
    showNotification('Create Guide feature coming soon!', 'info');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.375rem;
        color: white;
        font-weight: 500;
        z-index: 1000;
        max-width: 300px;
    `;
    
    const colors = {
        success: '#278b63',
        error: '#dc2626',
        info: '#3b82f6'
    };
    
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>