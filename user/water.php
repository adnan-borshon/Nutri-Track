<?php
$page_title = "Water Tracking";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
include 'header.php';

$glasses = 5;
$target = 8;
$percentage = round(($glasses / $target) * 100);
$weeklyData = [6, 8, 7, 8, 5, 6, 0];
$weeklyAverage = round(array_sum($weeklyData) / 7);
?>

<div class="section">
    <div>
        <h1 class="section-title">Water Tracking</h1>
        <p class="section-description">Stay hydrated throughout the day</p>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div class="card-content" style="padding: 2rem; text-align: center;">
                <div style="width: 180px; height: 180px; margin: 0 auto 1.5rem; position: relative;">
                    <svg width="180" height="180" style="transform: rotate(-90deg);">
                        <circle cx="90" cy="90" r="70" stroke="#f3f4f6" stroke-width="12" fill="none"/>
                        <circle cx="90" cy="90" r="70" stroke="#06b6d4" stroke-width="12" fill="none" 
                                stroke-dasharray="<?php echo 2 * pi() * 70; ?>" 
                                stroke-dashoffset="<?php echo 2 * pi() * 70 * (1 - $glasses / $target); ?>"/>
                    </svg>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                        <div class="stat-value"><?php echo $glasses; ?></div>
                        <div class="stat-label">glasses</div>
                    </div>
                </div>
                
                <h2 class="card-title" style="font-size: 1.5rem; margin-bottom: 0.5rem;">
                    <?php echo $glasses; ?> of <?php echo $target; ?> glasses
                </h2>
                <p class="card-description" style="margin-bottom: 1.5rem;">
                    <?php if ($glasses >= $target): ?>
                        Great job! You've reached your goal!
                    <?php else: ?>
                        <?php echo $target - $glasses; ?> more glass<?php echo ($target - $glasses) !== 1 ? 'es' : ''; ?> to go
                    <?php endif; ?>
                </p>

                <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <button class="btn btn-outline" style="width: 3rem; height: 3rem; border-radius: 50%; padding: 0;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
</svg>
                    </button>
                    <button class="btn btn-primary" style="padding: 0.75rem 2rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg> Add Glass</button>
                </div>

                <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <button class="btn btn-outline">+1</button>
                    <button class="btn btn-outline">+2</button>
                    <button class="btn btn-outline">+3</button>
                    <button class="btn btn-outline">+4</button>
                </div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card">
                <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 class="card-title">Today's Stats</h3>
                </div>
                <div class="card-content">
                    <div class="grid grid-3">
                        <div class="stat-card">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
</svg>
                        </div>
                            <p class="stat-value"><?php echo $glasses; ?></p>
                            <p class="stat-label">Glasses</p>
                        </div>
                        <div class="stat-card">
                            <p class="stat-value"><?php echo $glasses * 250; ?></p>
                            <p class="stat-label">ml consumed</p>
                        </div>
                        <div class="stat-card">
                            <p class="stat-value"><?php echo $percentage; ?>%</p>
                            <p class="stat-label">of goal</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($glasses >= $target): ?>
                <div class="card" style="background: rgba(6, 182, 212, 0.1); border-color: rgba(6, 182, 212, 0.2);">
                    <div class="card-content" style="display: flex; align-items: center; gap: 1rem;">
                        <div class="card-icon" style="background: rgba(6, 182, 212, 0.2); font-size: 1.5rem;">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:24px;height:24px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M15.5 4.323c1.88.799 3.5 2.409 4.5 4.677a.75.75 0 0 1-1.5.5c-.8-1.8-2.1-3.2-3.8-3.9a.75.75 0 0 1 .8-1.277Z" />
</svg>
                        </div>
                        <div>
                            <h3 class="card-title">Daily Goal Achieved!</h3>
                            <p class="card-description">Keep up the great hydration habits</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between;">
            <h3 class="card-title">Weekly Overview</h3>
            <p class="card-description">Average: <?php echo $weeklyAverage; ?> glasses/day</p>
        </div>
        <div class="card-content">
            <div style="height: 250px; display: flex; align-items: end; justify-content: space-between; gap: 1rem;">
                <?php foreach ($weeklyData as $i => $glasses): ?>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1;">
                        <div style="width: 100%; height: <?php echo $glasses * 25; ?>px; background: #06b6d4; border-radius: 4px; min-height: 4px;"></div>
                        <span class="stat-label"><?php echo ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$i]; ?></span>
                        <span class="recipe-tag"><?php echo $glasses; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>