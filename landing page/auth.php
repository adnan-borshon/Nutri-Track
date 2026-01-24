<?php
require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Role-based redirects
$redirectUrls = [
    'admin' => '../admin/dashboard.php',
    'nutritionist' => '../nutritionists/dashboard.php',
    'user' => '../user/dashboard.php'
];

// Handle Login (skip if this is a registration request)
if ($_POST && !isset($_POST['register']) && isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Check user status
            if ($user['status'] === 'pending') {
                $error = 'Your account is pending approval.';
                if (isset($_POST['ajax'])) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $error]);
                    exit;
                }
            } elseif ($user['status'] === 'inactive') {
                $error = 'Your account has been deactivated.';
                if (isset($_POST['ajax'])) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $error]);
                    exit;
                }
            } else {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['login_time'] = time();
                
                $redirect = $redirectUrls[$user['role']] ?? '../user/dashboard.php';
                
                // Return success response for AJAX
                if (isset($_POST['ajax'])) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'redirect' => $redirect,
                        'message' => 'Login successful! Welcome ' . $user['name']
                    ]);
                    exit;
                }
                
                // Regular form submission
                header('Location: ' . $redirect);
                exit;
            }
        } else {
            $error = 'Invalid email or password';
            
            // Return error response for AJAX
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $error]);
                exit;
            }
        }
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        $error = 'An error occurred. Please try again.';
        
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $error]);
            exit;
        }
    }
}

// Handle Registration
if ($_POST && isset($_POST['register']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    
    if ($password !== $confirmPassword) {
        $registration_error = 'Passwords do not match.';
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $registration_error]);
            exit;
        }
    } elseif (strlen($password) < 6) {
        $registration_error = 'Password must be at least 6 characters.';
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $registration_error]);
            exit;
        }
    } else {
        try {
            $db = getDB();
            
            // Check if email exists
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $registration_error = 'Email already registered.';
                if (isset($_POST['ajax'])) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $registration_error]);
                    exit;
                }
            } else {
                // Create user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, 'user', 'active')");
                $stmt->execute([$name, $email, $hashedPassword]);
                
                $userId = $db->lastInsertId();
                
                // Auto login
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_role'] = 'user';
                $_SESSION['login_time'] = time();
                
                $registration_success = true;
                
                if (isset($_POST['ajax'])) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'redirect' => '../user/dashboard.php',
                        'message' => 'Account created successfully! Welcome to NutriTrack!'
                    ]);
                    exit;
                }
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $registration_error = 'An error occurred. Please try again.';
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $registration_error]);
                exit;
            }
        }
    }
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php?message=logged_out');
    exit;
}
?>