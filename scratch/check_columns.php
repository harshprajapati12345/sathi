<?php
require 'config/database.php';
$db = sathi_db();
$res = $db->query('DESCRIBE users');
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\n";
}
