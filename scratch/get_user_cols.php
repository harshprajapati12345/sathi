<?php
require_once 'config/database.php';
$db = sathi_db();
$res = $db->query('SHOW COLUMNS FROM users');
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\n";
}
