<?php
require_once dirname(__DIR__) . '/config/database.php';
$db = sathi_db();
$res = $db->query("SHOW TABLES");
while($row = $res->fetch_row()) {
    echo $row[0] . "\n";
}
