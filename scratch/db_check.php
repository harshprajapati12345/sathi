<?php
require_once __DIR__ . '/../config/database.php';
$db = sathi_db();

echo "MARITAL STATUSES TABLE:\n";
$res = $db->query("SELECT * FROM marital_statuses");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Query error or table doesn't exist: " . $db->error . "\n";
}
