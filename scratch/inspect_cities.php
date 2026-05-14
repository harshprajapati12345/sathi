<?php
require_once dirname(__DIR__) . '/config/database.php';
$db = sathi_db();
$res = $db->query("DESCRIBE cities");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . " " . $row['Type'] . "\n";
}
echo "----\n";
$res = $db->query("SELECT * FROM cities LIMIT 5");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
