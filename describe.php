<?php
require_once __DIR__ . '/config/database.php';
$db = sathi_db();
$res = $db->query('DESCRIBE candidates');
while($row = $res->fetch_assoc()) echo $row['Field'] . ' | ' . $row['Type'] . "\n";
