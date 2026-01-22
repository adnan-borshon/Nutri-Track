<?php
$page_title = "Admin Dashboard";
require_once '../includes/session.php';
checkAuth('admin');
$user = getCurrentUser();
include 'header-unified.php';
?>

<div class="space-y-6">
    <div class="page-header">
        <h1 class="page-title">Admin Dashboard</h1>
        <p class="page-description">Welcome back, <?php echo $user['name']; ?>! Overview of your platform performance</p>
    </div>

    <div class="grid grid-4 gap-6">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Total Users</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">2,847</div>
            <div class="stat-change positive">+12% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Nutritionists</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" />
                        <path d="M8 15a6 6 0 1 0 12 0v-3" />
                        <path d="M11 3v2" />
                        <path d="M6 3v2" />
                        <circle cx="20" cy="10" r="2" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">156</div>
            <div class="stat-change positive">+8% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Active Diet Plans</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 3c1.918 0 3.52 1.35 3.91 3.151a4 4 0 0 1 2.09 7.723l0 7.126h-12v-7.126a4 4 0 1 1 2.092 -7.723a4.002 4.002 0 0 1 3.908 -3.151z" />
                        <path d="M6.161 17.009l11.839 -.009" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">1,234</div>
            <div class="stat-change positive">+5% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Daily Active Users</div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" />
                        <path d="M11 4h2" />
                        <path d="M12 17v.01" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">892</div>
            <div class="stat-change negative">-3% this month</div>
        </div>
    </div>

    <div class="grid grid-2 gap-6">
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h3 class="card-title">User Growth</h3>
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 17l6 -6l4 4l8 -8" />
                            <path d="M14 7l7 0l0 7" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 60%; background: var(--success-color);"></div>
                        <span class="chart-label">Jan</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 70%; background: var(--success-color);"></div>
                        <span class="chart-label">Feb</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 77%; background: var(--success-color);"></div>
                        <span class="chart-label">Mar</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 83%; background: var(--success-color);"></div>
                        <span class="chart-label">Apr</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 90%; background: var(--success-color);"></div>
                        <span class="chart-label">May</span>
                    </div>
                    <div class="chart-bar">
                        <div class="chart-bar-fill" style="height: 95%; background: var(--success-color);"></div>
                        <span class="chart-label">Jun</span>
                    </div>
                </div>
                
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--success-color);"></div>
                        <span class="legend-label">Users</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--info-color);"></div>
                        <span class="legend-label">Nutritionists</span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h3 class="card-title">Weekly Activity</h3>
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 12m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                            <path d="M9 8m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                            <path d="M15 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                            <path d="M4 20l14 0" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <div class="chart-bar">
                        <div class="flex flex-col items-center gap-1 h-full justify-end">
                            <div style="height: 60%; width: 15px; background: var(--success-color); border-radius: 2px;"></div>
                            <div style="height: 45%; width: 15px; background: var(--info-color); border-radius: 2px;"></div>
                            <div style="height: 30%; width: 15px; background: var(--warning-color); border-radius: 2px;"></div>
                        </div>
                        <span class="chart-label">Mon</span>
                    </div>
                    <div class="chart-bar">
                        <div class="flex flex-col items-center gap-1 h-full justify-end">
                            <div style="height: 67%; width: 15px; background: var(--success-color); border-radius: 2px;"></div>
                            <div style="height: 52%; width: 15px; background: var(--info-color); border-radius: 2px;"></div>
                            <div style="height: 35%; width: 15px; background: var(--warning-color); border-radius: 2px;"></div>
                        </div>
                        <span class="chart-label">Tue</span>
                    </div>
                    <div class="chart-bar">
                        <div class="flex flex-col items-center gap-1 h-full justify-end">
                            <div style="height: 74%; width: 15px; background: var(--success-color); border-radius: 2px;"></div>
                            <div style="height: 58%; width: 15px; background: var(--info-color); border-radius: 2px;"></div>
                            <div style="height: 40%; width: 15px; background: var(--warning-color); border-radius: 2px;"></div>
                        </div>
                        <span class="chart-label">Wed</span>
                    </div>
                    <div class="chart-bar">
                        <div class="flex flex-col items-center gap-1 h-full justify-end">
                            <div style="height: 71%; width: 15px; background: var(--success-color); border-radius: 2px;"></div>
                            <div style="height: 55%; width: 15px; background: var(--info-color); border-radius: 2px;"></div>
                            <div style="height: 38%; width: 15px; background: var(--warning-color); border-radius: 2px;"></div>
                        </div>
                        <span class="chart-label">Thu</span>
                    </div>
                    <div class="chart-bar">
                        <div class="flex flex-col items-center gap-1 h-full justify-end">
                            <div style="height: 65%; width: 15px; background: var(--success-color); border-radius: 2px;"></div>
                            <div style="height: 50%; width: 15px; background: var(--info-color); border-radius: 2px;"></div>
                            <div style="height: 42%; width: 15px; background: var(--warning-color); border-radius: 2px;"></div>
                        </div>
                        <span class="chart-label">Fri</span>
                    </div>
                    <div class="chart-bar">
                        <div class="flex flex-col items-center gap-1 h-full justify-end">
                            <div style="height: 49%; width: 15px; background: var(--success-color); border-radius: 2px;"></div>
                            <div style="height: 42%; width: 15px; background: var(--info-color); border-radius: 2px;"></div>
                            <div style="height: 48%; width: 15px; background: var(--warning-color); border-radius: 2px;"></div>
                        </div>
                        <span class="chart-label">Sat</span>
                    </div>
                    <div class="chart-bar">
                        <div class="flex flex-col items-center gap-1 h-full justify-end">
                            <div style="height: 46%; width: 15px; background: var(--success-color); border-radius: 2px;"></div>
                            <div style="height: 43%; width: 15px; background: var(--info-color); border-radius: 2px;"></div>
                            <div style="height: 50%; width: 15px; background: var(--warning-color); border-radius: 2px;"></div>
                        </div>
                        <span class="chart-label">Sun</span>
                    </div>
                </div>
                
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--success-color);"></div>
                        <span class="legend-label">Meals</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--info-color);"></div>
                        <span class="legend-label">Water</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--warning-color);"></div>
                        <span class="legend-label">Sleep</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-3 gap-6">
        <div class="card" style="grid-column: span 2;">
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
            <div class="card-content text-center">
                <div style="width: 200px; height: 200px; border-radius: 50%; background: conic-gradient(var(--success-color) 0deg 162deg, var(--info-color) 162deg 252deg, var(--warning-color) 252deg 306deg, #8b5cf6 306deg 360deg); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: white;"></div>
                </div>
                
                <div class="grid grid-2 gap-2">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--success-color);"></div>
                        <span class="legend-label">Weight Loss (45%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--info-color);"></div>
                        <span class="legend-label">Maintain (25%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: var(--warning-color);"></div>
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

<?php include '../footer-unified.php'; ?>