<?php
// Nutritionist Actions Handler
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Sample data
$users = [
    ['id' => 1, 'name' => 'John Doe', 'goal' => 'Weight Loss', 'progress' => '75%', 'email' => 'john@example.com', 'phone' => '+1 (555) 123-4567'],
    ['id' => 2, 'name' => 'Jane Smith', 'goal' => 'Build Muscle', 'progress' => '45%', 'email' => 'jane@example.com', 'phone' => '+1 (555) 234-5678'],
    ['id' => 3, 'name' => 'Mike Johnson', 'goal' => 'Maintain', 'progress' => '90%', 'email' => 'mike@example.com', 'phone' => '+1 (555) 345-6789'],
    ['id' => 4, 'name' => 'Emily Davis', 'goal' => 'Weight Loss', 'progress' => '60%', 'email' => 'emily@example.com', 'phone' => '+1 (555) 456-7890']
];

$dietPlans = [
    ['id' => 1, 'name' => 'Weight Loss Plan - John Doe', 'calories' => 1800, 'duration' => 12, 'type' => 'weight_loss', 'user_id' => 1],
    ['id' => 2, 'name' => 'Muscle Building - Jane Smith', 'calories' => 2400, 'duration' => 16, 'type' => 'muscle_building', 'user_id' => 2],
    ['id' => 3, 'name' => 'Maintenance Plan - Mike Johnson', 'calories' => 2000, 'duration' => 8, 'type' => 'maintenance', 'user_id' => 3]
];

$suggestions = [
    ['id' => 1, 'name' => 'Greek Yogurt Bowl', 'category' => 'breakfast', 'calories' => 320, 'prep_time' => 5],
    ['id' => 2, 'name' => 'Grilled Chicken Salad', 'category' => 'lunch', 'calories' => 450, 'prep_time' => 15],
    ['id' => 3, 'name' => 'Baked Salmon', 'category' => 'dinner', 'calories' => 380, 'prep_time' => 25]
];

function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

switch ($action) {
    case 'create_diet_plan':
        $planName = $_POST['planName'] ?? '';
        $userId = $_POST['userId'] ?? '';
        $calories = $_POST['calories'] ?? 0;
        $duration = $_POST['duration'] ?? 0;
        $planType = $_POST['planType'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if (empty($planName) || empty($userId) || $calories <= 0 || $duration <= 0) {
            sendResponse(false, 'All required fields must be filled');
        }
        
        $newPlan = [
            'id' => count($dietPlans) + 1,
            'name' => $planName,
            'user_id' => (int)$userId,
            'calories' => (int)$calories,
            'duration' => (int)$duration,
            'type' => $planType,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Diet plan created successfully', $newPlan);
        break;
        
    case 'edit_diet_plan':
        $planId = $_POST['planId'] ?? 0;
        $planName = $_POST['planName'] ?? '';
        $description = $_POST['description'] ?? '';
        $calories = $_POST['calories'] ?? 0;
        $duration = $_POST['duration'] ?? 0;
        $planType = $_POST['planType'] ?? '';
        
        if ($planId <= 0 || empty($planName)) {
            sendResponse(false, 'Invalid plan data');
        }
        
        $updatedPlan = [
            'id' => (int)$planId,
            'name' => $planName,
            'description' => $description,
            'calories' => (int)$calories,
            'duration' => (int)$duration,
            'type' => $planType,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Diet plan updated successfully', $updatedPlan);
        break;
        
    case 'add_suggestion':
        $mealName = $_POST['mealName'] ?? '';
        $category = $_POST['category'] ?? '';
        $prepTime = $_POST['prepTime'] ?? 0;
        $calories = $_POST['calories'] ?? 0;
        $description = $_POST['description'] ?? '';
        $tags = $_POST['tags'] ?? '';
        
        if (empty($mealName) || empty($category) || $calories <= 0) {
            sendResponse(false, 'Meal name, category, and calories are required');
        }
        
        $newSuggestion = [
            'id' => count($suggestions) + 1,
            'name' => $mealName,
            'category' => $category,
            'prep_time' => (int)$prepTime,
            'calories' => (int)$calories,
            'description' => $description,
            'tags' => array_map('trim', explode(',', $tags)),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Meal suggestion added successfully', $newSuggestion);
        break;
        
    case 'send_message':
        $userId = $_POST['userId'] ?? 0;
        $message = $_POST['message'] ?? '';
        
        if ($userId <= 0 || empty($message)) {
            sendResponse(false, 'Invalid message data');
        }
        
        $newMessage = [
            'id' => rand(1000, 9999),
            'user_id' => (int)$userId,
            'message' => $message,
            'sender' => 'nutritionist',
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Message sent successfully', $newMessage);
        break;
        
    case 'update_profile':
        $fullName = $_POST['fullName'] ?? '';
        $email = $_POST['email'] ?? '';
        $specialty = $_POST['specialty'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $bio = $_POST['bio'] ?? '';
        
        if (empty($fullName) || empty($email)) {
            sendResponse(false, 'Name and email are required');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendResponse(false, 'Invalid email format');
        }
        
        $updatedProfile = [
            'full_name' => $fullName,
            'email' => $email,
            'specialty' => $specialty,
            'phone' => $phone,
            'bio' => $bio,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Profile updated successfully', $updatedProfile);
        break;
        
    case 'update_password':
        $currentPassword = $_POST['currentPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            sendResponse(false, 'All password fields are required');
        }
        
        if ($newPassword !== $confirmPassword) {
            sendResponse(false, 'New passwords do not match');
        }
        
        if (strlen($newPassword) < 8) {
            sendResponse(false, 'Password must be at least 8 characters long');
        }
        
        sendResponse(true, 'Password updated successfully');
        break;
        
    case 'get_user_details':
        $userId = $_GET['userId'] ?? 0;
        
        if ($userId <= 0) {
            sendResponse(false, 'Invalid user ID');
        }
        
        $user = array_filter($users, fn($u) => $u['id'] == $userId);
        $user = reset($user);
        
        if (!$user) {
            sendResponse(false, 'User not found');
        }
        
        $userDetails = array_merge($user, [
            'age' => rand(25, 45),
            'height' => rand(60, 75) . '"',
            'weight' => rand(120, 200) . ' lbs',
            'activity_level' => 'Moderate',
            'last_login' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 24) . ' hours'))
        ]);
        
        sendResponse(true, 'User details retrieved', $userDetails);
        break;
        
    case 'get_notifications':
        $notifications = [
            [
                'id' => 1,
                'title' => 'New message from John Doe',
                'message' => 'Thanks for the meal suggestions!',
                'type' => 'message',
                'time' => '2 min ago',
                'read' => false
            ],
            [
                'id' => 2,
                'title' => 'Sarah Wilson logged a meal',
                'message' => 'Breakfast: Greek yogurt bowl',
                'type' => 'activity',
                'time' => '10 min ago',
                'read' => false
            ],
            [
                'id' => 3,
                'title' => 'Mike Johnson completed workout',
                'message' => '30 min cardio session',
                'type' => 'activity',
                'time' => '1 hour ago',
                'read' => true
            ]
        ];
        
        sendResponse(true, 'Notifications retrieved', $notifications);
        break;
        
    case 'get_chat_history':
        $userId = $_GET['userId'] ?? 0;
        
        if ($userId <= 0) {
            sendResponse(false, 'Invalid user ID');
        }
        
        $chatHistory = [
            [
                'id' => 1,
                'message' => 'Hi! How can I help you today?',
                'sender' => 'nutritionist',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
                'id' => 2,
                'message' => 'I have a question about my meal plan',
                'sender' => 'user',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-1 hour 50 minutes'))
            ],
            [
                'id' => 3,
                'message' => 'Of course! What would you like to know?',
                'sender' => 'nutritionist',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-1 hour 45 minutes'))
            ]
        ];
        
        sendResponse(true, 'Chat history retrieved', $chatHistory);
        break;
        
    case 'toggle_notification':
        $notificationType = $_POST['notificationType'] ?? '';
        $enabled = $_POST['enabled'] ?? false;
        
        if (empty($notificationType)) {
            sendResponse(false, 'Invalid notification type');
        }
        
        $setting = [
            'type' => $notificationType,
            'enabled' => (bool)$enabled,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Notification setting updated', $setting);
        break;
        
    case 'get_dashboard_stats':
        $stats = [
            'assigned_users' => 24,
            'active_diet_plans' => 18,
            'pending_chats' => 5,
            'appointments_today' => 3,
            'user_growth' => '+4 this week',
            'plan_growth' => '+8 this week',
            'unread_messages' => 2,
            'next_appointment' => '2:00 PM'
        ];
        
        sendResponse(true, 'Dashboard stats retrieved', $stats);
        break;
        
    default:
        sendResponse(false, 'Invalid action specified');
}
?>