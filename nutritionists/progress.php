<?php
require_once '../includes/session.php';
checkAuth('nutritionist');
include 'header.php';
?>

<div class="section-header">
    <h1 class="section-title">Progress Log</h1>
    <p class="section-description">Track your users' progress and achievements</p>
</div>

<div class="stats">
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
        </div>
        <div class="stat-value">24</div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg>
        </div>
        <div class="stat-value">18</div>
        <div class="stat-label">Active Plans</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trophy" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21l8 0" /><path d="M12 17l0 4" /><path d="M7 4l10 0" /><path d="M17 4v8a5 5 0 0 1 -10 0v-8" /><path d="M5 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19 9m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>
        </div>
        <div class="stat-value">89%</div>
        <div class="stat-label">Success Rate</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-stats" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /></svg>
        </div>
        <div class="stat-value">156</div>
        <div class="stat-label">Total Sessions</div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">User Progress Overview</h3>
        
        <div class="chart-container">
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 75%; background: #16a34a;"></div>
                <span class="faq-answer">John D.</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 45%; background: #f59e0b;"></div>
                <span class="faq-answer">Jane S.</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 90%; background: #16a34a;"></div>
                <span class="faq-answer">Mike J.</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 60%; background: #f59e0b;"></div>
                <span class="faq-answer">Emily D.</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 30%; background: #dc2626;"></div>
                <span class="faq-answer">Sarah W.</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 85%; background: #16a34a;"></div>
                <span class="faq-answer">Chris B.</span>
            </div>
        </div>
        
        <div class="admin-chart-legend">
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #16a34a;"></div>
                <span class="admin-legend-label">On Track (>70%)</span>
            </div>
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #f59e0b;"></div>
                <span class="admin-legend-label">Needs Attention (40-70%)</span>
            </div>
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #dc2626;"></div>
                <span class="admin-legend-label">At Risk (<40%)</span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Recent Progress Updates</h3>
        
        <div class="admin-activity-list">
            <div class="admin-activity-item">
                <div class="admin-activity-info">
                    <div class="admin-activity-dot"></div>
                    <div>
                        <p class="admin-activity-title">John Doe completed Week 8</p>
                        <p class="admin-activity-subtitle">Lost 2.5 lbs this week • Goal: 75% complete</p>
                    </div>
                </div>
                <div class="admin-activity-meta">
                    <span class="status-badge confirmed">On Track</span>
                    <span class="admin-activity-time">2 hours ago</span>
                </div>
            </div>
            
            <div class="admin-activity-item">
                <div class="admin-activity-info">
                    <div class="admin-activity-dot"></div>
                    <div>
                        <p class="admin-activity-title">Mike Johnson reached target weight</p>
                        <p class="admin-activity-subtitle">Maintenance phase started • Goal: 90% complete</p>
                    </div>
                </div>
                <div class="admin-activity-meta">
                    <span class="status-badge confirmed">Excellent</span>
                    <span class="admin-activity-time">1 day ago</span>
                </div>
            </div>
            
            <div class="admin-activity-item">
                <div class="admin-activity-info">
                    <div class="admin-activity-dot"></div>
                    <div>
                        <p class="admin-activity-title">Sarah Wilson missed check-in</p>
                        <p class="admin-activity-subtitle">No progress update for 5 days • Goal: 30% complete</p>
                    </div>
                </div>
                <div class="admin-activity-meta">
                    <span class="status-badge pending">Needs Follow-up</span>
                    <span class="admin-activity-time">3 days ago</span>
                </div>
            </div>
            
            <div class="admin-activity-item">
                <div class="admin-activity-info">
                    <div class="admin-activity-dot"></div>
                    <div>
                        <p class="admin-activity-title">Chris Brown gained muscle mass</p>
                        <p class="admin-activity-subtitle">Added 3 lbs lean muscle • Goal: 85% complete</p>
                    </div>
                </div>
                <div class="admin-activity-meta">
                    <span class="status-badge confirmed">Great Progress</span>
                    <span class="admin-activity-time">1 week ago</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>