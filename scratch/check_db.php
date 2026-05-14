<?php
require 'config/db.local.php';
$mysqli = new mysqli($config['host'], $config['user'], $config['password'], $config['database']);
$res = $mysqli->query('SELECT profile_photo, caste_id, religion_id FROM users WHERE profile_photo != "" LIMIT 1');
$row = $res->fetch_assoc();
print_r($row);
