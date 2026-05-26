<?php
require_once __DIR__ . '/config/database.php';
$db = sathi_db();

$sqls = [
    "CREATE TABLE IF NOT EXISTS mandirs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        status ENUM('Active', 'Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS subcasts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        status ENUM('Active', 'Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS gotras (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        status ENUM('Active', 'Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "ALTER TABLE users 
        ADD COLUMN mandir_id INT NULL AFTER profile_id,
        ADD COLUMN subcast_id INT NULL AFTER mandir_id,
        ADD COLUMN gotra_id INT NULL AFTER subcast_id,
        ADD COLUMN reference_person_1_name VARCHAR(255) NULL,
        ADD COLUMN reference_person_1_mobile VARCHAR(20) NULL,
        ADD COLUMN reference_person_1_relation VARCHAR(100) NULL,
        ADD COLUMN reference_person_2_name VARCHAR(255) NULL,
        ADD COLUMN reference_person_2_mobile VARCHAR(20) NULL,
        ADD COLUMN reference_person_2_relation VARCHAR(100) NULL"
];

foreach ($sqls as $sql) {
    if (!$db->query($sql)) {
        echo "Error: " . $db->error . "\n";
    } else {
        echo "Success: " . substr($sql, 0, 50) . "...\n";
    }
}
echo "Migration complete.\n";
