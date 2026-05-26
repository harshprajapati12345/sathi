<?php
require 'config/database.php';
$db = sathi_db();
$res = $db->query("SHOW TABLES");
while ($row = $res->fetch_row()) {
    $table = $row[0];
    echo "=== $table ===\n";
    $cRes = $db->query("DESCRIBE `$table`");
    while ($cRow = $cRes->fetch_assoc()) {
        echo "  " . $cRow['Field'] . "\n";
    }
}
