<?php
require_once 'config/database.php';
$db = sathi_db();
$res = $db->query('DESCRIBE users');
while($row = $res->fetch_assoc()) {
    echo "{$row['Field']} - {$row['Null']}\n";
}
echo "--- PAYMENTS ---\n";
$res = $db->query('DESCRIBE payments');
while($row = $res->fetch_assoc()) {
    echo "{$row['Field']} - {$row['Null']}\n";
}
