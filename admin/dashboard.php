<?php include 'header.php'; ?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="text-muted-foreground">Overview of your platform performance</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Total Users</div>
                <div class="stat-icon">👥</div>
            </div>
            <div class="stat-value">2,847</div>
            <div class="stat-change positive">+12% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Nutritionists</div>
                <div class="stat-icon">🩺</div>
            </div>
            <div class="stat-value">156</div>
            <div class="stat-change positive">+8% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Active Diet Plans</div>
                <div class="stat-icon">👨🍳</div>
            </div>
            <div class="stat-value">1,234</div>
            <div class="stat-change positive">+5% this month</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Daily Active Users</div>
                <div class="stat-icon">📱</div>
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
                    <div class="chart-icon">📈</div>
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
                    <div class="chart-icon">📊</div>
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