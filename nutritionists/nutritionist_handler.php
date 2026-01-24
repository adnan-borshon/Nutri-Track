<?php
// Nutritionist Actions Handler
require_once '../includes/session.php';
require_once '../includes/notifications.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

checkAuth('nutritionist');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$nutritionistId = $_SESSION['user_id'];

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
        handleCreateDietPlan($nutritionistId);
        break;
    case 'edit_diet_plan':
        handleEditDietPlan($nutritionistId);
        break;
    case 'delete_diet_plan':
        handleDeleteDietPlan($nutritionistId);
        break;
    case 'get_diet_plans':
        handleGetDietPlans($nutritionistId);
        break;
    case 'get_assigned_users':
        handleGetAssignedUsers($nutritionistId);
        break;
    case 'get_messages':
        handleGetMessages($nutritionistId);
        break;
    case 'send_message':
        handleSendMessage($nutritionistId);
        break;
    case 'get_chat_history':
        handleGetChatHistory($nutritionistId);
        break;
    case 'get_conversations':
        handleGetConversations($nutritionistId);
        break;
    case 'update_profile':
        handleUpdateProfile($nutritionistId);
        break;
    case 'update_password':
        handleUpdatePassword($nutritionistId);
        break;
    case 'get_user_details':
        handleGetUserDetails($nutritionistId);
        break;
    case 'get_dashboard_stats':
        handleGetDashboardStats($nutritionistId);
        break;
    case 'update_appointment_status':
        handleUpdateAppointmentStatus($nutritionistId);
        break;
    case 'get_meal_plan':
        handleGetMealPlan($nutritionistId);
        break;
    default:
        sendResponse(false, 'Invalid action specified');
}

// =============================================
// DIET PLAN FUNCTIONS
// =============================================

function handleCreateDietPlan($nutritionistId) {
    $planName = sanitize($_POST['planName'] ?? '');
    $userId = intval($_POST['userId'] ?? 0);
    $calories = intval($_POST['calories'] ?? 0);
    $duration = intval($_POST['duration'] ?? 0);
    $description = sanitize($_POST['description'] ?? '');
    $proteinGoal = intval($_POST['proteinGoal'] ?? 0);
    $carbsGoal = intval($_POST['carbsGoal'] ?? 0);
    $fatGoal = intval($_POST['fatGoal'] ?? 0);
    
    if (empty($planName) || empty($userId) || $calories <= 0) {
        sendResponse(false, 'Plan name, user, and calories are required');
    }
    
    try {
        $db = getDB();
        
        // Verify user is assigned to this nutritionist
        $stmt = $db->prepare("SELECT id FROM users WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$userId, $nutritionistId]);
        if (!$stmt->fetch()) {
            sendResponse(false, 'User is not assigned to you');
        }
        
        $stmt = $db->prepare("INSERT INTO diet_plans (user_id, nutritionist_id, name, description, daily_calories, protein_goal, carbs_goal, fat_goal, duration_weeks, start_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), 'active')");
        $stmt->execute([$userId, $nutritionistId, $planName, $description, $calories, $proteinGoal, $carbsGoal, $fatGoal, $duration]);
        
        $planId = $db->lastInsertId();
        
        sendResponse(true, 'Diet plan created successfully', ['id' => $planId]);
    } catch (PDOException $e) {
        error_log("Create diet plan error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleEditDietPlan($nutritionistId) {
    $planId = intval($_POST['planId'] ?? 0);
    $planName = sanitize($_POST['planName'] ?? '');
    $calories = intval($_POST['calories'] ?? 0);
    $duration = intval($_POST['duration'] ?? 0);
    $description = sanitize($_POST['description'] ?? '');
    $status = sanitize($_POST['status'] ?? 'active');
    
    if ($planId <= 0 || empty($planName)) {
        sendResponse(false, 'Invalid plan data');
    }
    
    try {
        $db = getDB();
        
        // Verify plan belongs to this nutritionist
        $stmt = $db->prepare("SELECT id FROM diet_plans WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$planId, $nutritionistId]);
        if (!$stmt->fetch()) {
            sendResponse(false, 'Diet plan not found');
        }
        
        $stmt = $db->prepare("UPDATE diet_plans SET name = ?, description = ?, daily_calories = ?, duration_weeks = ?, status = ? WHERE id = ?");
        $stmt->execute([$planName, $description, $calories, $duration, $status, $planId]);
        
        // Handle meal plan data
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
        
        // Delete existing meal plan data
        $stmt = $db->prepare("DELETE FROM diet_plan_meals WHERE diet_plan_id = ?");
        $stmt->execute([$planId]);
        
        // Insert new meal plan data
        foreach ($days as $day) {
            foreach ($mealTypes as $mealType) {
                $mealKey = "meal_{$day}_{$mealType}";
                $mealItems = sanitize($_POST[$mealKey] ?? '');
                
                if (!empty($mealItems)) {
                    $stmt = $db->prepare("INSERT INTO diet_plan_meals (diet_plan_id, day_of_week, meal_type, meal_items) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$planId, $day, $mealType, $mealItems]);
                }
            }
        }
        
        sendResponse(true, 'Diet plan updated successfully');
    } catch (PDOException $e) {
        error_log("Edit diet plan error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleDeleteDietPlan($nutritionistId) {
    $planId = intval($_POST['planId'] ?? 0);
    
    if ($planId <= 0) {
        sendResponse(false, 'Invalid plan ID');
    }
    
    try {
        $db = getDB();
        
        // Verify plan belongs to this nutritionist
        $stmt = $db->prepare("SELECT name FROM diet_plans WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$planId, $nutritionistId]);
        $plan = $stmt->fetch();
        
        if (!$plan) {
            sendResponse(false, 'Diet plan not found');
        }
        
        $stmt = $db->prepare("DELETE FROM diet_plans WHERE id = ?");
        $stmt->execute([$planId]);
        
        sendResponse(true, $plan['name'] . ' deleted successfully');
    } catch (PDOException $e) {
        error_log("Delete diet plan error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetDietPlans($nutritionistId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT dp.*, u.name as user_name 
                              FROM diet_plans dp 
                              JOIN users u ON dp.user_id = u.id 
                              WHERE dp.nutritionist_id = ? 
                              ORDER BY dp.created_at DESC");
        $stmt->execute([$nutritionistId]);
        $plans = $stmt->fetchAll();
        
        sendResponse(true, 'Diet plans retrieved', $plans);
    } catch (PDOException $e) {
        error_log("Get diet plans error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// USER MANAGEMENT FUNCTIONS
// =============================================

function handleGetAssignedUsers($nutritionistId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT u.id, u.name, u.email, u.goal, u.status, u.created_at,
                              (SELECT COUNT(*) FROM diet_plans WHERE user_id = u.id AND status = 'active') as active_plans
                              FROM users u 
                              WHERE u.nutritionist_id = ? AND u.role = 'user'
                              ORDER BY u.name ASC");
        $stmt->execute([$nutritionistId]);
        $users = $stmt->fetchAll();
        
        sendResponse(true, 'Users retrieved', $users);
    } catch (PDOException $e) {
        error_log("Get assigned users error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetUserDetails($nutritionistId) {
    $userId = intval($_GET['userId'] ?? $_POST['userId'] ?? 0);
    
    if ($userId <= 0) {
        sendResponse(false, 'Invalid user ID');
    }
    
    try {
        $db = getDB();
        
        // Verify user is assigned to this nutritionist
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$userId, $nutritionistId]);
        $user = $stmt->fetch();
        
        if (!$user) {
            sendResponse(false, 'User not found or not assigned to you');
        }
        
        // Get user's diet plans
        $stmt = $db->prepare("SELECT * FROM diet_plans WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        $dietPlans = $stmt->fetchAll();
        
        // Get recent meal logs
        $stmt = $db->prepare("SELECT ml.*, f.name as food_name, f.calories 
                              FROM meal_logs ml 
                              JOIN foods f ON ml.food_id = f.id 
                              WHERE ml.user_id = ? 
                              ORDER BY ml.log_date DESC, ml.created_at DESC 
                              LIMIT 10");
        $stmt->execute([$userId]);
        $mealLogs = $stmt->fetchAll();
        
        unset($user['password']);
        
        sendResponse(true, 'User details retrieved', [
            'user' => $user,
            'diet_plans' => $dietPlans,
            'meal_logs' => $mealLogs
        ]);
    } catch (PDOException $e) {
        error_log("Get user details error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// CHAT FUNCTIONS
// =============================================

function handleGetMessages($nutritionistId) {
    $userId = intval($_GET['user_id'] ?? $_POST['user_id'] ?? 0);
    
    if ($userId <= 0) {
        sendResponse(false, 'Invalid user ID');
    }
    
    try {
        $db = getDB();
        
        // Verify user is assigned to this nutritionist
        $stmt = $db->prepare("SELECT id FROM users WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$userId, $nutritionistId]);
        if (!$stmt->fetch()) {
            sendResponse(false, 'User is not assigned to you');
        }
        
        $stmt = $db->prepare("SELECT m.*, 
                              CASE WHEN m.sender_id = ? THEN 'nutritionist' ELSE 'user' END as sender_type
                              FROM messages m 
                              WHERE (m.sender_id = ? AND m.receiver_id = ?) 
                                 OR (m.sender_id = ? AND m.receiver_id = ?)
                              ORDER BY m.created_at ASC");
        $stmt->execute([$nutritionistId, $nutritionistId, $userId, $userId, $nutritionistId]);
        $messages = $stmt->fetchAll();
        
        // Mark messages as read
        $stmt = $db->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
        $stmt->execute([$userId, $nutritionistId]);
        
        sendResponse(true, 'Messages retrieved', ['messages' => $messages]);
    } catch (PDOException $e) {
        error_log("Get messages error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleSendMessage($nutritionistId) {
    $userId = intval($_POST['user_id'] ?? $_POST['userId'] ?? 0);
    $message = sanitize($_POST['message'] ?? '');
    
    if ($userId <= 0 || empty($message)) {
        sendResponse(false, 'Invalid message data');
    }
    
    try {
        $db = getDB();
        
        // Verify user is assigned to this nutritionist
        $stmt = $db->prepare("SELECT id FROM users WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$userId, $nutritionistId]);
        if (!$stmt->fetch()) {
            sendResponse(false, 'User is not assigned to you');
        }
        
        $stmt = $db->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$nutritionistId, $userId, $message]);
        
        $messageId = $db->lastInsertId();
        
        sendResponse(true, 'Message sent successfully', ['id' => $messageId]);
    } catch (PDOException $e) {
        error_log("Send message error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetChatHistory($nutritionistId) {
    $userId = intval($_GET['userId'] ?? $_POST['userId'] ?? 0);
    
    if ($userId <= 0) {
        sendResponse(false, 'Invalid user ID');
    }
    
    try {
        $db = getDB();
        
        $stmt = $db->prepare("SELECT m.*, 
                              CASE WHEN m.sender_id = ? THEN 'nutritionist' ELSE 'user' END as sender_type
                              FROM messages m 
                              WHERE (m.sender_id = ? AND m.receiver_id = ?) 
                                 OR (m.sender_id = ? AND m.receiver_id = ?)
                              ORDER BY m.created_at ASC");
        $stmt->execute([$nutritionistId, $nutritionistId, $userId, $userId, $nutritionistId]);
        $messages = $stmt->fetchAll();
        
        // Mark messages as read
        $stmt = $db->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
        $stmt->execute([$userId, $nutritionistId]);
        
        sendResponse(true, 'Chat history retrieved', $messages);
    } catch (PDOException $e) {
        error_log("Get chat history error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetConversations($nutritionistId) {
    try {
        $db = getDB();
        
        // Get all users assigned to this nutritionist with their latest message
        $stmt = $db->prepare("SELECT u.id, u.name, u.email,
                              (SELECT message FROM messages 
                               WHERE (sender_id = u.id AND receiver_id = ?) OR (sender_id = ? AND receiver_id = u.id)
                               ORDER BY created_at DESC LIMIT 1) as last_message,
                              (SELECT created_at FROM messages 
                               WHERE (sender_id = u.id AND receiver_id = ?) OR (sender_id = ? AND receiver_id = u.id)
                               ORDER BY created_at DESC LIMIT 1) as last_message_time,
                              (SELECT COUNT(*) FROM messages 
                               WHERE sender_id = u.id AND receiver_id = ? AND is_read = 0) as unread_count
                              FROM users u 
                              WHERE u.nutritionist_id = ? AND u.role = 'user'
                              ORDER BY last_message_time DESC");
        $stmt->execute([$nutritionistId, $nutritionistId, $nutritionistId, $nutritionistId, $nutritionistId, $nutritionistId]);
        $conversations = $stmt->fetchAll();
        
        sendResponse(true, 'Conversations retrieved', $conversations);
    } catch (PDOException $e) {
        error_log("Get conversations error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// PROFILE & SETTINGS FUNCTIONS
// =============================================

function handleUpdateProfile($nutritionistId) {
    $fullName = sanitize($_POST['fullName'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $specialty = sanitize($_POST['specialty'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    
    if (empty($fullName) || empty($email)) {
        sendResponse(false, 'Name and email are required');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse(false, 'Invalid email format');
    }
    
    try {
        $db = getDB();
        
        // Check if email is already used by another user
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $nutritionistId]);
        if ($stmt->fetch()) {
            sendResponse(false, 'Email already in use');
        }
        
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, specialty = ?, phone = ? WHERE id = ?");
        $stmt->execute([$fullName, $email, $specialty, $phone, $nutritionistId]);
        
        $_SESSION['user_name'] = $fullName;
        
        sendResponse(true, 'Profile updated successfully');
    } catch (PDOException $e) {
        error_log("Update profile error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleUpdatePassword($nutritionistId) {
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        sendResponse(false, 'All password fields are required');
    }
    
    if ($newPassword !== $confirmPassword) {
        sendResponse(false, 'New passwords do not match');
    }
    
    if (strlen($newPassword) < 6) {
        sendResponse(false, 'Password must be at least 6 characters long');
    }
    
    try {
        $db = getDB();
        
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$nutritionistId]);
        $user = $stmt->fetch();
        
        if (!$user || !verifyPassword($currentPassword, $user['password'])) {
            sendResponse(false, 'Current password is incorrect');
        }
        
        $hashedPassword = hashPassword($newPassword);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $nutritionistId]);
        
        sendResponse(true, 'Password updated successfully');
    } catch (PDOException $e) {
        error_log("Update password error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// DASHBOARD FUNCTIONS
// =============================================

function handleGetDashboardStats($nutritionistId) {
    try {
        $db = getDB();
        
        // Count assigned users
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE nutritionist_id = ? AND role = 'user'");
        $stmt->execute([$nutritionistId]);
        $assignedUsers = $stmt->fetch()['count'];
        
        // Count active diet plans
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM diet_plans WHERE nutritionist_id = ? AND status = 'active'");
        $stmt->execute([$nutritionistId]);
        $activePlans = $stmt->fetch()['count'];
        
        // Count unread messages
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = 0");
        $stmt->execute([$nutritionistId]);
        $unreadMessages = $stmt->fetch()['count'];
        
        // Count today's appointments
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM appointments WHERE nutritionist_id = ? AND appointment_date = CURDATE()");
        $stmt->execute([$nutritionistId]);
        $todayAppointments = $stmt->fetch()['count'];
        
        $stats = [
            'assigned_users' => $assignedUsers,
            'active_diet_plans' => $activePlans,
            'unread_messages' => $unreadMessages,
            'appointments_today' => $todayAppointments
        ];
        
        sendResponse(true, 'Dashboard stats retrieved', $stats);
    } catch (PDOException $e) {
        error_log("Get dashboard stats error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// APPOINTMENT FUNCTIONS
// =============================================

function handleUpdateAppointmentStatus($nutritionistId) {
    $appointmentId = intval($_POST['appointment_id'] ?? 0);
    $status = sanitize($_POST['status'] ?? '');
    
    if ($appointmentId <= 0 || empty($status)) {
        sendResponse(false, 'Invalid appointment data');
    }
    
    $validStatuses = ['confirmed', 'completed', 'cancelled', 'pending'];
    if (!in_array($status, $validStatuses)) {
        sendResponse(false, 'Invalid status');
    }
    
    try {
        $db = getDB();
        
        // Verify appointment belongs to this nutritionist
        $stmt = $db->prepare("SELECT id FROM appointments WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$appointmentId, $nutritionistId]);
        if (!$stmt->fetch()) {
            sendResponse(false, 'Appointment not found');
        }
        
        $stmt = $db->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        $stmt->execute([$status, $appointmentId]);
        
        // Create notification for user
        require_once '../includes/notifications.php';
        $stmt = $db->prepare("SELECT user_id FROM appointments WHERE id = ?");
        $stmt->execute([$appointmentId]);
        $appointment = $stmt->fetch();
        
        if ($appointment) {
            $messages = [
                'confirmed' => 'Your appointment request has been accepted',
                'completed' => 'Your appointment has been completed',
                'cancelled' => 'Your appointment has been cancelled'
            ];
            if (isset($messages[$status])) {
                createNotification($appointment['user_id'], 'appointment_update', 'Appointment Update', $messages[$status]);
            }
        }
        
        $statusMessages = [
            'confirmed' => 'Appointment request accepted',
            'completed' => 'Appointment marked as completed',
            'cancelled' => 'Appointment cancelled'
        ];
        $statusMessage = $statusMessages[$status] ?? 'Appointment status updated';
        sendResponse(true, $statusMessage);
    } catch (PDOException $e) {
        error_log("Update appointment status error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// MEAL PLAN FUNCTIONS
// =============================================

function handleGetMealPlan($nutritionistId) {
    $planId = intval($_GET['planId'] ?? 0);
    
    if ($planId <= 0) {
        sendResponse(false, 'Invalid plan ID');
    }
    
    try {
        $db = getDB();
        
        // Verify plan belongs to this nutritionist
        $stmt = $db->prepare("SELECT id FROM diet_plans WHERE id = ? AND nutritionist_id = ?");
        $stmt->execute([$planId, $nutritionistId]);
        if (!$stmt->fetch()) {
            sendResponse(false, 'Diet plan not found');
        }
        
        $stmt = $db->prepare("SELECT day_of_week, meal_type, meal_items FROM diet_plan_meals WHERE diet_plan_id = ?");
        $stmt->execute([$planId]);
        $meals = $stmt->fetchAll();
        
        sendResponse(true, 'Meal plan retrieved', ['meals' => $meals]);
    } catch (PDOException $e) {
        error_log("Get meal plan error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}
?>