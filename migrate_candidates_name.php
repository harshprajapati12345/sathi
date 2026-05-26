<?php
require_once __DIR__ . '/config/database.php';

$db = sathi_db();

echo "Starting candidates name migration...\n";

// 1. Add new columns if they don't exist
$res = $db->query("SHOW COLUMNS FROM candidates LIKE 'first_name'");
if ($res->num_rows === 0) {
    echo "Adding first_name and last_name columns...\n";
    $db->query("ALTER TABLE candidates ADD COLUMN first_name VARCHAR(255) NULL AFTER are_you_digamber_jain, ADD COLUMN last_name VARCHAR(255) NULL AFTER first_name");
}

// 2. Migrate data
echo "Migrating data...\n";
$res = $db->query("SELECT id, candidate_full_name FROM candidates WHERE candidate_full_name IS NOT NULL");
$stmt = $db->prepare("UPDATE candidates SET first_name = ?, last_name = ? WHERE id = ?");

while ($row = $res->fetch_assoc()) {
    $fullName = trim($row['candidate_full_name']);
    $parts = explode(' ', $fullName, 2);
    
    // Auto capitalize
    $firstName = ucwords(strtolower(trim($parts[0] ?? '')));
    $lastName = ucwords(strtolower(trim($parts[1] ?? '')));
    
    $stmt->bind_param("ssi", $firstName, $lastName, $row['id']);
    $stmt->execute();
}
$stmt->close();

// 3. Drop old column
$res = $db->query("SHOW COLUMNS FROM candidates LIKE 'candidate_full_name'");
if ($res->num_rows > 0) {
    echo "Dropping candidate_full_name column...\n";
    $db->query("ALTER TABLE candidates DROP COLUMN candidate_full_name");
}

echo "Migration completed!\n";
