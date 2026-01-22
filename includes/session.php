<?php
session_start();

// Check if user is logged in
function checkAuth($required_role = null) {
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
        header('Location: ../landing page/login.php?message=login_required');
        exit;
    }
    
    // Check role if specified
    if ($required_role && $_SESSION['user_role'] !== $required_role) {
        header('Location: ../landing page/login.php?message=access_denied');
        exit;
    }
    
    return true;
}

// Get current user info
function getCurrentUser() {
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
        return null;
    }
    
    return [
        'email' => $_SESSION['user_email'],
        'name' => $_SESSION['user_name'],
        'role' => $_SESSION['user_role'],
        'login_time' => $_SESSION['login_time']
    ];
}

// Check if user has specific role
function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

// Get user initials for avatar
function getUserInitials($name = null) {
    $name = $name ?: $_SESSION['user_name'];
    $parts = explode(' ', $name);
    return strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}
?>