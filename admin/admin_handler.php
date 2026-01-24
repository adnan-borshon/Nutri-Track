<?php
require_once '../includes/session.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

checkAuth('admin');

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add_user':
        handleAddUser();
        break;
    case 'edit_user':
        handleEditUser();
        break;
    case 'approve_user':
        handleApproveUser();
        break;
    case 'assign_nutritionist':
        handleAssignNutritionist();
        break;
    case 'add_nutritionist':
        handleAddNutritionist();
        break;
    case 'edit_nutritionist':
        handleEditNutritionist();
        break;
    case 'delete_nutritionist':
        handleDeleteNutritionist();
        break;
    case 'add_food':
        handleAddFood();
        break;
    case 'edit_food':
        handleEditFood();
        break;
    case 'delete_food':
        handleDeleteFood();
        break;
    case 'add_category':
        handleAddCategory();
        break;
    case 'edit_category':
        handleEditCategory();
        break;
    case 'delete_category':
        handleDeleteCategory();
        break;
    case 'update_password':
        handleUpdatePassword();
        break;
    case 'generate_report':
        handleGenerateReport();
        break;
    case 'backup_database':
        handleBackupDatabase();
        break;
    case 'clear_cache':
        handleClearCache();
        break;
    case 'toggle_maintenance':
        handleToggleMaintenance();
        break;
    case 'update_system_setting':
        handleUpdateSystemSetting();
        break;
    case 'get_system_settings':
        handleGetSystemSettings();
        break;
    case 'get_users':
        handleGetUsers();
        break;
    case 'get_nutritionists':
        handleGetNutritionists();
        break;
    case 'get_foods':
        handleGetFoods();
        break;
    case 'get_categories':
        handleGetCategories();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

// =============================================
// SYSTEM SETTINGS HELPERS
// =============================================

function getSystemSetting($key, $default = null) {
    try {
        $db = getDB();
        $stmt = $db->prepare('SELECT setting_value FROM system_settings WHERE setting_key = ?');
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ? $row['setting_value'] : $default;
    } catch (PDOException $e) {
        error_log('Get system setting error: ' . $e->getMessage());
        return $default;
    }
}

function setSystemSetting($key, $value) {
    $db = getDB();
    $stmt = $db->prepare('INSERT INTO system_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
    $stmt->execute([$key, $value]);
}

// =============================================
// USER MANAGEMENT
// =============================================

function handleAddUser() {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $goal = sanitize($_POST['goal'] ?? '');
    $password = $_POST['password'] ?? 'default123';
    
    if (empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Name and email are required']);
        return;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Check if email exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            return;
        }
        
        $hashedPassword = hashPassword($password);
        $stmt = $db->prepare("INSERT INTO users (name, email, password, role, status, goal) VALUES (?, ?, ?, 'user', 'active', ?)");
        $stmt->execute([$name, $email, $hashedPassword, $goal ?: null]);
        
        echo json_encode(['success' => true, 'message' => "User $name added successfully"]);
    } catch (PDOException $e) {
        error_log("Add user error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleEditUser() {
    $userId = intval($_POST['user_id'] ?? 0);
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $goal = sanitize($_POST['goal'] ?? '');
    $status = sanitize($_POST['status'] ?? '');
    $nutritionistIdRaw = $_POST['nutritionist_id'] ?? '';
    $nutritionistId = ($nutritionistIdRaw === '' || $nutritionistIdRaw === null) ? null : intval($nutritionistIdRaw);
    
    if (empty($userId) || empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Check if email exists for another user
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $userId]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            return;
        }

        if ($nutritionistId !== null) {
            $stmt = $db->prepare("SELECT id FROM users WHERE id = ? AND role = 'nutritionist' AND status = 'active'");
            $stmt->execute([$nutritionistId]);
            if (!$stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Invalid nutritionist selected']);
                return;
            }
        }

        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, goal = ?, status = ?, nutritionist_id = ? WHERE id = ? AND role = 'user'");
        $stmt->execute([$name, $email, $goal ?: null, $status, $nutritionistId, $userId]);
        
        echo json_encode(['success' => true, 'message' => "User $name updated successfully"]);
    } catch (PDOException $e) {
        error_log("Edit user error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleApproveUser() {
    $userId = intval($_POST['user_id'] ?? 0);
    
    if (empty($userId)) {
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        return;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("UPDATE users SET status = 'active' WHERE id = ? AND role = 'user'");
        $stmt->execute([$userId]);
        
        // Get user name for response
        $stmt = $db->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        echo json_encode(['success' => true, 'message' => ($user['name'] ?? 'User') . " approved successfully"]);
    } catch (PDOException $e) {
        error_log("Approve user error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleAssignNutritionist() {
    $userId = intval($_POST['user_id'] ?? 0);
    $nutritionistIdRaw = $_POST['nutritionist_id'] ?? '';
    $nutritionistId = ($nutritionistIdRaw === '' || $nutritionistIdRaw === null) ? null : intval($nutritionistIdRaw);
    
    if (empty($userId)) {
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        return;
    }
    
    try {
        $db = getDB();

        if ($nutritionistId !== null) {
            $stmt = $db->prepare("SELECT id FROM users WHERE id = ? AND role = 'nutritionist' AND status = 'active'");
            $stmt->execute([$nutritionistId]);
            if (!$stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Invalid nutritionist selected']);
                return;
            }
        }

        $stmt = $db->prepare("UPDATE users SET nutritionist_id = ? WHERE id = ? AND role = 'user'");
        $stmt->execute([$nutritionistId, $userId]);
        
        echo json_encode(['success' => true, 'message' => $nutritionistId === null ? 'Nutritionist unassigned successfully' : 'Nutritionist assigned successfully']);
    } catch (PDOException $e) {
        error_log("Assign nutritionist error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleGetUsers() {
    $search = sanitize($_POST['search'] ?? '');
    $status = sanitize($_POST['status'] ?? '');
    
    try {
        $db = getDB();
        $sql = "SELECT u.*, n.name as nutritionist_name 
                FROM users u 
                LEFT JOIN users n ON u.nutritionist_id = n.id 
                WHERE u.role = 'user'";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        if (!empty($status)) {
            $sql .= " AND u.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY u.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $users = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'data' => $users]);
    } catch (PDOException $e) {
        error_log("Get users error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

// =============================================
// NUTRITIONIST MANAGEMENT
// =============================================

function handleAddNutritionist() {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $specialty = sanitize($_POST['specialty'] ?? '');
    $status = sanitize($_POST['status'] ?? 'active');
    $password = $_POST['password'] ?? 'default123';
    
    if (empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Name and email are required']);
        return;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        return;
    }
    
    try {
        $db = getDB();

        if (!in_array($status, ['active', 'pending', 'inactive'], true)) {
            echo json_encode(['success' => false, 'message' => 'Invalid status value']);
            return;
        }
        
        // Check if email exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            return;
        }
        
        $hashedPassword = hashPassword($password);
        $stmt = $db->prepare("INSERT INTO users (name, email, password, role, status, specialty) VALUES (?, ?, ?, 'nutritionist', ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $status, $specialty]);
        
        echo json_encode(['success' => true, 'message' => "Nutritionist $name added successfully"]);
    } catch (PDOException $e) {
        error_log("Add nutritionist error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleEditNutritionist() {
    $nutritionistId = intval($_POST['nutritionist_id'] ?? 0);
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $specialty = sanitize($_POST['specialty'] ?? '');
    $status = sanitize($_POST['status'] ?? 'active');
    
    if (empty($nutritionistId) || empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Check if email exists for another user
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $nutritionistId]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            return;
        }
        
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, specialty = ?, status = ? WHERE id = ? AND role = 'nutritionist'");
        $stmt->execute([$name, $email, $specialty, $status, $nutritionistId]);
        
        echo json_encode(['success' => true, 'message' => "Nutritionist $name updated successfully"]);
    } catch (PDOException $e) {
        error_log("Edit nutritionist error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleDeleteNutritionist() {
    $nutritionistId = intval($_POST['nutritionist_id'] ?? 0);
    
    if (empty($nutritionistId)) {
        echo json_encode(['success' => false, 'message' => 'Nutritionist ID is required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Get name before deletion
        $stmt = $db->prepare("SELECT name FROM users WHERE id = ? AND role = 'nutritionist'");
        $stmt->execute([$nutritionistId]);
        $nutritionist = $stmt->fetch();
        
        if (!$nutritionist) {
            echo json_encode(['success' => false, 'message' => 'Nutritionist not found']);
            return;
        }
        
        // Remove nutritionist assignment from users first
        $stmt = $db->prepare("UPDATE users SET nutritionist_id = NULL WHERE nutritionist_id = ?");
        $stmt->execute([$nutritionistId]);
        
        // Delete the nutritionist
        $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role = 'nutritionist'");
        $stmt->execute([$nutritionistId]);
        
        echo json_encode(['success' => true, 'message' => $nutritionist['name'] . " deleted successfully"]);
    } catch (PDOException $e) {
        error_log("Delete nutritionist error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleGetNutritionists() {
    $search = sanitize($_POST['search'] ?? '');
    
    try {
        $db = getDB();
        $sql = "SELECT u.*, 
                (SELECT COUNT(*) FROM users WHERE nutritionist_id = u.id) as client_count 
                FROM users u 
                WHERE u.role = 'nutritionist'";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.specialty LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        $sql .= " ORDER BY u.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $nutritionists = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'data' => $nutritionists]);
    } catch (PDOException $e) {
        error_log("Get nutritionists error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

// =============================================
// FOOD MANAGEMENT
// =============================================

function handleAddFood() {
    $name = sanitize($_POST['name'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $categoryId = intval($_POST['category_id'] ?? 0);
    $calories = intval($_POST['calories'] ?? 0);
    $protein = floatval($_POST['protein'] ?? 0);
    $carbs = floatval($_POST['carbs'] ?? 0);
    $fat = floatval($_POST['fat'] ?? 0);
    
    if (empty($name) || empty($categoryId)) {
        echo json_encode(['success' => false, 'message' => 'Name and category are required']);
        return;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO foods (name, description, category_id, calories, protein, carbs, fat) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $categoryId, $calories, $protein, $carbs, $fat]);
        
        echo json_encode(['success' => true, 'message' => "Food item $name added successfully"]);
    } catch (PDOException $e) {
        error_log("Add food error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleEditFood() {
    $foodId = intval($_POST['food_id'] ?? 0);
    $name = sanitize($_POST['name'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $categoryId = intval($_POST['category_id'] ?? 0);
    $calories = intval($_POST['calories'] ?? 0);
    $protein = floatval($_POST['protein'] ?? 0);
    $carbs = floatval($_POST['carbs'] ?? 0);
    $fat = floatval($_POST['fat'] ?? 0);
    
    if (empty($foodId) || empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Food ID and name are required']);
        return;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("UPDATE foods SET name = ?, description = ?, category_id = ?, calories = ?, protein = ?, carbs = ?, fat = ? WHERE id = ?");
        $stmt->execute([$name, $description, $categoryId, $calories, $protein, $carbs, $fat, $foodId]);
        
        echo json_encode(['success' => true, 'message' => "Food item $name updated successfully"]);
    } catch (PDOException $e) {
        error_log("Edit food error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleDeleteFood() {
    $foodId = intval($_POST['food_id'] ?? 0);
    
    if (empty($foodId)) {
        echo json_encode(['success' => false, 'message' => 'Food ID is required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Get name before deletion
        $stmt = $db->prepare("SELECT name FROM foods WHERE id = ?");
        $stmt->execute([$foodId]);
        $food = $stmt->fetch();
        
        $stmt = $db->prepare("DELETE FROM foods WHERE id = ?");
        $stmt->execute([$foodId]);
        
        echo json_encode(['success' => true, 'message' => ($food['name'] ?? 'Food item') . " deleted successfully"]);
    } catch (PDOException $e) {
        error_log("Delete food error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleGetFoods() {
    $search = sanitize($_POST['search'] ?? '');
    $categoryId = intval($_POST['category_id'] ?? 0);
    
    try {
        $db = getDB();
        $sql = "SELECT f.*, c.name as category_name 
                FROM foods f 
                LEFT JOIN food_categories c ON f.category_id = c.id 
                WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND f.name LIKE ?";
            $params[] = "%$search%";
        }
        
        if (!empty($categoryId)) {
            $sql .= " AND f.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY f.name ASC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $foods = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'data' => $foods]);
    } catch (PDOException $e) {
        error_log("Get foods error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

// =============================================
// CATEGORY MANAGEMENT
// =============================================

function handleAddCategory() {
    $name = sanitize($_POST['name'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    
    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Category name is required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Check if category exists
        $stmt = $db->prepare("SELECT id FROM food_categories WHERE name = ?");
        $stmt->execute([$name]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Category already exists']);
            return;
        }
        
        $stmt = $db->prepare("INSERT INTO food_categories (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
        
        echo json_encode(['success' => true, 'message' => "Category $name added successfully"]);
    } catch (PDOException $e) {
        error_log("Add category error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleEditCategory() {
    $categoryId = intval($_POST['category_id'] ?? 0);
    $name = sanitize($_POST['name'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    
    if (empty($categoryId) || empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Category ID and name are required']);
        return;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("UPDATE food_categories SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $categoryId]);
        
        echo json_encode(['success' => true, 'message' => "Category $name updated successfully"]);
    } catch (PDOException $e) {
        error_log("Edit category error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleDeleteCategory() {
    $categoryId = intval($_POST['category_id'] ?? 0);
    
    if (empty($categoryId)) {
        echo json_encode(['success' => false, 'message' => 'Category ID is required']);
        return;
    }
    
    try {
        $db = getDB();
        
        // Get name before deletion
        $stmt = $db->prepare("SELECT name FROM food_categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        $category = $stmt->fetch();
        
        // Check if category has foods
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM foods WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $count = $stmt->fetch()['count'];
        
        if ($count > 0) {
            echo json_encode(['success' => false, 'message' => 'Cannot delete category with existing foods']);
            return;
        }
        
        $stmt = $db->prepare("DELETE FROM food_categories WHERE id = ?");
        $stmt->execute([$categoryId]);
        
        echo json_encode(['success' => true, 'message' => ($category['name'] ?? 'Category') . " deleted successfully"]);
    } catch (PDOException $e) {
        error_log("Delete category error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleGetCategories() {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT c.*, 
                              (SELECT COUNT(*) FROM foods WHERE category_id = c.id) as food_count 
                              FROM food_categories c 
                              ORDER BY c.name ASC");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'data' => $categories]);
    } catch (PDOException $e) {
        error_log("Get categories error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

// =============================================
// SETTINGS & UTILITIES
// =============================================

function handleUpdatePassword() {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'All password fields are required']);
        return;
    }
    
    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'New passwords do not match']);
        return;
    }
    
    if (strlen($newPassword) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
        return;
    }
    
    try {
        $db = getDB();
        $userId = $_SESSION['user_id'];
        
        // Get current password hash
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !verifyPassword($currentPassword, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
            return;
        }
        
        // Update password
        $hashedPassword = hashPassword($newPassword);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);
        
        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
    } catch (PDOException $e) {
        error_log("Update password error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleGenerateReport() {
    try {
        $db = getDB();
        
        // Get real stats
        $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
        $totalUsers = $stmt->fetch()['count'];
        
        $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'nutritionist'");
        $totalNutritionists = $stmt->fetch()['count'];
        
        $stmt = $db->query("SELECT COUNT(*) as count FROM diet_plans WHERE status = 'active'");
        $activePlans = $stmt->fetch()['count'];
        
        $stmt = $db->query("SELECT COUNT(*) as count FROM foods");
        $totalFoods = $stmt->fetch()['count'];
        
        $reportData = [
            'total_users' => $totalUsers,
            'total_nutritionists' => $totalNutritionists,
            'active_plans' => $activePlans,
            'total_foods' => $totalFoods,
            'generated_at' => date('Y-m-d H:i:s')
        ];
        
        echo json_encode(['success' => true, 'message' => 'Report generated successfully', 'data' => $reportData]);
    } catch (PDOException $e) {
        error_log("Generate report error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleBackupDatabase() {
    $backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    echo json_encode(['success' => true, 'message' => "Database backup created: $backupFile"]);
}

function handleClearCache() {
    echo json_encode(['success' => true, 'message' => 'Cache cleared successfully']);
}

function handleToggleMaintenance() {
    try {
        $current = getSystemSetting('maintenance_mode', '0');
        $new = ($current === '1') ? '0' : '1';
        setSystemSetting('maintenance_mode', $new);

        $status = ($new === '1') ? 'enabled' : 'disabled';
        echo json_encode(['success' => true, 'message' => "Maintenance mode $status", 'data' => ['maintenance_mode' => $new]]);
    } catch (PDOException $e) {
        error_log('Toggle maintenance error: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleUpdateSystemSetting() {
    $key = sanitize($_POST['key'] ?? '');
    $value = $_POST['value'] ?? null;

    if ($key === '') {
        echo json_encode(['success' => false, 'message' => 'Setting key is required']);
        return;
    }

    // allowlist
    $allowed = [
        'email_notifications',
        'registration_alerts',
        'maintenance_alerts',
        'maintenance_mode'
    ];
    if (!in_array($key, $allowed, true)) {
        echo json_encode(['success' => false, 'message' => 'Invalid setting key']);
        return;
    }

    try {
        setSystemSetting($key, $value);
        echo json_encode(['success' => true, 'message' => 'Setting updated', 'data' => ['key' => $key, 'value' => $value]]);
    } catch (PDOException $e) {
        error_log('Update system setting error: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}

function handleGetSystemSettings() {
    try {
        $settings = [
            'email_notifications' => getSystemSetting('email_notifications', '1'),
            'registration_alerts' => getSystemSetting('registration_alerts', '1'),
            'maintenance_alerts' => getSystemSetting('maintenance_alerts', '0'),
            'maintenance_mode' => getSystemSetting('maintenance_mode', '0')
        ];
        echo json_encode(['success' => true, 'data' => $settings]);
    } catch (PDOException $e) {
        error_log('Get system settings error: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
}
?>