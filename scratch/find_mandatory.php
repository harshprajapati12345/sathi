<?php
require_once 'config/database.php';
$db = sathi_db();
$query = "SELECT COLUMN_NAME 
          FROM INFORMATION_SCHEMA.COLUMNS 
          WHERE TABLE_SCHEMA = 'shadikibaat' 
          AND TABLE_NAME = 'users' 
          AND IS_NULLABLE = 'NO' 
          AND COLUMN_KEY != 'PRI' 
          AND COLUMN_DEFAULT IS NULL 
          AND EXTRA != 'auto_increment'";
$res = $db->query($query);
if (!$res) die($db->error);
while($row = $res->fetch_assoc()) {
    echo "Mandatory Column: " . $row['COLUMN_NAME'] . "\n";
}
echo "--- PAYMENTS ---\n";
$query = "SELECT COLUMN_NAME 
          FROM INFORMATION_SCHEMA.COLUMNS 
          WHERE TABLE_SCHEMA = 'shadikibaat' 
          AND TABLE_NAME = 'payments' 
          AND IS_NULLABLE = 'NO' 
          AND COLUMN_KEY != 'PRI' 
          AND COLUMN_DEFAULT IS NULL 
          AND EXTRA != 'auto_increment'";
$res = $db->query($query);
while($row = $res->fetch_assoc()) {
    echo "Mandatory Column: " . $row['COLUMN_NAME'] . "\n";
}
