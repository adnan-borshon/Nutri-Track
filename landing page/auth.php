<?php
session_start();

// Demo credentials for three roles
$demo_users = [
    'user@demo.com' => [
        'password' => 'demo123',
        'role' => 'user',
        'name' => 'John Doe',
        'redirect' => '../user/dashboard.php'
    ],
    'nutritionist@demo.com' => [
        'password' => 'demo123',
        'role' => 'nutritionist', 
        'name' => 'Dr. Sarah Mitchell',
        'redirect' => '../nutritionists/dashboard.php'
    ],
    'admin@demo.com' => [
        'password' => 'demo123',
        'role' => 'admin',
        'name' => 'Admin User',
        'redirect' => '../admin/dashboard.php'
    ]
];

if ($_POST && isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (isset($demo_users[$email]) && $demo_users[$email]['password'] === $password) {
        // Set session variables
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $demo_users[$email]['name'];
        $_SESSION['user_role'] = $demo_users[$email]['role'];
        $_SESSION['login_time'] = time();
        
        // Return success response for AJAX
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'redirect' => $demo_users[$email]['redirect'],
                'message' => 'Login successful! Welcome ' . $demo_users[$email]['name']
            ]);
            exit;
        }
        
        // Regular form submission
        header('Location: ' . $demo_users[$email]['redirect']);
        exit;
    } else {
        $error = 'Invalid email or password';
        
        // Return error response for AJAX
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $error
            ]);
            exit;
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