<?php
/**
 * User Actions Handler
 * Handles all user-related CRUD operations
 */
require_once '../includes/session.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

checkAuth('user');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$userId = $_SESSION['user_id'];

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
    // Meal Logging
    case 'log_meal':
        handleLogMeal($userId);
        break;
    case 'get_meals':
        handleGetMeals($userId);
        break;
    case 'delete_meal':
        handleDeleteMeal($userId);
        break;
    
    // Water Tracking
    case 'log_water':
        handleLogWater($userId);
        break;
    case 'get_water':
        handleGetWater($userId);
        break;
    
    // Sleep Tracking
    case 'log_sleep':
        handleLogSleep($userId);
        break;
    case 'get_sleep':
        handleGetSleep($userId);
        break;
    
    // Weight Tracking
    case 'log_weight':
        handleLogWeight($userId);
        break;
    case 'get_weight_history':
        handleGetWeightHistory($userId);
        break;
    
    // Diet Plan
    case 'get_diet_plan':
        handleGetDietPlan($userId);
        break;
    
    // Chat with Nutritionist
    case 'send_message':
        handleSendMessage($userId);
        break;
    case 'get_chat_history':
        handleGetChatHistory($userId);
        break;
    
    // Profile & Settings
    case 'update_profile':
        handleUpdateProfile($userId);
        break;
    case 'update_password':
        handleUpdatePassword($userId);
        break;
    case 'get_profile':
        handleGetProfile($userId);
        break;
    
    // Dashboard
    case 'get_dashboard_stats':
        handleGetDashboardStats($userId);
        break;
    
    // Food Search
    case 'search_foods':
        handleSearchFoods();
        break;
    case 'get_food_categories':
        handleGetFoodCategories();
        break;
    
    // Trends
    case 'get_trends':
        handleGetTrends($userId);
        break;
    
    // Appointments
    case 'book_appointment':
        handleBookAppointment($userId);
        break;
    case 'cancel_appointment':
        handleCancelAppointment($userId);
        break;
    
    // Goals
    case 'update_goals':
        handleUpdateGoals($userId);
        break;
    case 'get_goals':
        handleGetGoals($userId);
        break;
    
    // Diet Plan
    case 'request_plan_change':
        handleRequestPlanChange($userId);
        break;
    case 'get_shopping_list':
        handleGetShoppingList($userId);
        break;
    
    // Export
    case 'export_data':
        handleExportData($userId);
        break;
    
    default:
        sendResponse(false, 'Invalid action specified');
}

// =============================================
// MEAL LOGGING FUNCTIONS
// =============================================

function handleLogMeal($userId) {
    $foodId = intval($_POST['food_id'] ?? 0);
    $mealType = sanitize($_POST['meal_type'] ?? '');
    $servings = floatval($_POST['servings'] ?? 1);
    $logDate = sanitize($_POST['log_date'] ?? date('Y-m-d'));
    
    if ($foodId <= 0 || empty($mealType)) {
        sendResponse(false, 'Food and meal type are required');
    }
    
    $validMealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
    if (!in_array($mealType, $validMealTypes)) {
        sendResponse(false, 'Invalid meal type');
    }
    
    try {
        $db = getDB();
        
        // Verify food exists
        $stmt = $db->prepare("SELECT name FROM foods WHERE id = ?");
        $stmt->execute([$foodId]);
        $food = $stmt->fetch();
        
        if (!$food) {
            sendResponse(false, 'Food not found');
        }
        
        $stmt = $db->prepare("INSERT INTO meal_logs (user_id, food_id, meal_type, servings, log_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $foodId, $mealType, $servings, $logDate]);
        
        sendResponse(true, $food['name'] . ' logged successfully');
    } catch (PDOException $e) {
        error_log("Log meal error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetMeals($userId) {
    $logDate = sanitize($_GET['date'] ?? $_POST['date'] ?? date('Y-m-d'));
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT ml.*, f.name as food_name, f.calories, f.protein, f.carbs, f.fat, c.name as category_name
                              FROM meal_logs ml
                              JOIN foods f ON ml.food_id = f.id
                              LEFT JOIN food_categories c ON f.category_id = c.id
                              WHERE ml.user_id = ? AND ml.log_date = ?
                              ORDER BY FIELD(ml.meal_type, 'breakfast', 'lunch', 'dinner', 'snack'), ml.created_at");
        $stmt->execute([$userId, $logDate]);
        $meals = $stmt->fetchAll();
        
        // Calculate totals
        $totals = ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fat' => 0];
        foreach ($meals as $meal) {
            $totals['calories'] += $meal['calories'] * $meal['servings'];
            $totals['protein'] += $meal['protein'] * $meal['servings'];
            $totals['carbs'] += $meal['carbs'] * $meal['servings'];
            $totals['fat'] += $meal['fat'] * $meal['servings'];
        }
        
        sendResponse(true, 'Meals retrieved', ['meals' => $meals, 'totals' => $totals]);
    } catch (PDOException $e) {
        error_log("Get meals error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleDeleteMeal($userId) {
    $mealId = intval($_POST['meal_id'] ?? 0);
    
    if ($mealId <= 0) {
        sendResponse(false, 'Invalid meal ID');
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM meal_logs WHERE id = ? AND user_id = ?");
        $stmt->execute([$mealId, $userId]);
        
        if ($stmt->rowCount() > 0) {
            sendResponse(true, 'Meal deleted successfully');
        } else {
            sendResponse(false, 'Meal not found');
        }
    } catch (PDOException $e) {
        error_log("Delete meal error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// WATER TRACKING FUNCTIONS
// =============================================

function handleLogWater($userId) {
    $glasses = intval($_POST['glasses'] ?? 0);
    $logDate = sanitize($_POST['log_date'] ?? date('Y-m-d'));
    
    if ($glasses < 0) {
        sendResponse(false, 'Invalid water amount');
    }
    
    try {
        $db = getDB();
        
        // Use INSERT ... ON DUPLICATE KEY UPDATE for upsert
        $stmt = $db->prepare("INSERT INTO water_logs (user_id, glasses, log_date) VALUES (?, ?, ?)
                              ON DUPLICATE KEY UPDATE glasses = ?");
        $stmt->execute([$userId, $glasses, $logDate, $glasses]);
        
        sendResponse(true, 'Water intake logged successfully');
    } catch (PDOException $e) {
        error_log("Log water error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetWater($userId) {
    $logDate = sanitize($_GET['date'] ?? $_POST['date'] ?? date('Y-m-d'));
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM water_logs WHERE user_id = ? AND log_date = ?");
        $stmt->execute([$userId, $logDate]);
        $water = $stmt->fetch();
        
        sendResponse(true, 'Water data retrieved', $water ?: ['glasses' => 0, 'log_date' => $logDate]);
    } catch (PDOException $e) {
        error_log("Get water error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// SLEEP TRACKING FUNCTIONS
// =============================================

function handleLogSleep($userId) {
    $hours = floatval($_POST['hours'] ?? 0);
    $quality = sanitize($_POST['quality'] ?? '');
    $bedtime = sanitize($_POST['bedtime'] ?? '');
    $wakeTime = sanitize($_POST['wake_time'] ?? '');
    $logDate = sanitize($_POST['log_date'] ?? date('Y-m-d'));
    
    if ($hours <= 0 || $hours > 24) {
        sendResponse(false, 'Invalid sleep hours');
    }
    
    $validQualities = ['excellent', 'good', 'fair', 'poor'];
    if (!empty($quality) && !in_array($quality, $validQualities)) {
        sendResponse(false, 'Invalid sleep quality');
    }
    
    try {
        $db = getDB();
        
        $stmt = $db->prepare("INSERT INTO sleep_logs (user_id, hours, quality, bedtime, wake_time, log_date) VALUES (?, ?, ?, ?, ?, ?)
                              ON DUPLICATE KEY UPDATE hours = ?, quality = ?, bedtime = ?, wake_time = ?");
        $stmt->execute([$userId, $hours, $quality ?: null, $bedtime ?: null, $wakeTime ?: null, $logDate, 
                        $hours, $quality ?: null, $bedtime ?: null, $wakeTime ?: null]);
        
        sendResponse(true, 'Sleep logged successfully');
    } catch (PDOException $e) {
        error_log("Log sleep error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetSleep($userId) {
    $logDate = sanitize($_GET['date'] ?? $_POST['date'] ?? date('Y-m-d'));
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM sleep_logs WHERE user_id = ? AND log_date = ?");
        $stmt->execute([$userId, $logDate]);
        $sleep = $stmt->fetch();
        
        sendResponse(true, 'Sleep data retrieved', $sleep ?: ['hours' => 0, 'log_date' => $logDate]);
    } catch (PDOException $e) {
        error_log("Get sleep error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// WEIGHT TRACKING FUNCTIONS
// =============================================

function handleLogWeight($userId) {
    $weight = floatval($_POST['weight'] ?? 0);
    $notes = sanitize($_POST['notes'] ?? '');
    $logDate = sanitize($_POST['log_date'] ?? date('Y-m-d'));
    
    if ($weight <= 0) {
        sendResponse(false, 'Invalid weight');
    }
    
    try {
        $db = getDB();
        
        $stmt = $db->prepare("INSERT INTO weight_logs (user_id, weight, notes, log_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $weight, $notes, $logDate]);
        
        // Also update user's current weight
        $stmt = $db->prepare("UPDATE users SET weight = ? WHERE id = ?");
        $stmt->execute([$weight, $userId]);
        
        sendResponse(true, 'Weight logged successfully');
    } catch (PDOException $e) {
        error_log("Log weight error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetWeightHistory($userId) {
    $days = intval($_GET['days'] ?? 30);
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM weight_logs WHERE user_id = ? AND log_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY) ORDER BY log_date ASC");
        $stmt->execute([$userId, $days]);
        $weights = $stmt->fetchAll();
        
        sendResponse(true, 'Weight history retrieved', $weights);
    } catch (PDOException $e) {
        error_log("Get weight history error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// DIET PLAN FUNCTIONS
// =============================================

function handleGetDietPlan($userId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT dp.*, u.name as nutritionist_name 
                              FROM diet_plans dp
                              JOIN users u ON dp.nutritionist_id = u.id
                              WHERE dp.user_id = ? AND dp.status = 'active'
                              ORDER BY dp.created_at DESC LIMIT 1");
        $stmt->execute([$userId]);
        $plan = $stmt->fetch();
        
        if ($plan) {
            // Get meal suggestions for the plan
            $stmt = $db->prepare("SELECT * FROM diet_plan_meals WHERE diet_plan_id = ?");
            $stmt->execute([$plan['id']]);
            $meals = $stmt->fetchAll();
            $plan['meals'] = $meals;
        }
        
        sendResponse(true, 'Diet plan retrieved', $plan);
    } catch (PDOException $e) {
        error_log("Get diet plan error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// CHAT FUNCTIONS
// =============================================

function handleSendMessage($userId) {
    $message = sanitize($_POST['message'] ?? '');
    
    if (empty($message)) {
        sendResponse(false, 'Message cannot be empty');
    }
    
    try {
        $db = getDB();
        
        // Get user's nutritionist
        $stmt = $db->prepare("SELECT nutritionist_id FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !$user['nutritionist_id']) {
            sendResponse(false, 'You are not assigned to a nutritionist');
        }
        
        $stmt = $db->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $user['nutritionist_id'], $message]);
        
        sendResponse(true, 'Message sent successfully');
    } catch (PDOException $e) {
        error_log("Send message error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetChatHistory($userId) {
    try {
        $db = getDB();
        
        // Get user's nutritionist
        $stmt = $db->prepare("SELECT nutritionist_id FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !$user['nutritionist_id']) {
            sendResponse(true, 'No nutritionist assigned', []);
            return;
        }
        
        $nutritionistId = $user['nutritionist_id'];
        
        $stmt = $db->prepare("SELECT m.*, 
                              CASE WHEN m.sender_id = ? THEN 'user' ELSE 'nutritionist' END as sender_type,
                              u.name as sender_name
                              FROM messages m
                              JOIN users u ON m.sender_id = u.id
                              WHERE (m.sender_id = ? AND m.receiver_id = ?) 
                                 OR (m.sender_id = ? AND m.receiver_id = ?)
                              ORDER BY m.created_at ASC");
        $stmt->execute([$userId, $userId, $nutritionistId, $nutritionistId, $userId]);
        $messages = $stmt->fetchAll();
        
        // Mark messages as read
        $stmt = $db->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
        $stmt->execute([$nutritionistId, $userId]);
        
        sendResponse(true, 'Chat history retrieved', $messages);
    } catch (PDOException $e) {
        error_log("Get chat history error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// PROFILE & SETTINGS FUNCTIONS
// =============================================

function handleUpdateProfile($userId) {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $weight = floatval($_POST['weight'] ?? 0);
    $height = floatval($_POST['height'] ?? 0);
    $age = intval($_POST['age'] ?? 0);
    $goal = sanitize($_POST['goal'] ?? '');
    $healthConditions = sanitize($_POST['health_conditions'] ?? '');
    
    if (empty($name) || empty($email)) {
        sendResponse(false, 'Name and email are required');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse(false, 'Invalid email format');
    }
    
    try {
        $db = getDB();
        
        // Check if email is used by another user
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $userId]);
        if ($stmt->fetch()) {
            sendResponse(false, 'Email already in use');
        }
        
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, phone = ?, weight = ?, height = ?, age = ?, goal = ?, health_conditions = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $weight ?: null, $height ?: null, $age ?: null, $goal ?: null, $healthConditions ?: null, $userId]);
        
        $_SESSION['user_name'] = $name;
        
        sendResponse(true, 'Profile updated successfully');
    } catch (PDOException $e) {
        error_log("Update profile error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleUpdatePassword($userId) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        sendResponse(false, 'All password fields are required');
    }
    
    if ($newPassword !== $confirmPassword) {
        sendResponse(false, 'New passwords do not match');
    }
    
    if (strlen($newPassword) < 6) {
        sendResponse(false, 'Password must be at least 6 characters');
    }
    
    try {
        $db = getDB();
        
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !verifyPassword($currentPassword, $user['password'])) {
            sendResponse(false, 'Current password is incorrect');
        }
        
        $hashedPassword = hashPassword($newPassword);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);
        
        sendResponse(true, 'Password updated successfully');
    } catch (PDOException $e) {
        error_log("Update password error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetProfile($userId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT u.*, n.name as nutritionist_name 
                              FROM users u 
                              LEFT JOIN users n ON u.nutritionist_id = n.id 
                              WHERE u.id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if ($user) {
            unset($user['password']);
        }
        
        sendResponse(true, 'Profile retrieved', $user);
    } catch (PDOException $e) {
        error_log("Get profile error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// DASHBOARD FUNCTIONS
// =============================================

function handleGetDashboardStats($userId) {
    $today = date('Y-m-d');
    
    try {
        $db = getDB();
        
        // Today's calories
        $stmt = $db->prepare("SELECT SUM(f.calories * ml.servings) as total 
                              FROM meal_logs ml 
                              JOIN foods f ON ml.food_id = f.id 
                              WHERE ml.user_id = ? AND ml.log_date = ?");
        $stmt->execute([$userId, $today]);
        $todayCalories = $stmt->fetch()['total'] ?? 0;
        
        // Today's water
        $stmt = $db->prepare("SELECT glasses FROM water_logs WHERE user_id = ? AND log_date = ?");
        $stmt->execute([$userId, $today]);
        $todayWater = $stmt->fetch()['glasses'] ?? 0;
        
        // Last night's sleep
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $stmt = $db->prepare("SELECT hours FROM sleep_logs WHERE user_id = ? AND log_date = ?");
        $stmt->execute([$userId, $yesterday]);
        $lastSleep = $stmt->fetch()['hours'] ?? 0;
        
        // Current weight
        $stmt = $db->prepare("SELECT weight FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $currentWeight = $stmt->fetch()['weight'] ?? 0;
        
        // Active diet plan calories goal
        $stmt = $db->prepare("SELECT daily_calories FROM diet_plans WHERE user_id = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$userId]);
        $plan = $stmt->fetch();
        $caloriesGoal = $plan['daily_calories'] ?? 2000;
        
        // Unread messages
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        $unreadMessages = $stmt->fetch()['count'];
        
        $stats = [
            'today_calories' => round($todayCalories),
            'calories_goal' => $caloriesGoal,
            'today_water' => $todayWater,
            'water_goal' => 8,
            'last_sleep' => $lastSleep,
            'sleep_goal' => 8,
            'current_weight' => $currentWeight,
            'unread_messages' => $unreadMessages
        ];
        
        sendResponse(true, 'Dashboard stats retrieved', $stats);
    } catch (PDOException $e) {
        error_log("Get dashboard stats error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// FOOD SEARCH FUNCTIONS
// =============================================

function handleSearchFoods() {
    $search = sanitize($_GET['search'] ?? $_POST['search'] ?? '');
    $categoryId = intval($_GET['category_id'] ?? $_POST['category_id'] ?? 0);
    
    try {
        $db = getDB();
        $sql = "SELECT f.*, c.name as category_name FROM foods f 
                LEFT JOIN food_categories c ON f.category_id = c.id WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND f.name LIKE ?";
            $params[] = "%$search%";
        }
        
        if ($categoryId > 0) {
            $sql .= " AND f.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY f.name ASC LIMIT 50";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $foods = $stmt->fetchAll();
        
        sendResponse(true, 'Foods retrieved', $foods);
    } catch (PDOException $e) {
        error_log("Search foods error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetFoodCategories() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM food_categories ORDER BY name ASC");
        $categories = $stmt->fetchAll();
        
        sendResponse(true, 'Categories retrieved', $categories);
    } catch (PDOException $e) {
        error_log("Get categories error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// TRENDS FUNCTIONS
// =============================================

function handleGetTrends($userId) {
    $days = intval($_GET['days'] ?? 7);
    
    try {
        $db = getDB();
        
        // Calories trend
        $stmt = $db->prepare("SELECT ml.log_date, SUM(f.calories * ml.servings) as total
                              FROM meal_logs ml
                              JOIN foods f ON ml.food_id = f.id
                              WHERE ml.user_id = ? AND ml.log_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                              GROUP BY ml.log_date ORDER BY ml.log_date");
        $stmt->execute([$userId, $days]);
        $caloriesTrend = $stmt->fetchAll();
        
        // Water trend
        $stmt = $db->prepare("SELECT log_date, glasses FROM water_logs 
                              WHERE user_id = ? AND log_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                              ORDER BY log_date");
        $stmt->execute([$userId, $days]);
        $waterTrend = $stmt->fetchAll();
        
        // Sleep trend
        $stmt = $db->prepare("SELECT log_date, hours FROM sleep_logs 
                              WHERE user_id = ? AND log_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                              ORDER BY log_date");
        $stmt->execute([$userId, $days]);
        $sleepTrend = $stmt->fetchAll();
        
        // Weight trend
        $stmt = $db->prepare("SELECT log_date, weight FROM weight_logs 
                              WHERE user_id = ? AND log_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                              ORDER BY log_date");
        $stmt->execute([$userId, $days]);
        $weightTrend = $stmt->fetchAll();
        
        sendResponse(true, 'Trends retrieved', [
            'calories' => $caloriesTrend,
            'water' => $waterTrend,
            'sleep' => $sleepTrend,
            'weight' => $weightTrend
        ]);
    } catch (PDOException $e) {
        error_log("Get trends error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// APPOINTMENT FUNCTIONS
// =============================================

function handleBookAppointment($userId) {
    $nutritionistId = intval($_POST['nutritionist_id'] ?? 0);
    $date = sanitize($_POST['date'] ?? '');
    $time = sanitize($_POST['time'] ?? '');
    $reason = sanitize($_POST['reason'] ?? '');
    
    if ($nutritionistId <= 0 || empty($date) || empty($time)) {
        sendResponse(false, 'Nutritionist, date, and time are required');
    }
    
    // Validate date is in the future
    if (strtotime($date) < strtotime(date('Y-m-d'))) {
        sendResponse(false, 'Cannot book appointments in the past');
    }
    
    try {
        $db = getDB();
        
        // Verify nutritionist exists
        $stmt = $db->prepare("SELECT name FROM users WHERE id = ? AND role = 'nutritionist'");
        $stmt->execute([$nutritionistId]);
        $nutritionist = $stmt->fetch();
        
        if (!$nutritionist) {
            sendResponse(false, 'Nutritionist not found');
        }
        
        // Check for conflicting appointments
        $stmt = $db->prepare("SELECT id FROM appointments WHERE nutritionist_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'cancelled'");
        $stmt->execute([$nutritionistId, $date, $time]);
        if ($stmt->fetch()) {
            sendResponse(false, 'This time slot is already booked');
        }
        
        $stmt = $db->prepare("INSERT INTO appointments (user_id, nutritionist_id, appointment_date, appointment_time, notes, status) VALUES (?, ?, ?, ?, ?, 'scheduled')");
        $stmt->execute([$userId, $nutritionistId, $date, $time, $reason]);
        
        sendResponse(true, 'Appointment booked with ' . $nutritionist['name']);
    } catch (PDOException $e) {
        error_log("Book appointment error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleCancelAppointment($userId) {
    $appointmentId = intval($_POST['appointment_id'] ?? 0);
    
    if ($appointmentId <= 0) {
        sendResponse(false, 'Invalid appointment ID');
    }
    
    try {
        $db = getDB();
        
        $stmt = $db->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ? AND user_id = ?");
        $stmt->execute([$appointmentId, $userId]);
        
        if ($stmt->rowCount() > 0) {
            sendResponse(true, 'Appointment cancelled successfully');
        } else {
            sendResponse(false, 'Appointment not found');
        }
    } catch (PDOException $e) {
        error_log("Cancel appointment error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// GOALS FUNCTIONS
// =============================================

function handleUpdateGoals($userId) {
    $targetWeight = floatval($_POST['target_weight'] ?? 0);
    $dailyCalories = intval($_POST['daily_calories'] ?? 0);
    $dailyWater = floatval($_POST['daily_water'] ?? 0);
    $sleepGoal = floatval($_POST['sleep_goal'] ?? 0);
    $weeklyWeightLoss = floatval($_POST['weekly_weight_loss'] ?? 0);
    
    try {
        $db = getDB();
        
        // Store goals in user's record or a separate goals table
        // Using user table for simplicity - could also use a user_goals table
        $stmt = $db->prepare("UPDATE users SET goal = ? WHERE id = ?");
        $goalsJson = json_encode([
            'target_weight' => $targetWeight,
            'daily_calories' => $dailyCalories,
            'daily_water' => $dailyWater,
            'sleep_goal' => $sleepGoal,
            'weekly_weight_loss' => $weeklyWeightLoss
        ]);
        $stmt->execute([$goalsJson, $userId]);
        
        sendResponse(true, 'Goals updated successfully');
    } catch (PDOException $e) {
        error_log("Update goals error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetGoals($userId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT goal FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        $goals = $user && $user['goal'] ? json_decode($user['goal'], true) : [
            'target_weight' => 70,
            'daily_calories' => 2000,
            'daily_water' => 2.5,
            'sleep_goal' => 8,
            'weekly_weight_loss' => 0.5
        ];
        
        sendResponse(true, 'Goals retrieved', $goals);
    } catch (PDOException $e) {
        error_log("Get goals error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// DIET PLAN FUNCTIONS
// =============================================

function handleRequestPlanChange($userId) {
    $message = sanitize($_POST['message'] ?? '');
    
    try {
        $db = getDB();
        
        // Get user's nutritionist
        $stmt = $db->prepare("SELECT nutritionist_id FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !$user['nutritionist_id']) {
            sendResponse(false, 'You are not assigned to a nutritionist');
        }
        
        // Send message to nutritionist
        $fullMessage = "[Diet Plan Change Request] " . ($message ?: "User has requested changes to their diet plan.");
        $stmt = $db->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $user['nutritionist_id'], $fullMessage]);
        
        sendResponse(true, 'Request sent to your nutritionist');
    } catch (PDOException $e) {
        error_log("Request plan change error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

function handleGetShoppingList($userId) {
    try {
        $db = getDB();
        
        // Get active diet plan meals
        $stmt = $db->prepare("SELECT dp.id, dpm.*, f.name as food_name 
                              FROM diet_plans dp
                              JOIN diet_plan_meals dpm ON dp.id = dpm.diet_plan_id
                              LEFT JOIN foods f ON dpm.food_id = f.id
                              WHERE dp.user_id = ? AND dp.status = 'active'");
        $stmt->execute([$userId]);
        $meals = $stmt->fetchAll();
        
        if (empty($meals)) {
            sendResponse(false, 'No active diet plan found');
        }
        
        // Build shopping list from meals
        $shoppingList = [];
        foreach ($meals as $meal) {
            $foodName = $meal['food_name'] ?: $meal['custom_food_name'];
            if ($foodName && !in_array($foodName, $shoppingList)) {
                $shoppingList[] = $foodName;
            }
        }
        
        sendResponse(true, 'Shopping list generated', $shoppingList);
    } catch (PDOException $e) {
        error_log("Get shopping list error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}

// =============================================
// EXPORT FUNCTIONS
// =============================================

function handleExportData($userId) {
    $startDate = sanitize($_POST['start_date'] ?? date('Y-m-d', strtotime('-30 days')));
    $endDate = sanitize($_POST['end_date'] ?? date('Y-m-d'));
    $format = sanitize($_POST['format'] ?? 'csv');
    
    try {
        $db = getDB();
        
        // Gather all data
        $data = [
            'weight' => [],
            'calories' => [],
            'water' => [],
            'sleep' => []
        ];
        
        // Weight data
        $stmt = $db->prepare("SELECT log_date, weight, notes FROM weight_logs WHERE user_id = ? AND log_date BETWEEN ? AND ? ORDER BY log_date");
        $stmt->execute([$userId, $startDate, $endDate]);
        $data['weight'] = $stmt->fetchAll();
        
        // Calorie data
        $stmt = $db->prepare("SELECT ml.log_date, SUM(f.calories * ml.servings) as total_calories
                              FROM meal_logs ml JOIN foods f ON ml.food_id = f.id
                              WHERE ml.user_id = ? AND ml.log_date BETWEEN ? AND ?
                              GROUP BY ml.log_date ORDER BY ml.log_date");
        $stmt->execute([$userId, $startDate, $endDate]);
        $data['calories'] = $stmt->fetchAll();
        
        // Water data
        $stmt = $db->prepare("SELECT log_date, glasses FROM water_logs WHERE user_id = ? AND log_date BETWEEN ? AND ? ORDER BY log_date");
        $stmt->execute([$userId, $startDate, $endDate]);
        $data['water'] = $stmt->fetchAll();
        
        // Sleep data
        $stmt = $db->prepare("SELECT log_date, hours, quality FROM sleep_logs WHERE user_id = ? AND log_date BETWEEN ? AND ? ORDER BY log_date");
        $stmt->execute([$userId, $startDate, $endDate]);
        $data['sleep'] = $stmt->fetchAll();
        
        sendResponse(true, 'Data exported', $data);
    } catch (PDOException $e) {
        error_log("Export data error: " . $e->getMessage());
        sendResponse(false, 'Database error occurred');
    }
}
?>
