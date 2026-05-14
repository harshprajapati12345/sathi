<?php
require_once dirname(__DIR__) . '/config/database.php';
$db = sathi_db();
$res = $db->query("SELECT id, name FROM states");
while($row = $res->fetch_assoc()) {
    echo $row['id'] . ": " . $row['name'] . "\n";
}
