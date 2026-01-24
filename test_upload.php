<?php
// Test file to check upload directory permissions
$uploadDir = 'uploads/profiles/';

echo "<h3>Upload Directory Test</h3>";
echo "Directory: " . $uploadDir . "<br>";
echo "Exists: " . (is_dir($uploadDir) ? 'Yes' : 'No') . "<br>";
echo "Writable: " . (is_writable($uploadDir) ? 'Yes' : 'No') . "<br>";
echo "Permissions: " . substr(sprintf('%o', fileperms($uploadDir)), -4) . "<br>";

// Test creating a file
$testFile = $uploadDir . 'test.txt';
if (file_put_contents($testFile, 'test')) {
    echo "Test file created successfully<br>";
    unlink($testFile);
    echo "Test file deleted<br>";
} else {
    echo "Failed to create test file<br>";
}
?>