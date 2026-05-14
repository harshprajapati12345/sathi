<?php
require_once 'config/database.php';
$db = sathi_db();
$res = $db->query('SHOW TABLES');
while($row = $res->fetch_array()) {
    echo $row[0] . "\n";
}
