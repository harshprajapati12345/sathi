<?php
require_once 'config/database.php';
$db = sathi_db();
$res = $db->query('SHOW FULL COLUMNS FROM payments');
while($row = $res->fetch_assoc()) {
    if($row['Null'] == 'NO' && $row['Default'] === NULL && $row['Extra'] != 'auto_increment') {
        echo $row['Field'] . " is mandatory\n";
    }
}
