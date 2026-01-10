<?php include 'header.php'; ?>

<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="text-3xl font-bold">Diet Plans</h1>
            <p class="text-muted-foreground">Create and manage personalized diet plans</p>
        </div>
        <button class="btn btn-primary">➕ Create New Plan</button>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">🍎</div>
                <h3 class="diet-plan-title">Weight Loss Plan - John Doe</h3>
                <p class="diet-plan-description">1,800 calories/day • High protein, low carb</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">📅 Created: Mar 15, 2024</span>
                    <span class="meta-item">⏱️ Duration: 12 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm">✏️ Edit</button>
                    <button class="btn btn-outline btn-sm">👁️ View</button>
                </div>
            </div>
        </div>
    
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">💪</div>
                <h3 class="diet-plan-title">Muscle Building - Jane Smith</h3>
                <p class="diet-plan-description">2,400 calories/day • High protein, balanced carbs</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">📅 Created: Mar 10, 2024</span>
                    <span class="meta-item">⏱️ Duration: 16 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm">✏️ Edit</button>
                    <button class="btn btn-outline btn-sm">👁️ View</button>
                </div>
            </div>
        </div>
    
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">⚖️</div>
                <h3 class="diet-plan-title">Maintenance Plan - Mike Johnson</h3>
                <p class="diet-plan-description">2,000 calories/day • Balanced macros</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">📅 Created: Mar 8, 2024</span>
                    <span class="meta-item">⏱️ Duration: 8 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm">✏️ Edit</button>
                    <button class="btn btn-outline btn-sm">👁️ View</button>
                </div>
            </div>
        </div>
    
        <div class="diet-plan-card">
            <div class="diet-plan-content">
                <div class="diet-plan-icon">🥗</div>
                <h3 class="diet-plan-title">Weight Loss Plan - Emily Davis</h3>
                <p class="diet-plan-description">1,600 calories/day • Low carb, high fiber</p>
                <div class="diet-plan-meta">
                    <span class="meta-item">📅 Created: Mar 5, 2024</span>
                    <span class="meta-item">⏱️ Duration: 10 weeks</span>
                </div>
                <div class="diet-plan-actions">
                    <button class="btn btn-primary btn-sm">✏️ Edit</button>
                    <button class="btn btn-outline btn-sm">👁️ View</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>