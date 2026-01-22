<?php
// Admin Actions Handler
// This file handles AJAX requests from the admin panel

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get the action from the request
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Sample data arrays (in a real application, these would be database operations)
$users = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'goal' => 'Weight Loss', 'status' => 'active', 'nutritionist' => 'Dr. Smith'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'goal' => 'Maintain', 'status' => 'active', 'nutritionist' => 'Dr. Chen'],
    ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'goal' => 'Build Muscle', 'status' => 'pending', 'nutritionist' => null],
];

$nutritionists = [
    ['id' => 1, 'name' => 'Dr. Sarah Smith', 'email' => 'sarah@nutritrack.com', 'specialty' => 'Weight Management', 'status' => 'active', 'clients' => 24],
    ['id' => 2, 'name' => 'Dr. Michael Chen', 'email' => 'michael@nutritrack.com', 'specialty' => 'Sports Nutrition', 'status' => 'active', 'clients' => 18],
    ['id' => 3, 'name' => 'Dr. Emily Wilson', 'email' => 'emily@nutritrack.com', 'specialty' => 'Clinical Nutrition', 'status' => 'active', 'clients' => 31],
];

$foods = [
    ['id' => 1, 'name' => 'Apple', 'category' => 'Fruits', 'calories' => 52, 'protein' => 0.3, 'carbs' => 14, 'fat' => 0.2],
    ['id' => 2, 'name' => 'Carrot', 'category' => 'Vegetables', 'calories' => 41, 'protein' => 0.9, 'carbs' => 10, 'fat' => 0.2],
    ['id' => 3, 'name' => 'Chicken Breast', 'category' => 'Proteins', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fat' => 3.6],
];

$categories = [
    ['id' => 1, 'name' => 'Fruits', 'description' => 'Fresh and dried fruits', 'items' => 142],
    ['id' => 2, 'name' => 'Vegetables', 'description' => 'Fresh vegetables and greens', 'items' => 198],
    ['id' => 3, 'name' => 'Proteins', 'description' => 'Meat, fish, and legumes', 'items' => 156],
];

// Response function
function sendResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

// Handle different actions
switch ($action) {
    case 'add_user':
        $name = $_POST['fullName'] ?? '';
        $email = $_POST['email'] ?? '';
        $goal = $_POST['goal'] ?? '';
        $nutritionist = $_POST['nutritionist'] ?? null;
        
        if (empty($name) || empty($email) || empty($goal)) {
            sendResponse(false, 'All required fields must be filled');
        }
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendResponse(false, 'Invalid email format');
        }
        
        // In a real application, you would insert into database
        $newUser = [
            'id' => count($users) + 1,
            'name' => $name,
            'email' => $email,
            'goal' => $goal,
            'status' => 'pending',
            'nutritionist' => $nutritionist
        ];
        
        sendResponse(true, 'User added successfully', $newUser);
        break;
        
    case 'add_nutritionist':
        $name = $_POST['fullName'] ?? '';
        $email = $_POST['email'] ?? '';
        $specialty = $_POST['specialty'] ?? '';
        $license = $_POST['license'] ?? '';
        $bio = $_POST['bio'] ?? '';
        
        if (empty($name) || empty($email) || empty($specialty) || empty($license)) {
            sendResponse(false, 'All required fields must be filled');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendResponse(false, 'Invalid email format');
        }
        
        $newNutritionist = [
            'id' => count($nutritionists) + 1,
            'name' => $name,
            'email' => $email,
            'specialty' => $specialty,
            'license' => $license,
            'bio' => $bio,
            'status' => 'pending',
            'clients' => 0
        ];
        
        sendResponse(true, 'Nutritionist added successfully', $newNutritionist);
        break;
        
    case 'add_food':
        $name = $_POST['foodName'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $calories = $_POST['calories'] ?? 0;
        $protein = $_POST['protein'] ?? 0;
        $carbs = $_POST['carbs'] ?? 0;
        $fat = $_POST['fat'] ?? 0;
        
        if (empty($name) || empty($category) || $calories <= 0) {
            sendResponse(false, 'Name, category, and calories are required');
        }
        
        $newFood = [
            'id' => count($foods) + 1,
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'calories' => (float)$calories,
            'protein' => (float)$protein,
            'carbs' => (float)$carbs,
            'fat' => (float)$fat
        ];
        
        sendResponse(true, 'Food item added successfully', $newFood);
        break;
        
    case 'add_category':
        $name = $_POST['categoryName'] ?? '';
        $description = $_POST['description'] ?? '';
        $icon = $_POST['icon'] ?? '';
        
        if (empty($name) || empty($description)) {
            sendResponse(false, 'Name and description are required');
        }
        
        $newCategory = [
            'id' => count($categories) + 1,
            'name' => $name,
            'description' => $description,
            'icon' => $icon,
            'items' => 0
        ];
        
        sendResponse(true, 'Category added successfully', $newCategory);
        break;
        
    case 'approve_user':
        $userId = $_POST['userId'] ?? 0;
        
        if ($userId <= 0) {
            sendResponse(false, 'Invalid user ID');
        }
        
        // In a real application, you would update the database
        sendResponse(true, 'User approved successfully');
        break;
        
    case 'assign_nutritionist':
        $userId = $_POST['userId'] ?? 0;
        $nutritionistId = $_POST['nutritionistId'] ?? 0;
        
        if ($userId <= 0 || $nutritionistId <= 0) {
            sendResponse(false, 'Invalid user or nutritionist ID');
        }
        
        // In a real application, you would update the database
        sendResponse(true, 'Nutritionist assigned successfully');
        break;
        
    case 'delete_item':
        $itemId = $_POST['itemId'] ?? 0;
        $itemType = $_POST['itemType'] ?? '';
        
        if ($itemId <= 0 || empty($itemType)) {
            sendResponse(false, 'Invalid item ID or type');
        }
        
        // In a real application, you would delete from database
        sendResponse(true, ucfirst($itemType) . ' deleted successfully');
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
        
        // In a real application, you would verify current password and update
        sendResponse(true, 'Password updated successfully');
        break;
        
    case 'generate_report':
        // Simulate report generation
        sleep(2); // Simulate processing time
        
        $reportData = [
            'total_users' => count($users),
            'total_nutritionists' => count($nutritionists),
            'total_foods' => count($foods),
            'active_users' => array_filter($users, fn($u) => $u['status'] === 'active'),
            'pending_users' => array_filter($users, fn($u) => $u['status'] === 'pending'),
            'generated_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Report generated successfully', $reportData);
        break;
        
    case 'backup_database':
        // Simulate database backup
        sleep(3); // Simulate processing time
        
        $backupInfo = [
            'filename' => 'nutritrack_backup_' . date('Y-m-d_H-i-s') . '.sql',
            'size' => '2.4 MB',
            'tables' => ['users', 'nutritionists', 'foods', 'categories', 'diet_plans'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Database backup completed successfully', $backupInfo);
        break;
        
    case 'clear_cache':
        // Simulate cache clearing
        sleep(1); // Simulate processing time
        
        $cacheInfo = [
            'cleared_items' => ['user_sessions', 'food_data', 'nutritionist_profiles', 'system_settings'],
            'space_freed' => '45.2 MB',
            'cleared_at' => date('Y-m-d H:i:s')
        ];
        
        sendResponse(true, 'Cache cleared successfully', $cacheInfo);
        break;
        
    case 'get_stats':
        $stats = [
            'total_users' => 2847,
            'total_nutritionists' => 156,
            'active_plans' => 1234,
            'daily_active_users' => 892,
            'user_growth' => '+12%',
            'nutritionist_growth' => '+8%',
            'plan_growth' => '+5%',
            'dau_change' => '-3%'
        ];
        
        sendResponse(true, 'Stats retrieved successfully', $stats);
        break;
        
    default:
        sendResponse(false, 'Invalid action specified');
}
?>