<?php
require __DIR__ . '/../config/database.php';
try {
    $pdo = sathi_db();
    $stmt = $pdo->query("SHOW CREATE TABLE users");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['Create Table'] . "\n\n";
    
    $stmt = $pdo->query("SHOW CREATE TABLE registration_field_settings");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['Create Table'] . "\n\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
