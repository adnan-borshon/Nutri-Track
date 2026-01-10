<?php
$page_title = "Chat";
$_SESSION['user_name'] = 'John Doe';
$_SESSION['user_logged_in'] = true;
include 'header.php';

$messages = [
    ['sender' => 'nutritionist', 'name' => 'Dr. Sarah Smith', 'message' => 'Hello! How are you feeling today?', 'time' => '10:30 AM'],
    ['sender' => 'user', 'name' => 'You', 'message' => 'Hi Dr. Smith! I\'m doing well, thanks for asking.', 'time' => '10:32 AM'],
    ['sender' => 'nutritionist', 'name' => 'Dr. Sarah Smith', 'message' => 'Great to hear! I noticed you\'ve been consistent with your meal logging. Keep up the good work!', 'time' => '10:35 AM'],
    ['sender' => 'user', 'name' => 'You', 'message' => 'Thank you! I have a question about portion sizes for dinner.', 'time' => '10:37 AM']
];
?>

<div class="section" style="height: calc(100vh - 200px);">
    <div>
        <h1 class="section-title">Chat with Nutritionist</h1>
        <p class="section-description">Get personalized advice and support</p>
    </div>

    <div class="card" style="flex: 1; display: flex; flex-direction: column;">
        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.75rem;">
            <div class="team-avatar">DS</div>
            <div>
                <p class="card-title">Dr. Sarah Smith</p>
                <p class="card-description">🟢 Online</p>
            </div>
        </div>

        <div style="flex: 1; padding: 1rem; overflow-y: auto; display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($messages as $message): ?>
                <div style="display: flex; <?php echo $message['sender'] === 'user' ? 'justify-content: flex-end;' : 'justify-content: flex-start;'; ?>">
                    <div style="max-width: 70%; display: flex; flex-direction: column; gap: 0.25rem;">
                        <div style="background: <?php echo $message['sender'] === 'user' ? '#16a34a' : '#f3f4f6'; ?>; color: <?php echo $message['sender'] === 'user' ? 'white' : '#374151'; ?>; padding: 0.75rem 1rem; border-radius: 1rem; <?php echo $message['sender'] === 'user' ? 'border-bottom-right-radius: 0.25rem;' : 'border-bottom-left-radius: 0.25rem;'; ?>">
                            <?php echo $message['message']; ?>
                        </div>
                        <p class="stat-label" style="<?php echo $message['sender'] === 'user' ? 'text-align: right;' : 'text-align: left;'; ?>">
                            <?php echo $message['time']; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="padding: 1rem; border-top: 1px solid #e5e7eb;">
            <div style="display: flex; gap: 0.75rem;">
                <input type="text" placeholder="Type your message..." class="form-input" style="flex: 1;">
                <button class="btn btn-primary">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;stroke-width:1.5;vertical-align:middle;margin-right:4px;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
</svg> Send</button>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>