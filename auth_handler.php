<?php
/**
 * Authentication Handler
 * Handles login, register, and logout actions
 */

require_once __DIR__ . '/config/db.php';

startSession();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method');
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'login':
        handleLogin();
        break;
    case 'register':
        handleRegister();
        break;
    case 'logout':
        handleLogout();
        break;
    default:
        jsonResponse(false, 'Invalid action');
}

/**
 * Handle user login
 */
function handleLogin() {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validation
    if (empty($email) || empty($password)) {
        jsonResponse(false, 'Please fill in all fields');
    }
    
    if (!isValidEmail($email)) {
        jsonResponse(false, 'Invalid email format');
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            jsonResponse(false, 'Invalid email or password');
        }
        
        if (!verifyPassword($password, $user['password'])) {
            jsonResponse(false, 'Invalid email or password');
        }
        
        if ($user['status'] === 'pending') {
            jsonResponse(false, 'Your account is pending approval');
        }
        
        if ($user['status'] === 'inactive') {
            jsonResponse(false, 'Your account has been deactivated');
        }
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];
        
        // Determine redirect URL based on role
        $redirectUrls = [
            'admin' => 'admin/dashboard.php',
            'nutritionist' => 'nutritionists/dashboard.php',
            'user' => 'user/dashboard.php'
        ];
        
        $redirectUrl = $redirectUrls[$user['role']] ?? 'login.php';
        
        jsonResponse(true, 'Login successful', ['redirect' => $redirectUrl]);
        
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        jsonResponse(false, 'An error occurred. Please try again.');
    }
}

/**
 * Handle user registration
 */
function handleRegister() {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $terms = isset($_POST['terms']);
    
    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        jsonResponse(false, 'Please fill in all fields');
    }
    
    if (!isValidEmail($email)) {
        jsonResponse(false, 'Invalid email format');
    }
    
    if (strlen($password) < 6) {
        jsonResponse(false, 'Password must be at least 6 characters');
    }
    
    if ($password !== $confirmPassword) {
        jsonResponse(false, 'Passwords do not match');
    }
    
    if (!$terms) {
        jsonResponse(false, 'You must accept the terms and conditions');
    }
    
    try {
        $db = getDB();
        
        // Check if email already exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            jsonResponse(false, 'Email already registered');
        }
        
        // Insert new user
        $hashedPassword = hashPassword($password);
        $stmt = $db->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, 'user', 'active')");
        $stmt->execute([$name, $email, $hashedPassword]);
        
        $userId = $db->lastInsertId();
        
        // Auto login after registration
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = 'user';
        $_SESSION['user_name'] = $name;
        
        jsonResponse(true, 'Registration successful', ['redirect' => 'user/dashboard.php']);
        
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        jsonResponse(false, 'An error occurred. Please try again.');
    }
}

/**
 * Handle user logout
 */
function handleLogout() {
    session_destroy();
    jsonResponse(true, 'Logged out successfully', ['redirect' => 'login.php']);
}
