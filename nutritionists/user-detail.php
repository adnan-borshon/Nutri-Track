<?php include 'header.php'; ?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">John Doe</h1>
            <p class="section-description">Weight Loss Goal • Started March 15, 2024</p>
        </div>
        <div class="admin-action-buttons">
            <a href="chat.php?user=1" class="btn btn-primary">💬 Chat</a>
            <button class="btn btn-outline">📋 Edit Plan</button>
        </div>
    </div>
</div>

<div class="grid grid-3">
    <div class="stat-card">
        <div class="stat-value">75%</div>
        <div class="stat-label">Goal Progress</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">-12 lbs</div>
        <div class="stat-label">Weight Lost</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">8 weeks</div>
        <div class="stat-label">Time Active</div>
    </div>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-content">
            <h3 class="card-title">Personal Information</h3>
            <div class="contact-info">
                <div class="contact-icon">👤</div>
                <div class="contact-details">
                    <h4>Basic Info</h4>
                    <p>Age: 32 • Height: 5'10" • Starting Weight: 185 lbs</p>
                    <p class="description">Current Weight: 173 lbs • Target: 165 lbs</p>
                </div>
            </div>
            
            <div class="contact-info">
                <div class="contact-icon">📧</div>
                <div class="contact-details">
                    <h4>Contact</h4>
                    <p>john.doe@email.com</p>
                    <p class="description">+1 (555) 123-4567</p>
                </div>
            </div>
            
            <div class="contact-info">
                <div class="contact-icon">🎯</div>
                <div class="contact-details">
                    <h4>Goals</h4>
                    <p>Lose 20 lbs in 12 weeks</p>
                    <p class="description">Improve energy levels and fitness</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <h3 class="card-title">Current Diet Plan</h3>
            <div class="recipe-meta">
                <span>🔥 1,800 calories/day</span>
                <span>🥩 High protein, low carb</span>
            </div>
            
            <div class="admin-activity-list">
                <div class="admin-activity-item">
                    <div class="admin-activity-info">
                        <div class="card-icon">🍳</div>
                        <div>
                            <p class="admin-activity-title">Breakfast</p>
                            <p class="admin-activity-subtitle">Greek yogurt with berries • 320 cal</p>
                        </div>
                    </div>
                </div>
                
                <div class="admin-activity-item">
                    <div class="admin-activity-info">
                        <div class="card-icon">🥗</div>
                        <div>
                            <p class="admin-activity-title">Lunch</p>
                            <p class="admin-activity-subtitle">Grilled chicken salad • 450 cal</p>
                        </div>
                    </div>
                </div>
                
                <div class="admin-activity-item">
                    <div class="admin-activity-info">
                        <div class="card-icon">🐟</div>
                        <div>
                            <p class="admin-activity-title">Dinner</p>
                            <p class="admin-activity-subtitle">Baked salmon with vegetables • 480 cal</p>
                        </div>
                    </div>
                </div>
                
                <div class="admin-activity-item">
                    <div class="admin-activity-info">
                        <div class="card-icon">🍎</div>
                        <div>
                            <p class="admin-activity-title">Snacks</p>
                            <p class="admin-activity-subtitle">Apple with almond butter • 190 cal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Progress Chart</h3>
        
        <div class="chart-container">
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 100%; background: #dc2626;"></div>
                <span class="faq-answer">Week 1</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 95%; background: #f59e0b;"></div>
                <span class="faq-answer">Week 2</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 90%; background: #f59e0b;"></div>
                <span class="faq-answer">Week 3</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 85%; background: #16a34a;"></div>
                <span class="faq-answer">Week 4</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 80%; background: #16a34a;"></div>
                <span class="faq-answer">Week 5</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 78%; background: #16a34a;"></div>
                <span class="faq-answer">Week 6</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 75%; background: #16a34a;"></div>
                <span class="faq-answer">Week 7</span>
            </div>
            <div class="chart-bar">
                <div class="chart-bar-fill" style="height: 73%; background: #16a34a;"></div>
                <span class="faq-answer">Week 8</span>
            </div>
        </div>
        
        <div class="admin-chart-legend">
            <div class="admin-legend-item">
                <div class="admin-legend-dot" style="background: #16a34a;"></div>
                <span class="admin-legend-label">Weight (lbs)</span>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>