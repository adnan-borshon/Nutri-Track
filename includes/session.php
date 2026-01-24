<?php
require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function checkAuth($required_role = null) {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header('Location: /Health%20DIet/landing%20page/login.php?message=login_required');
        exit;
    }
    
    // Check role if specified
    if ($required_role) {
        $roles = is_array($required_role) ? $required_role : [$required_role];
        if (!in_array($_SESSION['user_role'], $roles)) {
            header('Location: /Health%20DIet/landing%20page/login.php?message=access_denied');
            exit;
        }
    }
    
    return true;
}

// Get current user info from database
function getCurrentUser() {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        return null;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching user: " . $e->getMessage());
        return null;
    }
}

// Check if user has specific role
function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

// Get user initials for avatar
function getUserInitials($name = null) {
    $name = $name ?: ($_SESSION['user_name'] ?? 'U');
    $parts = explode(' ', $name);
    return strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}

// Logout user
function logout() {
    session_destroy();
    header('Location: /Health%20DIet/landing%20page/login.php');
    exit;
}
?>