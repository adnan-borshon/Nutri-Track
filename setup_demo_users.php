<?php
/**
 * Setup Demo Users Script
 * Run this once to create/fix demo users with correct passwords
 * URL: http://localhost/Health%20DIet/setup_demo_users.php
 */

require_once __DIR__ . '/config/db.php';

echo "<h2>NutriTrack - Demo Users Setup</h2>";

try {
    $db = getDB();
    
    // Generate correct password hash for 'demo123'
    $hashedPassword = password_hash('demo123', PASSWORD_DEFAULT);
    
    echo "<p><strong>Generated hash for 'demo123':</strong><br><code>$hashedPassword</code></p>";
    
    // Demo users data
    $demoUsers = [
        [
            'name' => 'John Doe',
            'email' => 'user@demo.com',
            'role' => 'user',
            'goal' => 'weight_loss',
            'specialty' => null
        ],
        [
            'name' => 'Dr. Sarah Mitchell',
            'email' => 'nutritionist@demo.com',
            'role' => 'nutritionist',
            'goal' => null,
            'specialty' => 'Weight Management'
        ],
        [
            'name' => 'Admin User',
            'email' => 'admin@demo.com',
            'role' => 'admin',
            'goal' => null,
            'specialty' => null
        ]
    ];
    
    echo "<h3>Processing Demo Users:</h3><ul>";
    
    foreach ($demoUsers as $user) {
        // Check if user exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$user['email']]);
        $existing = $stmt->fetch();
        
        if ($existing) {
            // Update password
            $stmt = $db->prepare("UPDATE users SET password = ?, status = 'active' WHERE email = ?");
            $stmt->execute([$hashedPassword, $user['email']]);
            echo "<li>✅ Updated password for <strong>{$user['email']}</strong></li>";
        } else {
            // Insert new user
            $stmt = $db->prepare("INSERT INTO users (name, email, password, role, status, goal, specialty) VALUES (?, ?, ?, ?, 'active', ?, ?)");
            $stmt->execute([$user['name'], $user['email'], $hashedPassword, $user['role'], $user['goal'], $user['specialty']]);
            echo "<li>✅ Created new user <strong>{$user['email']}</strong></li>";
        }
    }
    
    echo "</ul>";
    
    // Assign user to nutritionist
    $stmt = $db->prepare("SELECT id FROM users WHERE email = 'nutritionist@demo.com'");
    $stmt->execute();
    $nutritionist = $stmt->fetch();
    
    if ($nutritionist) {
        $stmt = $db->prepare("UPDATE users SET nutritionist_id = ? WHERE email = 'user@demo.com'");
        $stmt->execute([$nutritionist['id']]);
        echo "<p>✅ Assigned John Doe to Dr. Sarah Mitchell</p>";
    }
    
    echo "<h3>Demo Credentials:</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>Role</th><th>Email</th><th>Password</th></tr>";
    echo "<tr><td>User</td><td>user@demo.com</td><td>demo123</td></tr>";
    echo "<tr><td>Nutritionist</td><td>nutritionist@demo.com</td><td>demo123</td></tr>";
    echo "<tr><td>Admin</td><td>admin@demo.com</td><td>demo123</td></tr>";
    echo "</table>";
    
    echo "<p style='margin-top: 20px;'><a href='landing page/login.php'>→ Go to Login Page</a></p>";
    
    echo "<p style='color: red; margin-top: 20px;'><strong>⚠️ Delete this file after setup for security!</strong></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
