<?php
require_once __DIR__ . '/config/database.php';
$db = sathi_db();
$res = $db->query('SELECT id, email FROM users');
if ($res) {
    while ($row = $res->fetch_assoc()) {
        echo "ID: {$row['id']}, Email: {$row['email']}\n";
    }
} else {
    echo "No users found or error: " . $db->error . "\n";
}
