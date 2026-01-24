<?php
require_once '../includes/session.php';
checkAuth('nutritionist');

$db = getDB();

// Check table structure
echo "<h2>Appointments Table Structure:</h2>";
$stmt = $db->query("DESCRIBE appointments");
$columns = $stmt->fetchAll();
echo "<pre>";
print_r($columns);
echo "</pre>";

// Check all appointments
echo "<h2>All Appointments:</h2>";
$stmt = $db->query("SELECT * FROM appointments ORDER BY id DESC LIMIT 10");
$appointments = $stmt->fetchAll();
echo "<pre>";
print_r($appointments);
echo "</pre>";

// Check status enum values
echo "<h2>Status Column Details:</h2>";
$stmt = $db->query("SHOW COLUMNS FROM appointments LIKE 'status'");
$statusColumn = $stmt->fetch();
echo "<pre>";
print_r($statusColumn);
echo "</pre>";
?>