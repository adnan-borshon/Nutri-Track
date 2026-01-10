<?php include 'header.php'; ?>

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">My Users</h1>
        <p class="text-muted-foreground">Manage your assigned users and their progress</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search users...">
            </div>
        </div>
        <div class="card-content">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">JD</div>
                        <h3 class="user-card-name">John Doe</h3>
                        <p class="user-card-goal">Weight Loss Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 75%</span>
                            <span class="activity-text">Last active: 2 hours ago</span>
                        </div>
                        <div class="user-card-actions">
                            <a href="user-detail.php?id=1" class="btn btn-primary btn-sm">View Details</a>
                            <a href="chat.php?user=1" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat</a>
                        </div>
                    </div>
                </div>
            
                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">JS</div>
                        <h3 class="user-card-name">Jane Smith</h3>
                        <p class="user-card-goal">Build Muscle Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 45%</span>
                            <span class="activity-text">Last active: 1 day ago</span>
                        </div>
                        <div class="user-card-actions">
                            <a href="user-detail.php?id=2" class="btn btn-primary btn-sm">View Details</a>
                            <a href="chat.php?user=2" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat</a>
                        </div>
                    </div>
                </div>
            
                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">MJ</div>
                        <h3 class="user-card-name">Mike Johnson</h3>
                        <p class="user-card-goal">Maintain Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 90%</span>
                            <span class="activity-text">Last active: 30 min ago</span>
                        </div>
                        <div class="user-card-actions">
                            <a href="user-detail.php?id=3" class="btn btn-primary btn-sm">View Details</a>
                            <a href="chat.php?user=3" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat</a>
                        </div>
                    </div>
                </div>
            
                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">ED</div>
                        <h3 class="user-card-name">Emily Davis</h3>
                        <p class="user-card-goal">Weight Loss Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 60%</span>
                            <span class="activity-text">Last active: 5 hours ago</span>
                        </div>
                        <div class="user-card-actions">
                            <a href="user-detail.php?id=4" class="btn btn-primary btn-sm">View Details</a>
                            <a href="chat.php?user=4" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat</a>
                        </div>
                    </div>
                </div>
            
                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">SW</div>
                        <h3 class="user-card-name">Sarah Wilson</h3>
                        <p class="user-card-goal">Weight Loss Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 30%</span>
                            <span class="activity-text">Last active: 1 hour ago</span>
                        </div>
                        <div class="user-card-actions">
                            <a href="user-detail.php?id=5" class="btn btn-primary btn-sm">View Details</a>
                            <a href="chat.php?user=5" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat</a>
                        </div>
                    </div>
                </div>
            
                <div class="user-card">
                    <div class="user-card-content">
                        <div class="user-avatar-large">CB</div>
                        <h3 class="user-card-name">Chris Brown</h3>
                        <p class="user-card-goal">Build Muscle Goal</p>
                        <div class="user-card-stats">
                            <span class="progress-text">Progress: 85%</span>
                            <span class="activity-text">Last active: 3 hours ago</span>
                        </div>
                        <div class="user-card-actions">
                            <a href="user-detail.php?id=6" class="btn btn-primary btn-sm">View Details</a>
                            <a href="chat.php?user=6" class="btn btn-outline btn-sm">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:4px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>