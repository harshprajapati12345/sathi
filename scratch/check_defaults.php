<?php
require_once 'config/database.php';
$db = sathi_db();
$res = $db->query('SHOW COLUMNS FROM users');
while($row = $res->fetch_assoc()) {
    if ($row['Field'] == 'created_at' || $row['Field'] == 'updated_at') {
        echo "Field: {$row['Field']}, Default: {$row['Default']}, Extra: {$row['Extra']}\n";
    }
}
$res = $db->query('SHOW COLUMNS FROM payments');
while($row = $res->fetch_assoc()) {
    if ($row['Field'] == 'created_at') {
        echo "Field: {$row['Field']}, Default: {$row['Default']}, Extra: {$row['Extra']}\n";
    }
}
