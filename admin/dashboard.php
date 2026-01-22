<?php
$page_title = "Admin Dashboard";
require_once '../includes/session.php';
checkAuth('admin');
$user = getCurrentUser();
include 'header.php';
?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <p class="text-muted-foreground">Welcome back, <?php echo $user['name']; ?>! Overview of your platform performance</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Total Users</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                </div>
            </div>
            <div class="stat-value">2,847</div>
            <div class="stat-change positive">+12% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Nutritionists</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-stethoscope" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" /><path d="M8 15a6 6 0 1 0 12 0v-3" /><path d="M11 3v2" /><path d="M6 3v2" /><circle cx="20" cy="10" r="2" /></svg>
                </div>
            </div>
            <div class="stat-value">156</div>
            <div class="stat-change positive">+8% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Active Diet Plans</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chef-hat" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c1.918 0 3.52 1.35 3.91 3.151a4 4 0 0 1 2.09 7.723l0 7.126h-12v-7.126a4 4 0 1 1 2.092 -7.723a4.002 4.002 0 0 1 3.908 -3.151z" /><path d="M6.161 17.009l11.839 -.009" /></svg>
                </div>
            </div>
            <div class="stat-value">1,234</div>
            <div class="stat-change positive">+5% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Daily Active Users</div>
                <div class="stat-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
                </div>
            </div>
            <div class="stat-value">892</div>
            <div class="stat-change negative">-3% this month</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <div class="card-header-content">
                    <h3 class="card-title">User Growth</h3>
                    <div class="chart-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 60%; background: #16a34a;"></div>
                        <span class="chart-label">Jan</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 70%; background: #16a34a;"></div>
                        <span class="chart-label">Feb</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 77%; background: #16a34a;"></div>
                        <span class="chart-label">Mar</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 83%; background: #16a34a;"></div>
                        <span class="chart-label">Apr</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 90%; background: #16a34a;"></div>
                        <span class="chart-label">May</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 95%; background: #16a34a;"></div>
                        <span class="chart-label">Jun</span>
                    </div>
                </div>
                
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #16a34a;"></div>
                        <span class="legend-label">Users</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #3b82f6;"></div>
                        <span class="legend-label">Nutritionists</span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">
                <div class="card-header-content">
                    <h3 class="card-title">Weekly Activity</h3>
                    <div class="chart-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chart-bar" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M4 20l14 0" /></svg>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: 60%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: 45%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: 30%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label">Mon</span>
                    </div>
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: 67%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: 52%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: 35%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label">Tue</span>
                    </div>
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: 74%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: 58%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: 40%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label">Wed</span>
                    </div>
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: 71%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: 55%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: 38%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label">Thu</span>
                    </div>
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: 65%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: 50%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: 42%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label">Fri</span>
                    </div>
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: 49%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: 42%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: 48%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label">Sat</span>
                    </div>
                    <div class="chart-bar">
                        <div class="stacked-bars">
                            <div class="stacked-bar" style="height: 46%; background: #16a34a;"></div>
                            <div class="stacked-bar" style="height: 43%; background: #3b82f6;"></div>
                            <div class="stacked-bar" style="height: 50%; background: #f59e0b;"></div>
                        </div>
                        <span class="chart-label">Sun</span>
                    </div>
                </div>
                
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #16a34a;"></div>
                        <span class="legend-label">Meals</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #3b82f6;"></div>
                        <span class="legend-label">Water</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f59e0b;"></div>
                        <span class="legend-label">Sleep</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="card lg:col-span-2">
            <div class="card-header">
                <h3 class="card-title">Recent Activity</h3>
            </div>
            <div class="card-content">
                <div class="space-y-4">
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-dot"></div>
                            <div>
                                <p class="activity-title">New user registered</p>
                                <p class="activity-subtitle">Emma Wilson</p>
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="activity-badge user">user</span>
                            <span class="activity-time">2 min ago</span>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-dot"></div>
                            <div>
                                <p class="activity-title">Diet plan created</p>
                                <p class="activity-subtitle">Dr. Smith</p>
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="activity-badge plan">plan</span>
                            <span class="activity-time">15 min ago</span>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-dot"></div>
                            <div>
                                <p class="activity-title">New nutritionist approved</p>
                                <p class="activity-subtitle">Dr. Chen</p>
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="activity-badge nutritionist">nutritionist</span>
                            <span class="activity-time">1 hour ago</span>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-dot"></div>
                            <div>
                                <p class="activity-title">Food item added</p>
                                <p class="activity-subtitle">Admin</p>
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="activity-badge food">food</span>
                            <span class="activity-time">2 hours ago</span>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-dot"></div>
                            <div>
                                <p class="activity-title">User report generated</p>
                                <p class="activity-subtitle">System</p>
                            </div>
                        </div>
                        <div class="activity-meta">
                            <span class="activity-badge report">report</span>
                            <span class="activity-time">3 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Goals Distribution</h3>
            </div>
            <div class="card-content">
                <div class="pie-chart">
                    <div class="pie-inner"></div>
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #16a34a;"></div>
                        <span class="legend-label">Weight Loss (45%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #3b82f6;"></div>
                        <span class="legend-label">Maintain (25%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #f59e0b;"></div>
                        <span class="legend-label">Gain Weight (15%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: #8b5cf6;"></div>
                        <span class="legend-label">Build Muscle (15%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>