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
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function handleAddUser() {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $goal = $_POST['goal'] ?? '';
    
    if (empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Name and email are required']);
        return;
    }
    
    // Simulate user creation
    echo json_encode(['success' => true, 'message' => "User $name added successfully"]);
}

function handleApproveUser() {
    $userId = $_POST['user_id'] ?? '';
    $userName = $_POST['user_name'] ?? '';
    
    if (empty($userId)) {
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "$userName approved successfully"]);
}

function handleAssignNutritionist() {
    $userId = $_POST['user_id'] ?? '';
    $nutritionistId = $_POST['nutritionist_id'] ?? '';
    $userName = $_POST['user_name'] ?? '';
    
    if (empty($userId) || empty($nutritionistId)) {
        echo json_encode(['success' => false, 'message' => 'User and nutritionist IDs are required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "Nutritionist assigned to $userName successfully"]);
}

function handleAddNutritionist() {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    
    if (empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Name and email are required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "Nutritionist $name added successfully"]);
}

function handleEditNutritionist() {
    $nutritionistId = $_POST['nutritionist_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    
    if (empty($nutritionistId) || empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "Nutritionist $name updated successfully"]);
}

function handleDeleteNutritionist() {
    $nutritionistId = $_POST['nutritionist_id'] ?? '';
    $name = $_POST['name'] ?? '';
    
    if (empty($nutritionistId)) {
        echo json_encode(['success' => false, 'message' => 'Nutritionist ID is required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "$name deleted successfully"]);
}

function handleAddFood() {
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $calories = $_POST['calories'] ?? '';
    
    if (empty($name) || empty($category)) {
        echo json_encode(['success' => false, 'message' => 'Name and category are required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "Food item $name added successfully"]);
}

function handleEditFood() {
    $foodId = $_POST['food_id'] ?? '';
    $name = $_POST['name'] ?? '';
    
    if (empty($foodId)) {
        echo json_encode(['success' => false, 'message' => 'Food ID is required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "Food item updated successfully"]);
}

function handleDeleteFood() {
    $foodId = $_POST['food_id'] ?? '';
    $name = $_POST['name'] ?? '';
    
    if (empty($foodId)) {
        echo json_encode(['success' => false, 'message' => 'Food ID is required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "$name deleted successfully"]);
}

function handleAddCategory() {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    
    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Category name is required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "Category $name added successfully"]);
}

function handleEditCategory() {
    $categoryId = $_POST['category_id'] ?? '';
    $name = $_POST['name'] ?? '';
    
    if (empty($categoryId)) {
        echo json_encode(['success' => false, 'message' => 'Category ID is required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "Category updated successfully"]);
}

function handleDeleteCategory() {
    $categoryId = $_POST['category_id'] ?? '';
    $name = $_POST['name'] ?? '';
    
    if (empty($categoryId)) {
        echo json_encode(['success' => false, 'message' => 'Category ID is required']);
        return;
    }
    
    echo json_encode(['success' => true, 'message' => "$name category deleted successfully"]);
}

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
    
    echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
}

function handleGenerateReport() {
    // Simulate report generation
    $reportData = [
        'total_users' => 2847,
        'total_nutritionists' => 156,
        'active_plans' => 1234,
        'success_rate' => 89,
        'generated_at' => date('Y-m-d H:i:s')
    ];
    
    echo json_encode(['success' => true, 'message' => 'Report generated successfully', 'data' => $reportData]);
}

function handleBackupDatabase() {
    // Simulate database backup
    $backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    echo json_encode(['success' => true, 'message' => "Database backup created: $backupFile"]);
}

function handleClearCache() {
    // Simulate cache clearing
    echo json_encode(['success' => true, 'message' => 'Cache cleared successfully']);
}

function handleToggleMaintenance() {
    // Simulate maintenance mode toggle
    $isMaintenanceMode = rand(0, 1);
    $status = $isMaintenanceMode ? 'enabled' : 'disabled';
    echo json_encode(['success' => true, 'message' => "Maintenance mode $status"]);
}
?>