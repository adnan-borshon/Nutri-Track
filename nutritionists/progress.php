<?php include 'header.php'; ?>

<div class="section-header">
    <h1 class="section-title">Progress Log</h1>
    <p class="section-description">Track your users' progress and achievements</p>
</div>

<div class="stats">
    <div class="stat-card">
        <div class="stat-value">24</div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">18</div>
        <div class="stat-label">Active Plans</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">89%</div>
        <div class="stat-label">Success Rate</div>
    </div>
    <div class="stat-card">
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