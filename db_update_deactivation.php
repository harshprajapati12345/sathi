<?php
require_once __DIR__ . '/config/database.php';
$db = sathi_db();

// Create profile_deactivation_requests table without FK just to be safe
$sql = "CREATE TABLE IF NOT EXISTS profile_deactivation_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reason VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actioned_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)";
if ($db->query($sql)) {
    echo "Table profile_deactivation_requests created or already exists.\n";
} else {
    echo "Error creating table: " . $db->error . "\n";
}

// Check if users table has status or is_active column
$res = $db->query("SHOW COLUMNS FROM users LIKE 'status'");
if ($res->num_rows == 0) {
    if ($db->query("ALTER TABLE users ADD COLUMN status VARCHAR(50) DEFAULT 'active'")) {
        echo "Added status column to users table.\n";
    } else {
        echo "Error altering users: " . $db->error . "\n";
    }
} else {
    echo "status column already exists in users table.\n";
}
